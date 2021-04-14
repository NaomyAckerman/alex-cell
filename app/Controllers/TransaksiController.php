<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Entities\{Stok, Transaksiacc, Transaksikartu, Transaksipartai, Transaksi, Transaksisaldo};
use App\Models\{ProdukModel, StokModel, TransaksiAccModel, TransaksiKartuModel, TransaksiModel, TransaksiPartaiModel, TransaksiSaldoModel, UserModel};

class TransaksiController extends BaseController
{
    protected $user, $trx_saldo, $etrx_saldo, $trx, $etrx, $produk, $trx_reseller, $trx_kartu, $trx_acc, $stok, $etrx_reseller, $etrx_kartu, $etrx_acc, $estok, $konter_id;
    public function __construct()
    {
        $this->konter_id = \user()->konter_id;
        $this->user = new UserModel();
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
    public function index() // * done
    {
        // trx
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            // 'total_trx' => null
        ])->orderBy('created_at', 'DESC')->first();
        $data_submit = [];
        // cek tabel transaksi kosongan
        ($trx) ? ($trx->total_trx != NULL) ? \array_push($data_submit, ['status_submit' => true]) : false : false;

        // Submit trx hari ini
        if ($this->request->getMethod() == 'post') {
            $trx_not_null = array_sum([$trx->total_saldo, $trx->total_acc, $trx->total_kartu, $trx->total_partai]);
            $total_tunai = $this->request->getVar('total_tunai');
            $total_pulsa = $this->request->getVar('total_pulsa');
            $total_keluar = $this->request->getVar('total_keluar');
            $total_modal = $this->request->getVar('total_modal');
            $total_trx = (array_sum([$total_modal, $total_pulsa, $total_keluar, $total_tunai]) + $trx_not_null);
            // update data trx
            $this->trx->update($trx->id, [
                'total_modal' => $total_modal,
                'total_pulsa' => $total_pulsa,
                'total_tunai' => $total_tunai,
                'total_keluar' => $total_keluar,
                'total_trx' => $total_trx,
                'created_at' => $this->now
            ]);
            session()->setFlashdata('success', 'berhasil submit data transaksi');
            return \redirect()->back()->withInput();
        }

        $trx_kartu = $this->produk->where([
            'transaksi_kartu.konter_id' => $this->konter_id,
            'stok.sisa_stok' => NULL,
            'DATE_FORMAT(transaksi_kartu.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            'DATE_FORMAT(stok.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')->groupBy('transaksi_kartu.id')->findAll();
        $trx_acc = $this->produk->where([
            'transaksi_acc.konter_id' => $this->konter_id,
            'stok.sisa_stok' => NULL,
            'DATE_FORMAT(transaksi_acc.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            'DATE_FORMAT(stok.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
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
            'DATE_FORMAT(stok.created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
        ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_partai', 'produk.id = transaksi_partai.produk_id')->groupBy('transaksi_partai.id')->findAll();
        return \view('pages/transaksi/index', [
            'title' => 'Transaksi',
            'trx_kartu' => $trx_kartu,
            'trx_acc' => $trx_acc,
            'trx_saldo' => $trx_saldo,
            'trx_reseller' => $trx_reseller,
            'trx' => $trx,
            'status_submit' => $data_submit
        ]);
    }

    public function kartu() // * done
    {
        // Submit trx
        if ($this->request->getMethod() == 'post') {
            $produk_id = $this->request->getVar('produk_id[]');
            $qty = $this->request->getVar('txr_kartu_qty[]');
            $list_total_trx = [];
            foreach ($produk_id as $key => $id) {
                $produk = $this->produk->where('id', $id)->first();
                // stok terakhir
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $id,
                ])->orderBy('created_at', 'DESC')->first();
                \array_push($list_total_trx, ($stok->stok - $qty[$key]) * $produk->harga_user);
                // update sisa_stok
                $this->stok->update($stok->id, ['sisa_stok' => $qty[$key], 'stok_teerjual' => ($stok->stok - $qty[$key])]);
                // add row stok
                $this->estok->created_at = ($this->now->getHour() < 5) ? $this->now->setDay($this->now->day - 1) : $this->now;
                $this->estok->produk_id = $id;
                $this->estok->konter_id = $this->konter_id;
                $this->estok->stok = $qty[$key];
                $this->estok->sisa_stok = NULL;
                $this->stok->save($this->estok);
            }

            // update transaksi global
            $day_now = ($this->now->getHour() < 5) ? $this->now->day - 1 : $this->now->day;
            $trx = $this->trx->where([
                'konter_id' => $this->konter_id,
            ])->orderBy('created_at', 'DESC')->first();
            // cek tabel transaksi kosongan maka auto save
            $kondisi = ($trx) ? (Time::parse($trx->created_at)->day == $day_now && $trx->total_kartu == null) : false;

            $total_trx_kartu = array_sum($list_total_trx);

            // cek jika trx sama dgn hri ini dan totalnya null maka update
            if ($kondisi) {
                // update data trx
                $this->trx->update($trx->id, ['total_kartu' => $total_trx_kartu, 'created_at' => $this->now]);
            } else {
                // save data trx baru
                $this->etrx->total_kartu = $total_trx_kartu;
                $this->etrx->konter_id = $this->konter_id;
                $this->etrx->created_at = $this->now;
                $this->trx->save($this->etrx);
            }

            session()->setFlashdata('success', "berhasil submit transaksi");
            return \redirect()->route('transaksi-kartu');
        }

        // global trx kartu
        $trx_kartu = $this->produk
            ->where('konter_id', $this->konter_id)
            ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')
            ->findAll();
        // data trx_kartu hari ini
        $data_trx = [];
        // data submit trx
        $data_submit = [];

        foreach ($trx_kartu as $key => $value) {
            // tgl trx kartu
            $day_trx = Time::parse($value->created_at)->day;
            // tgl hari ini
            $day_now = ($this->now->getHour() < 5) ? $this->now->day - 1 : $this->now->day;
            // filter trx_kartu global ke trx_kartu hari ini
            if ($day_now == $day_trx) {
                \array_push($data_trx, $value);

                // // Cek apakah sudah submit trx
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $value->produk_id,
                    'sisa_stok' => Null
                ])->first();
                $tgl_stok_terakhir = Time::parse($stok->created_at)->day;
                ($tgl_stok_terakhir == $day_now) ? \array_push($data_submit, ['status_submit' => true]) : false;
            }
        }
        // tgl trx untuk header
        $tgl_trx = $data_trx ? \date_format($data_trx[0]->created_at, "d / m / y") : \date_format($this->now, "d / m / y");

        return \view('pages/transaksi/kartu', [
            'title' => 'Transaksi Kartu',
            'produk_kartu' => $this->produk->where(['kategori_id' => 1, 'konter_id' => $this->konter_id, 'sisa_stok' => NULL])
                ->join('stok', 'produk.id = stok.produk_id')
                ->findAll(),
            'trx_kartu' => $data_trx,
            'data_submit' => $data_submit,
            'tgl_trx' => $tgl_trx
        ]);
    }
    public function kartu_store() // * done
    {
        $produk_id = $this->request->getVar('produk_id[]');
        $sisa = $this->request->getVar('produk_sisa[]');
        foreach ($produk_id as $key => $id) {
            // Cek kecukupan stok
            $stok = $this->stok
                ->where(['produk_id' => $id, 'konter_id' => $this->konter_id, 'sisa_stok' => Null])
                ->orderBy('created_at', 'DESC')->first();
            if ($sisa[$key] > $stok->stok or $sisa[$key] < 0) {
                session()->setFlashdata('errors', 'Stok tidak cukup');
                return \redirect()->back()->withInput();
            }
            // save trx_kartu
            $data = [
                'konter_id' => $this->konter_id,
                'produk_id'  => $id,
                'trx_kartu_qty'  => $sisa[$key],
            ];
            // cek hari trx
            ($this->now->getHour() < 5) ? $data['created_at'] = $this->now->setDay($this->now->day - 1) : false;
            $result = $this->trx_kartu->save($data);
            if (!$result) {
                session()->setFlashdata('error', $this->trx_kartu->errors());
                return \redirect()->back()->withInput();
            }
        }
        session()->setFlashdata('success', 'berhasil input transaksi');
        return \redirect()->back()->withInput();
    }
    public function kartu_edit($id) // * done
    {
        $trx_kartu = $this->produk
            ->where('transaksi_kartu.id', $id)
            ->join('stok', 'produk.id = stok.produk_id')
            ->join('transaksi_kartu', 'produk.id = transaksi_kartu.produk_id')
            ->orderBy('stok.created_at', 'DESC')->first();
        return \view('pages/transaksi/kartu_edit', [
            'title' => 'Transaksi Kartu Edit',
            'trx_kartu' => $trx_kartu
        ]);
    }
    public function kartu_update($id) // * done
    {
        // Cek kecukupan stok
        $stok = $this->stok
            ->join('transaksi_kartu', 'stok.produk_id = transaksi_kartu.produk_id')
            ->where(['transaksi_kartu.id' => $id, 'sisa_stok' => Null])
            ->orderBy('stok.created_at', 'DESC')->first();
        $sisa_stok = $this->request->getVar('trx_kartu_qty');
        if ($sisa_stok > $stok->stok or $sisa_stok < 0) {
            session()->setFlashdata('errors', 'Stok tidak cukup');
            return \redirect()->back()->withInput();
        }
        // update trx
        $this->etrx_kartu->fill($this->request->getVar());
        $this->etrx_kartu->id = $id;
        $result = $this->trx_kartu->save($this->etrx_kartu);
        if (!$result) {
            session()->setFlashdata('error', $this->trx_kartu->errors());
            return \redirect()->back()->withInput();
        }
        session()->setFlashdata('success', "berhasil update transaksi");
        return \redirect()->route('transaksi-kartu');
    }

    public function acc() // * done
    {
        // Submit trx acc
        if ($this->request->getMethod() == 'post') {
            $produk_id = $this->request->getVar('produk_id[]');
            $qty = $this->request->getVar('txr_acc_qty[]');
            $list_total_trx = [];
            foreach ($produk_id as $key => $id) {
                $produk = $this->produk->where('id', $id)->first();
                // stok terakhir
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $id,
                ])->orderBy('created_at', 'DESC')->first();
                \array_push($list_total_trx, ($stok->stok - $qty[$key]) * $produk->harga_user);
                // update sisa_stok
                $this->stok->update($stok->id, ['sisa_stok' => $qty[$key]]);
                // add row stok
                $this->estok->created_at = ($this->now->getHour() < 5) ? $this->now->setDay($this->now->day - 1) : $this->now;
                $this->estok->produk_id = $id;
                $this->estok->konter_id = $this->konter_id;
                $this->estok->stok = $qty[$key];
                $this->estok->sisa_stok = NULL;
                $this->stok->save($this->estok);
            }

            // update transaksi global
            $day_now = ($this->now->getHour() < 5) ? $this->now->day - 1 : $this->now->day;
            $trx = $this->trx->where([
                'konter_id' => $this->konter_id,
            ])->orderBy('created_at', 'DESC')->first();
            // cek tabel transaksi kosongan maka auto save
            $kondisi = ($trx) ? (Time::parse($trx->created_at)->day == $day_now && $trx->total_acc == null) : false;

            $total_trx_acc = array_sum($list_total_trx);

            // cek jika trx sama dgn hri ini dan totalnya null maka update
            if ($kondisi) {
                // update data trx
                $this->trx->update($trx->id, ['total_acc' => $total_trx_acc, 'created_at' => $this->now]);
            } else {
                // save data trx baru
                $this->etrx->total_acc = $total_trx_acc;
                $this->etrx->konter_id = $this->konter_id;
                $this->etrx->created_at = $this->now;
                $this->trx->save($this->etrx);
            }

            session()->setFlashdata('success', "berhasil submit transaksi");
            return \redirect()->route('transaksi-acc');
        }

        // global trx acc
        $trx_acc = $this->produk
            ->where('konter_id', $this->konter_id)
            ->join('transaksi_acc', 'produk.id = transaksi_acc.produk_id')
            ->findAll();
        // data trx_acc hari ini
        $data_trx = [];
        // data submit trx acc
        $data_submit = [];

        foreach ($trx_acc as $key => $value) {
            // tgl trx acc
            $day_trx = Time::parse($value->created_at)->day;
            // tgl hari ini
            $day_now = ($this->now->getHour() < 5) ? $this->now->day - 1 : $this->now->day;
            // filter trx_acc global ke trx_acc hari ini
            if ($day_now == $day_trx) {
                \array_push($data_trx, $value);

                // Cek apakah sudah submit trx acc
                $stok = $this->stok->where([
                    'konter_id' => $this->konter_id,
                    'produk_id' => $value->produk_id,
                    'sisa_stok' => Null
                ])->first();
                $tgl_stok_terakhir = Time::parse($stok->created_at)->day;
                ($tgl_stok_terakhir == $day_now) ? \array_push($data_submit, ['status_submit' => true]) : false;
            }
        }
        // tgl trx untuk header
        $tgl_trx = $data_trx ? \date_format($data_trx[0]->created_at, "d / m / y") : \date_format($this->now, "d / m / y");

        return \view('pages/transaksi/acc', [
            'title' => 'Transaksi Acc',
            'produk_acc' => $this->produk->where(['kategori_id' => 2, 'konter_id' => $this->konter_id, 'sisa_stok' => NULL])
                ->join('stok', 'produk.id = stok.produk_id')
                ->findAll(),
            'trx_acc' => $data_trx,
            'data_submit' => $data_submit,
            'tgl_trx' => $tgl_trx
        ]);
    }
    public function acc_store() // * done
    {
        $produk_id = $this->request->getVar('produk_id[]');
        $sisa = $this->request->getVar('produk_sisa[]');
        foreach ($produk_id as $key => $id) {
            // Cek kecukupan stok
            $stok = $this->stok
                ->where(['produk_id' => $id, 'konter_id' => $this->konter_id, 'sisa_stok' => Null])
                ->orderBy('created_at', 'DESC')->first();
            if ($sisa[$key] > $stok->stok or $sisa[$key] < 0) {
                session()->setFlashdata('errors', 'Stok tidak cukup');
                return \redirect()->back()->withInput();
            }
            // save trx_acc
            $data = [
                'konter_id' => $this->konter_id,
                'produk_id'  => $id,
                'trx_acc_qty'  => $sisa[$key],
            ];
            // cek hari trx
            ($this->now->getHour() < 5) ? $data['created_at'] = $this->now->setDay($this->now->day - 1) : false;
            $result = $this->trx_acc->save($data);
            if (!$result) {
                session()->setFlashdata('error', $this->trx_acc->errors());
                return \redirect()->back()->withInput();
            }
        }
        session()->setFlashdata('success', 'berhasil input transaksi');
        return \redirect()->back()->withInput();
    }
    public function acc_edit($id) // * done
    {
        $trx_acc = $this->produk
            ->where('transaksi_acc.id', $id)
            ->join('stok', 'produk.id = stok.produk_id')
            ->join('transaksi_acc', 'produk.id = transaksi_acc.produk_id')
            ->orderBy('stok.created_at', 'DESC')->first();
        return \view('pages/transaksi/acc_edit', [
            'title' => 'Transaksi acc Edit',
            'trx_acc' => $trx_acc
        ]);
    }
    public function acc_update($id) // * done
    {
        // Cek kecukupan stok
        $stok = $this->stok
            ->join('transaksi_acc', 'stok.produk_id = transaksi_acc.produk_id')
            ->where(['transaksi_acc.id' => $id, 'sisa_stok' => Null])
            ->orderBy('stok.created_at', 'DESC')->first();
        $sisa_stok = $this->request->getVar('trx_acc_qty');
        if ($sisa_stok > $stok->stok or $sisa_stok < 0) {
            session()->setFlashdata('errors', 'Stok tidak cukup');
            return \redirect()->back()->withInput();
        }
        // update trx
        $this->etrx_acc->fill($this->request->getVar());
        $this->etrx_acc->id = $id;
        $result = $this->trx_acc->save($this->etrx_acc);
        if (!$result) {
            session()->setFlashdata('error', $this->trx_acc->errors());
            return \redirect()->back()->withInput();
        }
        session()->setFlashdata('success', "berhasil update transaksi");
        return \redirect()->route('transaksi-acc');
    }

    public function reseller() // * done
    {
        // trx
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
        ])->orderBy('created_at', 'DESC')->first();

        $data_submit = [];
        $day_now = ($this->now->getHour() < 5) ? $this->now->day - 1 : $this->now->day;
        // cek tabel transaksi kosongan
        if ($trx) {
            $day_trx = Time::parse($trx->created_at)->day;
            // Cek apakah sudah submit pada trx hari ini
            ($day_trx == $day_now && $trx->total_partai != null) ? \array_push($data_submit, ['status_submit' => true]) : false;
        }

        // Submit trx hari ini
        if ($this->request->getMethod() == 'post') {
            // cek tabel transaksi kosongan maka auto save
            $kondisi = ($trx) ? ($day_trx == $day_now && $trx->total_partai == null) : false;

            $total_trx_reseller = $this->request->getVar('total_trx_reseller');

            // cek jika trx sama dgn hri ini dan totalnya null maka update
            if ($kondisi) {
                // update data trx
                $this->trx->update($trx->id, ['total_partai' => $total_trx_reseller, 'created_at' => $this->now]);
            } else {
                // save data trx baru
                $this->etrx->total_partai = $total_trx_reseller;
                $this->etrx->konter_id = $this->konter_id;
                $this->etrx->created_at = $this->now;
                $this->trx->save($this->etrx);
            }
            session()->setFlashdata('success', 'berhasil submit data transaksi');
            return \redirect()->back()->withInput();
        }

        $produk = $this->produk->findAll();
        $data_trx = [];
        $trx_reseller_all = $this->produk
            ->where(['konter_id', $this->konter_id])
            ->join('transaksi_partai', 'transaksi_partai.produk_id = produk.id')
            ->findAll();
        foreach ($trx_reseller_all as $key => $value) {
            // tgl trx acc
            $day_trx = Time::parse($value->created_at)->day;
            // tgl hari ini
            $day_now = ($this->now->getHour() < 5) ? $this->now->day - 1 : $this->now->day;
            // filter trx_acc global ke trx_acc hari ini
            if ($day_now == $day_trx) {
                \array_push($data_trx, $value);
            }
        }
        return \view('pages/transaksi/reseller', [
            'title' => 'Transaksi Reseller',
            'produk' => $produk,
            'trx_reseller' => $data_trx,
            'status_submit' => $data_submit
        ]);
    }
    public function reseller_store() // * done
    {
        $produk_id = $this->request->getVar('produk_id');
        $qty = $this->request->getVar('trx_partai_qty');
        if ($produk_id && $qty) {
            // stok terakhir
            $stok = $this->stok->where([
                'konter_id' => $this->konter_id,
                'produk_id' => $this->request->getVar('produk_id'),
            ])->orderBy('created_at', 'DESC')->first();
            // cek apakah stok tersedia
            $new_stok = $stok->stok - $this->request->getVar('trx_partai_qty');
            if ($new_stok < 0) {
                session()->setFlashdata('errors', 'Stok tidak mencukupi');
                return \redirect()->back()->withInput();
            }
        }
        // save trx reseller
        $this->etrx_reseller->fill($this->request->getVar());
        $this->etrx_reseller->konter_id = $this->konter_id;
        $this->etrx_reseller->created_at = ($this->now->getHour() < 5) ? $this->now->setDay($this->now->day - 1) : $this->now;
        $result = $this->trx_reseller->save($this->etrx_reseller);
        if (!$result) {
            session()->setFlashdata('error', $this->trx_reseller->errors());
            return \redirect()->back()->withInput();
        }
        // update stok
        $this->stok->update($stok->id, ['stok' => $new_stok]);
        session()->setFlashdata('success', 'berhasil menambah data transaksi');
        return \redirect()->back()->withInput();
    }
    public function reseller_edit($id) // * done
    {
        $trx_reseller = $this->produk
            ->where([
                'transaksi_partai.id' => $id,
            ])
            ->join('stok', 'stok.produk_id = produk.id')
            ->join('transaksi_partai', 'transaksi_partai.produk_id = produk.id')
            ->orderBy('stok.created_at', 'DESC')->first();
        return \view('pages/transaksi/reseller_edit', [
            'title' => 'Transaksi Reseller Edit',
            'trx_reseller' => $trx_reseller
        ]);
    }
    public function reseller_update($id) // * done
    {
        // Cek kecukupan stok
        $stok = $this->stok
            ->join('transaksi_partai', 'stok.produk_id = transaksi_partai.produk_id')
            ->where(['transaksi_partai.id' => $id, 'sisa_stok' => Null])
            ->orderBy('stok.created_at', 'DESC')->first();
        // update trx
        $this->etrx_reseller->fill($this->request->getVar());
        $this->etrx_reseller->id = $id;
        $result = $this->trx_reseller->save($this->etrx_reseller);
        if (!$result) {
            session()->setFlashdata('error', $this->trx_reseller->errors());
            return \redirect()->back()->withInput();
        }
        session()->setFlashdata('success', "berhasil update transaksi");
        return \redirect()->route('transaksi-reseller');
    }
    public function reseller_delete($id) // * done
    {
        $produk_id = $this->request->getVar('produk_id');
        $qty = $this->request->getVar('qty');
        // update stok
        $stok = $this->stok
            ->where(['konter_id' => $this->konter_id, 'produk_id' => $produk_id, 'sisa_stok' => null])
            ->first();
        $new_stok = $stok->stok + $qty;
        $this->stok->update($stok->id, ['stok' => $new_stok]);
        // delete
        $result = $this->trx_reseller->delete($id, true);
        if ($result) {
            session()->setFlashdata('success', "berhasil hapus transaksi");
            return \redirect()->route('transaksi-reseller');
        }
    }

    public function saldo() // * done
    {
        // trx
        $trx = $this->trx->where([
            'konter_id' => $this->konter_id,
        ])->orderBy('created_at', 'DESC')->first();

        $data_submit = [];
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
            session()->setFlashdata('success', 'berhasil submit data transaksi');
            return \redirect()->back()->withInput();
        }
        $saldo = $this->trx_saldo->where([
            'konter_id' => $this->konter_id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d')
        ])->findAll();
        return \view('pages/transaksi/saldo', [
            'title' => 'Transaksi Saldo',
            'trx_saldo' => $saldo,
            'status_submit' => $data_submit
        ]);
    }
    public function saldo_store() // * done
    {
        $this->etrx_saldo->fill($this->request->getVar());
        $this->etrx_saldo->konter_id = $this->konter_id;
        $this->etrx_saldo->create_at = $this->date_now;
        $result = $this->trx_saldo->save($this->etrx_saldo);
        if (!$result) {
            session()->setFlashdata('error', $this->trx_saldo->errors());
            return \redirect()->back()->withInput();
        }
        session()->setFlashdata('success', 'berhasil menambah data transaksi');
        return \redirect()->back()->withInput();
    }
    public function saldo_edit($id) // * done
    {
        $trx_saldo = $this->trx_saldo->find($id);
        return \view('pages/transaksi/saldo_edit', [
            'title' => 'Transaksi Saldo Edit',
            'trx_saldo' => $trx_saldo
        ]);
    }
    public function saldo_update($id) // * done
    {
        $this->etrx_saldo->fill($this->request->getVar());
        $this->etrx_saldo->id = $id;
        $result = $this->trx_saldo->save($this->etrx_saldo);
        if (!$result) {
            session()->setFlashdata('error', $this->trx_saldo->errors());
            return \redirect()->back()->withInput();
        }
        session()->setFlashdata('success', "berhasil update transaksi");
        return \redirect()->route('transaksi-saldo');
    }
    public function saldo_delete($id) // * done
    {
        $result = $this->trx_saldo->delete($id, true);
        if ($result) {
            session()->setFlashdata('success', "berhasil hapus transaksi");
            return \redirect()->route('transaksi-saldo');
        }
    }
}
