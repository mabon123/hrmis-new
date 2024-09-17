<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmirationType extends Model
{
    use HasFactory;

    protected $table = 'sys_admiration_types';

    protected $primaryKey = 'admiration_type_id';

    protected $fillable = [
    	'admiration_type_id',
    	'admiration_type_kh',
    	'admiration_type_en',
    	'active',
    	'created_by',
    	'updated_by'
    ];


    // Get created by user info
    public function createdBy()
    {
    	return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }


    // Get updated by user info
    public function updatedBy()
    {
    	return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }


    /**
     * Get only active admiration type
     *
     * Query Scope
     *
     * @param  Query  $query
     */
    public function scopeActive($query)
    {
    	return $query->where('active', 1);
    }
}
