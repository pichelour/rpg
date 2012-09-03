<ul>
	<li><a href="<?php echo url_action('new-hero'); ?>">Créer un nouveau héros</a></li>
	<li><a href="<?php echo url_action('choose-hero-to-load'); ?>">Charger un héros</a></li>
	<li>Supprimer un héros</li>
</ul>
<p>Supprimer quel héros ?</p>
<form action="<?php echo url_action('delete-hero'); ?>" method="post">
	<select name="name">
	<?php foreach ($heroes as $hero) : ?>
		<option value="<?php echo $hero; ?>"><?php echo $hero; ?></option>
	<?php endforeach; ?>
	<input type="submit" value="Supprimer" />
</ul>
