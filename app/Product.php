<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{

    protected $fillable = ['name', 'price', 'pack_size'];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public static function tambah($request)
    {

        DB::beginTransaction();
        try {
            $db = new Product();
            $db->name = $request->name;
            $db->price = $request->price;
            $db->pack_size = $request->pack_size;
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
            $db = Product::find($request->id);
            $db->name = $request->name;
            $db->price = $request->price;
            $db->pack_size = $request->pack_size;
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
            $db = Product::find($request->id);
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
