<?php

namespace App\Controllers;

use App\Entities\Stok;
use App\Models\{KonterModel, ProdukModel, StokModel};
use CodeIgniter\Router\Exceptions\RedirectException;

class StokController extends BaseController
{

    protected $estok, $stok, $konter, $produk, $konter_id;

    public function __construct()
    {
        $this->stok = new StokModel();
        $this->estok = new Stok();
        $this->konter = new KonterModel();
        $this->produk = new ProdukModel();
        $this->konter_id = \user()->konter_id;
    }

    public function index()
    {
        return \view('pages/stok/index', [
            'title' => 'Stok',
            'konter' => $this->konter
                ->where('id', $this->konter_id)
                ->first()
        ]);
    }

    public function stok()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('stok');
        $konter = \in_groups('karyawan') ? false : $this->konter->findAll();
        $data = ['status' => 'success'];
        if ($this->request->getMethod() === 'post') {
            $data['data'] = [
                'stok_kartu' => $this->stok
                    ->where([
                        'kategori_id' => 1,
                        'konter_id' => $this->request->getVar('konter_id'),
                        'sisa_stok' => NULL,
                    ])->orderBy('stok.created_at')->produk(),
                'stok_acc' => $this->stok
                    ->where([
                        'kategori_id' => 2,
                        'konter_id' => $this->request->getVar('konter_id'),
                        'sisa_stok' => NULL
                    ])->orderBy('stok.created_at')->produk()
            ];
            $data['token'] = csrf_hash();
        } else {
            $data['data'] = \view('pages/stok/stok', [
                'stok_kartu' => $this->stok
                    ->where([
                        'kategori_id' => 1,
                        'konter_id' => $this->konter_id,
                        'sisa_stok' => NULL,
                    ])->orderBy('stok.created_at')->produk(),
                'stok_acc' => $this->stok
                    ->where([
                        'kategori_id' => 2,
                        'konter_id' => $this->konter_id,
                        'sisa_stok' => NULL
                    ])->orderBy('stok.created_at')->produk(),
                'konter' => $konter
            ]);
        };

        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function edit()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('stok');
        $data = [
            'status' => 'success',
            'data' => \view('pages/stok/edit_stok', [
                'produk' => $this->produk->findAll()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function update()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('stok');
        $inp_stok = $this->request->getVar('stok');
        $produk_id = $this->request->getVar('produk_id');
        if ($produk_id && $inp_stok) {
            $data_produk = $this->produk->where('id', $produk_id)->first();
            $new_qty = $data_produk->produk_qty - $inp_stok;
            if ($new_qty < 0) {
                return $this->response->setStatusCode(400)
                    ->setJSON([
                        'status' => 'Bad Request',
                        'empty_qty' => [
                            'title' => 'Produk Kosong',
                            'message' => "Stok $data_produk->produk_nama tidak cukup! tersedia $data_produk->produk_qty"
                        ],
                        'token' => csrf_hash(),
                    ]);
            }
        }

        // query data stok terakhir
        $data_stok = $this->stok->where([
            'produk_id' => $produk_id,
            'konter_id' => $this->konter_id,
            'sisa_stok' => NULL
        ])->orderBy('created_at', 'DESC')->first();
        $new_stok = ($data_stok && $inp_stok) ? ($data_stok->stok + $inp_stok) : $inp_stok;
        $stok_id = $data_stok ? $data_stok->id : null;

        $this->estok->fill($this->request->getVar());
        $this->estok->stok = $new_stok;
        $this->estok->konter_id = $this->konter_id;
        $this->estok->id = $stok_id;
        $result = $this->stok->save($this->estok);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'Bad Request',
                    'errors' => $this->stok->errors(),
                    'token' => csrf_hash(),
                ]);
        }
        // update stok gudang
        $this->produk->update($produk_id, [
            'produk_qty' => $new_qty
        ]);

        $data = [
            'status' => 'success',
            'data' => 'Berhasil menambah <strong>' . $this->request->getVar('stok') . '</strong> stok',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
}
