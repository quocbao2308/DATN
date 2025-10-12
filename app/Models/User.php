<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the admin record associated with the user.
     */
    public function admin()
    {
        return $this->hasOne(\App\Models\HeThong\Admin::class, 'user_id');
    }

    /**
     * Get the dao tao record associated with the user.
     */
    public function daoTao()
    {
        return $this->hasOne(\App\Models\HeThong\DaoTao::class, 'user_id');
    }

    /**
     * Get the giang vien record associated with the user.
     */
    public function giangVien()
    {
        return $this->hasOne(\App\Models\NhanSu\GiangVien::class, 'user_id');
    }

    /**
     * Get the sinh vien record associated with the user.
     */
    public function sinhVien()
    {
        return $this->hasOne(\App\Models\NhanSu\SinhVien::class, 'user_id');
    }
}
