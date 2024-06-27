<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;

//Define Model
use App\Pembelian;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $datatable = Datatables::of(Pembelian::all());
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function($value) {
            $template = '
            <a href="javascript:void(0);" class="btn btn-success btn-circle edit-modal" data-table="tablePembelian" data-jenis="pembelian" data-id="'.$value->id.'" data-url="'.route('modal').'"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" class="btn btn-danger btn-circle delete-modal" data-table="tablePembelian" data-jenis="pembelian" data-tbl="tablePembelian" data-url="'.route('pembelian_crud').'" data-id="'.$value->id.'"><i class="fa fa-trash"></i></a>';
            return $template;
            });
        $datatable->editColumn('tanggal', function($value) {
            $tanggal = date('d F Y', strtotime($value->tanggal));
            return $tanggal;
        });
        $datatable->editColumn('harga', function($value) {
            $harga = "Rp " . number_format($value->harga,2,',','.');
            return $harga;
        });
        $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function PembelianCrud(Request $request){
        if ($request->isMethod('post')) {
            switch ($request->metode) {
                case 'tambah':
                    return Pembelian::tambah($request);    
                    break;
                case 'edit':
                    return Pembelian::rubah($request);
                    break;
            }
        }
        else if ($request->isMethod('delete')) {
            return Pembelian::hapus($request);
        }
    }
}
