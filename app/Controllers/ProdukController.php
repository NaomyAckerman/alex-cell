<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Router\Exceptions\RedirectException;
use App\Entities\{Produk, Stok};
use App\Models\{ProdukModel, KategoriModel, StokModel};
use phpDocumentor\Reflection\Types\Null_;

class ProdukController extends BaseController
{

    protected $produk, $eproduk, $kategori, $stok, $estok;

    public function __construct()
    {
        $this->stok = new StokModel();
        $this->estok = new Stok();
        $this->produk = new ProdukModel();
        $this->kategori = new KategoriModel();
        $this->eproduk = new Produk();
    }

    public function index()
    {
        return \view('pages/produk/index', ['title' => 'Produk']);
    }

    public function produk()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('produk');
        $data = [
            'status' => 'success',
            'data' => \view('pages/produk/produk', [
                'produk' =>  $this->produk->orderBy('produk.id', 'DESC')->kategori(),
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function create()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('produk');
        $data = [
            'status' => 'success',
            'data' => \view('pages/produk/tambah_produk', [
                'kategori' => $this->kategori->findAll()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('produk');
        $file = $this->request->getFile('produk_gambar');
        $nama_gambar = ($file->isValid()) ? $file->getRandomName() : '';
        $this->eproduk->fill($this->request->getVar());
        $this->eproduk->produk_slug = \url_title($this->request->getVar('produk_nama'));
        $this->eproduk->produk_gambar = $nama_gambar;
        $result = $this->produk->save($this->eproduk);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'Bad Request',
                    'errors' => $this->produk->errors(),
                    'token' => csrf_hash(),
                ]);
        }
        if ($file->isValid() && !$file->hasMoved()) $file->move('assets/images/products', $nama_gambar);
        // add stok per-konter
        $produk_id = $this->produk->getInsertID();
        for ($i = 0; $i < 2; $i++) {
            $this->estok->konter_id = $i + 1;
            $this->estok->produk_id = $produk_id;
            $this->estok->stok = 0;
            $this->estok->sisa_stok = NULL;
            $this->estok->stok_terjual = NULL;
            $this->stok->save($this->estok);
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil menyimpan produk baru <strong>' . $this->request->getVar('produk_nama') . '</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function delete($slug)
    {
        if (!$this->request->isAJAX()) throw new RedirectException('produk');
        $produk = $this->produk->where('produk_slug', $slug)->first();
        $this->produk->delete($produk->id, true);
        if ($produk->produk_gambar) \unlink("assets/images/products/$produk->produk_gambar");
        $data = [
            'status' => 'success',
            'data' => "Berhasil hapus Produk <strong>$produk->produk_nama</strong>",
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function edit($slug)
    {
        if (!$this->request->isAJAX()) throw new RedirectException('produk');
        $data = [
            'status' => 'success',
            'data' => \view('pages/produk/edit_produk', [
                'kategori' => $this->kategori->findAll(),
                'produk' => $this->produk->where('produk_slug', $slug)->first()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function update($slug)
    {
        if (!$this->request->isAJAX()) throw new RedirectException('produk');
        $file = $this->request->getFile('produk_gambar');
        $produk = $this->produk->where('produk_slug', $slug)->first();

        if (!$produk) throw new PageNotFoundException();
        $nama_gambar = (!$file->isValid()) ? $produk->produk_gambar : $file->getRandomName();

        $this->eproduk->fill($this->request->getVar());
        $this->eproduk->produk_gambar = $nama_gambar;
        $this->eproduk->produk_slug = \url_title($this->request->getVar('produk_nama'));
        $this->eproduk->id = $produk->id;
        $result = $this->produk->save($this->eproduk);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON(
                    [
                        'status' => 'Bad Request',
                        'errors' => $this->produk->errors(),
                        'token' => csrf_hash(),
                    ]
                );
        }
        if ($file->isValid() && !$file->hasMoved()) {
            if ($produk->produk_gambar) \unlink('assets/images/products/' . $produk->produk_gambar);
            $file->move('assets/images/products', $nama_gambar);
        }
        $data = [
            'status' => 'success',
            'data' => "Berhasil Edit produk <strong>$produk->produk_nama</strong>",
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
}
