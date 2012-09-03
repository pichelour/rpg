<?php
require __DIR__.'/vendor/ClassLoader/UniversalClassLoader.php';
$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespaces(array(
	 'Symfony\Component' => __DIR__.'/vendor/Symfony/Component/'
	,'Rpg' => __DIR__.'/..'
));
$loader->register();

function add_helper($helper)
{
	include __DIR__.'/helpers/'.$helper.'.php';
}

add_helper('helpers');

$game = new Rpg\Engine\Game();
$game->setAction(new Rpg\Action\Actions());
$game->start();
