<?php

namespace App\Models;

use CodeIgniter\Model;

class KonterModel extends Model
{
    protected $table = 'konter';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Konter';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'nama', 'email', 'no_telp', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'nama' => [
            'label'  => 'Nama',
            'rules'  => 'required|is_unique[konter.nama,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memilih {field} konter.',
                'is_unique' => 'Maaf. {field} itu sudah diambil. Pilih yang lain.'
            ]
        ],
        'email' => [
            'label'  => 'Email',
            'rules'  => 'required|is_unique[konter.email,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memilih {field} konter.',
                'is_unique' => 'Maaf. {field} itu sudah diambil. Pilih yang lain.'
            ]
        ],
        'no_telp' => [
            'label'  => 'No Telephone',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} konter.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
}
