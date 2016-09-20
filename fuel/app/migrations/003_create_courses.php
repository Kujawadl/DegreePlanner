<?php

namespace Fuel\Migrations;

class Create_courses
{
	public function up()
	{
		\DBUtil::create_table('courses', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
      'Department' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
      'Name' => array('constraint' => 255, 'type' => 'varchar'),
			'Hours' => array('constraint' => 11, 'type' => 'int'),
			'Code' => array('constraint' => 11, 'type' => 'int'),
			'WritingEnhanced' => array('type' => 'boolean'),
			'Honors' => array('type' => 'boolean'),
			'Lab' => array('type' => 'boolean'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'), true, false, null,
    array(
      'key' => 'Department',
      'reference' => array(
        'table' => 'departments',
        'column' => 'id'
      ),
      'on_update' => 'CASCADE',
      'on_delete' => 'RESTRICT'
    ),
    null));
	}

	public function down()
	{
		\DBUtil::drop_table('courses');
	}
}
