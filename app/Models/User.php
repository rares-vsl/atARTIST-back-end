<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'propic'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($invoice) {
            $invoice->portfolio->delete();
        });

        static::restoring(function ($invoice) {
            $invoice->portfolio()->withTrashed()->restore();
        });
    }

    // RELAZIONI
    
    public function portfolio()
    {
        return $this->hasOne(Portfolio::class)->withTrashed();
    }
}
