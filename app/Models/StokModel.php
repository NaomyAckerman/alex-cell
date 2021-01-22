<?php

namespace App\Models;

use CodeIgniter\Model;

class StokModel extends Model
{
    protected $table = 'stok';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Stok';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'konter_id', 'produk_id', 'stok', 'sisa_stok', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'stok' => [
            'label'  => 'Stok',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} stok.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'sisa_stok' => [
            'label'  => 'Sisa Stok',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} stok.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
}
