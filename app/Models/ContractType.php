<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    use HasFactory;

    protected $table = 'sys_contract_types';

    protected $primaryKey = 'contract_type_id';

    public $timestamps = false;

    protected $fillable = ['contract_type_id', 'contract_type_kh', 'contract_type_en'];


    // Get contract positions
    public function contractPositions()
    {
    	return $this->hasMany('App\Models\ContractStaffPosition', 'contract_type_id');
    }
}
