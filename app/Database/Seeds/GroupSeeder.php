<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'owner',
                'description' => 'role owner'
            ],
            [
                'name' => 'admin',
                'description' => 'role admin'
            ],
            [
                'name' => 'karyawan',
                'description' => 'role karyawan'
            ],
            [
                'name' => 'user',
                'description' => 'role user'
            ],
        ];

        // Using Query Builder
        $this->db->table('auth_groups')->insertBatch($data);
    }
}
