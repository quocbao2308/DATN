<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Model;

class VaiTro extends Model
{
    protected $table = 'vai_tro';

    protected $fillable = [
        'ten_vai_tro',
        'mo_ta',
    ];

    /**
     * Các quyền của vai trò
     */
    public function quyens()
    {
        return $this->belongsToMany(
            Quyen::class,
            'vai_tro_quyen',
            'vai_tro_id',
            'quyen_id'
        );
    }

    /**
     * Các admin có vai trò này
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'vai_tro_id');
    }

    /**
     * Các đào tạo có vai trò này
     */
    public function daoTaos()
    {
        return $this->hasMany(DaoTao::class, 'vai_tro_id');
    }
}
