<?php

namespace App\Controllers;

use App\Models\{ProdukModel, TransaksiModel, StokModel};

class DashboardController extends BaseController
{
    protected $trx, $konter_id, $stok, $produk;
    public function __construct()
    {
        $this->trx = new TransaksiModel();
        $this->stok = new StokModel();
        $this->produk = new ProdukModel();
        $this->konter_id = \user()->konter_id;
    }
    public function index()
    {
        $data = ['title' => 'dashboard'];
        $trx = \in_groups('karyawan') ?
            $this->trx->where([
                'konter_id' => $this->konter_id,
                'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            ])->first() :
            $this->trx->where([
                'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d'),
            ])->find();
        $data['trx'] = $trx;
        if (\in_groups('owner')) {
            $data['trx_konter1'] = $this->_trx_konter(1);
            $data['trx_konter2'] = $this->_trx_konter(2);
            $data['top_produk'] = $this->_top_produk(3);
            $data['laba_konter1'] = $this->_trx_laba(1);
            $data['laba_konter2'] = $this->_trx_laba(2);
            $data['total_kartu'] = $this->_produk_terjual(1);
            $data['total_acc'] = $this->_produk_terjual(2);
        }
        return \view('pages/dashboard/index', $data);
    }
    private function _produk_terjual($kategori)
    {
        $terjual_perbulan = [];
        $tahun = \date('Y');
        for ($i = 1; $i <= 12; $i++) {
            $list_perhari = [];
            $bulan = \str_pad($i, 2, 0, STR_PAD_LEFT);
            $produk = $this->produk->where([
                'kategori_id' => $kategori,
                'stok.stok_terjual !=' => null,
                'DATE_FORMAT(stok.created_at, "%Y-%m")' => "$tahun-$bulan",
            ])
                ->join('stok', 'produk.id = stok.produk_id')
                ->groupBy('stok.id')
                ->findAll();
            foreach ($produk as $p) {
                \array_push($list_perhari, $p->stok_terjual);
            }
            \array_push($terjual_perbulan, \array_sum($list_perhari));
            $list_perhari = [];
        }
        return $terjual_perbulan;
    }
    private function _trx_konter($id)
    {
        return $this->trx->where([
            'konter_id' => $id,
            'DATE_FORMAT(created_at, "%Y-%m-%d")' => $this->date_now->format('Y-m-d')
        ])->first();
    }
    private function _top_produk($limit)
    {
        return $this->stok->orderBy('stok_terjual', 'DESC')
            ->join('konter', 'stok.konter_id = konter.id')
            ->join('produk', 'stok.produk_id = produk.id')
            ->groupBy('stok.id')
            ->distinct('produk_id')
            ->findAll($limit);
    }
    private function _trx_laba($konter_id)
    {
        $year = date('Y');
        $arr_total_trx = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = \str_pad($i, 2, "0", STR_PAD_LEFT);
            $arr_count = [];
            $trx = $this->trx->where([
                'total_trx !=' => null,
                'konter_id' => $konter_id,
                'DATE_FORMAT(created_at, "%Y-%m")' =>  "$year-$month"
            ])->orderBy('created_at', 'DESC')->findAll();
            foreach ($trx as $item) {
                \array_push($arr_count, $item->total_trx);
            }
            \array_push($arr_total_trx, \array_sum($arr_count));
            $arr_count = [];
        }
        return $arr_total_trx;
    }
    //--------------------------------------------------------------------

}
