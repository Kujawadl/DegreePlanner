<h2>Editing <span class='muted'>Test</span></h2>
<br>

<?php echo render('test/_form'); ?>
<p>
	<?php echo Html::anchor('test/view/'.$test->id, 'View'); ?> |
	<?php echo Html::anchor('test', 'Back'); ?></p>
