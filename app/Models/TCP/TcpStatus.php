<?php

namespace App\Models\TCP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TcpStatus extends Model
{
    use HasFactory;
    protected $table = 'tcp_check_status';
    protected $primaryKey = 'tcp_status_id';

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [];
}
