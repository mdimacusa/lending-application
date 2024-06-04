<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payment extends Model
{
    use HasFactory;

    protected $table ='payment';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment_account()
    {
        return $this->belongsTo(PaymentAccount::class);
    }
}
