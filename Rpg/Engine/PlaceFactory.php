<?php
namespace Rpg\Engine;

class PlaceFactory
{
	private $game;

	public function __construct($game)
	{
		$this->game = $game;
	}
	
	public function create($placeName)
	{
		if ($placeName === 'worldmap')
		{
			$class = __NAMESPACE__.'\\'.'Map';
		}
		else
		{
			$class = __NAMESPACE__.'\\'.'City';
		}
		return new $class($this->game->getPlaceData($placeName), $this->game, $this);
	}
}
