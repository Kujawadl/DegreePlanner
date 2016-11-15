<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Name', 'Name', array('class'=>'control-label')); ?>

				<?php echo Form::input('Name', Input::post('Name', isset($college) ? $college->Name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Short Name', 'ShortName', array('class'=>'control-label')); ?>

				<?php echo Form::input('ShortName', Input::post('ShortName', isset($college) ? $college->ShortName : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Short Name')); ?>

		</div>
    <div class="form-group">
			<?php echo Form::label('Address', 'Address', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('Address', Input::post('Address', isset($college) ? $college->Address : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Address')); ?>

		</div>
    <div class="form-group">
			<?php echo Form::label('Phone', 'Phone', array('class'=>'control-label')); ?>

				<?php echo Form::input('Phone', Input::post('Phone', isset($college) ? $college->Phone : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Phone')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>
