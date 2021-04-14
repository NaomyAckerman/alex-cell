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
        'konter_id', 'produk_id', 'reseller', 'trx_partai_qty', 'created_by', 'updated_by', 'deleted_by', 'created_at'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'trx_partai_qty' => [
            'label'  => 'Jumlah',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memasukkan {field} transaksi partai.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
        'produk_id' => [
            'label'  => 'Produk',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memilih {field}.',
            ]
        ],
        'reseller' => [
            'label'  => 'Resseller',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memasukkan {field}.',
            ]
        ],
    ];
}
