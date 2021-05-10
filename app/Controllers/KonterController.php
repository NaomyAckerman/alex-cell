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

    public function index() // * done
    {
        return \view('pages/konter/index', ['title' => 'Konter']);
    }

    public function konter() // * done
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

    public function create() // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('konter');
        $data = [
            'status' => 'success',
            'data' => \view('pages/konter/tambah_konter'),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function store() // * done
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

    public function delete($id) // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('konter');
        $konter = $this->konter->find($id);
        $this->konter->delete($konter->id, true);
        if ($konter->konter_gambar) \unlink("assets/images/konter/$konter->konter_gambar");
        $data = [
            'status' => 'success',
            'data' => "Berhasil hapus konter <strong>$konter->konter_nama</strong>",
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function edit($id) // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('konter');
        $data = [
            'status' => 'success',
            'data' => \view('pages/konter/edit_konter', [
                'konter' => $this->konter->where('id', $id)->first()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function update($id) // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('konter');
        $file = $this->request->getFile('konter_gambar');
        $konter = $this->konter->find($id);

        if (!$konter) throw new PageNotFoundException();
        $nama_gambar = (!$file->isValid()) ? $konter->konter_gambar : $file->getRandomName();

        $this->ekonter->fill($this->request->getVar());
        $this->ekonter->konter_gambar = $nama_gambar;
        $this->ekonter->konter_slug = \url_title($this->request->getVar('konter_nama'));
        $this->ekonter->id = $konter->id;
        $result = $this->konter->save($this->ekonter);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON(
                    [
                        'status' => 'Bad Request',
                        'errors' => $this->konter->errors(),
                        'token' => csrf_hash(),
                    ]
                );
        }
        if ($file->isValid() && !$file->hasMoved()) {
            if ($konter->konter_gambar) \unlink('assets/images/konter/' . $konter->konter_gambar);
            $file->move('assets/images/konter', $nama_gambar);
        }
        $data = [
            'status' => 'success',
            'data' => "Berhasil Edit konter <strong>$konter->konter_nama</strong>",
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
}
