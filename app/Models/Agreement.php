<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $table ='agreement_files';

    protected $fillable = [
        'client_id',
        'soa_id',
        'pdf',
        'valid_id',
    ];

    public function client()
    {
        return $this->belongsTo(client::class);
    }
}
