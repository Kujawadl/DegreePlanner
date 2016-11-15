<h2>Viewing <span class='muted'>#<?php echo $college->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $college->Name; ?></p>
<p>
	<strong>Short Name:</strong>
	<?php echo $college->ShortName; ?></p>
<p>
  <strong>Address:</strong>
  <?php echo $college->Address; ?></p>
<p>
  <strong>Phone Number:</strong>
  <?php echo $college->Phone; ?></p>

<?php if (Auth::member(100)): ?>
  <?php echo Html::anchor('college/edit/'.$college->id, 'Edit'); ?> |
<?php endif ?>
<?php echo Html::anchor('college', 'Back'); ?>
