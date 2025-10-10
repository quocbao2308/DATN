<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DmTrinhDo extends Model
{
    use HasFactory;

    protected $table = 'dm_trinh_do';

    protected $fillable = [
        'ten_trinh_do',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function giangViens()
    {
        return $this->hasMany(\App\Models\NhanSu\GiangVien::class, 'trinh_do_id');
    }
}
