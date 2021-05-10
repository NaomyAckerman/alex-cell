<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiSaldoModel extends Model
{
    protected $table = 'transaksi_saldo';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Transaksisaldo';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'konter_id', 'ar_id', 'ar_nama', 'saldo', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'ar_id' => [
            'label'  => 'Saldo',
            'rules'  => 'required|alpha_numeric',
            'errors' => [
                'required' => 'Anda harus memasukkan {field} transaksi saldo.',
                'alpha_numeric' => 'Maaf. format {field} salah, gunakan format alpha numeric!.'
            ]
        ],
        'ar_nama' => [
            'label'  => 'Nama',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memasukkan {field} transaksi saldo.',
            ]
        ],
        'saldo' => [
            'label'  => 'Saldo',
            'rules'  => 'required|numeric',
            'errors' => [
                'required' => 'Anda harus memasukkan {field} transaksi saldo.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
            ]
        ],
    ];
}
