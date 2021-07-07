<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seed extends Seeder
{
        public function run()
        {
                $this->call('KonterSeeder');
                $this->call('KategoriSeeder');
                $this->call('UserSeeder');
                $this->call('GroupSeeder');
                $this->call('GroupUserSeeder');
                $this->call('ProdukSeeder');
        }
}
