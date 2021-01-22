<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class KonterSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'asabri',
                'gambar' => 'asabri.jpg',
                'email' => 'asabri@gmail.com',
                'no_telp' => '081934613970',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'nama' => 'cokro',
                'gambar' => 'cokro.jpg',
                'email' => 'cokro@gmail.com',
                'no_telp' => '081934613970',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];
        // Using Query Builder
        $this->db->table('konter')->insertBatch($data);
    }
}
