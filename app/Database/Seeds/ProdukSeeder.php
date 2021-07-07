<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ProdukSeeder extends Seeder
{
	public function run()
	{
		$faker = Factory::create();
		for ($i = 1; $i < 20; $i++) {
			$nama = "produk{$i}";
			$konter_id = ($i == 18 || $i == 19) ? 2 : 1;
			$this->db->table('produk')->insert([
				'kategori_id' 		=> $konter_id,
				'produk_gambar' 	=> "{$nama}.png",
				'produk_slug' 		=> $nama,
				'produk_nama'		=> $nama,
				'produk_deskripsi' 	=> $faker->text(100),
				'produk_qty'		=> 0,
				'harga_supply'		=> 0,
				'harga_user'		=> 0,
				'harga_partai'		=> 0,
				'created_at' 		=> Time::now(),
				'updated_at' 		=> Time::now(),
			]);
		}
	}
}
