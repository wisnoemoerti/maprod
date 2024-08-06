<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['batch_id', 'quantity', 'expired_at'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
