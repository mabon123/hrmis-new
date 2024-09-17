<!-- Report #1 -->
<h6 class="kh"><strong><i>{{ __('ក. ស្ថិតិសិស្ស ថ្នាក់៖') }}</i></strong></h6>
<table class="table table-bordered table-striped table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('ថ្នាក់ / សិស្ស') }}</th>
            <th class="text-center kh" colspan="2" style="width:30%;">{{ __('សិស្ស') }}</th>
            <th class="text-center kh" colspan="2" style="width:30%;">{{ __('ថ្នាក់') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('ជាក់ស្តែង') }}</th>
            <th class="text-center kh">{{ __('តាមនិយាម') }}</th>
        </tr>
    </thead>

    <tbody>
        @php
            $lowerSecTotal = 0; $lowerSecFemale = 0; $lowerSecClass = 0; $lowerSecNorm = 0;
            $upperSecTotal = 0; $upperSecFemale = 0; $upperSecClass = 0; $upperSecNorm = 0;
        @endphp

        @foreach($grades as $key => $grade)
            @if ($key == 0)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->preschool_num }}</td>
                    <td class="text-center kh">{{ $schoolData->preschoolf_num }}</td>
                    <td class="text-center kh">{{ $schoolData->preschool_totalclass_num }}</td>
                    <td class="text-center kh"></td>
                </tr>
            @elseif ($key == 1)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->grade1_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade1f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade1totalclass_num }}</td>
                    <td class="text-center kh"></td>
                </tr>
            @elseif ($key == 7)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->grade7_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade7f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade7totalclass_num }}</td>
                    @if ($schoolData->grade7_num == 0)
                        @php $g7Norm = 0; @endphp
                    @elseif ($schoolData->grade7_num <= 58)
                        @php $g7Norm = 1; @endphp
                    @elseif ($schoolData->grade7_num <= 112)
                        @php $g7Norm = 2; @endphp
                    @elseif ($schoolData->grade7_num <= 160)
                        @php $g7Norm = 3; @endphp
                    @else
                        @php $g7Norm = round($schoolData->grade7_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g7Norm }}</strong></td>
                </tr>
                @php 
                    $lowerSecTotal += $schoolData->grade7_num; 
                    $lowerSecFemale += $schoolData->grade7f_num; 
                    $lowerSecClass += $schoolData->grade7totalclass_num;
                    $lowerSecNorm += $g7Norm;
                @endphp
            @elseif ($key == 8)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->grade8_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade8f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade8totalclass_num }}</td>
                    @if ($schoolData->grade8_num == 0)
                        @php $g8Norm = 0; @endphp
                    @elseif ($schoolData->grade8_num <= 58)
                        @php $g8Norm = 1; @endphp
                    @elseif ($schoolData->grade8_num <= 112)
                        @php $g8Norm = 2; @endphp
                    @elseif ($schoolData->grade8_num <= 160)
                        @php $g8Norm = 3; @endphp
                    @else
                        @php $g8Norm = round($schoolData->grade8_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g8Norm }}</strong></td>
                </tr>
                @php 
                    $lowerSecTotal += $schoolData->grade8_num; 
                    $lowerSecFemale += $schoolData->grade8f_num; 
                    $lowerSecClass += $schoolData->grade8totalclass_num;
                    $lowerSecNorm += $g8Norm;
                @endphp
            @elseif ($key == 9)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->grade9_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade9f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade9totalclass_num }}</td>
                    @if ($schoolData->grade9_num == 0)
                        @php $g9Norm = 0; @endphp
                    @elseif ($schoolData->grade9_num <= 58)
                        @php $g9Norm = 1; @endphp
                    @elseif ($schoolData->grade9_num <= 112)
                        @php $g9Norm = 2; @endphp
                    @elseif ($schoolData->grade9_num <= 160)
                        @php $g9Norm = 3; @endphp
                    @else
                        @php $g9Norm = round($schoolData->grade9_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g9Norm }}</strong></td>
                </tr>
                @php 
                    $lowerSecTotal += $schoolData->grade9_num; 
                    $lowerSecFemale += $schoolData->grade9f_num; 
                    $lowerSecClass += $schoolData->grade9totalclass_num;
                    $lowerSecNorm += $g9Norm;
                @endphp
                <tr>
                    <td class="kh" style="font-weight:bold;">{{ 'សរុប (ទី៧-៩)' }}</td>
                    <td class="text-center bg-total kh"><strong>{{ $lowerSecTotal }}</strong></td>
                    <td class="text-center bg-total kh"><strong>{{ $lowerSecFemale }}</strong></td>
                    <td class="text-center bg-total kh"><strong>{{ $lowerSecClass }}</strong></td>
                    <td class="text-center bg-warning kh"><strong>{{ $lowerSecNorm }}</strong></td>
                </tr>
            @elseif ($key == 10)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->grade10_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade10f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade10totalclass_num }}</td>
                    @if ($schoolData->grade10_num == 0)
                        @php $g10Norm = 0; @endphp
                    @elseif ($schoolData->grade10_num <= 58)
                        @php $g10Norm = 1; @endphp
                    @elseif ($schoolData->grade10_num <= 112)
                        @php $g10Norm = 2; @endphp
                    @elseif ($schoolData->grade10_num <= 160)
                        @php $g10Norm = 3; @endphp
                    @else
                        @php $g10Norm = round($schoolData->grade10_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g10Norm }}</strong></td>
                </tr>
                @php
                    $upperSecTotal += $schoolData->grade10_num;
                    $upperSecFemale += $schoolData->grade10f_num; 
                    $upperSecClass += $schoolData->grade10totalclass_num;
                    $upperSecNorm += $g10Norm;
                @endphp
            <!-- Applied only for grade 11 & 12 (science & social class) -->
            @elseif ($key == 11)
                <tr>
                    <td class="kh">{{ $grade.' វិទ្យាសាស្រ្ត' }}</td>
                    <td class="text-center kh">{{ $schoolData->grade11_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade11f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade11totalclass_num }}</td>
                    @if ($schoolData->grade11_num == 0)
                        @php $g11Norm = 0; @endphp
                    @elseif ($schoolData->grade11_num <= 58)
                        @php $g11Norm = 1; @endphp
                    @elseif ($schoolData->grade11_num <= 112)
                        @php $g11Norm = 2; @endphp
                    @elseif ($schoolData->grade11_num <= 160)
                        @php $g11Norm = 3; @endphp
                    @else
                        @php $g11Norm = round($schoolData->grade11_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g11Norm }}</strong></td>
                </tr>
                <tr>
                    <td class="kh">{{ $grade.' សង្គម' }}</td>
                    <td class="text-center kh">{{ $schoolData->grade11so_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade11sof_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade11sototalclass_num }}</td>
                    @if ($schoolData->grade11so_num == 0)
                        @php $g11soNorm = 0; @endphp
                    @elseif ($schoolData->grade11so_num <= 58)
                        @php $g11soNorm = 1; @endphp
                    @elseif ($schoolData->grade11so_num <= 112)
                        @php $g11soNorm = 2; @endphp
                    @elseif ($schoolData->grade11so_num <= 160)
                        @php $g11soNorm = 3; @endphp
                    @else
                        @php $g11soNorm = round($schoolData->grade11so_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g11soNorm }}</strong></td>
                </tr>
                @php
                    $upperSecTotal += ($schoolData->grade11_num + $schoolData->grade11so_num);
                    $upperSecFemale += ($schoolData->grade11f_num + $schoolData->grade11sof_num); 
                    $upperSecClass += ($schoolData->grade11totalclass_num + $schoolData->grade11sototalclass_num);
                    $upperSecNorm += ($g11Norm + $g11soNorm);
                @endphp
            @elseif ($key == 12)
                <tr>
                    <td class="kh">{{ $grade.' វិទ្យាសាស្រ្ត' }}</td>
                    <td class="text-center kh">{{ $schoolData->grade12_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade12f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade12totalclass_num }}</td>
                    @if ($schoolData->grade12_num == 0)
                        @php $g12Norm = 0; @endphp
                    @elseif ($schoolData->grade12_num <= 58)
                        @php $g12Norm = 1; @endphp
                    @elseif ($schoolData->grade12_num <= 112)
                        @php $g12Norm = 2; @endphp
                    @elseif ($schoolData->grade12_num <= 160)
                        @php $g12Norm = 3; @endphp
                    @else
                        @php $g12Norm = round($schoolData->grade12_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g12Norm }}</strong></td>
                </tr>
                <tr>
                    <td class="kh">{{ $grade.' សង្គម' }}</td>
                    <td class="text-center kh">{{ $schoolData->grade12so_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade12sof_num }}</td>
                    <td class="text-center kh">{{ $schoolData->grade12sototalclass_num }}</td>
                    @if ($schoolData->grade12so_num == 0)
                        @php $g12soNorm = 0; @endphp
                    @elseif ($schoolData->grade12so_num <= 58)
                        @php $g12soNorm = 1; @endphp
                    @elseif ($schoolData->grade12so_num <= 112)
                        @php $g12soNorm = 2; @endphp
                    @elseif ($schoolData->grade12so_num <= 160)
                        @php $g12soNorm = 3; @endphp
                    @else
                        @php $g12soNorm = round($schoolData->grade12so_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $g12soNorm }}</strong></td>
                </tr>
                @php
                    $upperSecTotal += ($schoolData->grade12_num + $schoolData->grade12so_num);
                    $upperSecFemale += ($schoolData->grade12f_num + $schoolData->grade12sof_num); 
                    $upperSecClass += ($schoolData->grade12totalclass_num + $schoolData->grade12sototalclass_num);
                    $upperSecNorm += ($g12Norm + $g12soNorm);
                @endphp
            @elseif ($key == 15)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->technical_class_y1_num }}</td>
                    <td class="text-center kh">{{ $schoolData->technical_class_y1f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->technical_y1totalclass_num }}</td>
                    @if ($schoolData->technical_class_y1_num == 0)
                        @php $gtechy1Norm = 0; @endphp
                    @elseif ($schoolData->technical_class_y1_num <= 58)
                        @php $gtechy1Norm = 1; @endphp
                    @elseif ($schoolData->technical_class_y1_num <= 112)
                        @php $gtechy1Norm = 2; @endphp
                    @elseif ($schoolData->technical_class_y1_num <= 160)
                        @php $gtechy1Norm = 3; @endphp
                    @else
                        @php $gtechy1Norm = round($schoolData->technical_class_y1_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $gtechy1Norm }}</strong></td>
                </tr>
                @php
                    $upperSecTotal += $schoolData->technical_class_y1_num;
                    $upperSecFemale += $schoolData->technical_class_y1f_num; 
                    $upperSecClass += $schoolData->technical_y1totalclass_num;
                    $upperSecNorm += $gtechy1Norm;
                @endphp
            @elseif ($key == 16)
                <tr>
                    <td class="kh">{{ $grade }}</td>
                    <td class="text-center kh">{{ $schoolData->technical_class_y2_num }}</td>
                    <td class="text-center kh">{{ $schoolData->technical_class_y2f_num }}</td>
                    <td class="text-center kh">{{ $schoolData->technical_y2totalclass_num }}</td>
                    @if ($schoolData->technical_class_y2_num == 0)
                        @php $gtechy2Norm = 0; @endphp
                    @elseif ($schoolData->technical_class_y2_num <= 58)
                        @php $gtechy2Norm = 1; @endphp
                    @elseif ($schoolData->technical_class_y2_num <= 112)
                        @php $gtechy2Norm = 2; @endphp
                    @elseif ($schoolData->technical_class_y2_num <= 160)
                        @php $gtechy2Norm = 3; @endphp
                    @else
                        @php $gtechy2Norm = round($schoolData->technical_class_y2_num / 45); @endphp
                    @endif
                    <td class="text-center kh"><strong>{{ $gtechy2Norm }}</strong></td>
                </tr>
                @php
                    $upperSecTotal += $schoolData->technical_class_y2_num;
                    $upperSecFemale += $schoolData->technical_class_y2f_num; 
                    $upperSecClass += $schoolData->technical_y2totalclass_num;
                    $upperSecNorm += $gtechy2Norm;
                @endphp
                <tr>
                    <td class="kh" style="font-weight:bold;">{{ 'សរុប (ទី១០-១២)' }}</td>
                    <td class="text-center bg-total kh"><strong>{{ $upperSecTotal }}</strong></td>
                    <td class="text-center bg-total kh"><strong>{{ $upperSecFemale }}</strong></td>
                    <td class="text-center bg-total kh"><strong>{{ $upperSecClass }}</strong></td>
                    <td class="text-center bg-warning kh"><strong>{{ $upperSecNorm }}</strong></td>
                </tr>
            @else
                <tr>
                    <td class="kh">{{ $grade.' - '.$key }}</td>
                    <td class="text-center kh"></td>
                    <td class="text-center kh"></td>
                    <td class="text-center kh"></td>
                    <td class="text-center kh"></td>
                </tr>
            @endif
        @endforeach

        <tr>
            <td class="text-center kh" style="font-family:'Moul', 'Arial';">{{ __('សរុបរួម') }}</td>
            <td class="text-center bg-total kh"><strong>{{ $lowerSecTotal + $upperSecTotal }}</strong></td>
            <td class="text-center bg-total kh"><strong>{{ $lowerSecFemale + $upperSecFemale }}</strong></td>
            <td class="text-center bg-total kh"><strong>{{ $lowerSecClass + $upperSecClass }}</strong></td>
            <td class="text-center bg-warning kh"><strong>{{ $lowerSecNorm + $upperSecNorm }}</strong></td>
        </tr>
    </tbody>
</table>
<div class="page-break"></div>

<!-- Report #2 -->
<!-- Upper secondary school -->
@if ($location->location_type_id == 14 || $location->location_type_id == 9)
    @if (is_null($location->multi_level_edu))
        <h6 class="kh"><strong><i>{{ __('ខ. ចំនួនគ្រូបង្រៀន ថ្នាក់ទី ១០ ដល់ ១២ បុគ្គលិកទីចាត់ការ និងគ្រូបង្រៀនចេញថ្មី តាមប្រភេទក្របខណ្ឌ ៖') }}</i></strong></h6>

    @elseif ($location->multi_level_edu == 1)
        <h6 class="kh"><strong><i>{{ __('ខ. ចំនួនគ្រូបង្រៀន ថ្នាក់ទី ៧ ដល់ ១២ បុគ្គលិកទីចាត់ការ និងគ្រូបង្រៀនចេញថ្មី តាមប្រភេទក្របខណ្ឌ ៖') }}</i></strong></h6>
    @elseif ($location->multi_level_edu == 2)
        <h6 class="kh"><strong><i>{{ __('ខ. ចំនួនគ្រូបង្រៀន ថ្នាក់ទី ១ ដល់ ១២ បុគ្គលិកទីចាត់ការ និងគ្រូបង្រៀនចេញថ្មី តាមប្រភេទក្របខណ្ឌ ៖') }}</i></strong></h6>
    @endif
@endif

<table class="table table-bordered table-striped table-head-fixed text-nowrap">
	<thead>
        <tr>
            <th class="text-center kh" rowspan="4" style="vertical-align:middle;">{{ __('មុខវិជ្ជាឯកទេស') }}</th>

            @if ($location->location_type_id == 14 || $location->location_type_id == 9)
                <th class="text-center kh" colspan="15" style="width:20%;">{{ __('ចំនួនគ្រូបង្រៀន ថ្នាក់ទី 10-12 (តាមឯកទេសបណ្តុះបណ្តាល)') }}</th>

                @if ($location->multi_level_edu == 1)
                    <th class="text-center kh" colspan="15">{{ __('ចំនួនគ្រូបង្រៀន ថ្នាក់ទី 7-9 (តាមឯកទេសបណ្តុះបណ្តាល)') }}</th>
                @elseif ($location->multi_level_edu == 2)
                    <th class="text-center kh" colspan="15">{{ __('ចំនួនគ្រូបង្រៀន ថ្នាក់ទី 7-9 (តាមឯកទេសបណ្តុះបណ្តាល)') }}</th>
                    <th class="text-center kh" colspan="15">{{ __('ចំនួនគ្រូបង្រៀន ថ្នាក់ទី 1-6 (តាមឯកទេសបណ្តុះបណ្តាល)') }}</th>
                @endif
            @endif

            <th class="text-center kh" rowspan="2" colspan="2" style="vertical-align:middle;">{{ __('ចំ.បុគ្គលិកទីចាត់ការ') }}</th>
            <th class="text-center kh" colspan="6">{{ __('ចំ.គ្រូចេញថ្មី') }}</th>
            <th class="text-center kh" colspan="6">{{ __('ចំ.ចូលនិវត្ត') }}</th>
        </tr>
        <tr>
            @if ($location->location_type_id == 14 || $location->location_type_id == 9)
                <th class="text-center kh" colspan="11">{{ __('មានស្រាប់') }}</th>
                <th class="text-center kh" colspan="3">{{ __('និយាម') }}</th>
                <th class="text-center kh" rowspan="3" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('ចំ.គ្រូបន្ទុកថ្នាក់') }}</th>

                @if ($location->multi_level_edu == 1)
                    <th class="text-center kh" colspan="11">{{ __('មានស្រាប់') }}</th>
                    <th class="text-center kh" colspan="3">{{ __('តាមនិយាម') }}</th>
                    <th class="text-center kh" rowspan="3" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('ចំ.គ្រូបន្ទុកថ្នាក់') }}</th>
                @elseif ($location->multi_level_edu == 2)
                    <th class="text-center kh" colspan="11">{{ __('មានស្រាប់') }}</th>
                    <th class="text-center kh" colspan="3">{{ __('តាមនិយាម') }}</th>
                    <th class="text-center kh" rowspan="3" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('ចំ.គ្រូបន្ទុកថ្នាក់') }}</th>
                    <th class="text-center kh" colspan="11">{{ __('មានស្រាប់') }}</th>
                    <th class="text-center kh" colspan="3">{{ __('តាមនិយាម') }}</th>
                    <th class="text-center kh" rowspan="3" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('ចំ.គ្រូបន្ទុកថ្នាក់') }}</th>
                @endif
            @endif
            
            <th class="text-center kh">{{ __('ឧត្តម+1') }}</th>
            <th class="text-center kh">{{ __('ឧត្តម+2') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+1') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+2') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+3') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+4') }}</th>
            <th class="text-center kh">{{ __('ឧត្តម+1') }}</th>
            <th class="text-center kh">{{ __('ឧត្តម+2') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+1') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+2') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+3') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន+4') }}</th>
        </tr>
        <tr>
            @if ($location->location_type_id == 14 || $location->location_type_id == 9)
                <th class="text-center kh" colspan="2">{{ __('គ្រូ.ឧត្តម') }}</th>
                <th class="text-center kh" colspan="2">{{ __('គ្រូ.មូលដ្ឋាន') }}</th>
                <th class="text-center kh" colspan="2">{{ __('គ្រូបឋម') }}</th>
                <th class="text-center kh" colspan="2">{{ __('គ្រូមត្តេយ្យ') }}</th>
                <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>
                <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>

                @if ($location->multi_level_edu == 1)
                    <th class="text-center kh" colspan="2">{{ __('គ្រូ.ឧត្តម') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូ.មូលដ្ឋាន') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូបឋម') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូមត្តេយ្យ') }}</th>
                    <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>
                    <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>
                @elseif ($location->multi_level_edu == 2)
                    <th class="text-center kh" colspan="2">{{ __('គ្រូ.ឧត្តម') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូ.មូលដ្ឋាន') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូបឋម') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូមត្តេយ្យ') }}</th>
                    <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>
                    <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>

                    <th class="text-center kh" colspan="2">{{ __('គ្រូ.ឧត្តម') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូ.មូលដ្ឋាន') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូបឋម') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូមត្តេយ្យ') }}</th>
                    <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>
                    <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
                    <th class="text-center kh" colspan="2">{{ __('គ្រូលើស/ខ្វះ') }}</th>
                @endif
            @endif
            
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('ឧត្តម') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('ម.ដ្ឋាន') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('1.10.2023') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('1.10.2024') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('1.10.2023') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('1.10.2024') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('1.10.2025') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('1.10.2026') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('2023') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('2024') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('2023') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('2024') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('2025') }}</th>
            <th class="text-center text-danger kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('2026') }}</th>
        </tr>
        <tr>
            @if ($location->location_type_id == 14 || $location->location_type_id == 9)
                <th class="text-center kh">{{ __('សរុប') }}</th>
                <th class="text-center kh">{{ __('ស្រី') }}</th>
                <th class="text-center kh">{{ __('សរុប') }}</th>
                <th class="text-center kh">{{ __('ស្រី') }}</th>
                <th class="text-center kh">{{ __('សរុប') }}</th>
                <th class="text-center kh">{{ __('ស្រី') }}</th>
                <th class="text-center kh">{{ __('សរុប') }}</th>
                <th class="text-center kh">{{ __('ស្រី') }}</th>
                <th class="text-center kh">{{ __('ឧត្តម') }}</th>
                <th class="text-center kh">{{ __('សរុប') }}</th>
                <th class="text-center kh">{{ __('ឧត្តម') }}</th>
                <th class="text-center kh">{{ __('សរុប') }}</th>

                @if ($location->multi_level_edu == 1)
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('មូលដ្ឋាន') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('មូលដ្ឋាន') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                @elseif ($location->multi_level_edu == 2)
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('មូលដ្ឋាន') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('មូលដ្ឋាន') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>

                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('ស្រី') }}</th>
                    <th class="text-center kh">{{ __('មូលដ្ឋាន') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                    <th class="text-center kh">{{ __('មូលដ្ឋាន') }}</th>
                    <th class="text-center kh">{{ __('សរុប') }}</th>
                @endif
            @endif
        </tr>
    </thead>

    <tbody>
        @php $s_index = 0; @endphp

        @foreach ($subjects as $subject)
            <tr>
                <td class="kh">{{ $subject->subject_kh }}</td>

                @if ($location->location_type_id == 14 || $location->location_type_id == 9)
                    @foreach ($upperTeacherBySubjectArrs[$s_index] as $upperTeacherBySubjectArr)
                        <td class="text-center kh">{{ $upperTeacherBySubjectArr }}</td>
                    @endforeach

                    <td class="text-center kh">
                        @php
                            $needUpperTeacher = round((($schoolData->grade10totalclass_num * $subject->h_g10) + 
                                ($schoolData->grade11totalclass_num * $subject->h_g11_ss) + ($schoolData->grade11sototalclass_num * $subject->h_g11_sc) + 
                                ($schoolData->grade12totalclass_num * $subject->h_g12_ss) + ($schoolData->grade12sototalclass_num * $subject->h_g12_sc) + 
                                ($upperClassInCharges[$s_index] * 4)) / 16);
                        @endphp

                        {{ $needUpperTeacher }}
                    </td>
                    <td class="text-center kh">
                        {{ (($upperTeacherBySubjectArrs[$s_index][0] + $lowerTeacherBySubjectArrs[$s_index][0]) - $needUpperTeacher) }}
                    </td>
                    <td class="text-center kh">
                        {{ (($upperTeacherBySubjectArrs[$s_index][0] + $lowerTeacherBySubjectArrs[$s_index][0] + $upperTeacherBySubjectArrs[$s_index][2]) - $needUpperTeacher) }}
                    </td>

                    <td class="text-center kh">
                        @php
                            $needUpperTeacherNorm = round((($g10Norm * $subject->h_g10) + 
                                ($g11Norm * $subject->h_g11_ss) + ($g11soNorm * $subject->h_g11_sc) + 
                                ($g12Norm * $subject->h_g12_ss) + ($g12soNorm * $subject->h_g12_sc) + 
                                ($upperClassInCharges[$s_index] * 4)) / 16);
                        @endphp

                        {{ $needUpperTeacherNorm }}
                    </td>
                    <td class="text-center kh">
                        {{ (($upperTeacherBySubjectArrs[$s_index][0] + $lowerTeacherBySubjectArrs[$s_index][0]) - $needUpperTeacherNorm) }}
                    </td>
                    <td class="text-center kh">
                        {{ (($upperTeacherBySubjectArrs[$s_index][0] + $lowerTeacherBySubjectArrs[$s_index][0] + $upperTeacherBySubjectArrs[$s_index][2]) - $needUpperTeacherNorm) }}
                    </td>
                    <td class="text-center kh">{{ $upperClassInCharges[$s_index] }}</td>

                    @if ($location->multi_level_edu == 1)
                        @foreach ($lowerTeacherBySubjectArrs[$s_index] as $lowerTeacherBySubjectArr)
                            <td class="text-center kh">{{ $lowerTeacherBySubjectArr }}</td>
                        @endforeach

                        <td class="text-center kh">
                            @php
                                $needLowerTeacher = round((($schoolData->grade7totalclass_num * $subject->h_g7) + 
                                    ($schoolData->grade8totalclass_num * $subject->h_g8) + ($schoolData->grade9totalclass_num * $subject->h_g9) + 
                                    ($lowerClassInCharges[$s_index] * 4)) / 18);
                            @endphp

                            {{ $needLowerTeacher }}
                        </td>
                        <td class="text-center kh">
                            {{ (($lowerTeacherBySubjectArrs[$s_index][2] + $upperTeacherBySubjectArrs[$s_index][2]) - $needLowerTeacher) }}
                        </td>
                        <td class="text-center kh">
                            {{ (($lowerTeacherBySubjectArrs[$s_index][2] + $lowerTeacherBySubjectArrs[$s_index][4] + $upperTeacherBySubjectArrs[$s_index][2]) - $needLowerTeacher) }}
                        </td>

                        <td class="text-center kh">
                            @php
                                $needLowerTeacherNorm = round((($g7Norm * $subject->h_g7) + 
                                    ($g8Norm * $subject->h_g8) + ($g9Norm * $subject->h_g9) + 
                                    ($lowerClassInCharges[$s_index] * 4)) / 18);
                            @endphp

                            {{ $needLowerTeacherNorm }}
                        </td>
                        <td class="text-center kh">
                            {{ (($lowerTeacherBySubjectArrs[$s_index][2] + $upperTeacherBySubjectArrs[$s_index][2]) - $needLowerTeacherNorm) }}
                        </td>
                        <td class="text-center kh">
                            {{ (($lowerTeacherBySubjectArrs[$s_index][2] + $lowerTeacherBySubjectArrs[$s_index][4] + $upperTeacherBySubjectArrs[$s_index][2]) - $needLowerTeacherNorm) }}
                        </td>
                        <td class="text-center kh">{{ $lowerClassInCharges[$s_index] }}</td>
                    @endif
                @endif

                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
            </tr>
            @php $s_index += 1; @endphp
        @endforeach

    	<tr>
    		<td class="kh" style="font-family:'Moul', 'Arial';">{{ __('សរុប') }}</td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    		<td class="text-center kh"></td>
    	</tr>
    </tbody>
</table>
<div class="page-break"></div>

<!-- Report #3 -->
<h6 class="kh"><strong><i>{{ __('គ. ចំនួនបុគ្គលិកទីចាត់ការតាមប្រភេទក្របខណ្ឌ ៖') }}</i></strong></h6>
<table class="table table-bordered table-striped table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th class="text-center kh" colspan="13"></th>
            <th class="kh" colspan="2" style="width:5%;">{{ __('ជាក់ស្តែង') }}</th>
            <th class="kh" colspan="2" style="width:5%;">{{ __('តាមនិយាម') }}</th>
        </tr>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('បុគ្គលិកទីចាត់ការ') }}</th>
            <th class="text-center kh" colspan="2">{{ __('គ្រូ.ឧត្តម') }}</th>
            <th class="text-center kh" colspan="2">{{ __('គ្រូ.មូលដ្ឋាន') }}</th>
            <th class="text-center kh" colspan="2">{{ __('កីឡា') }}</th>
            <th class="text-center kh" colspan="2">{{ __('បឋម') }}</th>
            <th class="text-center kh" colspan="2">{{ __('មត្តេយ្យ') }}</th>
            <th class="text-center kh" colspan="2">{{ __('សរុប') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('លើស/ខ្វះ') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('លើស/ខ្វះ') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
        </tr>
    </thead>

    <tbody>
        @php 
            $positions = ['នាយក', 'នាយករង', 'លេខាធិការ', 'បណ្ណារក្ស', 'បេឡា', 'គណនេយ្យ', 'ទទួលបន្ទុកយុវជន', 
                            'បរិវច្ឆការី / ពិសោធន៍', 'ឆ្មាំ', 'បុគ្គលិកផ្សេងទៀត']; 

            $totalNonTeachingStaff = 0; $totalNonTeachingStaffF = 0;
        @endphp

        @foreach ($positions as $p_index => $position)
            @php
                $totalDirector = 0;
            @endphp
            <tr>
                <td class="kh">{{ $position }}</td>
                @foreach ($totalSchoolDirectorArr[$p_index] as $totalSchoolDirector)
                    <td class="text-center kh">{{ $totalSchoolDirector }}</td>
                @endforeach

                @php
                    $totalDirector = $totalSchoolDirectorArr[$p_index][0] + $totalSchoolDirectorArr[$p_index][2] + 
                                    $totalSchoolDirectorArr[$p_index][4] + $totalSchoolDirectorArr[$p_index][6] +
                                    $totalSchoolDirectorArr[$p_index][8];

                    $totalDirectorf = $totalSchoolDirectorArr[$p_index][1] + $totalSchoolDirectorArr[$p_index][3] + 
                                    $totalSchoolDirectorArr[$p_index][5] + $totalSchoolDirectorArr[$p_index][7] +
                                    $totalSchoolDirectorArr[$p_index][9];
                @endphp
                
                <td class="text-center kh">{{ $totalDirector }}</td>
                <td class="text-center kh">{{ $totalDirectorf }}</td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
            </tr>
        @endforeach

        <tr>
            <td class="kh"><strong>{{ __('បុគ្គលិកមិនបង្រៀន') }}</strong></td>
            <td class="text-center kh">{{ $totalNonTeachingStaff }}</td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
        </tr>
        <tr>
            <td class="kh"><strong>{{ __('បុគ្គលិកបង្រៀន') }}</strong></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
        </tr>
        <tr>
            <td class="kh"><strong>{{ __('សរុបរួម') }}</strong></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
        </tr>
    </tbody>
</table>
<div class="page-break"></div>

<!-- Report #4 -->
<h6 class="kh"><strong><i>{{ __('ឃ. ផែនការប៉ាន់ស្មាន ចំនួនលើស ឬខ្វះគ្រូបង្រៀន តាមឆ្នាំសិក្សាបន្តបន្ទាប់ ៖') }}</i></strong></h6>
<table class="table table-bordered table-striped table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('ឆ្នាំសិក្សា') }}</th>
            <th class="text-center kh" colspan="2">{{ __('ក្របខណ្ឌ នឹងបាត់បង់') }}</th>
            <th class="text-center kh" colspan="2">{{ __('គ្រូចេញថ្មី') }}</th>
            <th class="text-center kh" colspan="2">{{ __('ចំនួនថ្នាក់ កើន/ថយ') }}</th>
            <th class="text-center kh" colspan="2">{{ __('ចំនួនគ្រូបង្រៀន លើស /ខ្វះ') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('ឧត្តម') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន') }}</th>
            <th class="text-center kh">{{ __('ឧត្តម') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន') }}</th>
            <th class="text-center kh">{{ __('10-12') }}</th>
            <th class="text-center kh">{{ __('7-9') }}</th>
            <th class="text-center kh">{{ __('ឧត្តម') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន') }}</th>
        </tr>
    </thead>

    <tbody>
        @php 
            $years = ['2021-2022', '2022-2023', '2023-2024', '2024-2025']; 
        @endphp

        @foreach ($years as $year)
            <tr>
                <td class="kh">{{ $year }}</td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="page-break"></div>

<!-- Report #5 -->
<h6 class="kh"><strong><i>{{ __('ង. សញ្ញាបត្ររបស់បុគ្គលិកអប់រំ ៖') }}</i></strong></h6>
<table class="table table-bordered table-striped table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('សញ្ញាបត្រ') }}</th>
            <th class="text-center kh" colspan="9">{{ __('ក្របខណ្ឌ និង ឋានន្តរស័ក្តិ') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('ភេទ') }}</th>
            <th class="text-center kh">{{ __('ក.1') }}</th>
            <th class="text-center kh">{{ __('ក.2') }}</th>
            <th class="text-center kh">{{ __('ក.3') }}</th>
            <th class="text-center kh">{{ __('ខ.1') }}</th>
            <th class="text-center kh">{{ __('ខ.2') }}</th>
            <th class="text-center kh">{{ __('ខ.3') }}</th>
            <th class="text-center kh">{{ __('គ') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
        </tr>
    </thead>

    <tbody>
        @php 
            $quals = ['បណ្ឌិត', 'អនុបណ្ឌិត', 'បរិញ្ញាបត្រ', 'មធ្យមសិក្សាទុតិយភូមិ', 'មធ្យមសិក្សាបឋមភូមិ', 'ក្រោមមធ្យម.បឋមភូមិ']; 
        @endphp

        @foreach ($quals as $qual)
            <tr>
                <td class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ $qual }}</td>
                <td class="text-center kh">{{ __('សរុប') }}</td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
            </tr>
            <tr>
                <td class="text-center kh">{{ __('ស្រី') }}</td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
                <td class="text-center kh"></td>
            </tr>
        @endforeach


        <tr>
            <td class="text-center kh" rowspan="2" style="vertical-align:middle;"><strong>{{ __('សរុបរួម') }}</strong></td>
            <td class="text-center kh">{{ __('សរុប') }}</td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
        </tr>
        <tr>
            <td class="text-center kh">{{ __('ស្រី') }}</td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
            <td class="text-center kh"></td>
        </tr>
    </tbody>
</table>
<div class="page-break"></div>
