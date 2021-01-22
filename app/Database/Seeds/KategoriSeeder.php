<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'kartu',
                'gambar' => 'kartu_kategori.jpg',
                'deskripsi' => 'kartu perdana dan paketan',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'nama' => 'acc',
                'gambar' => 'acc_kategori.jpg',
                'deskripsi' => 'aksesoris',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];
        // Using Query Builder
        $this->db->table('kategori')->insertBatch($data);
    }
}
