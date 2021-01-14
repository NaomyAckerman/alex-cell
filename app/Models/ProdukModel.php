<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Produk';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'kategori_id', 'nama', 'deskripsi', 'qty', 'harga_supply', 'harga_user', 'harga_partai', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'nama' => [
            'label'  => 'Nama',
            'rules'  => 'required|is_unique[produk.nama,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memilih {field} produk.',
                'is_unique' => 'Maaf. {field} itu sudah diambil. Pilih yang lain.'
            ]
        ],
        'deskripsi' => [
            'label'  => 'Deskripsi',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memilih {field} produk.',
            ]
        ],
        'qty' => [
            'label'  => 'Qty',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} produk.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'harga_supply' => [
            'label'  => 'Harga Supply',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} produk.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'harga_user' => [
            'label'  => 'Harga User',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} produk.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'harga_partai' => [
            'label'  => 'Harga Partai',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} produk.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
}
