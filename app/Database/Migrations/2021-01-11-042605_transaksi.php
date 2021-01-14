<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
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
			'total_pulsa' => [
				'type' => 'BIGINT',
			],
			'total_saldo' => [
				'type' => 'BIGINT',
			],
			'total_acc' => [
				'type' => 'BIGINT',
			],
			'total_kartu' => [
				'type' => 'BIGINT',
			],
			'total_partai' => [
				'type' => 'BIGINT',
			],
			'total_tunai' => [
				'type' => 'BIGINT',
			],
			'total_keluar' => [
				'type' => 'BIGINT',
			],
			'total_trx' => [
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
		$this->forge->addForeignKey('konter_id', 'konter', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('transaksi');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transaksi');
	}
}
