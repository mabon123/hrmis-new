<td>{{ $staffs[$i]->payroll_id }}</td>
<td class="kh">{{ $staffs[$i]->fullname_kh }}</td>
<td>{{ $staffs[$i]->fullname_en }}</td>
<td class="kh">{{ $staffs[$i]->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
<td>{{ date('d-m-Y', strtotime($staffs[$i]->dob)) }}</td>
<td class="kh">{{ $staffs[$i]->salary_level }}</td>
<td class="kh">{{ $staffs[$i]->position_kh }}</td>
<td class="kh">{{ $staffs[$i]->qualification_kh }}</td>
<td>{{ date('d-m-Y', strtotime($staffs[$i]->start_date)) }}</td>
<td class="kh">{{ $staffs[$i]->status_kh }}</td>
<td class="kh text-center">
    @if (!empty($staffs[$i]->grade_id))
        {!! $is_teaching_icon !!}
    @endif
</td>
