<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            
            'location_code' => (string)$this->location_code,

            'location' => [
                'location_kh' => $this->location_kh,
                'location_en' => $this->location_en,            
                'emis_code' => (string)$this->emis_code,
                'location_type_kh' => (string)$this->location_type_kh,
                'acadermic_year_kh' => (string)$this->acadermic_year_kh,
                'distance_to_poe' => $this->distance_to_poe,
                'region_kh' => (string)$this->region_kh,
                'multi_levels_kh' => (string)$this->multi_levels_kh,
                'disadvantage' => $this->disadvantage,
                'sokrit' => $this->sokrit,
                'resource_center' => $this->resource_center,
                'library' => $this->library,
                'technical_school' => $this->technical_school,
                //'location_his' => str_replace("\r\n","",(string)$this->location_his),
                'location_his' => (string)$this->location_his,
            ],

             'classes' => [
                'preschool_num' => (string)$this->preschool_num,'preschoolf_num' => (string)$this->preschoolf_num,'preschool_totalclass_num' => (string)$this->preschool_totalclass_num,
                'preschool_medium_num' => (string)$this->preschool_medium_num,'preschool_mediumf_num' => (string)$this->preschool_mediumf_num,'preschool_mediumtotalclass_num' => (string)$this->preschool_mediumtotalclass_num,          
                'preschool_high_num' => (string)$this->preschool_high_num,'preschool_highf_num' => (string)$this->preschool_highf_num,'preschool_hightotalclass_num' => (string)$this->preschool_hightotalclass_num,
                'preschool_mix_num' => (string)$this->preschool_mix_num,'preschool_mixf_num' => (string)$this->preschool_mixf_num,'preschool_mixtotalclass_num' => (string)$this->preschool_mixtotalclass_num,
                'acceleration_class_y1_num' => (string)$this->acceleration_class_y1_num,'acceleration_class_y1f_num' => (string)$this->acceleration_class_y1f_num,'acceleration_y1totalclass_num' => (string)$this->acceleration_y1totalclass_num,
                'acceleration_class_y2_num' => (string)$this->acceleration_class_y2_num,'acceleration_class_y2f_num' => (string)$this->acceleration_class_y2f_num,'acceleration_y2totalclass_num' => (string)$this->acceleration_y2totalclass_num,
                'acceleration_class_y3_num' => (string)$this->acceleration_class_y3_num,'acceleration_class_y3f_num' => (string)$this->acceleration_class_y3f_num,'acceleration_y3totalclass_num' => (string)$this->acceleration_y3totalclass_num,
                'grade1_num' => (string)$this->grade1_num,'grade1f_num' => (string)$this->grade1f_num,
                'grade1totalclass_num' => (string)$this->grade1totalclass_num,'grade2_num' => (string)$this->grade2_num,
                'grade2f_num' => (string)$this->grade2f_num,'grade2totalclass_num' => (string)$this->grade2totalclass_num,
                'grade3_num' => (string)$this->grade3_num,'grade3f_num' => (string)$this->grade3f_num,'grade3totalclass_num' => (string)$this->grade3totalclass_num,
                'grade4_num' => (string)$this->grade4_num,'grade4f_num' => (string)$this->grade4f_num,'grade4totalclass_num' => (string)$this->grade4totalclass_num,
                'grade5_num' => (string)$this->grade5_num,'grade5f_num' => (string)$this->grade5f_num,'grade5totalclass_num' => (string)$this->grade5totalclass_num,
                'grade6_num' => (string)$this->grade6_num,'grade6f_num' => (string)$this->grade6f_num,'grade6totalclass_num' => (string)$this->grade6totalclass_num,
                'grade7_num' => (string)$this->grade7_num,'grade7f_num' => (string)$this->grade7f_num,'grade7totalclass_num' => (string)$this->grade7totalclass_num,
                'grade8_num' => (string)$this->grade8_num,'grade8f_num' => (string)$this->grade8f_num,'grade8totalclass_num' => (string)$this->grade8totalclass_num,
                'grade9_num' => (string)$this->grade9_num,'grade9f_num' => (string)$this->grade9f_num,'grade9totalclass_num' => (string)$this->grade9totalclass_num,
                'grade10_num' => (string)$this->grade10_num,'grade10f_num' => (string)$this->grade10f_num,'grade10totalclass_num' => (string)$this->grade10totalclass_num,
                'grade11_num' => (string)$this->grade11_num,'grade11f_num' => (string)$this->grade11f_num,'grade11totalclass_num' => (string)$this->grade11totalclass_num,
                'grade11so_num' => (string)$this->grade11so_num,'grade11sof_num' => (string)$this->grade11sof_num,'grade11sototalclass_num' => (string)$this->grade11sototalclass_num,
                'grade12_num' => (string)$this->grade12_num,'grade12f_num' => (string)$this->grade12f_num,'grade12totalclass_num' => (string)$this->grade12totalclass_num,
                'grade12so_num' => (string)$this->grade12so_num,'grade12sof_num' => (string)$this->grade12sof_num,'grade12sototalclass_num' => (string)$this->grade12sototalclass_num,
                'technical_class_y1_num' => (string)$this->technical_class_y1_num,'technical_class_y1f_num' => (string)$this->technical_class_y1f_num,'technical_y1totalclass_num' => (string)$this->technical_y1totalclass_num,
            ],

            'workplace_code' => [
                'province' =>(string)$this->workplace_province_code,
                'district' => (string)$this->workplace_district_code,
                'commune' => (string)$this->workplace_commune_code,
                'village' => (string)$this->workplace_village_code,            
            ],

            'workplace' => [
                'province' =>(string)$this->workplace_province,
                'district' => (string)$this->workplace_district,
                'commune' => (string)$this->workplace_commune,
                'village' => (string)$this->workplace_village,            
            ],
            
            'ns_256' => [
                'preschool_ns256' =>(string)$this->preschool_ns256,
                'preschool_medium_ns256' =>(string)$this->preschool_medium_ns256,
                'preschool_high_ns256' =>(string)$this->preschool_high_ns256,
                'preschool_mix_ns256' =>(string)$this->preschool_mix_ns256,
                'grade1_ns256' =>(string)$this->grade1_ns256,
                'grade2_ns256' =>(string)$this->grade2_ns256,
                'grade3_ns256' =>(string)$this->grade3_ns256,
                'grade4_ns256' =>(string)$this->grade4_ns256,
                'grade5_ns256' =>(string)$this->grade5_ns256,
                'grade6_ns256' =>(string)$this->grade6_ns256,
                'grade7_ns256' =>(string)$this->grade7_ns256,
                'grade8_ns256' =>(string)$this->grade8_ns256,
                'grade9_ns256' =>(string)$this->grade9_ns256,
                'grade10_ns256' =>(string)$this->grade10_ns256,
                'grade11_ns256' =>(string)$this->grade11_ns256,
                'grade12_ns256' =>(string)$this->grade12_ns256,
                'grade11so_ns256' =>(string)$this->grade11so_ns256,
                'grade12so_ns256' =>(string)$this->grade12so_ns256,
            ],

            'ns_20' => [
                'preschool_ns20' =>(string)$this->preschool_ns20,
                'preschool_medium_ns20' =>(string)$this->preschool_medium_ns20,
                'preschool_high_ns20' =>(string)$this->preschool_high_ns20,
                'preschool_mix_ns20' =>(string)$this->preschool_mix_ns20,
                'grade1_ns20' =>(string)$this->grade1_ns20,
                'grade2_ns20' =>(string)$this->grade2_ns20,
                'grade3_ns20' =>(string)$this->grade3_ns20,
                'grade4_ns20' =>(string)$this->grade4_ns20,
                'grade5_ns20' =>(string)$this->grade5_ns20,
                'grade6_ns20' =>(string)$this->grade6_ns20,
                'grade7_ns20' =>(string)$this->grade7_ns20,
                'grade8_ns20' =>(string)$this->grade8_ns20,
                'grade9_ns20' =>(string)$this->grade9_ns20,
                'grade10_ns20' =>(string)$this->grade10_ns20,
                'grade11_ns20' =>(string)$this->grade11_ns20,
                'grade12_ns20' =>(string)$this->grade12_ns20,
                'grade11so_ns20' =>(string)$this->grade11so_ns20,
                'grade12so_ns20' =>(string)$this->grade12so_ns20,
            ]

        ];
    }
}
