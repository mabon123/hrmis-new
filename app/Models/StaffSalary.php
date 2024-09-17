<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staff_salaries';

    protected $primaryKey = 'staff_sal_id';

    protected $fillable = [
    	'payroll_id',
    	'salary_level_id',
        'official_rank_id',
    	'salary_degree',
    	'salary_type_shift_date',
    	'salary_special_shift_date',
    	'salary_type_prokah_num',
    	'salary_type_prokah_order',
    	'cardre_type_id',
    	'salary_type_signdate',
        'pro_code',
        'request_qual_id',
        'request_year',
        'request_cardre_check_status',
        'request_cardre_check_date',
        'location_check_approver',
        'location_check_status',
        'location_check_date',
        'poe_check_approver',
        'poe_check_status',
        'poe_check_date',
        'admin_check_approver',
        'admin_check_status',
        'admin_check_date',
        'salary_thanorn',
    	'created_by',
    	'updated_by',
        'highest_salary'
    ];

    // Salary level
    public function salaryLevel()
    {
        return $this->belongsTo('App\Models\SalaryLevel', 'salary_level_id');
    }

    // Cardretype
    public function cardreType()
    {
        return $this->belongsTo('App\Models\CardreType', 'cardre_type_id');
    }

    // Official rank
    public function officialRank()
    {
        return $this->belongsTo(OfficialRank::class, 'official_rank_id');
    }

}
