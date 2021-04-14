<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Transaksi';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'konter_id', 'total_pulsa', 'total_saldo', 'total_acc', 'total_kartu', 'total_partai', 'total_tunai', 'total_modal', 'total_keluar', 'total_trx', 'created_by', 'updated_by', 'deleted_by', 'created_at'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        // 'total_pulsa' => [
        //     'label'  => 'Total Pulsa',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
        // 'total_saldo' => [
        //     'label'  => 'Total Saldo',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
        // 'total_acc' => [
        //     'label'  => 'Total Acc',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
        // 'total_kartu' => [
        //     'label'  => 'Total Kartu',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
        // 'total_partai' => [
        //     'label'  => 'Total Partai',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
        // 'total_tunai' => [
        //     'label'  => 'Total Tunai',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
        // 'total_keluar' => [
        //     'label'  => 'Total Keluar',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
        // 'total_trx' => [
        //     'label'  => 'Total Trx',
        //     'rules'  => 'required|numeric',
        //     'errors' => [
        //         'required' => 'Anda harus memilih {field} transaksi.',
        //         'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.'
        //     ]
        // ],
    ];
}
