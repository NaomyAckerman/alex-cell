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
        'konter_id', 'produk_id', 'trx_kartu_qty', 'created_by', 'updated_by', 'deleted_by', 'created_at'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'trx_kartu_qty' => [
            'label'  => 'Qty',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memasukkan {field} transaksi kartu.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
    public function produk()
    {
        return $this->join('produk', 'produk.id = transaksi_kartu.produk_id')->findAll();
    }
}
