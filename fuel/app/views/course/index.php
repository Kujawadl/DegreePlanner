<h2>Listing <span class='muted'>Courses</span></h2>
<br>
<?php if ($tests): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($tests as $item): ?>		<tr>

			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->description; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('course/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>
            <?php if (Auth::member(100)): ?>
              <?php echo Html::anchor('course/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>
              <?php echo Html::anchor('course/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>
            <?php endif ?>
          </div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
  <p>No Courses.</p>
<?php endif; ?>


<?php if(Auth::member(100)): ?>
  <p>
  	<?php echo Html::anchor('course/create', 'Add new Course', array('class' => 'btn btn-success')); ?>
  </p>
<?php endif ?>
