<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\TaiKhoan;

class Admin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'admin';

    protected $fillable = [
        'ho_ten',
        'email',
        'so_dien_thoai',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function taiKhoan()
    {
        return $this->hasOne(TaiKhoan::class, 'admin_id');
    }
}
