<?php

class Model_Course extends \Orm\Model
{
	protected static $_properties = array(
		'id',
    'Department',
		'Name',
		'Hours',
		'Code',
		'WritingEnhanced',
		'Honors',
		'Lab',
		'created_at',
		'updated_at',
	);

  protected static $_belongs_to = array(
    'Department' => array(
      'key_from'       => 'Department',
      'model_to'       => 'Model_Department',
      'key_to'         => 'id',
      'cascade_save'   => true,
      'cascade_delete' => false
    )
  );

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'courses';

}
