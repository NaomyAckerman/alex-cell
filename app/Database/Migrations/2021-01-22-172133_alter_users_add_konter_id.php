<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersAddKonterId extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
			'konter_id' => [
				'type' => 'INT',
				'after' => 'id',
				'unsigned' => true,
			],
			'CONSTRAINT `users_konter_id_foreign` FOREIGN KEY(`konter_id`) REFERENCES `konter`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
		]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropForeignKey('users', 'users_konter_id_foreign');
		$this->forge->dropColumn('users', 'konter_id');
	}
}
