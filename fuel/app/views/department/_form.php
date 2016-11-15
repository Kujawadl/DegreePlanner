<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
    <div class="form-group">
			<?php echo Form::label('College', 'College', array('class'=>'control-label')); ?>

				<?php
          $selections = array();
          foreach (Model_College::find('all') as $item) {
            $selections[$item->id] = $item->Name;
          }
          echo Form::select('College', 'none', $selections, array('class' => 'col-md-4 form-control', 'placeholder'=>'College'));
        ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Name', 'Name', array('class'=>'control-label')); ?>

				<?php echo Form::input('Name', Input::post('Name', isset($department) ? $department->Name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Short Name', 'ShortName', array('class'=>'control-label')); ?>

				<?php echo Form::input('ShortName', Input::post('ShortName', isset($department) ? $department->ShortName : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Short Name')); ?>

		</div>
    <div class="form-group">
			<?php echo Form::label('Phone', 'Phone', array('class'=>'control-label')); ?>

				<?php echo Form::input('Phone', Input::post('Phone', isset($department) ? $department->Phone : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Phone')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>
