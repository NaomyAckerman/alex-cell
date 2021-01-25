<?php

namespace App\Controllers;

use App\Entities\Produk;
use App\Models\ProdukModel;

class ProdukController extends BaseController
{

    protected $produk, $eproduk;

    public function __construct()
    {
        $this->produk = new ProdukModel();
        $this->eproduk = new Produk();
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
        $data = [
            'status' => 'success',
            'data' => \view('pages/produk/produk', [
                'produk' =>  $this->produk->kategori()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function create()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException('produk');
        }
        $data = [
            'status' => 'success',
            'data' => \view('pages/produk/tambah_produk'),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function store()
    {
        $attr = $this->eproduk->fill($this->request->getVar());
        $result = $this->produk->save($attr);
        if (!$result) {
            return $this->response->setStatusCode(200)
                ->setJSON(
                    [
                        'status' => 'Bad Request',
                        'errors' => $this->produk->errors(),
                        'token' => csrf_hash(),
                        'data' => $attr
                    ]
                );
        }
        $data = [
            'status' => 'sukses',
            'data' => $result
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
}
