<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['product_id', 'batch_number', 'production_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
