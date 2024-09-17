<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staff_leaves';
    protected $primaryKey = 'leave_id';

    protected $guarded = [];
    protected $casts = [];

    // Leave type
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
    // Staff info
    public function staffInfo()
    {
        return $this->belongsTo(Staff::class, 'payroll_id');
    }
}
