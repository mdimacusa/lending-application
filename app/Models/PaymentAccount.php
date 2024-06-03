<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;

    protected $table = 'payment_account';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
