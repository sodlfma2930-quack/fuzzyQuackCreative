<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRsvpsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'			=> [
				'type'				=> 'INT',
				'constraint'		=> 11,
				'unsigned'			=> true,
				'auto_increment'	=> true,
			],
			'name'			=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 50,
			],
			'phone'			=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 13,
			],
			'guests'		=> [
				'type'			=> 'TINYINT',
				'unsigned'		=> true,
				'default'		=> 0,
			],
			'attendance'	=> [
				'type'			=> 'ENUM',
				'constraint'	=> ['yes', 'no'],
				'default'		=> 'yes',
			],
			'message'		=> [
				'type'			=> 'VARCHAR',
				'constraint'	=> 255,
				'null'			=> true,
			],
			'created_at'	=> [
				'type'			=> 'DATETIME',
				'null'			=> false,
				'default'		=> 'current_timestamp()',
			],
			'updated_at'	=> [
				'type'			=> 'DATETIME',
				'null'			=> true,
				'default'		=> null,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('rsvps', true);
	}

	public function down()
	{
		$this->forge->dropTable('rsvps', true);
	}
}
