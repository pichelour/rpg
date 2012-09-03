<?php
namespace Rpg\Engine;

class Fight
{
	private $monsters;
	
	public function isFinished()
	{
		foreach ($this->monsters as $monster)
		{
			if (!$monster->isDead())
			{
				return false;
			}
		}
		return true;
	}
	
	public function setMonsters(array $monsters)
	{
		$this->monsters = $monsters;
	}
	
	public function getMonsters()
	{
		return $this->monsters;
	}

	public function getAliveMonsters()
	{
		$monsters = [];
		foreach ($this->monsters as $monster)
		{
			if (!$monster->isDead())
			{
				$monsters[] = $monster;
			}
		}
		return $monsters;
	}
	
	public function getMonster($id)
	{
		return $this->monsters[$id];
	}
}
