<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;

//Define Model
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $datatable = Datatables::of(Product::all());
        $datatable->addIndexColumn();
        $datatable->addColumn('actions', function ($value) {
            $template = '
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Ubah Jenis" class="btn btn-success btn-circle edit-modal" data-table="tableProduct" data-jenis="product" data-id="' . $value->id . '" data-url="' . route('modal') . '"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Hapus Jenis" class="btn btn-danger btn-circle delete-modal" data-table="tableProduct" data-jenis="product" data-tbl="tableProduct" data-url="' . route('product_crud') . '" data-id="' . $value->id . '"><i class="fa fa-trash"></i></a>';
            return $template;
        });
        $datatable->editColumn('price', function ($value) {
            $harga = "Rp " . number_format($value->price, 0, ',', '.');
            return $harga;
        });
        $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function ProductCrud(Request $request)
    {
        if ($request->isMethod('post')) {
            switch ($request->metode) {
                case 'tambah':
                    return Product::tambah($request);
                    break;
                case 'edit':
                    return Product::rubah($request);
                    break;
            }
        } else if ($request->isMethod('delete')) {
            return Product::hapus($request);
        }
    }
}
