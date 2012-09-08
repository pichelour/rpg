<?php
namespace Rpg\Action;
use Rpg\Engine\Action;

class Actions extends Action
{
	protected function executeCreateNewHero()
	{
		try
		{
			$this->game->createHero($_POST['name']);
			$this->redirect('moveTo', array(
				'place' => $this->game->getHero()->getPlaceId(),
				'x'     => $this->game->getHero()->getX(),
				'y'     => $this->game->getHero()->getY()
			));
			
		}
		catch (\InvalidArgumentException $e)
		{
			$this->setTemplate('new-hero');
			return array('message' => 'Seuls les lettres, chiffres, et les caractères -_. sont autorisés.');
		}
	}
	
	protected function executeChooseHeroToDelete()
	{
		return array('heroes' => $this->game->getHeroesList());
	}
	
	protected function executeDeleteHero()
	{
		if (empty($_REQUEST['name']) || !$this->game->deleteHero($_REQUEST['name']))
		{
			$this->redirect('choose-hero-to-delete');
		}
		$this->redirect('title-screen');
	}
	
	protected function executeChooseHeroToLoad()
	{
		return array('heroes' => $this->game->getHeroesList());
	}
	
	protected function executeLoadHero()
	{
		if (empty($_REQUEST['name']) || !$this->game->loadHero($_REQUEST['name']))
		{
			$this->redirect('choose-hero-to-load');
		}
		
		$this->redirect('place');
	}
	
	protected function executeSaveHero()
	{
		$this->game->saveHero();
		$this->redirect('place');
	}
	
	protected function executeQuit()
	{
		$this->game->quit();
		$this->redirect('title-screen');
	}
	
	protected function executePlace()
	{
		$place = $this->game->getNewPlace($this->game->getHero()->getPlaceId());
		return array('place' => $place);
	}
	
	protected function executeMoveTo()
	{
		$hero    = $this->game->getHero();
		$x       = $_GET['x'];
		$y       = $_GET['y'];
		$placeId = !empty($_GET['place']) ? $_GET['place'] : $hero->getPlaceId();
		$place   = $this->game->getNewPlace($placeId);

		$hero->moveTo($place, $x, $y);
		$this->game->setHero($hero);
		if ($this->game->timeToFight($place))
		{
			$this->redirect('fight');
		}
		$this->redirect('place');
	}
	
	protected function executeFight()
	{
		$fight = $this->game->getCurrentFight();
		if ($fight->isFinished())
		{
			$this->game->endFight($fight);
			$this->redirect('place');
		}
		return array('fight' => $fight);
	}
	
	protected function executeAttack()
	{
		$fight   = $this->game->getCurrentFight();
		$monster = $fight->getMonster($_GET['id']);
		$hero    = $this->game->getHero();
		$hero->attack($monster);
		foreach ($fight->getAliveMonsters() as $monster)
		{
			$monster->attack($hero);
		}
		
		$this->game->setFight($fight);
		$this->redirect('fight');
	}
}
