<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurationType extends Model
{
    use HasFactory;

    protected $table = 'sys_duration_types';

    protected $primaryKey = 'dur_type_id';

    public $timestamps = false;

    protected $fillable = ['dur_type_id', 'dur_type_kh', 'dur_type_en'];
}
