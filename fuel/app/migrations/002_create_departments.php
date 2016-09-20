<?php

namespace Fuel\Migrations;

class Create_departments
{
	public function up()
	{
		\DBUtil::create_table('departments', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
      'College' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
      'ShortName' => array('constraint' => 255, 'type' => 'varchar'),
			'Name' => array('constraint' => 255, 'type' => 'varchar'),
			'Phone' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'), true, false, null,
    array(
      'key' => 'College',
      'reference' => array(
        'table' => 'colleges',
        'column' => 'id'
      ),
      'on_update' => 'CASCADE',
      'on_delete' => 'RESTRICT'
    ),
    null);
	}

	public function down()
	{
		\DBUtil::drop_table('departments');
	}
}
