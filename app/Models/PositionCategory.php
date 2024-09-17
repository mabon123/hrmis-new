<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionCategory extends Model
{
    use HasFactory;

    protected $table = 'sys_position_categories';

    protected $primaryKey = 'pos_category_id';

    public $timestamps = false;

    protected $fillable = ['pos_category_id', 'pos_category_kh', 'pos_category_en'];
}
