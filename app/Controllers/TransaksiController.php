<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use CodeIgniter\Router\Exceptions\RedirectException;
use App\Entities\{Stok, Transaksiacc, Transaksikartu, Transaksipartai, Transaksi, Transaksisaldo};
use App\Libraries\Pdf;
use App\Models\{KonterModel, ProdukModel, StokModel, TransaksiAccModel, TransaksiKartuModel, TransaksiModel, TransaksiPartaiModel, TransaksiSaldoModel, UserModel};
use TCPDF;

class TransaksiController extends BaseController
{
    protected $user, $konter, $trx_saldo, $etrx_saldo, $trx, $etrx, $produk, $trx_reseller, $trx_kartu, $trx_acc, $stok, $etrx_reseller, $etrx_kartu, $etrx_acc, $estok, $konter_id;
    public function __construct()
    {
        $this->konter_id = \user()->konter_id;
        $this->user = new UserModel();
        $this->konter = new KonterModel();
        $this->produk = new ProdukModel();
        $this->trx_kartu = new TransaksiKartuModel();
        $this->etrx_kartu = new Transaksikartu();
        $this->trx_acc = new TransaksiAccModel();
        $this->etrx_acc = new Transaksiacc();
        $this->trx_reseller = new TransaksiPartaiModel();
        $this->etrx_reseller = new Transaksipartai();
        $this->stok = new StokModel();
        $this->estok = new Stok();
        $this->trx = new TransaksiModel();
        $this->etrx = new Transaksi();
        $this->trx_saldo = new TransaksiSaldoModel();
        $this->etrx_saldo = new Transaksisaldo();
    }

    public function index() // * fix code
    {
        $url = current_url(true)->getSegment(2);
        if ($url == 'saldo') {
            return \view('pages/transaksi/saldo/index', [
                'title' => 'Transaksi Saldo',
            ]);
        } elseif ($url == 'reseller') {
            return \view('pages/transaksi/reseller/index', [
                'title' => 'Transaksi Reseller',
            ]);
        } elseif ($url == 'kartu') {
            return \view('pages/transaksi/kartu/index', [
                'title' => 'Transaksi Kartu',
            ]);
        } elseif ($url == 'acc') {
            return \view('pages/transaksi/aksesoris/index', [
                'title' => 'Transaksi Aksesoris',
            ]);
        } else {
            return \view('pages/transaksi/rekap/index', [
                'title' => 'Rekap Transaksi',
            ]);
        }
    }

    public function saldo() // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('saldo');
        $data = ['status' => 'success'];

        $data_submit = [];
        // trx
        $trx = $this->trx->where(['konter_id' => $this->konter_id])->orderBy('created_at', 'DESC')->first();
        $day_now = ($this->now->getHour() < 5) ? $this->now->day - 1 : $this->now->day;
        // cek tabel transaksi kosongan
        if ($trx) {
            $day_trx = Time::parse($trx->created_at)->day;
            // Cek apakah sudah submit pada trx hari ini
            ($day_trx == $day_now && $trx->total_saldo != null) ? \array_push($data_submit, ['status_submit' => true]) : false;
        }

        // Submit trx hari ini
        if ($this->request->getMethod() == 'post') {
            // cek tabel transaksi kosongan maka auto save
            $kondisi = ($trx) ? ($day_trx == $day_now && $trx->total_saldo == null) : false;

            $total_trx_saldo = $this->request->getVar('total_trx_saldo');

            // cek jika trx sama dgn hri ini dan totalnya null maka update
            if ($kondisi) {
                // update data trx
                $this->trx->update($trx->id, ['total_saldo' => $total_trx_saldo, 'created_at' => $this->now]);
            } else {
                // save data trx baru
                $this->etrx->total_saldo = $total_trx_saldo;
                $this->etrx->konter_id = $this->konter_id;
                $this->etrx->created_at = $this->now;
                $this->trx->save($this->etrx);
            }
            $data['submit'] = 'berhasil submit data transaksi';
            return $this->response->setStatusCode(200)
                ->setJSON($data);
        }

        $saldo = $this->trx_saldo->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d')
        ])->findAll();

        $data['data'] = \view('pages/transaksi/saldo/saldo', [
            'title' => 'Transaksi Saldo',
            'trx_saldo' => $saldo,
            'status_submit' => $data_submit
        ]);
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function saldo_create() // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('saldo');
        $data = [
            'status' => 'success',
            'data' => \view('pages/transaksi/saldo/tambah_saldo'),
        ];
        // trx
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'total_saldo !=' => null,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->first();
        // Cek apakah sudah submit pada trx hari ini
        if ($trx) {
            $data = [
                'status' => 'Bad Request',
                'submit_err' => [
                    'title' => 'Status Transaksi',
                    'message' => "Transaksi saldo hari ini telah selesai"
                ],
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function saldo_store() // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('saldo');

        $this->etrx_saldo->fill($this->request->getVar());
        $this->etrx_saldo->konter_id = $this->konter_id;
        $this->etrx_saldo->create_at = $this->date_now;
        $result = $this->trx_saldo->save($this->etrx_saldo);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'Bad Request',
                    'errors' => $this->trx_saldo->errors(),
                    'token' => csrf_hash(),
                ]);
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil melakukan <strong>transaksi</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function saldo_edit($id) // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('saldo');
        $trx_saldo = $this->trx_saldo->find($id);
        $data = [
            'status' => 'success',
            'data' => \view('pages/transaksi/saldo/edit_saldo', [
                'trx_saldo' => $trx_saldo
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function saldo_update($id) // * done
    {
        if (!$this->request->isAJAX()) throw new RedirectException('produk');
        $this->etrx_saldo->fill($this->request->getVar());
        $this->etrx_saldo->id = $id;
        $result = $this->trx_saldo->save($this->etrx_saldo);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'Bad Request',
                    'errors' => $this->trx_saldo->errors(),
                    'token' => csrf_hash(),
                ]);
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil update <strong>transaksi</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function saldo_delete($id) // * done
    {
        $result = $this->trx_saldo->delete($id, true);
        if ($result) {
            $data = [
                'status' => 'success',
                'data' => 'Berhasil hapus <strong>transaksi</strong>',
            ];
            return $this->response->setStatusCode(200)
                ->setJSON($data);
        }
    }

    public function reseller() // *fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('reseller');
        $data = ['status' => 'success'];
        $status_submit = [];
        // trx global hari ini
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->first();
        // Cek apakah sudah submit pada trx hari ini
        ($trx) ? ($trx->total_partai != NULL) ? \array_push($status_submit, ['status_submit' => true]) : false : false;
        // Submit trx hari ini
        if ($this->request->getMethod() == 'post') {
            $total_trx_reseller = $this->request->getVar('total_trx_reseller');
            // cek tabel transaksi kosongan maka auto save
            // jika trx sama dgn hri ini dan totalnya null maka update
            if ($trx) {
                if ($trx->total_partai == NULL) {
                    // update data trx
                    $this->trx->update($trx->id, ['total_partai' => $total_trx_reseller, 'created_at' => $this->date_now]);
                }
            } else {
                // save data trx baru
                $this->etrx->total_partai = $total_trx_reseller;
                $this->etrx->konter_id = $this->konter_id;
                $this->etrx->created_at = $this->date_now;
                $this->trx->save($this->etrx);
            }
            $data['submit'] = 'berhasil submit data transaksi';
            return $this->response->setStatusCode(200)
                ->setJSON($data);
        }
        // transaksi reseller hari ini
        $trx_reseller = $this->produk
            ->where([
                'konter_id', $this->konter_id,
                'DATE_FORMAT(transaksi_partai.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d')
            ])
            ->join('transaksi_partai', 'transaksi_partai.produk_id = produk.id')
            ->findAll();

        $data['data'] = \view('pages/transaksi/reseller/reseller', [
            'trx_reseller' => $trx_reseller,
            'status_submit' => $status_submit
        ]);
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function reseller_create() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('reseller');
        $produk = $this->produk->findAll();
        $data = [
            'status' => 'success',
            'data' => \view('pages/transaksi/reseller/tambah_reseller', [
                'produk' => $produk
            ]),
        ];
        // trx global hari ini yang transaksi partainya null
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'total_partai !=' => null,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->first();
        // Cek apakah sudah submit pada trx global hari ini
        if ($trx) {
            $data = [
                'status' => 'Bad Request',
                'submit_err' => [
                    'title' => 'Status Transaksi',
                    'message' => "Transaksi reseller hari ini telah selesai"
                ],
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function reseller_store() // * fix code
    {
        $produk_id = $this->request->getVar('produk_id');
        $qty = $this->request->getVar('trx_partai_qty');
        // Cek ketersediaan stok
        if ($produk_id && $qty) {
            // stok terakhir
            $stok = $this->stok->where([
                'konter_id' => $this->konter_id,
                'produk_id' => $produk_id,
                'sisa_stok' => null
            ])->first();
            $new_stok = $stok->stok - $qty;
            // cek apakah stok tersedia
            if ($new_stok < 0 or $new_stok > $stok->stok) {
                $data = [
                    'status' => 'Bad Request',
                    'err' => [
                        'title' => 'Info Stok',
                        'message' => "Stok tidak cukup!, <strong>stok yang tersedia $stok->stok<strong>"
                    ],
                    'token' => csrf_hash(),
                ];
                return $this->response->setStatusCode(400)
                    ->setJSON($data);
            }
        }
        // save trx reseller
        $this->etrx_reseller->fill($this->request->getVar());
        $this->etrx_reseller->konter_id = $this->konter_id;
        $this->etrx_reseller->created_at = $this->date_now;
        $result = $this->trx_reseller->save($this->etrx_reseller);

        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'Bad Request',
                    'errors' => $this->trx_reseller->errors(),
                    'token' => csrf_hash(),
                ]);
        }
        // update stok
        $this->stok->update($stok->id, ['stok' => $new_stok]);
        $data = [
            'status' => 'success',
            'data' => 'Berhasil melakukan <strong>transaksi</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function reseller_delete($id) // * fix code
    {
        $reseller = $this->request->getVar('reseller');
        $produk = $this->request->getVar('produk');
        $produk_id = $this->request->getVar('produk_id');
        $qty = $this->request->getVar('qty');
        // update stok
        $stok = $this->stok
            ->where(['konter_id' => $this->konter_id, 'produk_id' => $produk_id, 'sisa_stok' => null])
            ->first();
        $new_stok = $stok->stok + $qty;
        $this->stok->update($stok->id, ['stok' => $new_stok]);
        // delete
        $this->trx_reseller->delete($id, true);
        $data = [
            'status' => 'success',
            'data' => "Berhasil hapus <strong>transaksi produk $produk milik $reseller</strong>",
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function acc() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-acc');
        $data = ['status' => 'success'];
        $status_submit = [];

        // trx global hari ini yang total transaksi accnya null
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->first();
        // Cek apakah sudah submit pada trx hari ini
        ($trx) ? ($trx->total_acc != NULL) ? \array_push($status_submit, ['status_submit' => true]) : false : false;

        // Submit trx acc
        if ($this->request->getMethod() == 'post') {
            $produk_id = $this->request->getVar('produk_id[]');
            $qty = $this->request->getVar('txr_acc_qty[]');
            $list_total_trx = [];
            // Update Stok and add new row
            foreach ($produk_id as $key => $id) {
                $harga_produk = $this->produk->where('id', $id)->first()->harga_user;
                // stok terakhir
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $id,
                    'sisa_stok' => NULL
                ])->orderBy('created_at', 'DESC')->first();
                $jumlah_laku = $stok->stok - $qty[$key];
                \array_push($list_total_trx, ($jumlah_laku * $harga_produk));
                // update sisa_stok dan jumlah terjual
                $this->stok->update($stok->id, [
                    'sisa_stok' => $qty[$key],
                    'stok_terjual' => $jumlah_laku
                ]);
                // add row stok
                $this->estok->created_at = $this->date_now;
                $this->estok->produk_id = $id;
                $this->estok->konter_id = $this->konter_id;
                $this->estok->stok = $qty[$key];
                $this->estok->sisa_stok = NULL;
                $this->estok->stok_terjual = NULL;
                $this->stok->save($this->estok);
            }
            $total_trx_acc = array_sum($list_total_trx);
            // cek tabel transaksi kosongan maka auto save
            // jika trx sama dgn hri ini dan totalnya null maka update
            if ($trx) {
                if ($trx->total_acc == NULL) {
                    // update data trx
                    $this->trx->update($trx->id, ['total_acc' => $total_trx_acc, 'created_at' => $this->date_now]);
                }
            } else {
                // save data trx baru
                $this->etrx->total_acc = $total_trx_acc;
                $this->etrx->konter_id = $this->konter_id;
                $this->etrx->created_at = $this->date_now;
                $this->trx->save($this->etrx);
            }
            $data['submit'] = 'berhasil submit data transaksi';
            return $this->response->setStatusCode(200)
                ->setJSON($data);
        }

        // trx acc hari ini
        $trx_acc = $this->produk
            ->where([
                'produk.kategori_id' => 2,
                'konter_id' => $this->konter_id,
                'DATE_FORMAT(transaksi_acc.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            ])
            ->join('transaksi_acc', 'produk.id = transaksi_acc.produk_id')->findAll();

        $data['data'] = \view('pages/transaksi/aksesoris/acc', [
            'title' => 'Transaksi Acc',
            'trx_acc' => $trx_acc,
            'status_submit' => $status_submit,
        ]);
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function acc_create() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-acc');
        // trx global hari ini yang total transaksi accnya null
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'total_acc !=' => null,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->first();
        // trx acc hari ini
        $trx_acc = $this->trx_acc
            ->where([
                'konter_id' => $this->konter_id,
                'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            ])->findAll();
        // Cek apakah sudah submit pada trx global hari ini
        if ($trx) {
            $data = [
                'status' => 'Bad Request',
                'submit_err' => [
                    'title' => 'Status Transaksi',
                    'message' => "Transaksi aksesoris hari ini telah selesai"
                ],
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        // Cek apakah sudah save pada trx acc hari ini
        else if ($trx_acc) {
            $data = [
                'status' => 'Bad Request',
                'tambah_err' => [
                    'title' => 'Status Transaksi',
                    'message' => "Anda telah melakukan transaksi aksesoris"
                ],
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        // Produk_Acc
        $produk_acc = $this->produk->where([
            'produk.kategori_id' => 2,
            'konter_id' => $this->konter_id,
            'sisa_stok' => NULL
        ])
            ->join('stok', 'produk.id = stok.produk_id')
            ->findAll();
        $data = [
            'status' => 'success',
            'data' => \view('pages/transaksi/aksesoris/tambah_acc', [
                'produk_acc' => $produk_acc,
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function acc_store() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-acc');
        $produk_id = $this->request->getVar('produk_id[]');
        $sisa = $this->request->getVar('produk_sisa[]');
        foreach ($produk_id as $key => $id) {
            if ($produk_id && $sisa) {
                // stok terakhir
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $id,
                    'sisa_stok' => null
                ])->first();
                // cek apakah stok tersedia
                if ($sisa[$key] > $stok->stok or $sisa[$key] < 0) {
                    $data = [
                        'tipe' => 'error',
                        'status' => 'Bad Request',
                        'err' => [
                            'title' => 'Info Stok',
                            'message' => "Stok tidak cukup!, <strong>stok yang tersedia $stok->stok<strong>"
                        ],
                        'token' => csrf_hash(),
                    ];
                    return $this->response->setStatusCode(400)
                        ->setJSON($data);
                }
            }
            // save trx_acc
            $this->etrx_acc->konter_id = $this->konter_id;
            $this->etrx_acc->produk_id = $id;
            $this->etrx_acc->trx_acc_qty = $sisa[$key];
            $this->etrx_acc->created_at = $this->date_now;
            $result = $this->trx_acc->save($this->etrx_acc);
            if (!$result) {
                $data = [
                    'tipe' => 'error',
                    'status' => 'Bad Request',
                    'err' => [
                        'title' => 'Info Stok',
                        'message' => $this->trx_acc->errors()['trx_acc_qty']
                    ],
                    'token' => csrf_hash(),
                ];
                return $this->response->setStatusCode(400)
                    ->setJSON($data);
            }
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil input <strong>transaksi</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function acc_edit($id) // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trc-acc');
        $trx_acc = $this->produk
            ->where('transaksi_acc.id', $id)
            ->join('stok', 'produk.id = stok.produk_id')
            ->join('transaksi_acc', 'produk.id = transaksi_acc.produk_id')
            ->orderBy('stok.created_at', 'DESC')->first();
        $data = [
            'status' => 'success',
            'data' => \view('pages/transaksi/aksesoris/edit_acc', [
                'trx_acc' => $trx_acc
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function acc_update($id) // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-acc');
        $sisa_stok = $this->request->getVar('trx_acc_qty');
        if ($sisa_stok) {
            // stok terakhir
            $stok = $this->stok
                ->where([
                    'transaksi_acc.konter_id' => $this->konter_id,
                    'transaksi_acc.id' => $id,
                    'sisa_stok' => null
                ])
                ->join('transaksi_acc', 'stok.produk_id = transaksi_acc.produk_id')
                ->orderBy('stok.created_at', 'DESC')->first();
            // cek apakah stok tersedia
            if ($sisa_stok > $stok->stok or $sisa_stok < 0) {
                $data = [
                    'tipe' => 'error',
                    'status' => 'Bad Request',
                    'err' => [
                        'title' => 'Info Stok',
                        'message' => "Stok tidak cukup!, <strong>stok yang tersedia $stok->stok<strong>"
                    ],
                    'token' => csrf_hash(),
                ];
                return $this->response->setStatusCode(400)
                    ->setJSON($data);
            }
        }
        // update trx
        $this->etrx_acc->fill($this->request->getVar());
        $this->etrx_acc->id = $id;
        $result = $this->trx_acc->save($this->etrx_acc);
        if (!$result) {
            $data = [
                'tipe' => 'error',
                'status' => 'Bad Request',
                'err' => [
                    'title' => 'Info Stok',
                    'message' => $this->trx_acc->errors()['trx_acc_qty']
                ],
                'token' => csrf_hash(),
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil update <strong>transaksi</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function kartu() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-kartu');
        $data = ['status' => 'success'];
        $status_submit = [];

        // trx global hari ini yang total transaksi kartunya null
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->first();
        // Cek apakah sudah submit pada trx hari ini
        ($trx) ? ($trx->total_kartu != NULL) ? \array_push($status_submit, ['status_submit' => true]) : false : false;

        // Submit trx kartu
        if ($this->request->getMethod() == 'post') {
            $produk_id = $this->request->getVar('produk_id[]');
            $qty = $this->request->getVar('txr_kartu_qty[]');
            $list_total_trx = [];
            // Update Stok and add new row
            foreach ($produk_id as $key => $id) {
                $harga_produk = $this->produk->where('id', $id)->first()->harga_user;
                // stok terakhir
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $id,
                    'sisa_stok' => NULL
                ])->orderBy('created_at', 'DESC')->first();
                $jumlah_laku = $stok->stok - $qty[$key];
                \array_push($list_total_trx, ($jumlah_laku * $harga_produk));
                // update sisa_stok dan jumlah terjual
                $this->stok->update($stok->id, [
                    'sisa_stok' => $qty[$key],
                    'stok_terjual' => $jumlah_laku
                ]);
                // add row stok
                $this->estok->created_at = $this->date_now;
                $this->estok->produk_id = $id;
                $this->estok->konter_id = $this->konter_id;
                $this->estok->stok = $qty[$key];
                $this->estok->sisa_stok = NULL;
                $this->estok->stok_terjual = NULL;
                $this->stok->save($this->estok);
            }
            $total_trx_kartu = array_sum($list_total_trx);
            // cek tabel transaksi kosongan maka auto save
            // jika trx sama dgn hri ini dan totalnya null maka update
            if ($trx) {
                if ($trx->total_kartu == NULL) {
                    // update data trx
                    $this->trx->update($trx->id, ['total_kartu' => $total_trx_kartu, 'created_at' => $this->date_now]);
                }
            } else {
                // save data trx baru
                $this->etrx->total_kartu = $total_trx_kartu;
                $this->etrx->konter_id = $this->konter_id;
                $this->etrx->created_at = $this->date_now;
                $this->trx->save($this->etrx);
            }
            $data['submit'] = 'berhasil submit data transaksi';
            return $this->response->setStatusCode(200)
                ->setJSON($data);
        }

        // trx kartu hari ini
        $trx_kartu = $this->produk
            ->where([
                'produk.kategori_id' => 1,
                'konter_id' => $this->konter_id,
                'DATE_FORMAT(transaksi_kartu.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            ])
            ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')->findAll();

        $data['data'] = \view('pages/transaksi/kartu/kartu', [
            'title' => 'Transaksi Kartu',
            'trx_kartu' => $trx_kartu,
            'status_submit' => $status_submit,
        ]);
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function kartu_create() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-kartu');
        // trx global hari ini yang total transaksi kartunya null
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'total_kartu !=' => null,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->first();
        // trx kartu hari ini
        $trx_kartu = $this->trx_kartu
            ->where([
                'konter_id' => $this->konter_id,
                'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            ])->findAll();
        // Cek apakah sudah submit pada trx global hari ini
        if ($trx) {
            $data = [
                'status' => 'Bad Request',
                'submit_err' => [
                    'title' => 'Status Transaksi',
                    'message' => "Transaksi kartu hari ini telah selesai"
                ],
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        // Cek apakah sudah save pada trx kartu hari ini
        else if ($trx_kartu) {
            $data = [
                'status' => 'Bad Request',
                'tambah_err' => [
                    'title' => 'Status Transaksi',
                    'message' => "Anda telah melakukan transaksi kartu"
                ],
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        // Produk_kartu
        $produk_kartu = $this->produk->where([
            'produk.kategori_id' => 1,
            'konter_id' => $this->konter_id,
            'sisa_stok' => NULL
        ])
            ->join('stok', 'produk.id = stok.produk_id')
            ->findAll();
        $data = [
            'status' => 'success',
            'data' => \view('pages/transaksi/kartu/tambah_kartu', [
                'produk_kartu' => $produk_kartu,
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function kartu_store() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-kartu');
        $produk_id = $this->request->getVar('produk_id[]');
        $sisa = $this->request->getVar('produk_sisa[]');
        foreach ($produk_id as $key => $id) {
            if ($produk_id && $sisa) {
                // stok terakhir
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $id,
                    'sisa_stok' => null
                ])->first();
                // cek apakah stok tersedia
                if ($sisa[$key] > $stok->stok or $sisa[$key] < 0) {
                    $data = [
                        'tipe' => 'error',
                        'status' => 'Bad Request',
                        'err' => [
                            'title' => 'Info Stok',
                            'message' => "Stok tidak cukup!, <strong>stok yang tersedia $stok->stok<strong>"
                        ],
                        'token' => csrf_hash(),
                    ];
                    return $this->response->setStatusCode(400)
                        ->setJSON($data);
                }
            }
            // save trx_kartu
            $this->etrx_kartu->konter_id = $this->konter_id;
            $this->etrx_kartu->produk_id = $id;
            $this->etrx_kartu->trx_kartu_qty = $sisa[$key];
            $this->etrx_kartu->created_at = $this->date_now;
            $result = $this->trx_kartu->save($this->etrx_kartu);
            if (!$result) {
                $data = [
                    'tipe' => 'error',
                    'status' => 'Bad Request',
                    'err' => [
                        'title' => 'Info Stok',
                        'message' => $this->trx_kartu->errors()['trx_kartu_qty']
                    ],
                    'token' => csrf_hash(),
                ];
                return $this->response->setStatusCode(400)
                    ->setJSON($data);
            }
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil input <strong>transaksi</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function kartu_edit($id) // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trc-kartu');
        $trx_kartu = $this->produk
            ->where('transaksi_kartu.id', $id)
            ->join('stok', 'produk.id = stok.produk_id')
            ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')
            ->orderBy('stok.created_at', 'DESC')->first();
        $data = [
            'status' => 'success',
            'data' => \view('pages/transaksi/kartu/edit_kartu', [
                'trx_kartu' => $trx_kartu
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function kartu_update($id) // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-kartu');
        $sisa_stok = $this->request->getVar('trx_kartu_qty');
        if ($sisa_stok) {
            // stok terakhir
            $stok = $this->stok
                ->where([
                    'transaksi_kartu.konter_id' => $this->konter_id,
                    'transaksi_kartu.id' => $id,
                    'sisa_stok' => null
                ])
                ->join('transaksi_kartu', 'stok.produk_id = transaksi_kartu.produk_id')
                ->orderBy('stok.created_at', 'DESC')->first();
            // cek apakah stok tersedia
            if ($sisa_stok > $stok->stok or $sisa_stok < 0) {
                $data = [
                    'tipe' => 'error',
                    'status' => 'Bad Request',
                    'err' => [
                        'title' => 'Info Stok',
                        'message' => "Stok tidak cukup!, <strong>stok yang tersedia $stok->stok<strong>"
                    ],
                    'token' => csrf_hash(),
                ];
                return $this->response->setStatusCode(400)
                    ->setJSON($data);
            }
        }
        // update trx
        $this->etrx_kartu->fill($this->request->getVar());
        $this->etrx_kartu->id = $id;
        $result = $this->trx_kartu->save($this->etrx_kartu);
        if (!$result) {
            $data = [
                'tipe' => 'error',
                'status' => 'Bad Request',
                'err' => [
                    'title' => 'Info Stok',
                    'message' => $this->trx_kartu->errors()['trx_kartu_qty']
                ],
                'token' => csrf_hash(),
            ];
            return $this->response->setStatusCode(400)
                ->setJSON($data);
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil update <strong>transaksi</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function rekap() // * fix code
    {
        if (!$this->request->isAJAX()) throw new RedirectException('trx-rekap');
        $data = ['status' => 'success'];
        // trx
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])->orderBy('created_at', 'DESC')->first();
        $status_submit = [];
        // cek tabel transaksi kosongan
        ($trx) ? ($trx->total_trx != NULL) ? \array_push($status_submit, ['status_submit' => true]) : false : false;

        // Submit trx hari ini
        if ($this->request->getMethod() == 'post') {
            $total_tunai = $this->request->getVar('total_tunai');
            $total_pulsa = $this->request->getVar('total_pulsa');
            $total_keluar = $this->request->getVar('total_keluar');
            $total_modal = $this->request->getVar('total_modal');
            if ($total_keluar = '' or $total_pulsa = '' or $total_keluar = '' or $total_modal = '') {
                $data = [
                    'tipe' => 'errors',
                    'status' => 'Bad Request',
                    'err' => [
                        'title' => 'Info Transaksi',
                        'message' => 'Data transaksi tidak boleh kosong'
                    ],
                    'token' => csrf_hash(),
                ];
                return $this->response->setStatusCode(400)
                    ->setJSON($data);
            }
            $trx_not_null = array_sum([$trx->total_saldo, $trx->total_acc, $trx->total_kartu, $trx->total_partai]);
            $total_trx = (array_sum([$total_modal, $total_pulsa]) + $trx_not_null) - $total_keluar;
            // update data trx
            $this->trx->update($trx->id, [
                'total_modal' => $total_modal,
                'total_pulsa' => $total_pulsa,
                'total_tunai' => $total_tunai,
                'total_keluar' => $total_keluar,
                'total_trx' => $total_trx,
                'created_at' => $this->now
            ]);
            $data['submit'] = 'berhasil submit data transaksi';
            return $this->response->setStatusCode(200)
                ->setJSON($data);
        }

        $trx_kartu = $this->produk->where([
            'transaksi_kartu.konter_id' => $this->konter_id,
            'stok.sisa_stok !=' => NULL,
            'DATE_FORMAT(stok.updated_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            'DATE_FORMAT(transaksi_kartu.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')->groupBy('transaksi_kartu.id')->findAll();
        $trx_acc = $this->produk->where([
            'transaksi_acc.konter_id' => $this->konter_id,
            'stok.sisa_stok !=' => NULL,
            'DATE_FORMAT(stok.updated_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            'DATE_FORMAT(transaksi_acc.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_acc', 'produk.id = transaksi_acc.produk_id')->groupBy('transaksi_acc.id')->findAll();
        $trx_saldo = $this->trx_saldo->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d')
        ])->findAll();
        $trx_reseller = $this->produk->where([
            'transaksi_partai.konter_id' => $this->konter_id,
            'stok.sisa_stok' => NULL,
            'DATE_FORMAT(transaksi_partai.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            // 'DATE_FORMAT(stok.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_partai', 'produk.id = transaksi_partai.produk_id')->groupBy('transaksi_partai.id')->findAll();
        $data['data'] = \view('pages/transaksi/rekap/rekap', [
            'trx_kartu' => $trx_kartu,
            'trx_acc' => $trx_acc,
            'trx_saldo' => $trx_saldo,
            'trx_reseller' => $trx_reseller,
            'trx' => $trx,
            'status_submit' => $status_submit
        ]);
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }

    public function info_transaksi() // * fix code
    {
        $data = [
            'title' => 'Info Transaksi',
            'konter' => $this->konter->findAll(),
            'token' => csrf_hash()
        ];
        if ($this->request->getMethod() == 'post') {
            $konter = $this->request->getVar('konter');
            $tgl = $this->request->getVar('tanggal');
            $trx_kartu = $this->produk->where([
                'transaksi_kartu.konter_id' => $konter,
                'stok.sisa_stok !=' => NULL,
                'DATE_FORMAT(stok.updated_at, "%Y-%m-%d")' => $tgl,
                'DATE_FORMAT(transaksi_kartu.created_at, "%Y-%m-%d")' => $tgl,
            ])
                ->join('stok', 'stok.produk_id = produk.id')
                ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')->groupBy('transaksi_kartu.id')->findAll();
            $trx_acc = $this->produk->where([
                'transaksi_acc.konter_id' => $konter,
                'stok.sisa_stok !=' => NULL,
                'DATE_FORMAT(stok.updated_at, "%Y-%m-%d")' => $tgl,
                'DATE_FORMAT(transaksi_acc.created_at, "%Y-%m-%d")' => $tgl,
            ])
                ->join('stok', 'stok.produk_id = produk.id')
                ->join('transaksi_acc', 'produk.id = transaksi_acc.produk_id')->groupBy('transaksi_acc.id')->findAll();
            $trx_saldo = $this->trx_saldo->where([
                'konter_id' => $konter,
                'DATE_FORMAT(created_at, "%Y-%m-%d")' => $tgl
            ])->findAll();
            $trx_reseller = $this->produk->where([
                'transaksi_partai.konter_id' => $konter,
                'stok.sisa_stok' => NULL,
                'DATE_FORMAT(transaksi_partai.created_at, "%Y-%m-%d")' => $tgl,
                // 'DATE_FORMAT(stok.created_at, "%Y-%m-%d")' => $tgl,
            ])
                ->join('stok', 'stok.produk_id = produk.id')
                ->join('transaksi_partai', 'produk.id = transaksi_partai.produk_id')->groupBy('transaksi_partai.id')->findAll();
            $trx = $this->trx->where([
                'konter_id' => $konter,
                'DATE_FORMAT(created_at, "%Y-%m-%d")' => $tgl,
            ])->first();
            $data['data'] = \view('pages/transaksi/info/info', [
                'trx_kartu' => $trx_kartu,
                'trx_acc' => $trx_acc,
                'trx_saldo' => $trx_saldo,
                'trx_reseller' => $trx_reseller,
                'trx' => $trx
            ]);
            return $this->response->setStatusCode(200)
                ->setJSON($data);
        }
        return \view('pages/transaksi/info/index', $data);
    }

    public function report($tgl, $konter) // * fix code
    {
        $trx_kartu = $this->produk->where([
            'transaksi_kartu.konter_id' => $konter,
            'stok.sisa_stok !=' => NULL,
            'DATE_FORMAT(stok.updated_at, "%Y-%m-%d")' => $tgl,
            'DATE_FORMAT(transaksi_kartu.created_at, "%Y-%m-%d")' => $tgl,
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')->groupBy('transaksi_kartu.id')->findAll();
        $trx_acc = $this->produk->where([
            'transaksi_acc.konter_id' => $konter,
            'stok.sisa_stok !=' => NULL,
            'DATE_FORMAT(stok.updated_at, "%Y-%m-%d")' => $tgl,
            'DATE_FORMAT(transaksi_acc.created_at, "%Y-%m-%d")' => $tgl,
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_acc', 'produk.id = transaksi_acc.produk_id')->groupBy('transaksi_acc.id')->findAll();
        $trx_saldo = $this->trx_saldo->where([
            'konter_id' => $konter,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $tgl
        ])->findAll();
        $trx_reseller = $this->produk->where([
            'transaksi_partai.konter_id' => $konter,
            'stok.sisa_stok' => NULL,
            'DATE_FORMAT(transaksi_partai.created_at, "%Y-%m-%d")' => $tgl,
            // 'DATE_FORMAT(stok.created_at, "%Y-%m-%d")' => $tgl,
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_partai', 'produk.id = transaksi_partai.produk_id')->groupBy('transaksi_partai.id')->findAll();
        $trx = $this->trx->where([
            'konter_id' => $konter,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $tgl,
        ])->first();
        return \view('pages/transaksi/info/report', [
            'trx_kartu' => $trx_kartu,
            'trx_acc' => $trx_acc,
            'trx_saldo' => $trx_saldo,
            'trx_reseller' => $trx_reseller,
            'trx' => $trx
        ]);
    }
}
