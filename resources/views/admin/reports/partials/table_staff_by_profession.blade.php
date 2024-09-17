<table class="table table-bordered table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('common.payroll_num') }}</th>
            <th>{{ __('common.name') }}</th>
            <th>{{ __('common.fullname_en') }}</th>
            <th>{{ __('common.sex') }}</th>
            <th>{{ __('common.dob') }}</th>
            <th>{{ __('common.salary_rank') }}</th>
            <th>{{ __('common.position') }}</th>
            <th>{{ __('qualification.prof_skill_desc') }}</th>
            <th>{{ __('qualification.first_subject') }}</th>
            <th>{{ __('qualification.second_subject') }}</th>
            <th>{{ __('common.qualification') }}</th>
            <th>{{ __('common.start_date') }}</th>
            <th>{{ __('common.current_status') }}</th>
            <th class="text-center">{{ __('common.teaching') }}</th>
        </tr>
    </thead>

    @php
        $g_workplace = '';$g_office = '';$row_num = 1; $total_records = count($staffs);
        $total_staff = 0; $female_staff = 0; $teachings = 0; $non_teachings = 0;
        $leave_no_pay = 0; $con_leave_no_pay = 0; $off_duty = 0;$con_study = 0;
        $is_teaching_icon = '<i class="fas fa-check-square success"></i>';
        $no_teaching_icon = '';
        $colspan = 15;
    @endphp

    <tbody>
        @for ($i=0; $i < $total_records; $i++) 
            @if($i > 0 && $staffs[$i]->location_code != $staffs[$i-1]->location_code)
                <tr>
                    <td colspan="{{ $colspan }}">
                        @include('admin.reports.partials.data_header')
                    </td>
                </tr>
                @php
                    $total_staff = 1; 
                    $female_staff = $staffs[$i]->sex != 1 ? 1 : 0; 
                    $teachings = !empty($staffs[$i]->grade_id) ? 1 : 0; 
                    $non_teachings = empty($staffs[$i]->grade_id) ? 1: 0;
                    $leave_no_pay = $staffs[$i]->status_id == 2 ? 1 : 0; 
                    $con_leave_no_pay = $staffs[$i]->status_id == 7 ? 1 : 0; 
                    $off_duty = $staffs[$i]->status_id == 8 ? 1 : 0;
                    $con_study = $staffs[$i]->status_id == 10 ? 1: 0;
                @endphp
            @else
                @php $total_staff ++; @endphp
                @if($staffs[$i]->sex != 1)
                    @php $female_staff += 1; @endphp
                @endif

                @if(!empty($staffs[$i]->grade_id))
                    @php $teachings += 1;@endphp
                @else
                    @php $non_teachings += 1;@endphp
                @endif
                
                @if($staffs[$i]->status_id == 2)
                    @php $leave_no_pay += 1;@endphp
                @elseif($staffs[$i]->status_id == 7)
                    @php $con_leave_no_pay += 1;@endphp
                @elseif($staffs[$i]->status_id == 8)
                    @php $off_duty += 1;@endphp
                @elseif($staffs[$i]->status_id == 10)
                    @php $con_study += 1;@endphp
                @endif
            @endif

            @if ($g_workplace !=$staffs[$i]->workplace_kh)
                <tr style="background-color: #cdcdcd">
                    <td class="kh" colspan="{{ $colspan }}">
                        <!-- Data Workplace -->
                        @include('admin.reports.partials.data_workplace')
                    </td>
                </tr>
                <tr>
                    <td> {{ $row_num++ }}</td>
                    <!-- Data Body -->
                    @include('admin.reports.partials.data_body_profession')
                </tr>
            @elseif ($g_workplace == $staffs[$i]->workplace_kh && $g_office != $staffs[$i]->office_kh)
                <tr>
                    <td class="kh" colspan="{{ $colspan }}">
                        <p style="margin-top:10px;margin-bottom:0px;">
                            {{ __('ការិយាល័យ៖ ') }} <span
                                style="font-family: 'Moul', 'Arial';margin-right:20px;">{{ $staffs[$i]->office_kh }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td> {{ $row_num++ }}</td>
                    <!-- Data Body -->
                    @include('admin.reports.partials.data_body_profession')
                </tr>
            @else
                <tr>
                    <td> {{ $row_num++ }}</td>
                    <!-- Data Body -->
                    @include('admin.reports.partials.data_body_profession')
                </tr>
            @endif

            @if($i == $total_records - 1)
                <tr>
                    <td colspan="{{ $colspan }}">
                        @include('admin.reports.partials.data_header')
                    </td>
                </tr>
                @php
                    $total_staff = 0; $female_staff = 0; $teachings = 0; $non_teachings = 0;
                    $leave_no_pay = 0; $con_leave_no_pay = 0; $off_duty = 0;$con_study = 0;
                @endphp

            @endif


            @php
            $g_workplace = $staffs[$i]->workplace_kh;
            $g_office = $staffs[$i]->office_kh;
            @endphp
            @endfor
    </tbody>
</table>
