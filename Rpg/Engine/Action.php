<?php
namespace Rpg\Engine;

abstract class Action
{
	protected $game;
	private $template;
	
	public function __construct()
	{
		$this->template = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'title-screen';
	}
	
	public function setGame($game)
	{
	    $this->game = $game;
	    return $this;
	}
	
	protected function setTemplate($template)
	{
		$this->template = $template;
	}
	
	public function execute()
	{
		$action = sprintf('execute%s',
			isset($_REQUEST['action']) ? $this->camelize($_REQUEST['action']) : 'TitleScreen'
		);
		
		if (method_exists($this, $action))
		{
			$this->show($this->$action());
		}
		else
		{
			$this->show();
		}
	}
	
	private function show($templateVars = null)
	{
		$template = sprintf(__DIR__.'/../templates/%s.php', $this->template);

		if (is_readable($template))
		{
			if (is_array($templateVars))
			{
				foreach ($templateVars as $var => $value)
				{
					$$var = $value;
				}
			}
			$hero = $this->game->getHero();
			ob_start();
			include $template;
			$content = ob_get_clean();
			
			$hero = $this->game->getHero();
			include __DIR__.'/../templates/layout.php';
		}
		else
		{
			throw new \Exception(
				sprintf('Template %s not found', $template)
			);
		}
	}
	
	protected final function redirect($action, $params = null, $urlEncode = false)
	{
		header('Location: '.url_action($action, $params, $urlEncode));
		exit;
	}
	
	private final function camelize($string, $separator = '-')
	{
		return str_replace(' ', '', ucwords(str_replace($separator, ' ', $string)));
	}
}
?>
