<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiKartuModel extends Model
{
    protected $table = 'transaksi_kartu';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Transaksikartu';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'konter_id', 'produk_id', 'trx_kartu_qty', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'qty' => [
            'label'  => 'Qty',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} transaksi kartu.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
}
