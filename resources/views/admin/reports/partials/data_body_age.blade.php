<td>{{ $staffs[$i]->payroll_id }}</td>
<td class="kh">{{ $staffs[$i]->fullname_kh }}</td>
<td>{{ $staffs[$i]->fullname_en }}</td>
<td class="kh">{{ $staffs[$i]->age }}</td>
<td class="kh">{{ $staffs[$i]->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
<td>{{ date('d-m-Y', strtotime($staffs[$i]->dob)) }}</td>
<td class="kh">{{ $staffs[$i]->position_kh }}</td>
<td class="kh text-center">
    @if (!empty($staffs[$i]->grade_id))
        {!! $is_teaching_icon !!}
    @else
        {!! $no_teaching_icon !!}
    @endif
</td>
