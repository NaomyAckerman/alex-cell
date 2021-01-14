<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'kategori_id' => [
				'type' => 'INT',
				'unsigned' => true,
			],
			'nama' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'deskripsi' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'qty' => [
				'type' => 'INT',
			],
			'harga_supply' => [
				'type' => 'BIGINT',
			],
			'harga_user' => [
				'type' => 'BIGINT',
			],
			'harga_partai' => [
				'type' => 'BIGINT',
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
		$this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('produk');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('produk');
	}
}
