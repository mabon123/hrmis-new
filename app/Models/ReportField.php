<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportField extends Model
{
    use HasFactory;

    protected $table = 'sys_report_fields';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public $timestamps = false;

    // Only Active
    public function scopeActive($query)
    {
        return $this->where('active', 1);
    }

    public function getTableFieldAttribute()
    {
        return $this->table_name.'.'.$this->field_name;
    }
}
