<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VaiTro extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vai_tro';

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
        'ten_vai_tro',
    ];

    /**
     * Get the permissions for this role.
     */
    public function quyens(): BelongsToMany
    {
        return $this->belongsToMany(
            Quyen::class,
            'vai_tro_quyen',
            'vai_tro_id',
            'quyen_id'
        );
    }
}
