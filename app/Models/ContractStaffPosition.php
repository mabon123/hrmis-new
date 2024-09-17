<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractStaffPosition extends Model
{
    use HasFactory;

    protected $table = 'sys_contstaff_positions';

    protected $primaryKey = 'cont_pos_id';

    public $timestamps = false;

    protected $fillable = ['cont_pos_id', 'contract_type_id', 'cont_pos_kh', 'cont_pos_en'];


    // Contract type
    public function contractType()
    {
    	return $this->belongsTo('App\Models\ContractType', 'contract_type_id');
    }
}
