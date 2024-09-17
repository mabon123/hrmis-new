<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffMovement extends Model
{
    use HasFactory;

    protected $table = 'hrmis_staff_movements';
    protected $primaryKey = 'movement_id';

    protected $guarded = [];
    protected $casts = [];

    // Staff Info
    public function staffInfo()
    {
        return $this->belongsTo(Staff::class, 'payroll_id');
    }

    // Old Province
    public function oldProvince()
    {
        return $this->belongsTo(Province::class, 'old_pro_code', 'pro_code');
    }

    // New Province
    public function newProvince()
    {
        return $this->belongsTo(Province::class, 'new_pro_code', 'pro_code');
    }

    // Old District
    public function oldDistrict()
    {
        return $this->belongsTo(District::class, 'old_dis_code', 'dis_code');
    }

    // New District
    public function newDistrict()
    {
        return $this->belongsTo(District::class, 'new_dis_code', 'dis_code');
    }

    // Old Location
    public function oldLocation()
    {
        return $this->belongsTo(Location::class, 'old_location_code', 'location_code');
    }

    // New Location
    public function newLocation()
    {
        return $this->belongsTo(Location::class, 'new_location_code', 'location_code');
    }

    // Old Status
    public function oldStatus()
    {
        return $this->belongsTo(StaffStatus::class, 'old_status_id', 'status_id');
    }

    // New Status
    public function newStatus()
    {
        return $this->belongsTo(StaffStatus::class, 'new_status_id', 'status_id');
    }
}
