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
                'kategori_nama' => 'kartu',
                'kategori_slug' => 'kartu',
                'kategori_gambar' => 'kartu_kategori.jpg',
                'kategori_deskripsi' => 'kartu perdana dan paketan',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'kategori_nama' => 'acc',
                'kategori_slug' => 'kartu',
                'kategori_gambar' => 'acc_kategori.jpg',
                'kategori_deskripsi' => 'aksesoris',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];
        // Using Query Builder
        $this->db->table('kategori')->insertBatch($data);
    }
}
