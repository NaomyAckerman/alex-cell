<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaksiSaldo extends Migration
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
			'ar_id' => [
				'type' => 'VARCHAR',
				'constraint' => '10',
			],
			'nama' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'saldo' => [
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
		$this->forge->createTable('transaksi_saldo');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transaksi_saldo');
	}
}
