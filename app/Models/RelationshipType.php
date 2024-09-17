<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationshipType extends Model
{
    use HasFactory;

    protected $table = 'sys_relation_types';

    protected $primaryKey = 'relation_type_id';

    public $timestamps = false;

    protected $fillable = ['relation_type_id', 'relation_type_kh', 'relation_type_en'];
}
