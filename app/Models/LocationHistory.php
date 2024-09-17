<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationHistory extends Model
{
    use HasFactory;

    protected $table = 'hrmis_location_histories';

    protected $primaryKey = 'location_his_id';

    protected $fillable = [
        'location_code', 'year_id', 'class_num', 'tstud_num', 'fstud_num',
        'preschool_num', 'preschoolf_num', 'preschool_totalclass_num', 'preschool_medium_num',
        'preschool_mediumf_num', 'preschool_mediumtotalclass_num', 'preschool_high_num', 'preschool_highf_num',
        'preschool_hightotalclass_num', 'preschool_mix_num', 'preschool_mixf_num', 'preschool_mixtotalclass_num',
        'grade1_num', 'grade1f_num', 'grade1totalclass_num', 'grade2_num', 'grade2f_num', 'grade2totalclass_num',
        'grade3_num', 'grade3f_num', 'grade3totalclass_num', 'grade4_num', 'grade4f_num', 'grade4totalclass_num',
        'grade5_num', 'grade5f_num', 'grade5totalclass_num', 'grade6_num', 'grade6f_num', 'grade6totalclass_num',
        'grade7_num', 'grade7f_num', 'grade7totalclass_num', 'grade8_num', 'grade8f_num', 'grade8totalclass_num',
        'grade9_num', 'grade9f_num', 'grade9totalclass_num', 'grade10_num', 'grade10f_num', 'grade10totalclass_num',
        'grade11_num', 'grade11f_num', 'grade11totalclass_num', 'grade12_num', 'grade12f_num', 'grade12totalclass_num',
        'grade11so_num', 'grade11sof_num', 'grade11sototalclass_num', 'grade12so_num', 'grade12sof_num', 'grade12sototalclass_num',
        'acceleration_class_y1_num', 'acceleration_class_y1f_num', 'acceleration_y1totalclass_num',
        'acceleration_class_y2_num', 'acceleration_class_y2f_num', 'acceleration_y2totalclass_num',
        'acceleration_class_y3_num', 'acceleration_class_y3f_num', 'acceleration_y3totalclass_num',
        'technical_class_y1_num', 'technical_class_y1f_num', 'technical_y1totalclass_num',
        'technical_class_y2_num', 'technical_class_y2f_num', 'technical_y2totalclass_num',
        'technical_class_y3_num', 'technical_class_y3f_num', 'technical_y3totalclass_num',
        'rttc_class_y1_num', 'rttc_class_y1f_num', 'rttc_y1totalclass_num',
        'rttc_class_y2_num', 'rttc_class_y2f_num', 'rttc_y2totalclass_num',
        'rttc_class_y3_num', 'rttc_class_y3f_num', 'rttc_y3totalclass_num',
        'rttc_class_y4_num', 'rttc_class_y4f_num', 'rttc_y4totalclass_num',
        'pttc_class_y1_num', 'pttc_class_y1f_num', 'pttc_y1totalclass_num',
        'pttc_class_y2_num', 'pttc_class_y2f_num', 'pttc_y2totalclass_num',
        'nie_class_y1_num', 'nie_class_y1f_num', 'nie_y1totalclass_num',
        'nie_class_y2_num', 'nie_class_y2f_num', 'nie_y2totalclass_num',
        'ces_class_num', 'ces_class_f_num', 'ces_totalclass_num',
        'psttc_class_y1_num', 'psttc_class_y1f_num', 'psttc_y1totalclass_num',
        'psttc_class_y2_num', 'psttc_class_y2f_num', 'psttc_y2totalclass_num',
    ];


    // Get location
    public function location()
    {
    	return $this->belongsTo('App\Models\Location', 'location_code');
    }


    // Get academic year
    public function academicYear()
    {
    	return $this->belongsTo('App\Models\AcademicYear', 'year_id');
    }
}
