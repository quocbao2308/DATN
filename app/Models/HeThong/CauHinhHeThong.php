<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHinhHeThong extends Model
{
    use HasFactory;

    protected $table = 'cau_hinh_he_thong';

    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Helper methods
     */
    public static function get($key, $default = null)
    {
        $config = self::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

    public static function set($key, $value, $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description
            ]
        );
    }

    public static function has($key)
    {
        return self::where('key', $key)->exists();
    }

    public static function remove($key)
    {
        return self::where('key', $key)->delete();
    }

    /**
     * Common system configs
     */
    public static function getHocPhiMotTinChi()
    {
        return (float) self::get('hoc_phi_mot_tin_chi', 500000);
    }

    public static function getToiDaTinChiMoiKy()
    {
        return (int) self::get('toi_da_tin_chi_moi_ky', 24);
    }

    public static function getThoiGianMoDangKy()
    {
        return self::get('thoi_gian_mo_dang_ky');
    }

    public static function getEmailSupport()
    {
        return self::get('email_support', 'support@smis.edu.vn');
    }
}
