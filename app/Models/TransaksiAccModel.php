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
        'konter_id', 'produk_id', 'trx_acc_qty', 'created_by', 'updated_by', 'deleted_by', 'created_at'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'trx_acc_qty' => [
            'label'  => 'sisa',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memasukkan {field} transaksi acc.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
    public function produk()
    {
        return $this->join('produk', 'produk.id = transaksi_kartu.produk_id')->findAll();
    }
}
