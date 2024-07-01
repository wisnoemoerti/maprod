<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['batch_id', 'transaction_date', 'quantity', 'transaction_type'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
