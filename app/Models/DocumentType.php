<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'sys_doc_types';

    protected $primaryKey = 'doc_type_id';

    public $timestamps = false;

    protected $fillable = ['doc_type_id', 'doc_type_kh', 'doc_type_en'];
}
