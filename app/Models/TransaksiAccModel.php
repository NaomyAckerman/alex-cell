<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiAccModel extends Model
{
    protected $table = 'transaksi_acc';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Transaksiacc';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'konter_id', 'produk_id', 'qty', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'qty' => [
            'label'  => 'Qty',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memilih {field} transaksi acc.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
}