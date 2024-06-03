<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    use HasFactory;

    protected $table ='client';

    protected $fillable = [
        'first_name',
        'middle_name',
        'surname',
        'email',
        'contact_number',
        'address',
    ];

    //unique id automatically store to the table
    protected static function boot()
    {
        parent::boot();
        static::creating(function($request)
        {
            $request->unique_id = rand(11111111,99999999);
        });
    }
    public function soa()
    {
        return $this->hasMany(Soa::class);
    }

    public function payment_account()
    {
        return $this->hasMany(PaymentAccount::class);
    }
    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
    public function agreement()
    {
        return $this->hasMany(Agreement::class);
    }


}
