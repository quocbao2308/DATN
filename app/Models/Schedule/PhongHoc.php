<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongHoc extends Model
{
    use HasFactory;

    protected $table = 'phong_hoc';

    protected $fillable = [
        'ma_phong',
        'suc_chua',
        'vi_tri',
    ];

    protected $casts = [
        'suc_chua' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function lichHocs()
    {
        return $this->hasMany(LichHoc::class, 'phong_hoc_id');
    }

    public function lichThis()
    {
        return $this->hasMany(LichThi::class, 'phong_hoc_id');
    }
}
