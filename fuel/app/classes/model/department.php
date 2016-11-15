<?php

class Model_Department extends \Orm\Model
{
	protected static $_properties = array(
    'id',
    'College',
    'ShortName',
    'Name',
    'Phone',
    'created_at',
    'updated_at'
	);

  protected static $_belongs_to = array(
    'Department' => array(
      'key_from'       => 'College',
      'model_to'       => 'Model_College',
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

	protected static $_table_name = 'departments';

}
