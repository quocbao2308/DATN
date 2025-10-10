<?php

namespace App\Models\HeThong;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DaoTao extends Model
{
    protected $table = 'dao_tao';

    protected $fillable = [
        'user_id',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'dia_chi',
    ];

    /**
     * User account
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
