<?php

namespace App\Database\Seeds;

use Faker\Factory;
use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $data = [
            [
                'konter_id' => 1,
                'email' => 'owner@gmail.com',
                'username' => 'owner',
                'alamat' => $faker->streetAddress,
                'no_telp' => $faker->phoneNumber,
                'password_hash' => '$2y$10$umy.OmWOBLUDNXBdqT1e1.sNynULxyi4uuS2aFG4DaiY5OhdaSrMK',
                'active' => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'konter_id' => 1,
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'alamat' => $faker->streetAddress,
                'no_telp' => $faker->phoneNumber,
                'password_hash' => '$2y$10$umy.OmWOBLUDNXBdqT1e1.sNynULxyi4uuS2aFG4DaiY5OhdaSrMK',
                'active' => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'konter_id' => 1,
                'email' => 'karyawan@gmail.com',
                'username' => 'karyawan',
                'alamat' => $faker->streetAddress,
                'no_telp' => $faker->phoneNumber,
                'password_hash' => '$2y$10$umy.OmWOBLUDNXBdqT1e1.sNynULxyi4uuS2aFG4DaiY5OhdaSrMK',
                'active' => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'konter_id' => 2,
                'email' => 'karyawan2@gmail.com',
                'username' => 'karyawan2',
                'alamat' => $faker->streetAddress,
                'no_telp' => $faker->phoneNumber,
                'password_hash' => '$2y$10$umy.OmWOBLUDNXBdqT1e1.sNynULxyi4uuS2aFG4DaiY5OhdaSrMK',
                'active' => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ]
        ];
        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
