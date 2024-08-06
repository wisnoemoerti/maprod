<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;

//Define Model
use App\Barang;
use App\Batch;
use App\Product;
use App\Stock;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $table = DB::table('products')
            ->join('batches', 'products.id', '=', 'batches.product_id')
            ->join('stocks', 'batches.id', '=', 'stocks.batch_id')
            ->select('products.id', 'batches.id as batch_id', 'stocks.id as stock_id', 'products.name', 'products.price', 'products.pack_size', 'batches.batch_number', 'stocks.quantity', 'stocks.expired_at')
            ->get();
        $datatable = Datatables::of($table);
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function ($value) {
            $template = '
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Stok" class="btn btn-warning btn-circle stok-modal" data-table="tableBarang" data-jenis="stok" data-id="' . $value->batch_id . '" data-url="' . route('modal') . '"><i class="fa fa-pen"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Barang" class="btn btn-success btn-circle edit-modal" data-table="tableBarang" data-jenis="barang" data-id="' . $value->batch_id . '" data-url="' . route('modal') . '"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Hapus Barang" class="btn btn-danger btn-circle delete-modal" data-table="tableBarang" data-jenis="barang" data-tbl="tableBarang" data-url="' . route('barang_crud') . '" data-id="' . $value->batch_id . '"><i class="fa fa-trash"></i></a>';
            return $template;
        });
        $datatable->editColumn('price', function ($value) {
            $price = "Rp " . number_format($value->price, 0, ',', '.');
            return $price;
        });
        $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function BarangCrud(Request $request)
    {
        if ($request->isMethod('post')) {
            switch ($request->metode) {
                case 'tambah':
                    DB::beginTransaction();
                    try {
                        $productId = $request->input('product_id');
                        $productionDate = $request->input('production_date');
                        $quantity = $request->input('quantity');

                        $tanggal = now()->format('d');
                        $bulan = strtoupper(now()->format('M'));

                        $nomor_urut = Batch::whereDate('created_at', today())->count() + 1;
                        $nomor_urut_formatted = sprintf('%03d', $nomor_urut);

                        $batchNumber = "{$tanggal}/{$bulan}/BATCH{$nomor_urut_formatted}";

                        DB::transaction(function () use ($productId, $batchNumber, $productionDate, $quantity) {
                            // Create a new batch
                            $batch = Batch::create([
                                'product_id' => $productId,
                                'batch_number' => $batchNumber,
                                'production_date' => $productionDate,
                            ]);

                            // Add stock for the new batch
                            Stock::create([
                                'batch_id' => $batch->id,
                                'quantity' => $quantity,
                                'expired_at' =>  \Carbon\Carbon::parse($productionDate)->addDays(30),  // Set expired_at to production date plus 30 days
                            ]);

                            // Create a transaction record for the stock addition
                            Transaction::create([
                                'batch_id' => $batch->id,
                                'transaction_date' => now(),
                                'quantity' => $quantity,
                                'transaction_type' => 'IN',
                            ]);
                        });
                        DB::commit();
                        $responseData = 'Data barang berhasil disimpan';
                        return response()->json(['message' => $responseData], 201);
                    } catch (\Exception $ex) {
                        DB::rollback();
                        $responseData = $ex->getMessage();
                        return response()->json(['message' => 'failed', 'data' => $responseData], 400);
                    }
                    break;
                case 'edit':
                    DB::beginTransaction();
                    try {
                        $productId = $request->input('product_id');
                        $batchId = $request->input('id');
                        $productionDate = $request->input('production_date');
                        $quantity = $request->input('quantity');

                        DB::transaction(function () use ($batchId, $productionDate, $productId, $quantity) {
                            // Temukan batch berdasarkan batch_id
                            $batch = Batch::find($batchId);
                            // Update production date jika diperlukan
                            $batch->update([
                                'product_id' => $productId,
                                'production_date' => $productionDate,
                            ]);

                            $stock = Stock::where('batch_id', $batchId)->first();
                            $stock->update([
                                'quantity' => $quantity,
                            ]);

                            $transaction = Transaction::where('batch_id', $batchId)->first();
                            $transaction->update([
                                'quantity' => $quantity,
                            ]);
                        });

                        DB::commit();
                        $responseData = 'Data barang berhasil disimpan';
                        return response()->json(['message' => $responseData], 201);
                    } catch (\Exception $ex) {
                        DB::rollback();
                        $responseData = $ex->getMessage();
                        return response()->json(['message' => 'failed', 'data' => $responseData], 400);
                    }
                    break;
            }
        } else if ($request->isMethod('delete')) {
            DB::beginTransaction();
            try {
                Batch::find($request->id)->delete();
                Stock::where('batch_id', $request->id)->delete();
                Transaction::where('batch_id', $request->id)->delete();
                DB::commit();
                $responseData = 'Data berhasil dihapus';
                return response()->json(['message' => $responseData, 'data' => $responseData], 201);
            } catch (\Exception $ex) {
                DB::rollback();
                $responseData = $ex->getMessage();
                return response()->json(['message' => 'failed', 'data' => $responseData], 400);
            }
        }
    }

    public function updateStokBarang(Request $request)
    {
        DB::beginTransaction();
        try {
            $productId = $request->input('product_id');
            $batchId = $request->input('id');
            $productionDate = $request->input('production_date');
            $quantity = $request->input('quantity');
            $type = $request->input('type');
            DB::transaction(function () use ($batchId, $productionDate, $productId, $quantity, $type) {

                $stock = Stock::where('batch_id', $batchId)->first();
                if ($type == "Pengurangan") {
                    $stock->update([
                        'quantity' => $stock->quantity - $quantity,
                    ]);
                    Transaction::create([
                        'batch_id' => $batchId,
                        'transaction_date' => now(),
                        'quantity' => $quantity,
                        'transaction_type' => 'OUT',
                    ]);
                } else {
                    $stock->update([
                        'quantity' => $stock->quantity + $quantity,
                    ]);
                    Transaction::create([
                        'batch_id' => $batchId,
                        'transaction_date' => now(),
                        'quantity' => $quantity,
                        'transaction_type' => 'IN',
                    ]);
                }
            });

            DB::commit();
            $responseData = 'Data barang berhasil disimpan';
            return response()->json(['message' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
            return response()->json(['message' => 'failed', 'data' => $responseData], 400);
        }
    }

    public function getBarang(Request $request)
    {
        $data = Product::with(['batches' => function ($query) {
            $query->whereHas('stock', function ($stockQuery) {
                $stockQuery->where('quantity', '>', 0)
                    ->where('expired_at', '>', Carbon::now());
            });
        }])
            ->select('id', 'name', 'pack_size', 'price')
            ->get()
            ->filter(function ($product) {
                $totalStock = $product->batches->sum(function ($batch) {
                    return $batch->stock ? $batch->stock->sum('quantity') : 0;
                });
                return $totalStock > 0;
            })
            ->sortBy('name');


        $html = '';
        foreach ($data as $key => $value) {
            $totalStock = $value->batches->sum(function ($batch) {
                return $batch->stock ? $batch->stock->quantity : 0;
            });

            $html .= '
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' . $value->name . ' ISI (' . $value->pack_size . ')</div>
                        <div class="h5 mb-0 text-xs font-weight-bold text-gray-800">Rp. ' . number_format($value->price, 2, ',', '.') . '</div>
                        <div class="text-xs font-weight-bold text-primary mt-2"> Stok: ' . $totalStock . '</div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success btn-circle tambah-barang" data-id="' . $value->id . '" data-harga="' . $value->price . '" data-stock="' . $totalStock . '" data-nama="' . $value->name . ' ISI (' . $value->pack_size . ') ">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    </div>
                </div>
                </div>
            </div>';
        }
        return response()->json($html);
    }
}
