<?php $i1=0; $i2=0; $i3=0; ?>
<?php if($pro_code > 0) { ?>
    <h1>
        @if(auth()->user()->level_id == 3)
            @if( !empty($location_kh) )
                <h2>ការិយាល័យអប់រំ យុវជន និងកីឡា</h2>
                <h2>នៃរដ្ឋបាលក្រុង/ស្រុក{{$dis_kh}}</h2>
                <h2>{{$location_kh}}</h2>        
            @elseif( !empty($dis_kh) )
                <h2>រដ្ឋបាលក្រុង/ស្រុក{{$dis_kh}}</h2>
                <h2>ការិយាល័យអប់រំ យុវជន និងកីឡា</h2>
            @else
                <h2>ក្រសួងអប់រំយុវជន និងកីឡា</h2>
                <h2>{{auth()->user()->work_place->location_kh}}</h2>
            @endif
        @elseif(auth()->user()->level_id == 4)
            @if( !empty($location_kh) )
                <h2>ការិយាល័យអប់រំ យុវជន និងកីឡា</h2>
                <h2>នៃរដ្ឋបាលក្រុង/ស្រុក{{$dis_kh}}</h2>
                <h2>{{$location_kh}}</h2>        
            @else
                <h2>រដ្ឋបាលក្រុង/ស្រុក{{auth()->user()->staff->currentWorkPlace()->district->name_kh}}</h2>
                <h2>ការិយាល័យអប់រំ យុវជន និងកីឡា</h2>
            @endif
        @elseif(auth()->user()->level_id == 5)
            <h2>ការិយាល័យអប់រំ យុវជន និងកីឡា</h2>
            <h2>នៃរដ្ឋបាលក្រុង/ស្រុក{{$dis_kh}}</h2>
            <h2>{{auth()->user()->work_place->location_kh}}</h2>                                
        @else
            @if( !empty($location_kh) )
                <h2>ក្រសួងអប់រំយុវជន និងកីឡា</h2>
                <h2>{{App\Models\Location::where('location_code', auth()->user()->work_place->parent_location_code)->select('location_kh')->first()->location_kh}}</h2>
                <h2>{{$location_kh}}</h2>
            @else
                <h2>ក្រសួងអប់រំយុវជន និងកីឡា</h2>
                <h2>{{App\Models\Location::where('location_code', auth()->user()->work_place->parent_location_code)->select('location_kh')->first()->location_kh}}</h2>
                <h2>{{auth()->user()->work_place->location_kh}}</h2>
            @endif
        @endif
    </h1>
    <h2>បញ្ជីរាយនាមមន្រ្តីរាជការស្នើសុំដំឡើងថ្នាក់ ឋានន្តរស័ក្ដិ តាមវេនអតីតភាពការងារសម្រាប់ឆ្នាំ{{$y}}</h2>

    <table>	
        <tr>
            <td rowspan="2" ><strong>ល.រ</strong></td>
            <td rowspan="2" ><strong>អត្តលេខ</strong></td>
            <td rowspan="2" ><strong>គោត្តនាមនិងនាម</strong></td>
            <td rowspan="2" ><strong>ភេទ</strong></td>
            <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំកំណើត</strong></td>
            <td rowspan="2" ><strong>តួនាទី/<br/>មុខតំណែង</strong></td>
            <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ចូលបម្រើ<br/>ការងារ</strong></td>
            <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ដំឡើងថ្នាក់<br/>ចុងក្រោយ</strong></td>
            <td rowspan="2" ><strong>ព្រះរាជក្រឹត្យ<br/>អនុក្រឹត្យ<br/>ប្រកាសលេខ</strong></td>
            <td rowspan="2" ><strong>លេខរៀង</strong></td>
            <td colspan="2" ><strong>ដំឡើងថ្នាក់<br/>និងឋានន្តរស័ក្តិ</strong></td>        
            <td rowspan="2" ><strong>អង្គភាព</strong></td>
            <td rowspan="2" ><strong>ផ្សេងៗ</strong></td>
        </tr>
        <tr><td><strong>បច្ចុប្បន្ន</strong></td><td><strong>ស្នើសុំ</strong></td></tr>
        <tr><td colspan="15" style="text-align: left;"><h3>១- ប្រកាស</h3></td></tr>
        <tr><td colspan="15" style="text-align: left;"><h3>១-១ ដំឡើងថ្នាក់ </h3></td></tr>
            @if(count($brokah_domleungtnaks) > 0)
                @foreach($brokah_domleungtnaks as $index => $brokah_domleungtnak)
                    <?php  $i1 = $i1 + 1; ?>
                    <tr>
                        <td >{{ $i1 }}</td>
                        <td>{{ $brokah_domleungtnak->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $brokah_domleungtnak->surname_kh.' '.$brokah_domleungtnak->name_kh }}</td>
                        <td>{{ $brokah_domleungtnak->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($brokah_domleungtnak->dob)) }}</td>
                        <td>
                            @if(!empty($brokah_domleungtnak->currentPosition())) 
                                @if(str_contains($brokah_domleungtnak->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($brokah_domleungtnak->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$brokah_domleungtnak->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($brokah_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td >{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($brokah_domleungtnak->lastCardre->cardre_type_id == 1 && $brokah_domleungtnak->lastCardre->request_cardre_check_status == 1) && ($brokah_domleungtnak->requestCardreOffeset1->cardre_type_id == 2 && $brokah_domleungtnak->requestCardreOffeset1->request_cardre_check_status == 1))      
                                {{ (!empty($brokah_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($brokah_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($brokah_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($brokah_domleungtnak->lastCardreSalary->salaryLevel) && !empty($brokah_domleungtnak->lastCardreSalary->salary_degree)) ? ($brokah_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($brokah_domleungtnak->requestCardreCircle->salaryLevel) || !empty($brokah_domleungtnak->requestCardreCircle->salary_degree)) ? ($brokah_domleungtnak->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($brokah_domleungtnak->currentWorkPlace()) ? 
                                        str_replace(' ', '', $brokah_domleungtnak->currentWorkPlace()->location_kh) : 
                                        (!empty($brokah_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $brokah_domleungtnak->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>១-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
            @if(count($brokah_thanorns) > 0)
                @foreach($brokah_thanorns as $index => $brokah_thanorn)
                    <?php  $i1 = $i1 + 1; ?>
                    <tr>
                        <td >{{ $i1 }}</td>
                        <td>{{ $brokah_thanorn->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $brokah_thanorn->surname_kh.' '.$brokah_thanorn->name_kh }}</td>
                        <td>{{ $brokah_thanorn->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($brokah_thanorn->dob)) }}</td>
                        <td>
                            @if(!empty($brokah_thanorn->currentPosition())) 
                                @if(str_contains($brokah_thanorn->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($brokah_thanorn->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$brokah_thanorn->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($brokah_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($brokah_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($brokah_thanorn->lastCardre->cardre_type_id == 1 && $brokah_thanorn->lastCardre->request_cardre_check_status == 1) && ($brokah_thanorn->requestCardreOffeset1->cardre_type_id == 2 && $brokah_thanorn->requestCardreOffeset1->request_cardre_check_status == 1))
                                {{ (!empty($brokah_thanorn->requestCardreOffeset1->salaryLevel) && !empty($brokah_thanorn->requestCardreOffeset1->salary_degree)) ? ($brokah_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($brokah_thanorn->lastCardreSalary->salaryLevel) && !empty($brokah_thanorn->lastCardreSalary->salary_degree)) ? ($brokah_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($brokah_thanorn->requestCardreCircle->salaryLevel) || !empty($brokah_thanorn->requestCardreCircle->salary_degree)) ? ($brokah_thanorn->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($brokah_thanorn->currentWorkPlace()) ? 
                                        str_replace(' ', '', $brokah_thanorn->currentWorkPlace()->location_kh) : 
                                        (!empty($brokah_thanorn->latestWorkPlace()) ? str_replace(' ', '', $brokah_thanorn->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>២- អនុក្រឹត្យ</h3></td></tr>                    
        <tr><td colspan="15" style="text-align: left;"><h3>២-១ ដំឡើងថ្នាក់ </h3></td></tr>
            @if(count($ahnukret_domleungtnaks) > 0)
                @foreach($ahnukret_domleungtnaks as $index => $ahnukret_domleungtnak)
                    <?php  $i2 = $i2 + 1; ?>
                    <tr>
                        <td >{{ $i2 }}</td>
                        <td>{{ $ahnukret_domleungtnak->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $ahnukret_domleungtnak->surname_kh.' '.$ahnukret_domleungtnak->name_kh }}</td>
                        <td>{{ $ahnukret_domleungtnak->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($ahnukret_domleungtnak->dob)) }}</td>
                        <td>
                            @if(!empty($ahnukret_domleungtnak->currentPosition())) 
                                @if(str_contains($ahnukret_domleungtnak->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($ahnukret_domleungtnak->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$ahnukret_domleungtnak->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($ahnukret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($ahnukret_domleungtnak->lastCardre->cardre_type_id == 1 && $ahnukret_domleungtnak->lastCardre->request_cardre_check_status == 1) && ($ahnukret_domleungtnak->requestCardreOffeset1->cardre_type_id == 2 && $ahnukret_domleungtnak->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($ahnukret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($ahnukret_domleungtnak->lastCardreSalary->salary_degree)) ? ($ahnukret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($ahnukret_domleungtnak->requestCardreCircle->salaryLevel) || !empty($ahnukret_domleungtnak->requestCardreCircle->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($ahnukret_domleungtnak->currentWorkPlace()) ? 
                                        str_replace(' ', '', $ahnukret_domleungtnak->currentWorkPlace()->location_kh) : 
                                        (!empty($ahnukret_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $ahnukret_domleungtnak->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>២-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
            @if(count($ahnukret_thanorns) > 0)
                @foreach($ahnukret_thanorns as $index => $ahnukret_thanorn)
                    <?php  $i2 = $i2 + 1; ?>
                    <tr>
                        <td >{{ $i2 }}</td>
                        <td>{{ $ahnukret_thanorn->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $ahnukret_thanorn->surname_kh.' '.$ahnukret_thanorn->name_kh }}</td>
                        <td>{{ $ahnukret_thanorn->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($ahnukret_thanorn->dob)) }}</td>
                        <td>
                            @if(!empty($ahnukret_thanorn->currentPosition())) 
                                @if(str_contains($ahnukret_thanorn->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($ahnukret_thanorn->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$ahnukret_thanorn->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($ahnukret_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($ahnukret_thanorn->lastCardre->cardre_type_id == 1 && $ahnukret_thanorn->lastCardre->request_cardre_check_status == 1) && ($ahnukret_thanorn->requestCardreOffeset1->cardre_type_id == 2 && $ahnukret_thanorn->requestCardreOffeset1->request_cardre_check_status == 1))          
                                {{ (!empty($ahnukret_thanorn->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_thanorn->requestCardreOffeset1->salary_degree)) ? ($ahnukret_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($ahnukret_thanorn->lastCardreSalary->salaryLevel) && !empty($ahnukret_thanorn->lastCardreSalary->salary_degree)) ? ($ahnukret_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($ahnukret_thanorn->requestCardreCircle->salaryLevel) || !empty($ahnukret_thanorn->requestCardreCircle->salary_degree)) ? ($ahnukret_thanorn->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($ahnukret_thanorn->currentWorkPlace()) ? 
                                        str_replace(' ', '', $ahnukret_thanorn->currentWorkPlace()->location_kh) : 
                                        (!empty($ahnukret_thanorn->latestWorkPlace()) ? str_replace(' ', '', $ahnukret_thanorn->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>៣- ព្រះរាជក្រឹត្យ</h3></td></tr>
        <tr><td colspan="15" style="text-align: left;"><h3>៣-១ ដំឡើងថ្នាក់ </h3></td></tr>
            @if(count($reachkret_domleungtnaks) > 0)
                @foreach($reachkret_domleungtnaks as $index => $reachkret_domleungtnak)
                    <?php  $i3 = $i3 + 1; ?>
                    <tr>
                        <td >{{ $index + 1}}</td>
                        <td>{{ $reachkret_domleungtnak->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $reachkret_domleungtnak->surname_kh.' '.$reachkret_domleungtnak->name_kh }}</td>
                        <td>{{ $reachkret_domleungtnak->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($reachkret_domleungtnak->dob)) }}</td>
                        <td>
                            @if(!empty($reachkret_domleungtnak->currentPosition())) 
                                @if(str_contains($reachkret_domleungtnak->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($reachkret_domleungtnak->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$reachkret_domleungtnak->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($reachkret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($reachkret_domleungtnak->lastCardre->cardre_type_id == 1 && $reachkret_domleungtnak->lastCardre->request_cardre_check_status == 1) && ($reachkret_domleungtnak->requestCardreOffeset1->cardre_type_id == 2 && $reachkret_domleungtnak->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($reachkret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($reachkret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($reachkret_domleungtnak->lastCardreSalary->salary_degree)) ? ($reachkret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($reachkret_domleungtnak->requestCardreCircle->salaryLevel) || !empty($reachkret_domleungtnak->requestCardreCircle->salary_degree)) ? ($reachkret_domleungtnak->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($reachkret_domleungtnak->currentWorkPlace()) ? 
                                        str_replace(' ', '', $reachkret_domleungtnak->currentWorkPlace()->location_kh) : 
                                        (!empty($reachkret_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $reachkret_domleungtnak->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>៣-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
            @if(count($reachkret_thanorns) > 0)
                @foreach($reachkret_thanorns as $index => $reachkret_thanorn)
                    <?php  $i3 = $i3 + 1; ?>
                    <tr>
                        <td >{{ $i3 }}</td>
                        <td>{{ $reachkret_thanorn->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $reachkret_thanorn->surname_kh.' '.$reachkret_thanorn->name_kh }}</td>
                        <td>{{ $reachkret_thanorn->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($reachkret_thanorn->dob)) }}</td>
                        <td>
                            @if(!empty($reachkret_thanorn->currentPosition())) 
                                @if(str_contains($reachkret_thanorn->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($reachkret_thanorn->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$reachkret_thanorn->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($reachkret_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorn->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($reachkret_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($reachkret_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($reachkret_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($reachkret_thanorn->lastCardre->cardre_type_id == 1 && $reachkret_thanorn->lastCardre->request_cardre_check_status == 1) && ($reachkret_thanorn->requestCardreOffeset1->cardre_type_id == 2 && $reachkret_thanorn->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($reachkret_thanorn->requestCardreOffeset1->salaryLevel) && !empty($reachkret_thanorn->requestCardreOffeset1->salary_degree)) ? ($reachkret_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($reachkret_thanorn->lastCardreSalary->salaryLevel) && !empty($reachkret_thanorn->lastCardreSalary->salary_degree)) ? ($reachkret_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_thanorn->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($reachkret_thanorn->requestCardreCircle->salaryLevel) || !empty($reachkret_thanorn->requestCardreCircle->salary_degree)) ? ($reachkret_thanorn->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $reachkret_thanorn->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($reachkret_thanorn->currentWorkPlace()) ? 
                                        str_replace(' ', '', $reachkret_thanorn->currentWorkPlace()->location_kh) : 
                                        (!empty($reachkret_thanorn->latestWorkPlace()) ? str_replace(' ', '', $reachkret_thanorn->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            @endif
        <tr>
            <td colspan="15">            
                បញ្ឍប់បញ្ជីត្រឹមចំនួន {{$staffs_count}}នាក់ ក្នុងនោះស្រីចំនួន {{$staffs_f_count}}នាក់។          
            </td>
        </tr>

    </table>

<?php }elseif($pro_code == 0 ) { ?>

    <h1>
        <h2>ក្រសួងអប់រំយុវជន និងកីឡា</h2>
    </h1>
    <h2>បញ្ជីរាយនាមមន្រ្តីរាជការស្នើសុំដំឡើងថ្នាក់ ឋានន្តរស័ក្ដិ តាមវេនអតីតភាពការងារសម្រាប់ឆ្នាំ{{$y}}</h2>
    <table>	
        <tr>
            <td rowspan="2" ><strong>ល.រ</strong></td>
            <td rowspan="2" ><strong>អត្តលេខ</strong></td>
            <td rowspan="2" ><strong>គោត្តនាមនិងនាម</strong></td>
            <td rowspan="2" ><strong>ភេទ</strong></td>
            <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំកំណើត</strong></td>
            <td rowspan="2" ><strong>តួនាទី/<br/>មុខតំណែង</strong></td>
            <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ចូលបម្រើ<br/>ការងារ</strong></td>
            <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ដំឡើងថ្នាក់<br/>ចុងក្រោយ</strong></td>
            <td rowspan="2" ><strong>ព្រះរាជក្រឹត្យ<br/>អនុក្រឹត្យ<br/>ប្រកាសលេខ</strong></td>
            <td rowspan="2" ><strong>លេខរៀង</strong></td>
            <td colspan="2" ><strong>ដំឡើងថ្នាក់<br/>និងឋានន្តរស័ក្តិ</strong></td>        
            <td rowspan="2" ><strong>អង្គភាព</strong></td>
            <td rowspan="2" ><strong>ខេត្ត</strong></td>
            <td rowspan="2" ><strong>ផ្សេងៗ</strong></td>
        </tr>
        <tr><td><strong>បច្ចុប្បន្ន</strong></td><td><strong>ស្នើសុំ</strong></td></tr>

        <tr><td colspan="15" style="text-align: left;"><h3>១- ប្រកាស</h3></td></tr>
        <tr><td colspan="15" style="text-align: left;"><h3>១-១ ដំឡើងថ្នាក់ </h3></td></tr>
            @if(count($brokah_domleungtnaks) > 0)
                @foreach($brokah_domleungtnaks as $index => $brokah_domleungtnak)                                
                    <?php  $i1 = $i1 + 1; ?>
                    <tr>
                        <td >{{ $i1 }}</td>
                        <td>{{ $brokah_domleungtnak->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $brokah_domleungtnak->surname_kh.' '.$brokah_domleungtnak->name_kh }}</td>
                        <td>{{ $brokah_domleungtnak->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($brokah_domleungtnak->dob)) }}</td>
                        <td>
                            @if(!empty($brokah_domleungtnak->currentPosition())) 
                                @if(str_contains($brokah_domleungtnak->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($brokah_domleungtnak->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$brokah_domleungtnak->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($brokah_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td >{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($brokah_domleungtnak->lastCardre->cardre_type_id == 1 && $brokah_domleungtnak->lastCardre->request_cardre_check_status == 1) && ($brokah_domleungtnak->requestCardreOffeset1->cardre_type_id == 2 && $brokah_domleungtnak->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($brokah_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($brokah_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($brokah_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($brokah_domleungtnak->lastCardreSalary->salaryLevel) && !empty($brokah_domleungtnak->lastCardreSalary->salary_degree)) ? ($brokah_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($brokah_domleungtnak->requestCardreCircle->salaryLevel) || !empty($brokah_domleungtnak->requestCardreCircle->salary_degree)) ? ($brokah_domleungtnak->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($brokah_domleungtnak->currentWorkPlace()) ? 
                                        str_replace(' ', '', $brokah_domleungtnak->currentWorkPlace()->location_kh) : 
                                        (!empty($brokah_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $brokah_domleungtnak->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td> {{ !empty($brokah_domleungtnak->currentWorkPlace()) ? 
                                        str_replace(' ', '', $brokah_domleungtnak->currentWorkPlace()->province->name_kh) : 
                                        (!empty($brokah_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $brokah_domleungtnak->latestWorkPlace()->currentWorkPlace()->province->name_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>                                
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>១-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
            @if(count($brokah_thanorns) > 0)
                @foreach($brokah_thanorns as $index => $brokah_thanorn)                                
                    <?php  $i1 = $i1 + 1; ?>
                    <tr>
                        <td >{{ $i1 }}</td>
                        <td>{{ $brokah_thanorn->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $brokah_thanorn->surname_kh.' '.$brokah_thanorn->name_kh }}</td>
                        <td>{{ $brokah_thanorn->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($brokah_thanorn->dob)) }}</td>
                        <td>
                            @if(!empty($brokah_thanorn->currentPosition())) 
                                @if(str_contains($brokah_thanorn->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($brokah_thanorn->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$brokah_thanorn->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($brokah_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($brokah_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($brokah_thanorn->lastCardre->cardre_type_id == 1 && $brokah_thanorn->lastCardre->request_cardre_check_status == 1) && ($brokah_thanorn->requestCardreOffeset1->cardre_type_id == 2 && $brokah_thanorn->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($brokah_thanorn->requestCardreOffeset1->salaryLevel) && !empty($brokah_thanorn->requestCardreOffeset1->salary_degree)) ? ($brokah_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($brokah_thanorn->lastCardreSalary->salaryLevel) && !empty($brokah_thanorn->lastCardreSalary->salary_degree)) ? ($brokah_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($brokah_thanorn->requestCardreCircle->salaryLevel) || !empty($brokah_thanorn->requestCardreCircle->salary_degree)) ? ($brokah_thanorn->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($brokah_thanorn->currentWorkPlace()) ? 
                                        str_replace(' ', '', $brokah_thanorn->currentWorkPlace()->location_kh) : 
                                        (!empty($brokah_thanorn->latestWorkPlace()) ? str_replace(' ', '', $brokah_thanorn->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td> {{ !empty($brokah_thanorn->currentWorkPlace()) ? 
                                        str_replace(' ', '', $brokah_thanorn->currentWorkPlace()->province->name_kh) : 
                                        (!empty($brokah_thanorn->latestWorkPlace()) ? str_replace(' ', '', $brokah_thanorn->latestWorkPlace()->currentWorkPlace()->province->name_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>                                
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>២- អនុក្រឹត្យ</h3></td></tr>                    
        <tr><td colspan="15" style="text-align: left;"><h3>២-១ ដំឡើងថ្នាក់ </h3></td></tr>
            @if(count($ahnukret_domleungtnaks) > 0)
                @foreach($ahnukret_domleungtnaks as $index => $ahnukret_domleungtnak)                                
                    <?php  $i2 = $i2 + 1; ?>
                    <tr>
                        <td >{{ $i2 }}</td>
                        <td>{{ $ahnukret_domleungtnak->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $ahnukret_domleungtnak->surname_kh.' '.$ahnukret_domleungtnak->name_kh }}</td>
                        <td>{{ $ahnukret_domleungtnak->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($ahnukret_domleungtnak->dob)) }}</td>
                        <td>
                            @if(!empty($ahnukret_domleungtnak->currentPosition())) 
                                @if(str_contains($ahnukret_domleungtnak->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($ahnukret_domleungtnak->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$ahnukret_domleungtnak->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($ahnukret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($ahnukret_domleungtnak->lastCardre->cardre_type_id == 1 && $ahnukret_domleungtnak->lastCardre->request_cardre_check_status == 1) && ($ahnukret_domleungtnak->requestCardreOffeset1->cardre_type_id == 2 && $ahnukret_domleungtnak->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($ahnukret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($ahnukret_domleungtnak->lastCardreSalary->salary_degree)) ? ($ahnukret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($ahnukret_domleungtnak->requestCardreCircle->salaryLevel) || !empty($ahnukret_domleungtnak->requestCardreCircle->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($ahnukret_domleungtnak->currentWorkPlace()) ? 
                                        str_replace(' ', '', $ahnukret_domleungtnak->currentWorkPlace()->location_kh) : 
                                        (!empty($ahnukret_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $ahnukret_domleungtnak->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td> {{ !empty($ahnukret_domleungtnak->currentWorkPlace()) ? 
                                    str_replace(' ', '', $ahnukret_domleungtnak->currentWorkPlace()->province->name_kh) : 
                                    (!empty($ahnukret_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $ahnukret_domleungtnak->latestWorkPlace()->currentWorkPlace()->province->name_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>                                
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>២-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
            @if(count($ahnukret_thanorns) > 0)
                @foreach($ahnukret_thanorns as $index => $ahnukret_thanorn)                                
                    <?php  $i2 = $i2 + 1; ?>
                    <tr>
                        <td >{{ $i2 }}</td>
                        <td>{{ $ahnukret_thanorn->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $ahnukret_thanorn->surname_kh.' '.$ahnukret_thanorn->name_kh }}</td>
                        <td>{{ $ahnukret_thanorn->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($ahnukret_thanorn->dob)) }}</td>
                        <td>
                            @if(!empty($ahnukret_thanorn->currentPosition())) 
                                @if(str_contains($ahnukret_thanorn->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($ahnukret_thanorn->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$ahnukret_thanorn->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($ahnukret_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($ahnukret_thanorn->lastCardre->cardre_type_id == 1 && $ahnukret_thanorn->lastCardre->request_cardre_check_status == 1) && ($ahnukret_thanorn->requestCardreOffeset1->cardre_type_id == 2 && $ahnukret_thanorn->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($ahnukret_thanorn->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_thanorn->requestCardreOffeset1->salary_degree)) ? ($ahnukret_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($ahnukret_thanorn->lastCardreSalary->salaryLevel) && !empty($ahnukret_thanorn->lastCardreSalary->salary_degree)) ? ($ahnukret_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($ahnukret_thanorn->requestCardreCircle->salaryLevel) || !empty($ahnukret_thanorn->requestCardreCircle->salary_degree)) ? ($ahnukret_thanorn->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($ahnukret_thanorn->currentWorkPlace()) ? 
                                        str_replace(' ', '', $ahnukret_thanorn->currentWorkPlace()->location_kh) : 
                                        (!empty($ahnukret_thanorn->latestWorkPlace()) ? str_replace(' ', '', $ahnukret_thanorn->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td> {{ !empty($ahnukret_thanorn->currentWorkPlace()) ? 
                                    str_replace(' ', '', $ahnukret_thanorn->currentWorkPlace()->province->name_kh) : 
                                    (!empty($ahnukret_thanorn->latestWorkPlace()) ? str_replace(' ', '', $ahnukret_thanorn->latestWorkPlace()->currentWorkPlace()->province->name_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>                                
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>៣- ព្រះរាជក្រឹត្យ</h3></td></tr>
        <tr><td colspan="15" style="text-align: left;"><h3>៣-១ ដំឡើងថ្នាក់ </h3></td></tr>
            @if(count($reachkret_domleungtnaks) > 0)
                @foreach($reachkret_domleungtnaks as $index => $reachkret_domleungtnak)                                
                    <?php  $i3 = $i3 + 1; ?>
                    <tr>
                        <td >{{ $index + 1}}</td>
                        <td>{{ $reachkret_domleungtnak->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $reachkret_domleungtnak->surname_kh.' '.$reachkret_domleungtnak->name_kh }}</td>
                        <td>{{ $reachkret_domleungtnak->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($reachkret_domleungtnak->dob)) }}</td>
                        <td>
                            @if(!empty($reachkret_domleungtnak->currentPosition())) 
                                @if(str_contains($reachkret_domleungtnak->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($reachkret_domleungtnak->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$reachkret_domleungtnak->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($reachkret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($reachkret_domleungtnak->lastCardre->cardre_type_id == 1 && $reachkret_domleungtnak->lastCardre->request_cardre_check_status == 1) && ($reachkret_domleungtnak->requestCardreOffeset1->cardre_type_id == 2 && $reachkret_domleungtnak->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($reachkret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($reachkret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($reachkret_domleungtnak->lastCardreSalary->salary_degree)) ? ($reachkret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($reachkret_domleungtnak->requestCardreCircle->salaryLevel) || !empty($reachkret_domleungtnak->requestCardreCircle->salary_degree)) ? ($reachkret_domleungtnak->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($reachkret_domleungtnak->currentWorkPlace()) ? 
                                        str_replace(' ', '', $reachkret_domleungtnak->currentWorkPlace()->location_kh) : 
                                        (!empty($reachkret_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $reachkret_domleungtnak->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td> {{ !empty($reachkret_domleungtnak->currentWorkPlace()) ? 
                                str_replace(' ', '', $reachkret_domleungtnak->currentWorkPlace()->province->name_kh) : 
                                (!empty($reachkret_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $reachkret_domleungtnak->latestWorkPlace()->currentWorkPlace()->province->name_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>                                
                @endforeach
            @endif
        <tr><td colspan="15" style="text-align: left;"><h3>៣-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
            @if(count($reachkret_thanorns) > 0)
                @foreach($reachkret_thanorns as $index => $reachkret_thanorn)                                
                    <?php  $i3 = $i3 + 1; ?>
                    <tr>
                        <td >{{ $i3 }}</td>
                        <td>{{ $reachkret_thanorn->payroll_id }}</td>
                        <td style="text-align: left;" nowrap>{{ $reachkret_thanorn->surname_kh.' '.$reachkret_thanorn->name_kh }}</td>
                        <td>{{ $reachkret_thanorn->sex == 1 ? 'ប' : 'ស' }}</td>
                        <td>{{ date('d/m/Y', strtotime($reachkret_thanorn->dob)) }}</td>
                        <td>
                            @if(!empty($reachkret_thanorn->currentPosition())) 
                                @if(str_contains($reachkret_thanorn->currentPosition()->position_kh, 'គ្រូ')) 
                                    បង្រៀន
                                @elseif(str_contains($reachkret_thanorn->currentPosition()->position_kh, 'មន្ត្រី')) 
                                    មន្ត្រី
                                @else
                                    {{$reachkret_thanorn->currentPosition()->position_kh}}
                                    @endif
                            @endif                                  
                        </td>
                        <td>{{ isset($reachkret_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorn->start_date)->format('d/m/Y')) : '' }}</td>
                        <td>{{ isset($reachkret_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                        <td nowrap>{{ !empty($reachkret_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                        <td>{{ !empty($reachkret_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                        <td>
                            @if(($reachkret_thanorn->lastCardre->cardre_type_id == 1 && $reachkret_thanorn->lastCardre->request_cardre_check_status == 1) && ($reachkret_thanorn->requestCardreOffeset1->cardre_type_id == 2 && $reachkret_thanorn->requestCardreOffeset1->request_cardre_check_status == 1))    
                                {{ (!empty($reachkret_thanorn->requestCardreOffeset1->salaryLevel) && !empty($reachkret_thanorn->requestCardreOffeset1->salary_degree)) ? ($reachkret_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                            @else
                                {{ (!empty($reachkret_thanorn->lastCardreSalary->salaryLevel) && !empty($reachkret_thanorn->lastCardreSalary->salary_degree)) ? ($reachkret_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_thanorn->lastCardreSalary->salary_degree) : '' }}
                            @endif
                        </td>
                        <td>{{ (!empty($reachkret_thanorn->requestCardreCircle->salaryLevel) || !empty($reachkret_thanorn->requestCardreCircle->salary_degree)) ? ($reachkret_thanorn->requestCardreCircle->salaryLevel->salary_level_kh .'.'. $reachkret_thanorn->requestCardreCircle->salary_degree) : '' }}</td>
                        <td> {{ !empty($reachkret_thanorn->currentWorkPlace()) ? 
                                        str_replace(' ', '', $reachkret_thanorn->currentWorkPlace()->location_kh) : 
                                        (!empty($reachkret_thanorn->latestWorkPlace()) ? str_replace(' ', '', $reachkret_thanorn->latestWorkPlace()->location_kh) : '') }}
                        </td>
                        <td> {{ !empty($reachkret_thanorn->currentWorkPlace()) ? 
                            str_replace(' ', '', $reachkret_thanorn->currentWorkPlace()->province->name_kh) : 
                            (!empty($reachkret_thanorn->latestWorkPlace()) ? str_replace(' ', '', $reachkret_thanorn->latestWorkPlace()->currentWorkPlace()->province->name_kh) : '') }}
                        </td>
                        <td></td>
                    </tr>                                
                @endforeach
            @endif

            
        
        <tr>
            <td colspan="15">            
                បញ្ឍប់បញ្ជីត្រឹមចំនួន {{$staffs_count}}នាក់ ក្នុងនោះស្រីចំនួន {{$staffs_f_count}}នាក់។          
            </td>
        </tr>

    </table>
<?php } ?>