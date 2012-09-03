<ul>
	<li><a href="<?php echo url_action('new-hero'); ?>">Créer un nouveau héros</a></li>
	<li>Charger un héros</li>
	<li><a href="<?php echo url_action('choose-hero-to-delete'); ?>">Supprimer un héros</a></li>
</ul>
<p>Charger quel héros ?</p>
<form action="<?php echo url_action('load-hero'); ?>" method="post">
	<select name="name">
	<?php foreach ($heroes as $hero) : ?>
		<option value="<?php echo $hero; ?>"><?php echo $hero; ?></option>
	<?php endforeach; ?>
	<input type="submit" value="Charger" />
</ul>
