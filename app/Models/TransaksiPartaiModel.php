<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiPartaiModel extends Model
{
    protected $table = 'transaksi_partai';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Transaksipartai';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'konter_id', 'produk_id', 'user_id', 'qty', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'qty' => [
            'label'  => 'Qty',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} transaksi partai.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
}
