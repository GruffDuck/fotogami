<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'email',
        'password',
        "phone",
        "organization_type",
        "organization_name",
        "recovery_key",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Kullanıcı tipi: 'organizational' veya 'individual'
    public function isOrganizational()
    {
        return $this->organization_type === 'organizational';
    }
    public function isIndividual()
    {
        return $this->organization_type !== 'organizational';
    }
    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }
    // Organizasyonel kullanıcı için birden fazla event ve paket
    public function packages()
    {
        return $this->hasManyThrough(Package::class, Event::class, 'created_by', 'id', 'id', 'id');
    }
}
