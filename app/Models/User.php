<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Hash;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'surname',
        'email',
        'pincode',
        'password',
        'role',
    ];

    //get firstname from fillable and ignore to use attribute in query
    public function setFirstNameAttribute($value)
    {
        $this->first_name = $value;
    }
    //get middle_name from fillable and ignore to use attribute in query
    public function setMiddleNameAttribute($value)
    {
        $this->middle_name = $value;
    }
    //get surname from fillable and ignore to use attribute in query
    public function setSurnameAttribute($value)
    {
        $this->surname = $value;
    }

    // protected function format_name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (mixed $value, array $attributes)
    //         => $attributes['first_name'].' '.$attributes['middle_name'].' '.$attributes['surname'],
    //     );
    // }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        //insert all data included automatically
        static::creating(function($request)
        {
            $request->name      = $request->first_name.' '.$request->middle_name.' '.$request->surname;
            $request->unique_id = rand(11111111,99999999);
        });

        //update all data included automatically
        // static::updating(function($request)
        // {
        //     $request->password = Hash::make($request->password);
        // });
    }

    public function company_wallet_history(): hasOne
    {
        return $this->hasOne(CompanyWalletHistory::class);
    }
    public function company_wallet_history_all(): hasMany
    {
        return $this->hasMany(CompanyWalletHistory::class);
    }
    public function soa()
    {
        return $this->hasMany(Soa::class);
    }
    public function notification(): hasMany
    {
        return $this->hasMany(Notification::class);
    }

}
