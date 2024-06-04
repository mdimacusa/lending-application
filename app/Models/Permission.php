<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Permission extends Model
{
    use HasFactory;

    protected $table = 'permission';

    public function rolepermission()
    {
        return $this->belongsTo(RolePermission::class);
    }
}
