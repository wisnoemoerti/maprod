<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Pembelian extends Model
{
    protected $table = 'pembelians';

    public static function tambah($request)
    {
    	DB::beginTransaction();
        try {
            $db = new Pembelian();
			$db->nama =  $request->nama;
			$db->keterangan =  $request->keterangan;
            $db->harga =  $request->harga;
            $db->tanggal =  $request->tanggal;
			$db->save();
	    	DB::commit();
			$responseData = 'Data pembelian berhasil disimpan';
			return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
			return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }

	public static function rubah($request)
    {
    	DB::beginTransaction();
        try {
            $db = Pembelian::find($request->id);
			$db->nama =  $request->nama;
			$db->keterangan =  $request->keterangan;
            $db->harga =  $request->harga;
            $db->tanggal =  $request->tanggal;
			$db->save();
            DB::commit();
			$responseData = 'Data berhasil diubah';
	    	return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
			return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }

    public static function hapus($request)
    {
    	DB::beginTransaction();
        try {
            $db = Pembelian::find($request->id);
			$db->delete();
            DB::commit();
			$responseData = 'Data berhasil dihapus';
	    	return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
	    	return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }
}
