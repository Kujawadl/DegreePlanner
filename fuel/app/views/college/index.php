<h2>Listing <span class='muted'>Colleges</span></h2>
<br>
<?php if ($colleges): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>College</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($colleges as $item): ?>		<tr>

			<td><?php echo $item->Name; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('college/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>
            <?php if (Auth::member(100)): ?>
              <?php echo Html::anchor('college/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>
              <?php echo Html::anchor('test/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>
            <?php endif ?>
          </div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Colleges.</p>

<?php endif; ?>

<?php if(Auth::member(100)): ?>
  <p>
  	<?php echo Html::anchor('college/create', 'Add new College', array('class' => 'btn btn-success')); ?>
  </p>
<?php endif ?>
