<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use PDF;

//Define Model
use App\Transaksi;
use App\TransaksiDetail;
use App\Barang;
use App\Batch;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $datatable = Datatables::of(TransactionDetail::all());
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function ($value) {
            $template = '
                <a href="javascript:void(0);" class="btn btn-primary btn-circle info-modal" data-table="tablePenjualan" data-jenis="penjualan" data-id="' . $value->id . '" data-url="' . route('modal') . '"><i class="fa fa-info"></i></a>';
            // $template = '
            // <a href="javascript:void(0);" class="btn btn-success btn-circle edit-modal" data-table="tablePenjualan" data-jenis="penjualan" data-id="'.$value->id.'" data-url="'.route('modal').'"><i class="fa fa-edit"></i></a>
            // <a href="javascript:void(0);" class="btn btn-danger btn-circle delete-modal" data-table="tablePenjualan" data-jenis="penjualan" data-tbl="tablePenjualan" data-url="'.route('penjualan_crud').'" data-id="'.$value->id.'"><i class="fa fa-trash"></i></a>';
            return $template;
        });
        $datatable->editColumn('transaction_date', function ($value) {
            $tanggal_transaki = date('d F Y', strtotime($value->transaction_date));
            return $tanggal_transaki;
        });
        $datatable->editColumn('total_payment', function ($value) {
            $total_payment = "Rp " . number_format($value->total_payment, 2, ',', '.');
            return $total_payment;
        });
        $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function listTransaction(Request $request)
    {
        $table = DB::table('transactions')
            ->join('batches', 'transactions.batch_id', '=', 'batches.id')
            ->join('products', 'batches.product_id', '=', 'products.id')
            ->select(
                'transactions.transaction_date',
                'transactions.created_at',
                'transactions.quantity',
                'transactions.transaction_type',
                'products.name as product_name',
                'products.price as product_price',
                'batches.batch_number'
            )
            ->get();

        $datatable = Datatables::of($table);
        $datatable->editColumn('created_at', function ($value) {
            $created_at = date('d M Y H:i:s ', strtotime($value->created_at));
            return $created_at;
        });
        $datatable->addIndexColumn();
        return $datatable->make(true);
    }

    public function postTransaction(Request $request)
    {
        // dd($request->all());

        // $collect = [];

        // foreach ($param['barang'] as $id => $item) {
        //     $barang['id'] = $id;
        //     $barang['qty'] = $item['qty'];
        //     $barang['harga'] = $item['harga'];

        //     array_push($collect, $barang);
        // }

        // dd($collect);
        DB::beginTransaction();
        try {
            $db = new TransactionDetail();

            $db->buyer_name       = $request->nama;
            $db->description         = $request->keterangan;
            $db->transaction_date  = Carbon::now();
            $db->total_payment   = $request->total_pembayaran;
            $db->paid              = $request->bayar;
            $db->return          = $request->kembalian;
            $saved = $db->save();
            if ($saved) {
                foreach ($request->barang as $id => $item) {
                    $remainingQuantity = $item['qty'];

                    $batches = Batch::where('product_id', $id)
                        ->whereHas('stock', function ($query) {
                            $query->where('quantity', '>', 0);
                        })
                        ->orderBy('production_date')
                        ->with('stock')
                        ->get();

                    foreach ($batches as $batch) {
                        if ($remainingQuantity <= 0) {
                            break;
                        }

                        $currentBatchQuantity = $batch->stock->quantity;

                        if ($currentBatchQuantity >= $remainingQuantity) {
                            Transaction::create([
                                'transaction_details_id' => $db->id,
                                'batch_id' => $batch->id,
                                'transaction_date' => now(),
                                'quantity' => $remainingQuantity,
                                'price_at_buy' => $item['harga'],
                                'transaction_type' => 'PURCHASED'
                            ]);

                            $batch->stock->update([
                                'quantity' => $currentBatchQuantity - $remainingQuantity
                            ]);

                            $remainingQuantity = 0;
                        } else {
                            Transaction::create([
                                'transaction_details_id' => $db->id,
                                'batch_id' => $batch->id,
                                'transaction_date' => now(),
                                'quantity' => $currentBatchQuantity,
                                'price_at_buy' => $item['harga'],
                                'transaction_type' => 'PURCHASED'
                            ]);

                            $batch->stock->update([
                                'quantity' => 0
                            ]);

                            $remainingQuantity -= $currentBatchQuantity;
                        }
                    }


                    // $db2 = new TransaksiDetail();
                    // $db2->id_barang       = $id;
                    // $db2->id_transaksi         = $db->id;
                    // $db2->jumlah_barang  = $item['qty'];
                    // $db2->harga   = $item['harga'];
                    // $db2->total_harga   = $item['harga'];
                    // $save = $db2->save();

                    // $db3 = Barang::find($id);
                    // $db3->jumlah_stok = $db3->jumlah_stok - $item['qty'];
                    // $db3->save();
                }
            }
            DB::commit();
            $responseData = 'Data barang berhasil disimpan';
            return response()->json(['message' => $responseData, 'data' => $db], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
            return response()->json(['message' => 'failed', 'data' => $responseData], 400);
        }
    }


    public function struk()
    {
        $dataTransaksi = DB::table('transaction_details')->orderBy('created_at', 'desc')->first();

        $dataListBarang = DB::table('transactions')
            ->join('batches', 'transactions.batch_id', '=', 'batches.id')
            ->join('products', 'batches.product_id', '=', 'products.id')
            ->select('transactions.quantity', 'transactions.price_at_buy', 'products.name')
            ->where('transactions.transaction_details_id', '=', $dataTransaksi->id)
            ->get();
        return view('pages.penjualan.struk', ['dataTransaksi' => $dataTransaksi, 'dataListBarang' => $dataListBarang]);
    }
}
