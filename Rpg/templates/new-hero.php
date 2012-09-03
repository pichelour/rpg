<ul>
	<li>Créer un nouveau héros</li>
	<li><a href="<?php echo url_action('choose-hero-to-load'); ?>">Charger un héros</a></li>
	<li><a href="<?php echo url_action('choose-hero-to-delete'); ?>">Supprimer un héros</a></li>
</ul>
<?php if (isset($message)) : ?>
	<p><?php echo $message; ?></p>
<?php endif; ?>
<form action="<?php echo url_action('create-new-hero'); ?>" method="post">
	<label for="nom">Quel est le nom de votre héros ?</label>
	<input type="text" name="name" />
	<input type="submit" value="Créer" />
</form>
