<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produk;
    public function __construct()
    {
        $this->produk = new ProdukModel();
    }

    public function index()
    {
        return \view('pages/produk/index', ['title' => 'Produk']);
    }
    public function produk()
    {
        $produk = $this->produk->findAll();
        return \view('pages/produk/produk', [
            'title' => 'Produk',
            'produk' =>  $produk
        ]);
    }
}
