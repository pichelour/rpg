<?php
namespace Rpg\Engine;

abstract class Place
{
	protected $data,
	          $game,
	          $visibility;
	
	public function __construct($data, $game, $placeFactory)
	{
		$this->data = $data;
		$this->game = $game;
		$this->placeFactory = $placeFactory;
	}
	
	public function getName()
	{
		return $this->data['name'];
	}
	
	public function getId()
	{
		return $this->data['id'];
	}
	
	public function getMonsters()
	{
		return $this->data['monsters'];
	}
	
	public function isReachable($x, $y)
	{
		if ($x < 0 || $x > $this->data['maxX']
		 || $y < 0 || $y > $this->data['maxY'])
		{
			return false;
		}
		
		if (abs($this->game->getHero()->getX() - $x) > 1
		 || abs($this->game->getHero()->getY() - $y) > 1)
		{
			return false;
		}
		
		return true;
	}
	
	protected function computeHeroVisibility()
	{
		if (!empty($this->visibility))
		{
			return;
		}
		$x = $this->game->getHero()->getX();
		$y = $this->game->getHero()->getY();
		$this->visibility = [
			'minX' => max($x - 3, 0),
			'maxX' => min($x + 3, $this->data['maxX'] - 1),
			'minY' => max($y - 3, 0),
			'maxY' => min($y + 3, $this->data['maxY'] - 1),
		];
		$this->visibility['places'] = $this->getVisiblePlaces();
	}
	
	public function getTile($x, $y)
	{
		return new Tile($this->data['tiles'][$y][$x]);
	}
	
	public function whatOn($x, $y)
	{
		$whatOn = [];
		
		if ($this->game->getHero()->getX() == $x
		 && $this->game->getHero()->getY() == $y)
		{
			$whatOn[] = $this->game->getHero();
		}
		
		$this->computeHeroVisibility();
		foreach ($this->data['places'] as $place)
		{
			if ($place['x'] == $x && $place['y'] == $y)
			{
				$whatOn[] = $this->visibility['places'][$place['id']];
				break;
			}
		}
		return $whatOn;
	}
	
	protected function getVisiblePlaces()
	{
		$places = [];
		foreach ($this->data['places'] as $place)
		{
			if ($place['x'] >= $this->getMinXVisible() && $place['x'] <= $this->getMaxXVisible()
			 && $place['y'] >= $this->getMinYVisible() && $place['y'] <= $this->getMaxYVisible())
			{
				$places[$place['id']] = $this->placeFactory->create($place['id']);
			}
		}
		return $places;
	}
	
	public function getEnterPosition($placeId)
	{
		foreach ($this->data['places'] as $place)
		{
			if ($place['id'] == $placeId)
			{
				return ['x' => $place['x'], 'y' => $place['y']];
			}
		}
		return false;
	}
	
	public function getMinXVisible()  { $this->computeHeroVisibility(); return $this->visibility['minX']; }
	public function getMinYVisible()  { $this->computeHeroVisibility(); return $this->visibility['minY']; }
	public function getMaxXVisible()  { $this->computeHeroVisibility(); return $this->visibility['maxX']; }
	public function getMaxYVisible()  { $this->computeHeroVisibility(); return $this->visibility['maxY']; }
}
