<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaiTro extends Model
{
    use HasFactory;

    protected $table = 'vai_tro';

    protected $fillable = [
        'ten_vai_tro',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Many-to-Many với TaiKhoan
    public function taiKhoans()
    {
        return $this->belongsToMany(
            TaiKhoan::class,
            'tai_khoan_vai_tro',
            'vai_tro_id',
            'tai_khoan_id'
        )->withTimestamps();
    }

    // Many-to-Many với Quyen
    public function quyens()
    {
        return $this->belongsToMany(
            Quyen::class,
            'vai_tro_quyen',
            'vai_tro_id',
            'quyen_id'
        )->withTimestamps();
    }

    /**
     * Helper methods
     */
    public function hasPermission($permissionCode)
    {
        return $this->quyens()->where('ma_quyen', $permissionCode)->exists();
    }

    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Quyen::where('ma_quyen', $permission)->firstOrFail();
        }

        return $this->quyens()->syncWithoutDetaching($permission);
    }

    public function revokePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Quyen::where('ma_quyen', $permission)->firstOrFail();
        }

        return $this->quyens()->detach($permission);
    }
}
