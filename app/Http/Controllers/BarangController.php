<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;

//Define Model
use App\Barang;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $table = DB::table('barangs')
            ->join('jenis', 'barangs.id_jenis', '=', 'jenis.id')
            ->select('barangs.*', 'jenis.nama', 'jenis.harga');
        $datatable = Datatables::of($table);
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function ($value) {
            $template = '
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Stok" class="btn btn-warning btn-circle stok-modal" data-table="tablePersediaan" data-jenis="stok" data-id="' . $value->id . '" data-url="' . route('modal') . '"><i class="fa fa-pen"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Barang" class="btn btn-success btn-circle edit-modal" data-table="tableBarang" data-jenis="barang" data-id="' . $value->id . '" data-url="' . route('modal') . '"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Hapus Barang" class="btn btn-danger btn-circle delete-modal" data-table="tableBarang" data-jenis="barang" data-tbl="tableBarang" data-url="' . route('barang_crud') . '" data-id="' . $value->id . '"><i class="fa fa-trash"></i></a>';
            return $template;
        });
        $datatable->editColumn('harga', function ($value) {
            $harga = "Rp " . number_format($value->harga, 2, ',', '.');
            return $harga;
        });
        $datatable->editColumn('jenis_pack', function ($value) {
            $jenis_pack = $value->jenis_pack . " butir";
            return $jenis_pack;
        });
        $datatable->editColumn('jumlah_stok', function ($value) {
            $jumlah_stok = $value->jumlah_stok . " pack";
            return $jumlah_stok;
        });
        $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function BarangCrud(Request $request)
    {
        if ($request->isMethod('post')) {
            switch ($request->metode) {
                case 'tambah':
                    return Barang::tambah($request);
                    break;
                case 'edit':
                    return Barang::rubah($request);
                    break;
            }
        } else if ($request->isMethod('delete')) {
            return Barang::hapus($request);
        }
    }

    public function updateStokBarang(Request $request)
    {
        return Barang::updateStokBarang($request);
    }

    public function getBarang(Request $request)
    {
        $data = Barang::select('id', 'nama', 'jumlah_stok', 'harga')->where('nama', $request->barang)
            ->orWhere('nama', 'like', '%' . $request->barang . '%')->get();

        $html = '';
        foreach ($data as $key => $value) {
            $html .= '
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' . $value->nama . '</div>
                    <div class="h5 mb-0 text-xs font-weight-bold text-gray-800">Rp. ' . number_format($value->harga, 2, ',', '.') . '</div>
                    <div class="text-xs font-weight-bold text-primary mt-2"> Stok: ' . $value->jumlah_stok . '</div>
                  </div>
                  <div class="col-auto">
                    <button class="btn btn-success btn-circle tambah-barang" data-id="' . $value->id . '" data-harga="' . $value->harga . '" data-nama="' . $value->nama . '">
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
