<h2>Viewing <span class='muted'>#<?php echo $department->id; ?></span></h2>

<p>
	<strong>College:</strong>
	College of <?php echo Model_College::find($department->College)->Name; ?></p>
<p>
	<strong>Name:</strong>
	Department of <?php echo $department->Name; ?></p>
<p>
	<strong>Short Name:</strong>
	<?php echo $department->ShortName; ?></p>
<p>
	<strong>Phone:</strong>
	<?php echo $department->Phone; ?></p>

<?php if (Auth::member(100)): ?>
  <?php echo Html::anchor('department/edit/'.$department->id, 'Edit'); ?> |
<?php endif ?>
<?php echo Html::anchor('department', 'Back'); ?>
