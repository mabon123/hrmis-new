<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardreType extends Model
{
    use HasFactory;

    protected $table = 'sys_cardre_types';

    protected $primaryKey = 'cardre_type_id';

    public $timestamps = false;

    protected $fillable = ['cardre_type_id', 'cardre_type_kh', 'cardre_type_en'];
}
