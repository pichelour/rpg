<div id="fight">
	<?php foreach ($fight->getMonsters() as $index => $monster) : ?>
	<div class="monster <?php if ($monster->isDead()) : echo 'dead'; endif; ?>">
		<?php echo $monster->getName(); ?><br />
		<?php echo $monster->getHp().'/'.$monster->getMaxHp(); ?><br />
		<a href="<?php echo url_action('attack', array('id' => $index)); ?>">Attaquer</a>
	</div>
	<?php endforeach; ?>
</div>
