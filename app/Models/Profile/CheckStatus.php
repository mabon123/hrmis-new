<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckStatus extends Model
{
    use HasFactory;

    protected $table = 'sys_check_status';

    protected $primaryKey = 'check_status_id';

    public $timestamps = false;

    protected $fillable = ['check_status_id', 'check_status_kh', 'check_status_en'];
}