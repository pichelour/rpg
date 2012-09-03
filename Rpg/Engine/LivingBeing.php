<?php
namespace Rpg\Engine;

abstract class LivingBeing
{
	const STATUS_DEAD = 1;

	protected  $name,
	           $hp,
	           $maxHp,
	           $mp,
	           $maxMp,
	           $level,
	           $strength,
	           $defence,
	           $eyesight,
	           $magic,
	           $magicDef,
	           $weapon,
	           $armor,
	           $objects,
	           $exp,
	           $status;
	
	public function __construct($name)
	{
		$this->name    = $name;
		$this->objects = array();
	}
	
	public function getStats()
	{
		return array(
			'level'    => $this->level,
			'hp' 	   => $this->hp.'/'.$this->maxHp,
			'mp'       => $this->mp.'/'.$this->maxMp,
			'strength' => $this->strength,
			'defence'  => $this->defence,
			'eyesight' => $this->eyesight,
			'magic'    => $this->magic,
			'magicDef' => $this->magicDef,
			'exp'      => $this->exp
		);
	}
	
	public function attack(LivingBeing $lb)
	{
		$lb->hp -= $this->strength - $lb->defence;
		if ($lb->hp <= 0)
		{
			$lb->status |= self::STATUS_DEAD;
		}
	}
	
	public function isDead()
	{
		return $this->status & self::STATUS_DEAD;
	}
	
	public function setLevel($val)
	{
		$this->level = $val;
		return $this;
	}
	
	public function setMaxHp($val)
	{
		$this->hp = $val;
		$this->maxHp = $val;
		return $this;
	}
	
	public function setMaxMp($val)
	{
		$this->mp = $val;
		$this->maxMp = $val;
		return $this;
	}
	
	public function setStrength($val)
	{
		$this->strength = $val;
		return $this;
	}
	
	public function setDefence($val)
	{
		$this->defence = $val;
		return $this;
	}
	
	public function setEyesight($val)
	{
		$this->eyesight = $val;
		return $this;
	}
	
	public function setMagic($val)
	{
		$this->magic = $val;
		return $this;
	}
	
	public function setMagicDef($val)
	{
		$this->magicDef = $val;
		return $this;
	}
	
	public function setExp($val)
	{
		$this->exp = $val;
		return $this;
	}

	public function setObject($nom, $nb = 1)
	{
		!isset($this->objects[$nom]) 
			? $this->objects[$nom] = $nb
			: $this->objects[$nom] += $nb;
		return $this;
	}
	
	public function getMaxHp()
	{
		return $this->maxHp;
	}
	
	public function getHp()
	{
		return $this->hp;
	}
	
	public function getLevel()
	{
		return $this->level;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getEyesight()
	{
		return $this->eyesight;
	}
	
	public function getExp()
	{
		return $this->exp;
	}
	
	public function getObjects()
	{
		return $this->objects;
	}
}
