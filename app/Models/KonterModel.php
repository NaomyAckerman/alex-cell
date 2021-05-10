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
        'konter_nama', 'konter_gambar', 'konter_email', 'konter_no_telp', 'created_by', 'updated_by', 'deleted_by'
    ];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'konter_nama' => [
            'label'  => 'Nama',
            'rules'  => 'required|is_unique[konter.konter_nama,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memilih {field} konter.',
                'is_unique' => 'Maaf. {field} itu sudah diambil. Pilih yang lain.'
            ]
        ],
        'konter_gambar' => [
            'label'  => 'gambar konter',
            'rules'  => 'max_size[konter_gambar,1024]|is_image[konter_gambar]|mime_in[konter_gambar,image/png,image/jpg,image/jpeg]',
            'errors' => [
                'max_size' => 'Ukuran file {field} max 1mb.',
                'is_image' => 'Format file {field} bukan gambar.',
                'mime_in' => 'File {field} bukan gambar.',
                'is_unique' => 'Maaf. {field} sudah tersedia.'
            ]
        ],
        'konter_email' => [
            'label'  => 'Email',
            'rules'  => 'required|is_unique[konter.konter_email,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memilih {field} konter.',
                'is_unique' => 'Maaf. {field} itu sudah diambil. Pilih yang lain.'
            ]
        ],
        'konter_no_telp' => [
            'label'  => 'No Telephone',
            'rules'  => 'required|numeric|exact_length[11,13,12]',
            'errors' => [
                'required' => 'Anda harus memilih {field} konter.',
                'numeric' => 'Maaf. format {field} salah, gunakan format numeric!.',
                'exact_length' => 'Jumlah {field} tidak valid.'
            ]
        ],
    ];
}
