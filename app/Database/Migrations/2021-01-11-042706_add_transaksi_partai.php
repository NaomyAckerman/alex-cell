<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaksiPartai extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'konter_id' => [
				'type' => 'INT',
				'unsigned' => true,
			],
			'produk_id' => [
				'type' => 'INT',
				'unsigned' => true,
			],
			'user_id' => [
				'type' => 'INT',
				'unsigned' => true,
			],
			'qty' => [
				'type' => 'INT',
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
		$this->forge->addForeignKey('produk_id', 'produk', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('konter_id', 'konter', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('transaksi_partai');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transaksi_partai');
	}
}
