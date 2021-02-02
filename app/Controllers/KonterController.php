<?php

namespace App\Controllers;

use App\Entities\Konter;
use App\Models\KonterModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Router\Exceptions\RedirectException;

class KonterController extends BaseController
{
    protected $konter, $ekonter;
    public function __construct()
    {
        $this->konter = new KonterModel();
        $this->ekonter = new Konter();
    }

    public function index()
    {
        return \view('pages/konter/index', ['title' => 'Konter']);
    }

    public function konter()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('konter');
        $data = [
            'status' => 'success',
            'data' => \view('pages/konter/konter', [
                'konter' =>  $this->konter->findAll()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function create()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('konter');
        $data = [
            'status' => 'success',
            'data' => \view('pages/konter/tambah_konter'),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('konter');
        $file = $this->request->getFile('konter_gambar');
        $nama_gambar = ($file->isValid()) ? $file->getRandomName() : '';
        $this->ekonter->fill($this->request->getVar());
        $this->ekonter->konter_gambar = $nama_gambar;
        $result = $this->konter->save($this->ekonter);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'Bad Request',
                    'errors' => $this->konter->errors(),
                    'token' => csrf_hash(),
                ]);
        }
        if ($file->isValid() && !$file->hasMoved()) $file->move('assets/images/konter', $nama_gambar);
        $data = [
            'status' => 'success',
            'data' => 'Berhasil menyimpan data konter baru <strong>' . $this->request->getVar('konter_nama') . '</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
}
