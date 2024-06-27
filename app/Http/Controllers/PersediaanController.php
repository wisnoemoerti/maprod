<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;

//Define Model
use App\Persediaan;

class PersediaanController extends Controller
{
    public function index()
    {
        $datatable = Datatables::of(Persediaan::all());
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function($value) {
            $template = '
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Stok" class="btn btn-warning btn-circle stok-modal" data-table="tablePersediaan" data-jenis="stok-persediaan" data-id="'.$value->id.'" data-url="'.route('modal').'"><i class="fa fa-pen"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Persediaan" class="btn btn-success btn-circle edit-modal" data-table="tablePersediaan" data-jenis="persediaan" data-id="'.$value->id.'" data-url="'.route('modal').'"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Hapus Persediaan" class="btn btn-danger btn-circle delete-modal" data-table="tablePersediaan" data-jenis="persediaan" data-tbl="tablePersediaan" data-url="'.route('persediaan_crud').'" data-id="'.$value->id.'"><i class="fa fa-trash"></i></a>';
            return $template;
            });
        $datatable->editColumn('jumlah_stok', function($value) {
            $jumlah_stok = $value->jumlah_stok . " ".$value->satuan;
            return $jumlah_stok;
        });
        $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function PersediaanCrud(Request $request){
        if ($request->isMethod('post')) {
            switch ($request->metode) {
                case 'tambah':
                    return Persediaan::tambah($request);    
                    break;
                case 'edit':
                    return Persediaan::rubah($request);
                    break;
            }
        }
        else if ($request->isMethod('delete')) {
            return Persediaan::hapus($request);
        }
    }

    public function updateStokPersediaan(Request $request){
        return Persediaan::updateStokPersediaan($request);
    }
}
