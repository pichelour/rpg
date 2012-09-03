<?php
namespace Rpg\Engine;

class Hero extends LivingBeing
{
	private $gold,
	        $x,
	        $y,
	        $placeId;
	
	public function enterTo(Place $place)
	{
		$position = $place->getEnterPosition($this->getPlaceId());
		$this->setPlaceId($place->getId())
		     ->setPosition($position['x'], $position['y']);
	}
	
	public function moveTo(Place $place, $x, $y)
	{
		if ($place->getId() !== $this->getPlaceId())
		{
			$this->enterTo($place);
		}
		elseif ($place->isReachable($x, $y))
		{
			$this->setPosition($x, $y);
		}
	}
	
	public function addExp($exp)
	{
		$this->exp += $exp;
	}
	
	public function setGold($gold)
	{
		$this->gold = $gold;
		return $this;
	}

	public function setPosition($x, $y)
	{
		$this->x = $x;
		$this->y = $y;
		return $this;
	}
	
	public function setPlaceId($placeId)
	{
		$this->placeId = $placeId;
		return $this;
	}
	
	public function getGold()
	{
		return $this->gold;
	}
	
	public function getX()
	{
		return $this->x;
	}
	
	public function getY()
	{
		return $this->y;
	}
	
	public function getPlaceId()
	{
		return $this->placeId;
	}
}
