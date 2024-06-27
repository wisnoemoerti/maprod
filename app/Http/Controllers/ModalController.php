<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Barang;
use App\Persediaan;
use App\Pembelian;
use App\Transaksi;
use App\TransaksiDetail;

use DB;
class ModalController extends Controller
{
    public function modal(Request $request)
    {   

        $modal_size = 'modal-sm';
        $modal_title = '';
        $modal_body = '';
        $modal_footer = '';
        $url = '';
        $table = '';
        $action = '';
        switch ($request->jenis) {
            case 'barang':

                $url = route('barang_crud');
                
                $table = 'tableBarang';
                
                $action = $request->has('id') ? 'edit' : 'add';
                
                $modal_size = 'modal-lg';
                
                $modal_title = $request->has('id') ? '<i class="fa fa-edit"></i> Ubah Barang' : '<i class="fa fa-plus"></i> Tambah Barang';

                $data = $request->has('id') ? Barang::find($request->id) : [] ;

                $modal_body = View::make('modal_form.barang',$data)->render();

                $modal_footer = '
                <button type="submit" id="btn-save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-url="'.$url.'" data-tbl="'.$table.'" data-action ="'.$action.'" >Save</button>
                <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>';
                break;
            case 'stok':

                    $url = route('updateStokBarang');
                    
                    $table = 'tableBarang';
                    
                    $action = $request->has('id') ? 'edit' : 'add';
                    
                    $modal_size = 'modal-lg';
                    
                    $modal_title = $request->has('id') ? '<i class="fa fa-edit"></i> Update Stok Barang' : '<i class="fa fa-plus"></i> Tambah Barang';
    
                    $data = $request->has('id') ? Barang::find($request->id) : [] ;
    
                    $modal_body = View::make('modal_form.updateStok',$data)->render();
    
                    $modal_footer = '
                    <button type="submit" id="btn-save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-url="'.$url.'" data-tbl="'.$table.'" data-action ="'.$action.'" >Save</button>
                    <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>';
                    break;
                case 'persediaan':

                        $url = route('persediaan_crud');
                        
                        $table = 'tablePersediaan';
                        
                        $action = $request->has('id') ? 'edit' : 'add';
                        
                        $modal_size = 'modal-lg';
                        
                        $modal_title = $request->has('id') ? '<i class="fa fa-edit"></i> Ubah Persediaan' : '<i class="fa fa-plus"></i> Tambah Persediaan';
        
                        $data = $request->has('id') ? Persediaan::find($request->id) : [] ;
        
                        $modal_body = View::make('modal_form.persediaan',$data)->render();
        
                        $modal_footer = '
                        <button type="submit" id="btn-save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-url="'.$url.'" data-tbl="'.$table.'" data-action ="'.$action.'" >Save</button>
                        <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>';
                break;
            case 'stok-persediaan':

                    $url = route('updateStokPersediaan');
                    
                    $table = 'tablePersediaan';
                    
                    $action = $request->has('id') ? 'edit' : 'add';
                    
                    $modal_size = 'modal-lg';
                    
                    $modal_title = $request->has('id') ? '<i class="fa fa-edit"></i> Update Stok Persediaan' : '<i class="fa fa-plus"></i> Tambah Persediaan';
    
                    $data = $request->has('id') ? Persediaan::find($request->id) : [] ;
    
                    $modal_body = View::make('modal_form.updateStok',$data)->render();
    
                    $modal_footer = '
                    <button type="submit" id="btn-save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-url="'.$url.'" data-tbl="'.$table.'" data-action ="'.$action.'" >Save</button>
                    <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>';
                    break;
            case 'pembelian':

                $url = route('pembelian_crud');
                
                $table = 'tablePembelian';
                
                $action = $request->has('id') ? 'edit' : 'add';
                
                $modal_size = 'modal-lg';
                
                $modal_title = $request->has('id') ? '<i class="fa fa-edit"></i> Ubah Pembelian' : '<i class="fa fa-plus"></i> Tambah Pembelian';

                $data = $request->has('id') ? Pembelian::find($request->id) : [] ;

                $modal_body = View::make('modal_form.pembelian',$data)->render();

                $modal_footer = '
                <button type="submit" id="btn-save" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-url="'.$url.'" data-tbl="'.$table.'" data-action ="'.$action.'" >Save</button>
                <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>';
                break;

            case 'penjualan':

                $url = route('pembelian_crud');
                
                $table = 'tablePenjualan';
                
                $modal_size = 'modal-lg';
                
                $modal_title = '<i class="fa fa-info"></i> Info Transaksi';

                $dataTransaksi = DB::table('transaksis')->where('transaksis.id', '=', $request->id )->get();
                $dataListBarang = DB::table('transaksi_details')
                ->join('barangs', 'transaksi_details.id_barang', '=', 'barangs.id')
                ->select('transaksi_details.id_barang','transaksi_details.id_transaksi','transaksi_details.jumlah_barang','transaksi_details.harga', 'barangs.nama')
                ->where('transaksi_details.id_transaksi', '=', $request->id)
                ->get();
                // $table = DB::table('transaksis')->join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')->get();
                

                $modal_body = View::make('modal_form.penjualan', ['dataTransaksi' => $dataTransaksi, 'dataListBarang' => $dataListBarang])->render();

                $modal_footer = '
                <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>';
                break;
        }
        $data = array('modal_size' => $modal_size,'modal_title' => $modal_title, 'modal_body' => $modal_body, 'modal_footer' => $modal_footer);

        return response()->json($data);
    }
}
