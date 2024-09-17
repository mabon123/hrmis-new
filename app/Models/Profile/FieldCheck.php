<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldCheck extends Model
{
    use HasFactory;

    protected $table = 'sys_field_checks';

    protected $primaryKey = 'field_id';

    public $timestamps = false;

    protected $fillable = ['field_id', 'field_title_kh', 'field_title_en', 'table_name', 'field_name'];
}