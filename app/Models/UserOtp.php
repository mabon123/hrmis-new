<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    use HasFactory;

    protected $table = 'admin_user_otps';

    protected $guarded = [];
    protected $casts = [];

    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
