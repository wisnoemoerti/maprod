<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;

//Define Model
use App\Jenis;

class JenisController extends Controller
{
    public function index()
    {
        $datatable = Datatables::of(Jenis::all());
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function ($value) {
            $template = '
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Jenis" class="btn btn-success btn-circle edit-modal" data-table="tableJenis" data-jenis="jenis" data-id="' . $value->id . '" data-url="' . route('modal') . '"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Hapus Jenis" class="btn btn-danger btn-circle delete-modal" data-table="tableJenis" data-jenis="jenis" data-tbl="tableJenis" data-url="' . route('jenis_crud') . '" data-id="' . $value->id . '"><i class="fa fa-trash"></i></a>';
            return $template;
        });
        $datatable->editColumn('harga', function ($value) {
            $harga = "Rp " . number_format($value->harga, 2, ',', '.');
            return $harga;
        });
        $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function JenisCrud(Request $request)
    {
        if ($request->isMethod('post')) {
            switch ($request->metode) {
                case 'tambah':
                    return Jenis::tambah($request);
                    break;
                case 'edit':
                    return Jenis::rubah($request);
                    break;
            }
        } else if ($request->isMethod('delete')) {
            return Jenis::hapus($request);
        }
    }

}
