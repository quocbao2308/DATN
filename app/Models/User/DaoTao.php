<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\TaiKhoan;

class DaoTao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dao_tao';

    protected $fillable = [
        'ho_ten',
        'email',
        'so_dien_thoai',
        'phong_ban',
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
        return $this->hasOne(TaiKhoan::class, 'dao_tao_id');
    }
}
