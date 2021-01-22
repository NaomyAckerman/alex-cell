<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKonter extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'				=> 'INT',
				'unsigned' 			=> true,
				'auto_increment' 	=> true,
			],
			'nama' => [
				'type'				=> 'VARCHAR',
				'constraint' 		=> '128'
			],
			'gambar' => [
				'type'				=> 'VARCHAR',
				'constraint' 		=> '128'
			],
			'email' => [
				'type' 				=> 'VARCHAR',
				'constraint' 		=> '128',
			],
			'no_telp' => [
				'type'				=> 'VARCHAR',
				'constraint' 		=> '20',
			],
			'created_by' => [
				'type' 			=> 'INT',
				'null'		=> true,
			],
			'updated_by' => [
				'type' 			=> 'INT',
				'null'		=> true,
			],
			'deleted_by' => [
				'type' 			=> 'INT',
				'null'		=> true,
			],
			'created_at' => [
				'type'				=> 'DATETIME',
			],
			'updated_at' => [
				'type'				=> 'DATETIME',
			],
			'deleted_at' => [
				'type'				=> 'DATETIME',
				'null'		=> true,
			],
		]);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('konter');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('konter');
	}
}
