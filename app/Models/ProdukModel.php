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
        'kategori_id', 'produk_nama', 'produk_gambar', 'produk_slug', 'produk_deskripsi', 'produk_qty', 'harga_supply', 'harga_user', 'harga_partai', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'kategori_id' => [
            'label'  => 'kategori',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memilih {field} produk.'
            ]
        ],
        'produk_nama' => [
            'label'  => 'Nama produk',
            'rules'  => 'required|is_unique[produk.produk_nama,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memilih {field}.',
                'is_unique' => 'Maaf. {field} sudah tersedia.'
            ]
        ],
        'produk_gambar' => [
            'label'  => 'Gambar produk',
            'rules'  => 'max_size[produk_gambar,1024]|is_image[produk_gambar]|mime_in[produk_gambar,image/png,image/jpg,image/jpeg]',
            'errors' => [
                'max_size' => 'Ukuran file {field} max 1mb.',
                'is_image' => 'Format file {field} bukan gambar.',
                'mime_in' => 'File {field} bukan gambar.',
                'is_unique' => 'Maaf. {field} sudah tersedia.'
            ]
        ],
        'produk_deskripsi' => [
            'label'  => 'Deskripsi',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memilih {field}.',
            ]
        ],
        'produk_qty' => [
            'label'  => 'Qty produk',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field}.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'harga_supply' => [
            'label'  => 'Harga Supply',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field}.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'harga_user' => [
            'label'  => 'Harga User',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field}.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'harga_partai' => [
            'label'  => 'Harga Partai',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field}.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];

    public function kategori()
    {
        return $this->join('kategori', 'kategori.id = produk.kategori_id')->findAll();
    }
}
