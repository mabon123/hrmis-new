<h1 class="text-center">{{ __('report.staff_by_age') }}</h1>

<table class="table table-bordered table-head-fixed text-nowrap">
    <thead>
        <tr>
            <!-- Data Header -->
            @include('admin.reports.partials.data_header_age')
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
                        @include('admin.reports.partials.data_body_age')
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
                        @include('admin.reports.partials.data_body_age')
                    </tr>
                @else
                    <tr>
                        <td> {{ $row_num++ }}</td>
                        <!-- Data Body -->
                        @include('admin.reports.partials.data_body_age')
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
