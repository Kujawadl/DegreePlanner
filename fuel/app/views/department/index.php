<h2>Listing <span class='muted'>Departments</span></h2>
<br>
<?php if ($departments): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($departments as $item): ?>		<tr>

			<td><?php echo $item->Name; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('/department/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>
            <?php if (Auth::member(100)): ?>
              <?php echo Html::anchor('/department/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>
              <?php echo Html::anchor('/department/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>
            <?php endif ?>
          </div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Departments.</p>

<?php endif; ?>


<?php if(Auth::member(100)): ?>
  <p>
  	<?php echo Html::anchor('/department/create', 'Add new Department', array('class' => 'btn btn-success')); ?>
  </p>
<?php endif ?>
