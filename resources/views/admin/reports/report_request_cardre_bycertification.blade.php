<?php $i1=0; $i2=0; $i3=0; ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>បញ្ជីរាយនាមមន្រ្តីរាជការស្នើសុំដំឡើងថ្នាក់តាមសញ្ញាបត្រ{{auth()->user()->work_place->location_kh}}ឆ្នាំ{{$y}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>       
        .wrapper{width: 1030px; margin: 0 auto;}
        h1,h2,h3,h4{font-family:'Khmer OS Muol Light',Moul;margin:0;padding:0;font-weight:normal!important;line-height:18px;}
        h1{font-size:13px!important;text-align:center;}
        h2{font-size:12px!important;text-align:left;}
        h3{font-size:11px!important;}
        h4{font-family:'Khmer OS Siemreap',Moul;font-size:12px!important;}
        td{font-family:'Khmer OS Siemreap',Moul;border: .1px solid black;text-align:center;font-size:12px!important;padding: 0 2px!important;}
        tr{height:18px;}
        header>h2:nth-last-child(1){padding-bottom:6px}
        header>h2:nth-last-child(3)~h2{text-align:center;}
        header>h2:nth-last-child(3)+h2{margin-top:-10px;}
        header>h2:nth-of-type(1){margin-top:-10px;}
        table{border-collapse: collapse;border-spacing: 0;width: 100%;}     
        footer>*{float:left; text-align:center;font-weight:normal;}
        footer>div:nth-child(1){width:40%;}
        footer>div:nth-child(2){width:17%;padding-top:1px}
        footer>div:nth-child(3){width:40%;}
        table { width: 1030px; }
        @page{margin: .7cm .5cm;size:landscape;}
        @media print{body{width:1400px!important;display:initial;}footer{break-inside: avoid!important;}}
    </style>
</head>

<body class="lang-{{ config('app.locale') }}">
    <div class="wrapper" id="root">    
        @if($pro_code > 0)
            <table>
                <tr>
                    <td colspan="15" style="border-left: none!important; border-top: none!important; border-right: none!important;">
                        <header>
                            <h1>ព្រះរាជាណាចក្រកម្ពុជា</h1>
                            <h1>ជាតិ សាសនា ព្រះមហាក្សត្រ</h1>
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
                            <h2>បញ្ជីរាយនាមមន្រ្តីរាជការស្នើសុំដំឡើងថ្នាក់ ឋានន្តរស័ក្ដិ</h2>
                            <h2>តាមសញ្ញាបត្រខ្ពស់ជាងក្របខណ្ឌសម្រាប់ឆ្នាំ{{$y}}</h2>
                        </header>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" ><strong>ល.រ</strong></td>
                    <td rowspan="2" ><strong>អត្តលេខ</strong></td>
                    <td rowspan="2"><strong>គោត្តនាមនិងនាម</strong></td>
                    <td rowspan="2" ><strong>ភេទ</strong></td>
                    <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំកំណើត</strong></td>
                    <td rowspan="2" ><strong>តួនាទី/<br/>មុខតំណែង</strong></td>
                    <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ចូលបម្រើ<br/>ការងារ</strong></td>
                    <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ដំឡើងថ្នាក់<br/>ចុងក្រោយ</strong></td>
                    <td rowspan="2" ><strong>ព្រះរាជក្រឹត្យ<br/>អនុក្រឹត្យ<br/>ប្រកាសលេខ</strong></td>
                    <td rowspan="2" ><strong>លេខរៀង</strong></td>
                    <td colspan="2" ><strong>ដំឡើងថ្នាក់<br/>និងឋានន្តរស័ក្តិ</strong></td>
                    <td rowspan="2" ><strong>សញ្ញាបត្រ</strong></td>
                    <td rowspan="2" ><strong>អង្គភាព</strong></td>
                    <td rowspan="2 style="text-align: center;><strong>ផ្សេងៗ</strong></td>
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
                                <td>{{ isset($brokah_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td></th>
                                <td>{{ isset($brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                <td nowrap>{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                <td >{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                <td>
                                    @if($brokah_domleungtnak->lastCardre->cardre_type_id == 1 && $brokah_domleungtnak->lastCardre->request_cardre_check_status == 1)               
                                        {{ (!empty($brokah_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($brokah_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($brokah_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                        {{ (!empty($brokah_domleungtnak->lastCardreSalary->salaryLevel) && !empty($brokah_domleungtnak->lastCardreSalary->salary_degree)) ? ($brokah_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                                    @endif
                                </td>
                                <td>{{ (!empty($brokah_domleungtnak->requestCardreCertificate->salaryLevel) || !empty($brokah_domleungtnak->requestCardreCertificate->salary_degree)) ? ($brokah_domleungtnak->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreCertificate->salary_degree) : '' }}</td>
                                <td>{{ (!empty($brokah_domleungtnak->highestQualification->qualificationCode->qualification_kh)) ? ($brokah_domleungtnak->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
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
                                <td>{{ isset($brokah_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->start_date)->format('d/m/Y')) : '' }}</td></th>
                                <td>{{ isset($brokah_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                <td nowrap>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                <td>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                <td>
                                    @if($brokah_thanorn->lastCardre->cardre_type_id == 1 && $brokah_thanorn->lastCardre->request_cardre_check_status == 1)               
                                        {{ (!empty($brokah_thanorn->requestCardreOffeset1->salaryLevel) && !empty($brokah_thanorn->requestCardreOffeset1->salary_degree)) ? ($brokah_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                        {{ (!empty($brokah_thanorn->lastCardreSalary->salaryLevel) && !empty($brokah_thanorn->lastCardreSalary->salary_degree)) ? ($brokah_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->lastCardreSalary->salary_degree) : '' }}
                                    @endif
                                </td>
                                <td>{{ (!empty($brokah_thanorn->requestCardreCertificate->salaryLevel) || !empty($brokah_thanorn->requestCardreCertificate->salary_degree)) ? ($brokah_thanorn->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreCertificate->salary_degree) : '' }}</td>
                                <th>{{ (!empty($brokah_thanorn->highestQualification->qualificationCode->qualification_kh)) ? ($brokah_thanorn->highestQualification->qualificationCode->qualification_kh) : '' }}</th>
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
                                <td>{{ isset($ahnukret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td></th>
                                <td>{{ isset($ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                <td nowrap>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                <td>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                <td>
                                    @if($ahnukret_domleungtnak->lastCardre->cardre_type_id == 1 && $ahnukret_domleungtnak->lastCardre->request_cardre_check_status == 1)               
                                        {{ (!empty($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                        {{ (!empty($ahnukret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($ahnukret_domleungtnak->lastCardreSalary->salary_degree)) ? ($ahnukret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                                    @endif
                                </td>
                                <td>{{ (!empty($ahnukret_domleungtnak->requestCardreCertificate->salaryLevel) || !empty($ahnukret_domleungtnak->requestCardreCertificate->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreCertificate->salary_degree) : '' }}</td>
                                <td>{{ (!empty($ahnukret_domleungtnak->highestQualification->qualificationCode->qualification_kh)) ? ($ahnukret_domleungtnak->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
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
                                <td >{{ $i2}}</td>
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
                                <td>{{ isset($ahnukret_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->start_date)->format('d/m/Y')) : '' }}</td></th>
                                <td>{{ isset($ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                <td nowrap>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                <td>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                <td>
                                    @if($ahnukret_thanorn->lastCardre->cardre_type_id == 1 && $ahnukret_thanorn->lastCardre->request_cardre_check_status == 1)               
                                        {{ (!empty($ahnukret_thanorn->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_thanorn->requestCardreOffeset1->salary_degree)) ? ($ahnukret_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                        {{ (!empty($ahnukret_thanorn->lastCardreSalary->salaryLevel) && !empty($ahnukret_thanorn->lastCardreSalary->salary_degree)) ? ($ahnukret_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->lastCardreSalary->salary_degree) : '' }}
                                    @endif
                                </td>
                                <td>{{ (!empty($ahnukret_thanorn->requestCardreCertificate->salaryLevel) || !empty($ahnukret_thanorn->requestCardreCertificate->salary_degree)) ? ($ahnukret_thanorn->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreCertificate->salary_degree) : '' }}</td>
                                <td>{{ (!empty($ahnukret_thanorn->highestQualification->qualificationCode->qualification_kh)) ? ($ahnukret_thanorn->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
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
                                <td >{{ $i3 }}</td>
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
                                <td>{{ isset($reachkret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td></th>
                                <td>{{ isset($reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                <td nowrap>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                <td>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                <td>
                                    @if($reachkret_domleungtnak->lastCardre->cardre_type_id == 1 && $reachkret_domleungtnak->lastCardre->request_cardre_check_status == 1)               
                                        {{ (!empty($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($reachkret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                        {{ (!empty($reachkret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($reachkret_domleungtnak->lastCardreSalary->salary_degree)) ? ($reachkret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                                    @endif
                                </td>
                                <td>{{ (!empty($reachkret_domleungtnak->requestCardreCertificate->salaryLevel) || !empty($reachkret_domleungtnak->requestCardreCertificate->salary_degree)) ? ($reachkret_domleungtnak->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreCertificate->salary_degree) : '' }}</td>
                                <td>{{ (!empty($reachkret_domleungtnak->highestQualification->qualificationCode->qualification_kh)) ? ($reachkret_domleungtnak->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
                                <td>{{ !empty($reachkret_domleungtnak->currentWorkPlace()) ? 
                                                str_replace(' ', '', $reachkret_domleungtnak->currentWorkPlace()->location_kh) : 
                                                (!empty($reachkret_domleungtnak->latestWorkPlace()) ? str_replace(' ', '', $reachkret_domleungtnak->latestWorkPlace()->location_kh) : '') }}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                <tr><td colspan="15" style="text-align: left;"><h3>៣-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
                    @if(count($reachkret_thanorns) > 0)
                        @foreach($reachkret_thanorns as $index => $reachkret_thanorns)
                            <?php  $i3 = $i3 + 1; ?>
                            <tr>
                                <td >{{ $i3 }}</td>
                                <td>{{ $reachkret_thanorns->payroll_id }}</td>
                                <td style="text-align: left;" nowrap>{{ $reachkret_thanorns->surname_kh.' '.$reachkret_thanorns->name_kh }}</td>
                                <td>{{ $reachkret_thanorns->sex == 1 ? 'ប' : 'ស' }}</td>
                                <td>{{ date('d/m/Y', strtotime($reachkret_thanorns->dob)) }}</td>
                                <td>
                                    @if(!empty($reachkret_thanorns->currentPosition())) 
                                        @if(str_contains($reachkret_thanorns->currentPosition()->position_kh, 'គ្រូ')) 
                                            បង្រៀន
                                        @elseif(str_contains($reachkret_thanorns->currentPosition()->position_kh, 'មន្ត្រី')) 
                                            មន្ត្រី
                                        @else
                                            {{$reachkret_thanorns->currentPosition()->position_kh}}
                                            @endif
                                    @endif                                  
                                </td>
                                <td>{{ isset($reachkret_thanorns->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorns->start_date)->format('d/m/Y')) : '' }}</td></th>
                                <td>{{ isset($reachkret_thanorns->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorns->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                <td nowrap>{{ !empty($reachkret_thanorns->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_thanorns->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                <td>{{ !empty($reachkret_thanorns->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_thanorns->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                <td>
                                    @if($reachkret_thanorns->lastCardre->cardre_type_id == 1 && $reachkret_thanorns->lastCardre->request_cardre_check_status == 1)               
                                        {{ (!empty($reachkret_thanorns->requestCardreOffeset1->salaryLevel) && !empty($reachkret_thanorns->requestCardreOffeset1->salary_degree)) ? ($reachkret_thanorns->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_thanorns->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                        {{ (!empty($reachkret_thanorns->lastCardreSalary->salaryLevel) && !empty($reachkret_thanorns->lastCardreSalary->salary_degree)) ? ($reachkret_thanorns->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_thanorns->lastCardreSalary->salary_degree) : '' }}
                                    @endif
                                </td>
                                <td>{{ (!empty($reachkret_thanorns->requestCardreCertificate->salaryLevel) || !empty($reachkret_thanorns->requestCardreCertificate->salary_degree)) ? ($reachkret_thanorns->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $reachkret_thanorns->requestCardreCertificate->salary_degree) : '' }}</td>
                                <td>{{ (!empty($reachkret_thanorns->highestQualification->qualificationCode->qualification_kh)) ? ($reachkret_thanorns->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
                                <td> {{ !empty($reachkret_thanorns->currentWorkPlace()) ? 
                                                str_replace(' ', '', $reachkret_thanorns->currentWorkPlace()->location_kh) : 
                                                (!empty($reachkret_thanorns->latestWorkPlace()) ? str_replace(' ', '', $reachkret_thanorns->latestWorkPlace()->location_kh) : '') }}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="15" style="border: none!important;">
                        <footer> 
                            <div>
                                <span style="margin-left: -130px;">បញ្ឍប់បញ្ជីត្រឹមចំនួន {{$staffs_count}}នាក់ ក្នុងនោះស្រីចំនួន {{$staffs_f_count}}នាក់។</span>
                                <br>
                                <br>បានឃើញ និងឯកភាព
                                <br>  ថ្ងៃ...........................ខែ...................ឆ្នាំ..............ព.ស.២៥.......
                                <br>{{auth()->user()->staff->currentWorkPlace()->province->name_kh}} ថ្ងៃទី........ ខែ............... ឆ្នាំ២០.......</?>
                                <br>ប្រធានអង្គភាព/គ្រឹះស្ថានសិក្សា
                            </div>                        
                            <div></div>
                            <div>
                                <br>ថ្ងៃ...........................ខែ...................ឆ្នាំ..............ព.ស.២៥.......
                                <br>{{auth()->user()->staff->currentWorkPlace()->province->name_kh}} ថ្ងៃទី........ ខែ............... ឆ្នាំ២០.......
                                <br>អ្នកធ្វើតារាង
                            </div>
                        </footer>
                        </td>
                    </tr>
            </table>
        @elseif($pro_code == 0 )
            <table>
                <tr>
                    <td colspan="15" style="border-left: none!important; border-top: none!important; border-right: none!important;">
                        <header>
                            <h1>ព្រះរាជាណាចក្រកម្ពុជា</h1>
                            <h1>ជាតិ សាសនា ព្រះមហាក្សត្រ</h1>
                            <h2>ក្រសួងអប់រំយុវជន និងកីឡា</h2>
                            <h2 style="margin-top: 0px;">បញ្ជីរាយនាមមន្រ្តីរាជការស្នើសុំដំឡើងថ្នាក់ ឋានន្តរស័ក្ដិ</h2>
                            <h2>តាមសញ្ញាបត្រខ្ពស់ជាងក្របខណ្ឌសម្រាប់ឆ្នាំ{{$y}}</h2>
                        </header>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" ><strong>ល.រ</strong></td>
                    <td rowspan="2" ><strong>អត្តលេខ</strong></td>
                    <td rowspan="2"><strong>គោត្តនាមនិងនាម</strong></td>
                    <td rowspan="2" ><strong>ភេទ</strong></td>
                    <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំកំណើត</strong></td>
                    <td rowspan="2" ><strong>តួនាទី/<br/>មុខតំណែង</strong></td>
                    <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ចូលបម្រើ<br/>ការងារ</strong></td>
                    <td rowspan="2" ><strong>ថ្ងៃខែឆ្នាំ<br/>ដំឡើងថ្នាក់<br/>ចុងក្រោយ</strong></td>
                    <td rowspan="2" ><strong>ព្រះរាជក្រឹត្យ<br/>អនុក្រឹត្យ<br/>ប្រកាសលេខ</strong></td>
                    <td rowspan="2" ><strong>លេខរៀង</strong></td>
                    <td colspan="2" ><strong>ដំឡើងថ្នាក់<br/>និងឋានន្តរស័ក្តិ</strong></td>
                    <td rowspan="2" ><strong>សញ្ញាបត្រ</strong></td>
                    <td rowspan="2" ><strong>អង្គភាព</strong></td>
                    <td rowspan="2" ><strong>ខេត្ត</strong></td>
                    <td rowspan="2 style="text-align: center;><strong>ផ្សេងៗ</strong></td>
                </tr>
                <tr><td><strong>បច្ចុប្បន្ន</strong></td><td><strong>ស្នើសុំ</strong></td></tr>

                    <tr><td colspan="16" style="text-align: left;"><h3>១- ប្រកាស</h3></td></tr>
                    <tr><td colspan="16" style="text-align: left;"><h3>១-១ ដំឡើងថ្នាក់ </h3></td></tr>
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
                                    <td>{{ isset($brokah_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td></th>
                                    <td>{{ isset($brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                    <td nowrap>{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                    <td >{{ !empty($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($brokah_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                    <td>
                                        @if($brokah_domleungtnak->lastCardre->cardre_type_id == 1 && $brokah_domleungtnak->lastCardre->request_cardre_check_status == 1)               
                                            {{ (!empty($brokah_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($brokah_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($brokah_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                                            @else
                                            {{ (!empty($brokah_domleungtnak->lastCardreSalary->salaryLevel) && !empty($brokah_domleungtnak->lastCardreSalary->salary_degree)) ? ($brokah_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                                        @endif
                                    </td>
                                    <td>{{ (!empty($brokah_domleungtnak->requestCardreCertificate->salaryLevel) || !empty($brokah_domleungtnak->requestCardreCertificate->salary_degree)) ? ($brokah_domleungtnak->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $brokah_domleungtnak->requestCardreCertificate->salary_degree) : '' }}</td>
                                    <td>{{ (!empty($brokah_domleungtnak->highestQualification->qualificationCode->qualification_kh)) ? ($brokah_domleungtnak->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
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
                    <tr><td colspan="16" style="text-align: left;"><h3>១-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
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
                                    <td>{{ isset($brokah_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->start_date)->format('d/m/Y')) : '' }}</td></th>
                                    <td>{{ isset($brokah_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $brokah_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                    <td nowrap>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                    <td>{{ !empty($brokah_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($brokah_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                    <td>
                                        @if($brokah_thanorn->lastCardre->cardre_type_id == 1 && $brokah_thanorn->lastCardre->request_cardre_check_status == 1)               
                                            {{ (!empty($brokah_thanorn->requestCardreOffeset1->salaryLevel) && !empty($brokah_thanorn->requestCardreOffeset1->salary_degree)) ? ($brokah_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                                            @else
                                            {{ (!empty($brokah_thanorn->lastCardreSalary->salaryLevel) && !empty($brokah_thanorn->lastCardreSalary->salary_degree)) ? ($brokah_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->lastCardreSalary->salary_degree) : '' }}
                                        @endif
                                    </td>
                                    <td>{{ (!empty($brokah_thanorn->requestCardreCertificate->salaryLevel) || !empty($brokah_thanorn->requestCardreCertificate->salary_degree)) ? ($brokah_thanorn->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $brokah_thanorn->requestCardreCertificate->salary_degree) : '' }}</td>
                                    <th>{{ (!empty($brokah_thanorn->highestQualification->qualificationCode->qualification_kh)) ? ($brokah_thanorn->highestQualification->qualificationCode->qualification_kh) : '' }}</th>
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
                    <tr><td colspan="16" style="text-align: left;"><h3>២- អនុក្រឹត្យ</h3></td></tr>                    
                    <tr><td colspan="16" style="text-align: left;"><h3>២-១ ដំឡើងថ្នាក់ </h3></td></tr>
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
                                    <td>{{ isset($ahnukret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td></th>
                                    <td>{{ isset($ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                    <td nowrap>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                    <td>{{ !empty($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                    <td>
                                        @if($ahnukret_domleungtnak->lastCardre->cardre_type_id == 1 && $ahnukret_domleungtnak->lastCardre->request_cardre_check_status == 1)               
                                            {{ (!empty($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                                            @else
                                            {{ (!empty($ahnukret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($ahnukret_domleungtnak->lastCardreSalary->salary_degree)) ? ($ahnukret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                                        @endif
                                    </td>
                                    <td>{{ (!empty($ahnukret_domleungtnak->requestCardreCertificate->salaryLevel) || !empty($ahnukret_domleungtnak->requestCardreCertificate->salary_degree)) ? ($ahnukret_domleungtnak->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $ahnukret_domleungtnak->requestCardreCertificate->salary_degree) : '' }}</td>
                                    <td>{{ (!empty($ahnukret_domleungtnak->highestQualification->qualificationCode->qualification_kh)) ? ($ahnukret_domleungtnak->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
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
                    <tr><td colspan="16" style="text-align: left;"><h3>២-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
                        @if(count($ahnukret_thanorns) > 0)
                            @foreach($ahnukret_thanorns as $index => $ahnukret_thanorn)
                                <?php  $i2 = $i2 + 1; ?>
                                <tr>
                                    <td >{{ $i2}}</td>
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
                                    <td>{{ isset($ahnukret_thanorn->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->start_date)->format('d/m/Y')) : '' }}</td></th>
                                    <td>{{ isset($ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $ahnukret_thanorn->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                    <td nowrap>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                    <td>{{ !empty($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order) ? (($ahnukret_thanorn->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                    <td>
                                        @if($ahnukret_thanorn->lastCardre->cardre_type_id == 1 && $ahnukret_thanorn->lastCardre->request_cardre_check_status == 1)               
                                            {{ (!empty($ahnukret_thanorn->requestCardreOffeset1->salaryLevel) && !empty($ahnukret_thanorn->requestCardreOffeset1->salary_degree)) ? ($ahnukret_thanorn->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreOffeset1->salary_degree) : '' }}
                                            @else
                                            {{ (!empty($ahnukret_thanorn->lastCardreSalary->salaryLevel) && !empty($ahnukret_thanorn->lastCardreSalary->salary_degree)) ? ($ahnukret_thanorn->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->lastCardreSalary->salary_degree) : '' }}
                                        @endif
                                    </td>
                                    <td>{{ (!empty($ahnukret_thanorn->requestCardreCertificate->salaryLevel) || !empty($ahnukret_thanorn->requestCardreCertificate->salary_degree)) ? ($ahnukret_thanorn->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $ahnukret_thanorn->requestCardreCertificate->salary_degree) : '' }}</td>
                                    <td>{{ (!empty($ahnukret_thanorn->highestQualification->qualificationCode->qualification_kh)) ? ($ahnukret_thanorn->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
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
                    <tr><td colspan="16" style="text-align: left;"><h3>៣- ព្រះរាជក្រឹត្យ</h3></td></tr>
                    <tr><td colspan="16" style="text-align: left;"><h3>៣-១ ដំឡើងថ្នាក់ </h3></td></tr>
                        @if(count($reachkret_domleungtnaks) > 0)
                            @foreach($reachkret_domleungtnaks as $index => $reachkret_domleungtnak)
                                <?php  $i3 = $i3 + 1; ?>
                                <tr>
                                    <td >{{ $index + 1}}</td>
                                    <td>{{ $i3 }}</td>
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
                                    <td>{{ isset($reachkret_domleungtnak->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->start_date)->format('d/m/Y')) : '' }}</td></th>
                                    <td>{{ isset($reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_domleungtnak->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                    <td nowrap>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                    <td>{{ !empty($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_domleungtnak->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                    <td>
                                        @if($reachkret_domleungtnak->lastCardre->cardre_type_id == 1 && $reachkret_domleungtnak->lastCardre->request_cardre_check_status == 1)               
                                            {{ (!empty($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel) && !empty($reachkret_domleungtnak->requestCardreOffeset1->salary_degree)) ? ($reachkret_domleungtnak->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreOffeset1->salary_degree) : '' }}
                                            @else
                                            {{ (!empty($reachkret_domleungtnak->lastCardreSalary->salaryLevel) && !empty($reachkret_domleungtnak->lastCardreSalary->salary_degree)) ? ($reachkret_domleungtnak->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->lastCardreSalary->salary_degree) : '' }}
                                        @endif
                                    </td>
                                    <td>{{ (!empty($reachkret_domleungtnak->requestCardreCertificate->salaryLevel) || !empty($reachkret_domleungtnak->requestCardreCertificate->salary_degree)) ? ($reachkret_domleungtnak->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $reachkret_domleungtnak->requestCardreCertificate->salary_degree) : '' }}</td>
                                    <td>{{ (!empty($reachkret_domleungtnak->highestQualification->qualificationCode->qualification_kh)) ? ($reachkret_domleungtnak->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
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
                    <tr><td colspan="16" style="text-align: left;"><h3>៣-២ ឋានន្តរស័ក្ដិ  </h3></td></tr>
                    @if(count($reachkret_thanorns) > 0)
                        @foreach($reachkret_thanorns as $index => $reachkret_thanorns)                           
                            <?php  $i3 = $i3 + 1; ?>
                            <tr>
                                <td >{{ $i3 }}</td>
                                <td>{{ $reachkret_thanorns->payroll_id }}</td>
                                <td style="text-align: left;" nowrap>{{ $reachkret_thanorns->surname_kh.' '.$reachkret_thanorns->name_kh }}</td>
                                <td>{{ $reachkret_thanorns->sex == 1 ? 'ប' : 'ស' }}</td>
                                <td>{{ date('d/m/Y', strtotime($reachkret_thanorns->dob)) }}</td>
                                <td>
                                    @if(!empty($reachkret_thanorns->currentPosition())) 
                                        @if(str_contains($reachkret_thanorns->currentPosition()->position_kh, 'គ្រូ')) 
                                            បង្រៀន
                                        @elseif(str_contains($reachkret_thanorns->currentPosition()->position_kh, 'មន្ត្រី')) 
                                            មន្ត្រី
                                        @else
                                            {{$reachkret_thanorns->currentPosition()->position_kh}}
                                            @endif
                                    @endif                                  
                                </td>
                                <td>{{ isset($reachkret_thanorns->start_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorns->start_date)->format('d/m/Y')) : '' }}</td></th>
                                <td>{{ isset($reachkret_thanorns->lastCardreCercleDate->salary_type_shift_date) ? (\Carbon\Carbon::createFromFormat('Y-m-d', $reachkret_thanorns->lastCardreCercleDate->salary_type_shift_date)->format('d/m/Y')) : '' }}</td>
                                <td nowrap>{{ !empty($reachkret_thanorns->lastCardreSalary->salary_type_prokah_num) ? (($reachkret_thanorns->lastCardreSalary->salary_type_prokah_num)) : '' }}</td>
                                <td>{{ !empty($reachkret_thanorns->lastCardreSalary->salary_type_prokah_order) ? (($reachkret_thanorns->lastCardreSalary->salary_type_prokah_order)) : '' }}</td>
                                <td>
                                    @if($reachkret_thanorns->lastCardre->cardre_type_id == 1 && $reachkret_thanorns->lastCardre->request_cardre_check_status == 1)               
                                        {{ (!empty($reachkret_thanorns->requestCardreOffeset1->salaryLevel) && !empty($reachkret_thanorns->requestCardreOffeset1->salary_degree)) ? ($reachkret_thanorns->requestCardreOffeset1->salaryLevel->salary_level_kh .'.'. $reachkret_thanorns->requestCardreOffeset1->salary_degree) : '' }}
                                        @else
                                        {{ (!empty($reachkret_thanorns->lastCardreSalary->salaryLevel) && !empty($reachkret_thanorns->lastCardreSalary->salary_degree)) ? ($reachkret_thanorns->lastCardreSalary->salaryLevel->salary_level_kh .'.'. $reachkret_thanorns->lastCardreSalary->salary_degree) : '' }}
                                    @endif
                                </td>
                                <td>{{ (!empty($reachkret_thanorns->requestCardreCertificate->salaryLevel) || !empty($reachkret_thanorns->requestCardreCertificate->salary_degree)) ? ($reachkret_thanorns->requestCardreCertificate->salaryLevel->salary_level_kh .'.'. $reachkret_thanorns->requestCardreCertificate->salary_degree) : '' }}</td>
                                <td>{{ (!empty($reachkret_thanorns->highestQualification->qualificationCode->qualification_kh)) ? ($reachkret_thanorns->highestQualification->qualificationCode->qualification_kh) : '' }}</td>
                                <td> {{ !empty($reachkret_thanorns->currentWorkPlace()) ? 
                                                str_replace(' ', '', $reachkret_thanorns->currentWorkPlace()->location_kh) : 
                                                (!empty($reachkret_thanorns->latestWorkPlace()) ? str_replace(' ', '', $reachkret_thanorns->latestWorkPlace()->location_kh) : '') }}
                                </td>
                                <td> {{ !empty($reachkret_thanorns->currentWorkPlace()) ? 
                                    str_replace(' ', '', $reachkret_thanorns->currentWorkPlace()->province->name_kh) : 
                                    (!empty($reachkret_thanorns->latestWorkPlace()) ? str_replace(' ', '', $reachkret_thanorns->latestWorkPlace()->currentWorkPlace()->province->name_kh) : '') }}
                                </td>
                                <td></td>
                            </tr>                            
                        @endforeach
                    @endif
                
                
                <tr>
                    <td colspan="16" style="border: none!important;">
                    <footer> 
                        <div>
                            <span style="margin-left: -130px;">បញ្ឍប់បញ្ជីត្រឹមចំនួន {{$staffs_count}}នាក់ ក្នុងនោះស្រីចំនួន {{$staffs_f_count}}នាក់។</span>
                            <br>
                            <br>បានឃើញ និងឯកភាព
                            <br>  ថ្ងៃ...........................ខែ...................ឆ្នាំ..............ព.ស.២៥.......
                            <br>{{auth()->user()->staff->currentWorkPlace()->province->name_kh}} ថ្ងៃទី........ ខែ............... ឆ្នាំ២០.......</?>
                            <br>ប្រធានអង្គភាព/គ្រឹះស្ថានសិក្សា
                        </div>                        
                        <div></div>
                        <div>
                            <br>ថ្ងៃ...........................ខែ...................ឆ្នាំ..............ព.ស.២៥.......
                            <br>{{auth()->user()->staff->currentWorkPlace()->province->name_kh}} ថ្ងៃទី........ ខែ............... ឆ្នាំ២០.......
                            <br>អ្នកធ្វើតារាង
                        </div>
                    </footer>
                    </td>
                </tr>
            </table>
        @endif
    </div>
    
</body>

</html>
