<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ThongBao extends Model
{
    use HasFactory;

    protected $table = 'thong_bao';

    protected $fillable = [
        'nguoi_nhan_id',
        'nguoi_tao_id',
        'tieu_de',
        'noi_dung',
        'loai',
        'lien_ket',
        'da_doc',
        'vai_tro_nhan', // all, admin, dao_tao, giang_vien, sinh_vien
        'batch_id', // ID nhóm để nhóm các thông báo cùng lúc gửi
    ];

    protected $casts = [
        'da_doc' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function nguoiNhan()
    {
        return $this->belongsTo(User::class, 'nguoi_nhan_id');
    }

    public function nguoiTao()
    {
        return $this->belongsTo(User::class, 'nguoi_tao_id');
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

    public function scopeByRole($query, $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('vai_tro_nhan', $role)
                ->orWhere('vai_tro_nhan', 'all');
        });
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update(['da_doc' => true]);
    }

    public function markAsUnread()
    {
        $this->update(['da_doc' => false]);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('loai', $type);
    }
}
