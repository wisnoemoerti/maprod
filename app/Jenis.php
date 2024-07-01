<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Jenis extends Model
{
    protected $table = 'jenis';

    public static function tambah($request)
    {
        DB::beginTransaction();
        try {
            $db = new Jenis();
            $db->nama = $request->nama;
            $db->harga = $request->harga;
            $db->save();
            DB::commit();

            $responseData = 'Data berhasil disimpan';
            return response()->json(['message' => $responseData, 'data' => $db], 201); // Return saved data
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
            return response()->json(['message' => 'failed', 'data' => $responseData], 400);
        }
    }

    public static function rubah($request)
    {
        DB::beginTransaction();
        try {
            $db = Jenis::find($request->id);
            $db->harga =  $request->harga;
            $db->save();
            DB::commit();
            $responseData = 'Data berhasil diubah';
            return response()->json(['message' => $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
            return response()->json(['message' => 'failed', 'data' => $responseData], 400);
        }
    }

    public static function hapus($request)
    {
        DB::beginTransaction();
        try {
            $db = Jenis::find($request->id);
            $db->delete();
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
