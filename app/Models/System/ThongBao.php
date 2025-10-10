<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\TaiKhoan;

class ThongBao extends Model
{
    use HasFactory;

    protected $table = 'thong_bao';

    protected $fillable = [
        'tai_khoan_id',
        'tieu_de',
        'noi_dung',
        'loai',
        'lien_ket',
        'da_doc',
    ];

    protected $casts = [
        'da_doc' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }

    /**
     * Scopes
     */
    public function scopeUnread($query)
    {
        return $query->where('da_doc', false);
    }

    public function scopeRead($query)
    {
        return $query->where('da_doc', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('loai', $type);
    }

    /**
     * Helper methods
     */
    public function markAsRead()
    {
        $this->update(['da_doc' => true]);
    }

    public function markAsUnread()
    {
        $this->update(['da_doc' => false]);
    }
}
