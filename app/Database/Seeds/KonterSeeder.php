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
                'konter_nama' => 'asabri',
                'konter_gambar' => 'asabri.jpg',
                'konter_email' => 'asabri@gmail.com',
                'konter_no_telp' => '081934613970',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'konter_nama' => 'cokro',
                'konter_gambar' => 'cokro.jpg',
                'konter_email' => 'cokro@gmail.com',
                'konter_no_telp' => '081934613970',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];
        // Using Query Builder
        $this->db->table('konter')->insertBatch($data);
    }
}
