<?php
namespace Rpg\Engine;

class Monster extends LivingBeing
{
	private $loot;
	
	public function setLoot($loot)
	{
		$this->loot = $loot;
		return $this;
	}
}
