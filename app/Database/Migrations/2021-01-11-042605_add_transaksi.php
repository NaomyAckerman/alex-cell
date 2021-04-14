<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaksi extends Migration
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
				'null'		=> true,
			],
			'total_saldo' => [
				'type' => 'BIGINT',
				'null'		=> true,
			],
			'total_acc' => [
				'type' => 'BIGINT',
				'null'		=> true,
			],
			'total_kartu' => [
				'type' => 'BIGINT',
				'null'		=> true,
			],
			'total_partai' => [
				'type' => 'BIGINT',
				'null'		=> true,
			],
			'total_tunai' => [
				'type' => 'BIGINT',
				'null'		=> true,
			],
			'total_modal' => [
				'type' => 'BIGINT',
				'null'		=> true,
			],
			'total_keluar' => [
				'type' => 'BIGINT',
				'null'		=> true,
			],
			'total_trx' => [
				'type' => 'BIGINT',
				'null'		=> true,
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
