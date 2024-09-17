<?php

namespace App\Http\Controllers\ApiV1;
use App\Models\Location;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationsResource;

class LocationController extends Controller
{
    
    // public function getLocations($pro_code) {        
    public function getLocations(Request $request) {        
        try {
            $request->validate([
                'pro_code' => 'required',
                'location_type_id' => 'required',
            ]);
            $locationcode = $request->location_code;
            $discode = $request->dis_code;
            $comcode = $request->com_code;
            $procode = $request->pro_code;
            $location_type_id = $request->location_type_id;
            $data = Location::
                            leftJoin('sys_location_types', 'sys_locations.location_type_id', '=', 'sys_location_types.location_type_id')
                            ->leftJoin('sys_provinces', 'sys_locations.pro_code', '=', 'sys_provinces.pro_code')
                            ->leftJoin('sys_districts', 'sys_locations.dis_code', '=', 'sys_districts.dis_code')
                            ->leftJoin('sys_communes', 'sys_locations.com_code', '=', 'sys_communes.com_code')
                            ->leftJoin('sys_villages', 'sys_locations.vil_code', '=', 'sys_villages.vil_code')
                            ->leftJoin('sys_regions', 'sys_locations.region_id', '=', 'sys_regions.region_id')
                            ->leftJoin('sys_multi_levels', 'sys_locations.multi_level_edu', '=', 'sys_multi_levels.multi_level_id')
                            ->leftJoin(
                                DB::raw('
                                    (
                                        SELECT `location_code`, `year_kh`,
                                        preschool_num,preschoolf_num,preschool_totalclass_num,
                                        preschool_medium_num,preschool_mediumf_num,preschool_mediumtotalclass_num,
                                        preschool_high_num,preschool_highf_num,preschool_hightotalclass_num,
                                        preschool_mix_num,preschool_mixf_num,preschool_mixtotalclass_num,
                                        acceleration_class_y1_num,acceleration_class_y1f_num,acceleration_y1totalclass_num,
                                        acceleration_class_y2_num,acceleration_class_y2f_num,acceleration_y2totalclass_num,
                                        acceleration_class_y3_num,acceleration_class_y3f_num,acceleration_y3totalclass_num,
                                        grade1_num,grade1f_num,grade1totalclass_num,
                                        grade2_num,grade2f_num,grade2totalclass_num,
                                        grade3_num,grade3f_num,grade3totalclass_num,
                                        grade4_num,grade4f_num,grade4totalclass_num,
                                        grade5_num,grade5f_num,grade5totalclass_num,
                                        grade6_num,grade6f_num,grade6totalclass_num,
                                        grade7_num,grade7f_num,grade7totalclass_num,
                                        grade8_num,grade8f_num,grade8totalclass_num,
                                        grade9_num,grade9f_num,grade9totalclass_num,
                                        grade10_num,grade10f_num,grade10totalclass_num,
                                        grade11_num,grade11f_num,grade11totalclass_num,
                                        grade11so_num,grade11sof_num,grade11sototalclass_num,
                                        grade12_num,grade12f_num,grade12totalclass_num,
                                        grade12so_num,grade12sof_num,grade12sototalclass_num,
                                        technical_class_y1_num,technical_class_y1f_num,technical_y1totalclass_num,
                                        technical_class_y2_num,technical_class_y2f_num,technical_y2totalclass_num,
                                        technical_class_y3_num,technical_class_y3f_num,technical_y3totalclass_num,
                                        func_getNS(256, 0, preschool_num) as preschool_ns256,
                                        func_getNS(20, 0, preschool_num) as preschool_ns20,
                                        func_getNS(256, 0, preschool_medium_num) as preschool_medium_ns256,
                                        func_getNS(20, 0, preschool_medium_num) as preschool_medium_ns20,
                                        func_getNS(256, 0, preschool_high_num) as preschool_high_ns256,
                                        func_getNS(20, 0, preschool_high_num) as preschool_high_ns20,
                                        func_getNS(256, 0, preschool_mix_num) as preschool_mix_ns256,
                                        func_getNS(20, 0, preschool_mix_num) as preschool_mix_ns20,
                                        func_getNS(256, 1, grade1_num) as grade1_ns256,
                                        func_getNS(20, 1, grade1_num) as grade1_ns20,
                                        func_getNS(256, 1, grade2_num) as grade2_ns256,
                                        func_getNS(20, 1, grade2_num) as grade2_ns20,
                                        func_getNS(256, 1, grade3_num) as grade3_ns256,
                                        func_getNS(20, 1, grade3_num) as grade3_ns20,
                                        func_getNS(256, 2, grade4_num) as grade4_ns256,
                                        func_getNS(20, 2, grade4_num) as grade4_ns20,
                                        func_getNS(256, 2, grade5_num) as grade5_ns256,
                                        func_getNS(20, 2, grade5_num) as grade5_ns20,
                                        func_getNS(256, 2, grade6_num) as grade6_ns256,
                                        func_getNS(20, 2, grade6_num) as grade6_ns20,
                                        func_getNS(256, 3, grade7_num) as grade7_ns256,
                                        func_getNS(20, 3, grade7_num) as grade7_ns20,
                                        func_getNS(256, 3, grade8_num) as grade8_ns256,
                                        func_getNS(20, 3, grade8_num) as grade8_ns20,
                                        func_getNS(256, 3, grade9_num) as grade9_ns256,
                                        func_getNS(20, 3, grade9_num) as grade9_ns20,
                                        func_getNS(256, 3, grade10_num) as grade10_ns256,
                                        func_getNS(20, 3, grade10_num) as grade10_ns20,
                                        func_getNS(256, 3, grade11_num) as grade11_ns256,
                                        func_getNS(20, 3, grade11_num) as grade11_ns20,
                                        func_getNS(256, 3, grade12_num) as grade12_ns256,
                                        func_getNS(20, 3, grade12_num) as grade12_ns20,
                                        func_getNS(256, 3, grade11so_num) as grade11so_ns256,
                                        func_getNS(20, 3, grade11so_num) as grade11so_ns20,
                                        func_getNS(256, 3, grade12so_num) as grade12so_ns256,
                                        func_getNS(20, 3, grade12so_num) as grade12so_ns20
                                        FROM `hrmis_location_histories` 
                                        INNER JOIN sys_academic_years ON(hrmis_location_histories.`year_id`=sys_academic_years.`year_id`)
                                        WHERE `cur_year`=1
                                        GROUP BY `location_code`
                                    )loca_hist
                                '),function($join){           
                                    $join->on('sys_locations.location_code', '=', 'loca_hist.location_code');
                                }
                            )
                            ->select(
                                'sys_locations.location_kh as location_kh', 
                                'sys_locations.location_en as location_en', 
                                'sys_locations.location_code as location_code', 
                                'sys_locations.emis_code as emis_code', 
                                'sys_location_types.location_type_kh as location_type_kh',                                
                                'loca_hist.year_kh as acadermic_year_kh', 
                                'sys_locations.distance_to_poe as distance_to_poe', 
                                'sys_provinces.name_kh as workplace_province', 
                                'sys_locations.pro_code as workplace_province_code', 
                                'sys_districts.name_kh as workplace_district', 
                                'sys_locations.dis_code as workplace_district_code', 
                                'sys_communes.name_kh as workplace_commune', 
                                'sys_locations.com_code as workplace_commune_code', 
                                'sys_villages.name_kh as workplace_village', 
                                'sys_locations.vil_code as workplace_village_code', 
                                'sys_regions.region_kh as region_kh', 
                                'sys_multi_levels.multi_levels_kh as multi_levels_kh', 
                                'sys_locations.disadvantage as disadvantage', 
                                'sys_locations.resource_center as resource_center', 
                                'sys_locations.library as library', 
                                'sys_locations.technical_school as technical_school', 
                                'sys_locations.location_his as location_his', 
                                'preschool_num','preschoolf_num','preschool_totalclass_num',
                                'preschool_medium_num','preschool_mediumf_num','preschool_mediumtotalclass_num',
                                'preschool_high_num','preschool_highf_num','preschool_hightotalclass_num',
                                'preschool_mix_num','preschool_mixf_num','preschool_mixtotalclass_num',
                                'acceleration_class_y1_num','acceleration_class_y1f_num','acceleration_y1totalclass_num',
                                'acceleration_class_y2_num','acceleration_class_y2f_num','acceleration_y2totalclass_num',
                                'acceleration_class_y3_num','acceleration_class_y3f_num','acceleration_y3totalclass_num',
                                'grade1_num','grade1f_num','grade1totalclass_num',
                                'grade2_num','grade2f_num','grade2totalclass_num',
                                'grade3_num','grade3f_num','grade3totalclass_num',
                                'grade4_num','grade4f_num','grade4totalclass_num',
                                'grade5_num','grade5f_num','grade5totalclass_num',
                                'grade6_num','grade6f_num','grade6totalclass_num',
                                'grade7_num','grade7f_num','grade7totalclass_num',
                                'grade8_num','grade8f_num','grade8totalclass_num',
                                'grade9_num','grade9f_num','grade9totalclass_num',
                                'grade10_num','grade10f_num','grade10totalclass_num',
                                'grade11_num','grade11f_num','grade11totalclass_num',
                                'grade11so_num','grade11sof_num','grade11sototalclass_num',
                                'grade12_num','grade12f_num','grade12totalclass_num',
                                'grade12so_num','grade12sof_num','grade12sototalclass_num',
                                'technical_class_y1_num','technical_class_y1f_num','technical_y1totalclass_num',
                                'technical_class_y2_num','technical_class_y2f_num','technical_y2totalclass_num',
                                'technical_class_y3_num','technical_class_y3f_num','technical_y3totalclass_num',
                                'preschool_ns256 as preschool_ns256',
                                'preschool_ns20 as preschool_ns20',
                                'preschool_medium_ns256 as preschool_medium_ns256',
                                'preschool_medium_ns20 as preschool_medium_ns20',
                                'preschool_high_ns256 as preschool_high_ns256',
                                'preschool_high_ns20 as preschool_high_ns20',
                                'preschool_mix_ns256 as preschool_mix_ns256',
                                'preschool_mix_ns20 as preschool_mix_ns20',
                                'grade1_ns256 as grade1_ns256',
                                'grade1_ns20 as grade1_ns20',
                                'grade2_ns256 as grade2_ns256',
                                'grade2_ns20 as grade2_ns20',
                                'grade3_ns256 as grade3_ns256',
                                'grade3_ns20 as grade3_ns20',
                                'grade4_ns256 as grade4_ns256',
                                'grade4_ns20 as grade4_ns20',
                                'grade5_ns256 as grade5_ns256',
                                'grade5_ns20 as grade5_ns20',
                                'grade6_ns256 as grade6_ns256',
                                'grade6_ns20 as grade6_ns20',
                                'grade7_ns256 as grade7_ns256',
                                'grade7_ns20 as grade7_ns20',
                                'grade8_ns256 as grade8_ns256',
                                'grade8_ns20 as grade8_ns20',
                                'grade9_ns256 as grade9_ns256',
                                'grade9_ns20 as grade9_ns20',
                                'grade10_ns256 as grade10_ns256',
                                'grade10_ns20 as grade10_ns20',
                                'grade11_ns256 as grade11_ns256',
                                'grade11_ns20 as grade11_ns20',
                                'grade12_ns256 as grade12_ns256',
                                'grade12_ns20 as grade12_ns20',
                                'grade11so_ns256 as grade11so_ns256',
                                'grade11so_ns20 as grade11so_ns20',
                                'grade12so_ns256 as grade12so_ns256',
                                'grade12so_ns20 as grade12so_ns20',
                            )
                            //->whereIn('sys_locations.location_type_id',[11,17,18,9,10,14,15])
                            ->when($locationcode <> '' , function($query) use($procode, $locationcode) {
                                $query->where('sys_locations.pro_code',$procode)
                                          ->where('sys_locations.location_code',$locationcode);
                            })                            
                            ->when($discode <> '' , function($query) use($procode, $discode) {
                                $query->where('sys_locations.pro_code',$procode)
                                        ->where('sys_locations.dis_code',$discode);
                            })
                            ->when($comcode <> '' , function($query) use($procode, $comcode) {
                                $query->where('sys_locations.pro_code',$procode)
                                        ->where('sys_locations.com_code',$comcode);
                            })
                            ->when($procode <> '' , function($query) use($procode) {
                                $query->where('sys_locations.pro_code',$procode);
                            })
                            ->when($location_type_id <> 0 , function($query) use($location_type_id) {
                                $query->where('sys_locations.location_type_id',$location_type_id);
                            })
                            ->when($location_type_id == 0, function($query) {
                                $query->whereIn('sys_locations.location_type_id',[14,15,17,18]);
                            })
                            ->groupBy('sys_locations.location_code')
                            ->get()->all();

            if(!empty($data)) {
               return LocationsResource::collection($data)
               ->response()
               ->setStatusCode(202);
            }else{
                return response(array(
                    'message' => 'Not record found!',
                 ), 404);
            }
        } catch (\Exception $exeption) {
            return response(["message"=>$exeption->getMessage()]);
        }
    }

}
