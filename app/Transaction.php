<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['transaction_details_id', 'batch_id', 'transaction_date', 'quantity', 'transaction_type', 'price_at_buy'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
