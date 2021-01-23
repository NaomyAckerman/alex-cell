<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class ProdukController extends BaseController
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
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException('produk');
        }
        $produk = $this->produk
            ->join('kategori', 'kategori.id = produk.kategori_id', 'left')
            ->findAll();
        $data = [
            'status' => 'success',
            'data' => \view('pages/produk/produk', [
                'title' => 'Produk',
                'produk' =>  $produk
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
}
