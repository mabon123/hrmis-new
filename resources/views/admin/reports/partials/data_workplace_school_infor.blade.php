        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->location_code }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text"> {{ $staffs[$i]->workplace_kh }}</span></td>        
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->province_kh }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->district_kh }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->commune_kh }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->region_kh }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->disadvantage }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->sokrit }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->AmountSt }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->FAmount }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{$staffs[$i]->AmountConS }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{$staffs[$i]->TAmount }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{  $staffs[$i]->NTAmount }}</span></td> @if( $staffs[$i]->TAmount/$staffs[$i]->AmountSt*100<70)
        <td style="text-align: center; border: 1px solid black; background-color:red;"><span class="info-box-text">{{ sprintf('%0.2f',$staffs[$i]->TAmount/$staffs[$i]->AmountSt*100).'% ' }}</span></td>
         @else
         <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ sprintf('%0.2f',$staffs[$i]->TAmount/$staffs[$i]->AmountSt*100).'% ' }}</span></td>
        @endif
        <!--មត្តេយ្យ--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->preschool_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->preschoolf_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->preschool_totalclass_num }}</span></td>
        <!--ថ្នាក់ទី១--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade1_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade1f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade1totalclass_num }}</span></td>
         <!--ថ្នាក់ទី២--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade2_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade2f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade2totalclass_num }}</span></td>
        <!--ថ្នាក់ទី៣--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade3_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade3f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade3totalclass_num }}</span></td>
        <!--ថ្នាក់ទី៤--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade4_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade4f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade4totalclass_num }}</span></td>
        <!--ថ្នាក់ទី៥--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade5_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade5f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade5totalclass_num }}</span></td>
        <!--ថ្នាក់ទី៦--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade6_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade6f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade6totalclass_num }}</span></td>
         <!--ថ្នាក់ពន្លឺនឆ្នាំទី១ --> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_class_y1_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_class_y1f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_y1totalclass_num }}</span></td>
         <!--ថ្នាក់ពន្លឺនឆ្នាំទី២ --> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_class_y2_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_class_y2f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_y2totalclass_num }}</span></td>
        <!--ថ្នាក់ពន្លឺនឆ្នាំទី៣ --> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_class_y3_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_class_y3f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->acceleration_y3totalclass_num }}</span></td>
        <!--ថ្នាក់ទី៧--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade7_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade7f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade7totalclass_num }}</span></td>
        <!--ថ្នាក់ទី៨--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade8_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade8f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade8totalclass_num }}</span></td>
        <!--ថ្នាក់ទី៩--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade9_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade9f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade9totalclass_num }}</span></td>
        <!--ថ្នាក់ទី១០--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade10_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade10f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade10totalclass_num }}</span></td>
        <!--ថ្នាក់ទី១១--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade11_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade11f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade11totalclass_num }}</span></td>
        <!--ថ្នាក់ទី១២--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade12_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade12f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->grade12totalclass_num }}</span></td>
        <!--ឆ្នាំសិក្សាទី១--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_class_y1_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_class_y1f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_y1totalclass_num }}</span></td>
        <!--ឆ្នាំសិក្សាទី២--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_class_y2_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_class_y2f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_y2totalclass_num }}</span></td>
        <!--ឆ្នាំសិក្សាទី៣--> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_class_y3_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_class_y3f_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->technical_y3totalclass_num }}</span></td>
        <!--សរុបរួម --> 
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->tstud_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->fstud_num }}</span></td>
        <td style="text-align: center; border: 1px solid black;"><span class="info-box-text">{{ $staffs[$i]->class_num }}</span></td>
