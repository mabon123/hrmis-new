<h1>{{ __('report.staff_by_positions') }}</h1>
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
            <th class="text-center">{{ __('common.teaching') }}</th>
        </tr>
    </thead>

    @php
        $g_workplace = '';$g_office = '';$row_num = 1; $total_records = count($staffs);
        $is_teaching_icon = 'Yes';
        $no_teaching_icon = 'No';
    @endphp

    <tbody>
        @for ($i=0; $i < $total_records; $i++) 
            @if($i == $total_records - 1)
                <tr>
                    <td colspan="9">
                        <!-- Data Summary -->
                        @include('admin.reports.partials.data_summary_pos')
                    </td>
                </tr>
            @else
                @if ($g_workplace !=$staffs[$i]->workplace_kh)
                    <tr style="background-color: #cdcdcd">
                        <td class="kh" colspan="9">
                            <!-- Data Workplace -->
                            @include('admin.reports.partials.data_workplace')
                        </td>
                    </tr>
                    <tr>
                        <td> {{ $row_num++ }}</td>
                        <!-- Data Body -->
                        @include('admin.reports.partials.data_body_position')
                    </tr>
                @elseif ($g_workplace == $staffs[$i]->workplace_kh && $g_office != $staffs[$i]->office_kh)
                    <tr>
                        <td class="kh" colspan="9">
                            <p style="margin-top:10px;margin-bottom:0px;">
                                {{ __('ការិយាល័យ៖ ') }} <span
                                    style="font-family: 'Moul', 'Arial';margin-right:20px;">{{ $staffs[$i]->office_kh }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td> {{ $row_num++ }}</td>
                        <!-- Data Body -->
                        @include('admin.reports.partials.data_body_position')
                    </tr>
                @else
                    <tr>
                        <td> {{ $row_num++ }}</td>
                        <!-- Data Body -->
                        @include('admin.reports.partials.data_body_position')
                    </tr>
                @endif

            @endif


            @php
            $g_workplace = $staffs[$i]->workplace_kh;
            $g_office = $staffs[$i]->office_kh;
            @endphp
            @endfor
    </tbody>
</table>
