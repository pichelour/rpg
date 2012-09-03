<?php
use Rpg\Engine\Hero;
use Rpg\Engine\Place;
use Rpg\Engine\Tile;
?>

<table id="map">
<?php
for ($y = $place->getMinYVisible(); $y <= $place->getMaxYVisible(); $y++)
{
	echo '<tr>';
	for ($x = $place->getMinXVisible(); $x <= $place->getMaxXVisible(); $x++)
	{
		$tile = $place->getTile($x, $y);
		echo '<td class="tile'.$tile->getType().'">';
		
		if ($place->isReachable($x, $y)
		 && !($hero->getX() == $x && $hero->getY() == $y))
		{
			echo '<a class="tile" href="'.url_action('moveTo', array('x' => $x, 'y' => $y)).'"></a>';
		}
		else
		{
			echo '<span class="tile"></span>';
		}
		
		foreach ($place->whatOn($x, $y) as $whatOn)
		{
			if ($whatOn instanceof Place)
			{
				if ($place->isReachable($x, $y))
				{
					echo '<a class="city" href="'.url_action('moveTo', array('place' => $whatOn->getId())).'">'.$whatOn->getName().'</a>';
				}
				else
				{
					echo '<span class="city">'.$whatOn->getName().'</span>';
				}
			}
			if ($whatOn instanceof Hero)
			{
				echo '<span id="hero"></span>';
			}
		}
		echo '</td>';
	}
	echo '</tr>';
}
?>
</table>
