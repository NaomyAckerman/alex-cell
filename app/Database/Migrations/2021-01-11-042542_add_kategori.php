<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategori extends Migration
{

	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'nama'       => [
				'type'          => 'VARCHAR',
				'constraint'    => '128',
			],
			'gambar'       => [
				'type'          => 'VARCHAR',
				'constraint'    => '128',
			],
			'deskripsi'       => [
				'type'          => 'TEXT',
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
				'type'          => 'DATETIME',
			],
			'updated_at' => [
				'type' 			=> 'DATETIME',
			],
			'deleted_at' => [
				'type' 			=> 'DATETIME',
				'null'		=> true,
			],
		]);
		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('kategori');
	}

	public function down()
	{
		$this->forge->dropTable('kategori');
	}
}
