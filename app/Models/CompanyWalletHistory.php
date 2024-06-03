<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CompanyWalletHistory extends Model
{
    use HasFactory;
    protected $table ='company_wallet_history';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
