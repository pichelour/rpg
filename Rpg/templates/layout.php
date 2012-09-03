<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Riverside</title>
	<link rel="stylesheet" media="screen" type="text/css" href="assets/style.css" >
</head>
<body>

<h1>Riverside</h1>
<?php if ($hero instanceof \Rpg\Engine\Hero) : ?>
<aside>
	<table>
		<tr><th colspan="2"><?php echo $hero->getName(); ?></th></tr>
		<?php foreach ($hero->getStats() as $stat => $valeur) : ?>
		<tr><td><?php echo $stat; ?></td><td><?php echo $valeur; ?></td></tr>
		<?php endforeach ?>
		<tr><td>Or</td><td><?php echo $hero->getGold(); ?></td></tr>
		<tr><td>Position</td><td><?php echo $hero->getPlaceId().' ('.$hero->getX().'-'.$hero->getY().')'; ?></td></tr>
	</table>
	<ul>
		<li><a href="<?php echo url_action('save-hero'); ?>">Enregistrer</a></li>
	</ul>
</aside>
<?php endif; ?>
<section>
	<?php echo $content; ?>
</section>

</body>
</html>
