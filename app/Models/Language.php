<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'sys_languages';

    protected $primaryKey = 'language_id';

    public $timestamps = false;

    protected $fillable = ['language_id', 'language_kh', 'language_en'];
}
