<?php

namespace Fuel\Migrations;

class Create_colleges
{
	public function up()
	{
		\DBUtil::create_table('colleges', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'ShortName' => array('constraint' => 255, 'type' => 'varchar'),
			'Name' => array('constraint' => 255, 'type' => 'varchar'),
			'Address' => array('type' => 'text'),
			'Phone' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('colleges');
	}
}
