<h2>Editing <span class='muted'>College</span></h2>
<br>

<?php echo render('college/_form'); ?>
<p>
	<?php echo Html::anchor('college/view/'.$college->id, 'View'); ?> |
	<?php echo Html::anchor('college', 'Back'); ?></p>
