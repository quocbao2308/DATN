<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\HeThong\VaiTro;

class Quyen extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quyen';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ma_quyen',
        'mo_ta',
    ];

    /**
     * Get the roles that have this permission.
     */
    public function vaiTros(): BelongsToMany
    {
        return $this->belongsToMany(VaiTro::class, 'vai_tro_quyen', 'quyen_id', 'vai_tro_id');
    }
}
