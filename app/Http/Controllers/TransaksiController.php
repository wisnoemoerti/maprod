<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;
use DB;
use Carbon\Carbon;
use PDF;

//Define Model
use App\Transaksi;
use App\TransaksiDetail;
use App\Barang;



class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $datatable = Datatables::of(Transaksi::all());
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function($value) {
            $template = '
                <a href="javascript:void(0);" class="btn btn-primary btn-circle info-modal" data-table="tablePenjualan" data-jenis="penjualan" data-id="'.$value->id.'" data-url="'.route('modal').'"><i class="fa fa-info"></i></a>';
            // $template = '
            // <a href="javascript:void(0);" class="btn btn-success btn-circle edit-modal" data-table="tablePenjualan" data-jenis="penjualan" data-id="'.$value->id.'" data-url="'.route('modal').'"><i class="fa fa-edit"></i></a>
            // <a href="javascript:void(0);" class="btn btn-danger btn-circle delete-modal" data-table="tablePenjualan" data-jenis="penjualan" data-tbl="tablePenjualan" data-url="'.route('penjualan_crud').'" data-id="'.$value->id.'"><i class="fa fa-trash"></i></a>';
            return $template;
            });
        $datatable->editColumn('tanggal_transaksi', function($value) {
            $tanggal_transaki = date('d F Y', strtotime($value->tanggal_transaksi));
            return $tanggal_transaki;
        });
        $datatable->editColumn('total_pembayaran', function($value) {
            $total_pembayaran = "Rp " . number_format($value->total_pembayaran,2,',','.');
            return $total_pembayaran;
        });
        $datatable->rawColumns(['actions']);
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
            $db = new Transaksi();
            $db->nama_pembeli       = $request->nama;
            $db->keterangan         = $request->keterangan;
            $db->tanggal_transaksi  = Carbon::now();
            $db->total_pembayaran   = $request->total_pembayaran;
            $db->bayar              = $request->bayar;
            $db->kembalian          = $request->kembalian;
            $saved = $db->save();
            if($saved){
                foreach ($request->barang as $id => $item) {
                    $db2 = new TransaksiDetail();
                    $db2->id_barang       = $id;
                    $db2->id_transaksi         = $db->id;
                    $db2->jumlah_barang  = $item['qty'];
                    $db2->harga   = $item['harga'];
                    $db2->total_harga   = $item['harga'];
                    $save = $db2->save();

                    $db3 = Barang::find($id);
                    $db3->jumlah_stok = $db3->jumlah_stok - $item['qty'];
                    $db3->save();
                }
            }
            DB::commit();
            $responseData = 'Data barang berhasil disimpan';
            return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
            return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }


    public function struk()
    {
        $dataTransaksi = DB::table('transaksis')->orderBy('created_at', 'desc')->first();
        $dataListBarang = DB::table('transaksi_details')
        ->join('barangs', 'transaksi_details.id_barang', '=', 'barangs.id')
        ->select('transaksi_details.id_barang','transaksi_details.id_transaksi','transaksi_details.jumlah_barang','transaksi_details.harga', 'barangs.nama')
        ->where('transaksi_details.id_transaksi', '=', $dataTransaksi->id)
        ->get();
        return view('pages.penjualan.struk', ['dataTransaksi' => $dataTransaksi, 'dataListBarang' => $dataListBarang]);
    }

}
