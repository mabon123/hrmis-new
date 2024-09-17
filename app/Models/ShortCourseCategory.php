<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortCourseCategory extends Model
{
    use HasFactory;

    protected $table = 'sys_shortcourse_categories';

    protected $primaryKey = 'shortcourse_cat_id';

    public $timestamps = false;

    protected $fillable = ['shortcourse_cat_id', 'shortcourse_cat_kh', 'shortcourse_cat_en'];
}
