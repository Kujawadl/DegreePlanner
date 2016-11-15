<h2>Viewing <span class='muted'>#<?php echo $test->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $test->name; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $test->description; ?></p>

<?php echo Html::anchor('test/edit/'.$test->id, 'Edit'); ?> |
<?php echo Html::anchor('test', 'Back'); ?>