<?php
namespace Rpg\Engine;

class Game
{
	private $hero   = null,
	        $action = null;
	
	public function __construct()
	{
		session_start();
	}

	public function start()
	{
		$this->action->execute();
	}
	
	public function quit()
	{
		session_destroy();
	}
	
	public function setAction(Action $action)
	{
		$this->action = $action;
		$this->action->setGame($this);
	    return $this;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function setHero($hero)
	{
		$this->hero = $hero;
		$_SESSION['hero'] = $hero;
	    return $this;
	}

	public function getHero()
	{
		if (isset($_SESSION['hero']))
		{
			$this->hero = $_SESSION['hero'];
		}
		return $this->hero;
	}
	
	public function createHero($name)
	{
		if (empty($name) || !preg_match('#^[ \w\d-_\.]+$#', $name))
		{
			throw new \InvalidArgumentException();
		}
	
		$hero = new Hero($name);
		$hero->setMaxHp(20)
			->setMaxMp(5)
			->setLevel(1)
			->setStrength(4)
			->setDefence(3)
			->setEyesight(3)
			->setMagic(2)
			->setMagicDef(1)
			->setExp(0)
			->setGold(200)
			->setPosition(3, 3)
			->setPlaceId('worldmap');
		
		$this->setHero($hero);
		$this->saveHero();
		return $hero;
	}
	
	public function saveHero()
	{
		file_put_contents(__DIR__.'/../save/'.$this->getHero()->getName().'.sav', serialize($this->hero));
		return true;
	}
	
	public function loadHero($name)
	{
		if (!is_readable(__DIR__.'/../save/'.$name.'.sav'))
		{
			return false;
		}
		$this->setHero(unserialize(file_get_contents(__DIR__.'/../save/'.$name.'.sav')));
		return true;
	}
	
	public function deleteHero($name)
	{
		if (!is_writable(__DIR__.'/../save/'.$name.'.sav'))
		{
			return false;
		}
		unlink(__DIR__.'/../save/'.$name.'.sav');
		$this->setHero(null);
		return true;
	}
	
	public function getHeroesList()
	{
		$names = [];
		foreach (new \DirectoryIterator(__DIR__.'/../save/') as $fileInfo)
		{
			if ($fileInfo->isDot())
			{
				continue;
			}
			$names[] = $fileInfo->getBasename('.sav');
		}
		return $names;
	}
	
	public function getPlaceData($id)
	{
		return json_decode(file_get_contents(__DIR__.'/../data/places/'.$id.'.json'), true);
	}
	
	public function loadMonster($id)
	{
		$data = json_decode(file_get_contents(__DIR__.'/../data/monsters/'.$id.'.json'), true);
		return (new Monster($data['name']))
		    ->setLevel($data['level'])
		    ->setExp($data['exp'])
		    ->setMaxHp($data['maxHp'])
		    ->setMaxMp($data['maxMp'])
		    ->setStrength($data['strength'])
		    ->setDefence($data['defence'])
		    ->setLoot($data['loot']);
	}
	
	public function getCurrentFight()
	{
		if (empty($_SESSION['fight']))
		{
			$fight = new Fight();
			$fight->setMonsters($this->initFightMonsters());
			$this->setFight($fight);
		}
		else
		{
			$fight = $_SESSION['fight'];
		}
		return $fight;
	}
	
	private function initFightMonsters()
	{
		$placeFactory = new PlaceFactory($this);
		$place = $placeFactory->create($this->getHero()->getPlaceId());
		$monsters = $place->getMonsters();
		return [uniqid() => $this->loadMonster($monsters[array_rand($monsters)])];
	}
	
	public function endFight($fight)
	{
		$hero = $this->getHero();
		foreach ($fight->getMonsters() as $monster)
		{
			$hero->addExp($monster->getExp());
		}
		$this->setHero($hero);
		unset($_SESSION['fight']);
	}
	
	public function setFight($fight)
	{
		$_SESSION['fight'] = $fight;
	}
}
