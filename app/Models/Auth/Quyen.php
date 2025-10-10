<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    use HasFactory;

    protected $table = 'quyen';

    protected $fillable = [
        'ma_quyen',
        'mo_ta',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Many-to-Many với VaiTro
    public function vaiTros()
    {
        return $this->belongsToMany(
            VaiTro::class,
            'vai_tro_quyen',
            'quyen_id',
            'vai_tro_id'
        )->withTimestamps();
    }
}
