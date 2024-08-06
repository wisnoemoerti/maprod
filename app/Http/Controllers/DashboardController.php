<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\TransaksiDetail;
use App\Pembelian;
use App\Barang;
use App\Product;
use App\Transaction;
use App\TransactionDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function LabaRugi()
    {
        function getPendapatan($i)
        {
            $count = 0;
            $Transaksi = TransactionDetail::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->select('total_payment')->get();

            foreach ($Transaksi as $data) {
                $count += $data->total_payment;
            }
            return $count;
        }

        $pendapatan = [];
        for ($i = 1; $i < 13; $i++) {
            array_push($pendapatan, getPendapatan($i));
        }

        $data = [
            "pendapatan" => $pendapatan,
        ];
        return $data;
    }

    public function Barang()
    {
        function getPenjualan($productId)
        {
            return Transaction::whereHas('batch', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
                ->where('transaction_type', 'PURCHASED')
                ->sum('quantity');
        }

        $data = Product::select('id', 'name')->get();
        $barang = [];
        $Penjualan = [];

        foreach ($data as $product) {
            array_push($Penjualan, getPenjualan($product->id));
            array_push($barang, $product->name);
        }

        return [
            "barang" => $barang,
            "penjualan" => $Penjualan,
        ];
    }
}
