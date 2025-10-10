<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Admin;
use App\Models\User\DaoTao;
use App\Models\User\SinhVien;
use App\Models\User\GiangVien;

class TaiKhoan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tai_khoan';

    protected $fillable = [
        'ten_dang_nhap',
        'mat_khau',
        'sinh_vien_id',
        'giang_vien_id',
        'dao_tao_id',
        'admin_id',
        'last_login',
        'remember_token',
        'email_verified_at',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Polymorphic relationship - Tài khoản có thể thuộc về 1 trong 4 loại user
     */
    public function userable()
    {
        // Determine which type of user this account belongs to
        if ($this->sinh_vien_id) {
            return $this->belongsTo(SinhVien::class, 'sinh_vien_id');
        }
        if ($this->giang_vien_id) {
            return $this->belongsTo(GiangVien::class, 'giang_vien_id');
        }
        if ($this->dao_tao_id) {
            return $this->belongsTo(DaoTao::class, 'dao_tao_id');
        }
        if ($this->admin_id) {
            return $this->belongsTo(Admin::class, 'admin_id');
        }
        return null;
    }

    // Relationships
    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class, 'sinh_vien_id');
    }

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'giang_vien_id');
    }

    public function daoTao()
    {
        return $this->belongsTo(DaoTao::class, 'dao_tao_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Many-to-Many với VaiTro
    public function vaiTros()
    {
        return $this->belongsToMany(
            VaiTro::class,
            'tai_khoan_vai_tro',
            'tai_khoan_id',
            'vai_tro_id'
        )->withTimestamps();
    }

    /**
     * Helper methods
     */
    public function isSinhVien()
    {
        return !is_null($this->sinh_vien_id);
    }

    public function isGiangVien()
    {
        return !is_null($this->giang_vien_id);
    }

    public function isDaoTao()
    {
        return !is_null($this->dao_tao_id);
    }

    public function isAdmin()
    {
        return !is_null($this->admin_id);
    }

    public function getUserType()
    {
        if ($this->isAdmin()) return 'admin';
        if ($this->isDaoTao()) return 'dao_tao';
        if ($this->isGiangVien()) return 'giang_vien';
        if ($this->isSinhVien()) return 'sinh_vien';
        return null;
    }

    /**
     * Check if user has role
     */
    public function hasRole($roleName)
    {
        return $this->vaiTros()->where('ten_vai_tro', $roleName)->exists();
    }

    /**
     * Check if user has permission
     */
    public function hasPermission($permissionCode)
    {
        return $this->vaiTros()
            ->whereHas('quyens', function ($query) use ($permissionCode) {
                $query->where('ma_quyen', $permissionCode);
            })
            ->exists();
    }
}
