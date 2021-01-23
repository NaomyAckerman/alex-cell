<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Kategori';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['kategori_nama', 'kategori_gambar', 'kategori_slug', 'kategori_deskripsi', 'created_by', 'updated_by', 'deleted_by'];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'nama' => [
            'label'  => 'Nama',
            'rules'  => 'required|is_unique[kategori.nama,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memilih {field} kategori.',
                'is_unique' => 'Maaf. {field} itu sudah diambil. Pilih yang lain.'
            ]
        ],
    ];
}
