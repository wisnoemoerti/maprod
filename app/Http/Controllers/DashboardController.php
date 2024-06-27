<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\TransaksiDetail;
use App\Pembelian;
use App\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function LabaRugi()
    {
        function getPendapatan($i){
            $count = 0;
            $Transaksi = Transaksi::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->select('total_pembayaran')->get();
            foreach ($Transaksi as $data){
                $count += $data->total_pembayaran;
            }
            return $count;
        }

        function getPengeluaran($i){
            $count = 0;
            $Pembelian = Pembelian::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->select('harga')->get();
            foreach ($Pembelian as $data){
                $count += $data->harga;
            }
            return $count;
        }

        $pendapatan = [];
        $pengeluaran = [];
        for ($i=1; $i < 13 ; $i++) { 
            array_push($pendapatan,getPendapatan($i));
            array_push($pengeluaran,getPengeluaran($i));
        }

        $data = [
            "pendapatan" => $pendapatan,
            "pengeluaran" => $pengeluaran,
        ];
        return $data;
    }

    public function Barang()
    {
        function getPenjualan($id){
            $count = 0;
            $TransaksiDetail = TransaksiDetail::where('id_barang',$id)->select('jumlah_barang')->get();
            foreach ($TransaksiDetail as $data){
                $count += $data->jumlah_barang;
            }
            return $count;
        }

        $data = Barang::select('nama','id')->get();
        $barang = [];
        $Penjualan = [];
        foreach ($data as $datas){
            array_push($Penjualan,getPenjualan($datas->id));
            array_push($barang,$datas->nama);
        }       
        return [
            "barang" => $barang,
            "penjualan" => $Penjualan,
        ];;
    }
}
