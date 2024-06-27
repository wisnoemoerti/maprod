<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class Persediaan extends Model
{
    protected $table = 'persediaans';

    public static function tambah($request)
    {
    	DB::beginTransaction();
        try {
            $db = new Persediaan();
			$db->nama =  $request->nama;
			$db->jumlah_stok =  $request->jumlah_stok;
			$db->satuan =  $request->satuan;
			$db->save();
	    	DB::commit();
			$responseData = 'Data persediaan berhasil disimpan';
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
            $db = Persediaan::find($request->id);
			$db->nama =  $request->nama;
			$db->jumlah_stok =  $request->jumlah_stok;
			$db->satuan =  $request->satuan;
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

    public static function updateStokPersediaan($request)
    {
    	DB::beginTransaction();
        try {
            $db = Persediaan::find($request->id);
            if ($request->type == "Pengurangan"){
                $db->jumlah_stok =  $db->jumlah_stok-$request->jumlah_stok;
            }else{
                $db->jumlah_stok =  $db->jumlah_stok+$request->jumlah_stok;
            }
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
            $db = Persediaan::find($request->id);
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
