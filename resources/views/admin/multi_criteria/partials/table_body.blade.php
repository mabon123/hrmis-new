@foreach ($reportHeaders as $reportHeader)

    @if ($reportHeader->field_name == 'sex')
        <td class="kh">{{ $staff[$reportHeader->field_name] == '1' ? 'ប្រុស' : 'ស្រី' }}</td>

    @elseif ($reportHeader->field_name == 'status_kh')
        <td class="kh">{{ $staff->status_kh }}</td>

    @elseif ($reportHeader->field_name == 'surname_kh')
        <td class="kh">{{ $staff->last_name_kh }}</td>

    @elseif ($reportHeader->field_name == 'name_kh')
        <td class="kh">{{ $staff->first_name_kh }}</td>

    @elseif ($reportHeader->field_name == 'surname_en')
        <td class="kh">{{ $staff->last_name_en }}</td>

    @elseif ($reportHeader->field_name == 'name_en')
        <td class="kh">{{ $staff->first_name_en }}</td>

    @elseif ($reportHeader->field_name == 'ethnic_kh')
        <td class="kh">{{ $staff->ethnic_kh }}</td>

    @elseif ($reportHeader->field_name == 'birth_pro_code')
        <td class="kh">{{ $staff->birth_province }}</td>
        
    @elseif ($reportHeader->field_name == 'dob')
        <td class="kh">{{ $staff->dob > 0 ? date('d-m-Y', strtotime($staff->dob)) : '---' }}</td>

    @elseif ($reportHeader->field_name == 'maritalstatus_id')
        <td class="kh">{{ $staff->maritalstatus_kh }}</td>

    @elseif ($reportHeader->field_name == 'adr_vil_code')
        <td class="kh">{{ $staff->adr_village }}</td>

    @elseif ($reportHeader->field_name == 'adr_com_code')
        <td class="kh">{{ $staff->adr_commune }}</td>

    @elseif ($reportHeader->field_name == 'adr_dis_code')
        <td class="kh">{{ $staff->adr_district }}</td>

    @elseif ($reportHeader->field_name == 'adr_pro_code')
        <td class="kh">{{ $staff->adr_province }}</td>

    <!-- Staff Workplace -->
    @elseif ($reportHeader->table_name == 'sys_locations')
        @if ($reportHeader->field_name == 'pro_code')
            <td class="kh">{{ $staff->work_province }}</td>
        @endif
        @if ($reportHeader->field_name == 'dis_code')
            <td class="kh">{{ $staff->work_district }}</td>
        @endif
        @if ($reportHeader->field_name == 'com_code')
            <td class="kh">{{ $staff->work_commune }}</td>
        @endif
        @if ($reportHeader->field_name == 'location_kh')
            <td class="kh">{{ $staff->work_location }}</td>
        @endif

    @elseif ($reportHeader->table_name == 'sys_offices' && $reportHeader->field_name == 'office_kh')
        <td class="kh">{{ $staff->work_office }}</td>

    @elseif ($reportHeader->table_name == 'hrmis_work_histories')
        @if ($reportHeader->field_name == 'additional_position_id')
            <td class="kh">{{ $staff->additional_position_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'position_id')
            <td class="kh">{{ $staff->position_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'prokah_num')
            <td class="kh">{{ $staff->work_history_prokah_num }}</td>
        @endif
        @if ($reportHeader->field_name == 'start_date')
            <td class="kh">{{ $staff->work_history_start_date > 0 ? 
                date('d-m-Y', strtotime($staff->work_history_start_date)) : '' }}</td>
        @endif

    <!-- Salary -->
    @elseif ($reportHeader->table_name == 'hrmis_staff_salaries')
        @if ($reportHeader->field_name == 'cardre_type_id')
            <td class="kh">{{ $staff->salary_cardre_type_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'salary_level_id')
            <td class="kh">{{ $staff->salary_level_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'salary_degree')
            <td class="kh">{{ $staff->salary_degree }}</td>
        @endif
        @if ($reportHeader->field_name == 'salary_type_prokah_num')
            <td class="kh">{{ $staff->salary_prokah_num }}</td>
        @endif
        @if ($reportHeader->field_name == 'salary_type_prokah_order')
            <td class="kh">{{ $staff->salary_prokah_order }}</td>
        @endif
        @if ($reportHeader->field_name == 'salary_type_shift_date')
            <td class="kh">{{ $staff->salary_shift_date > 0 ? 
                date('d-m-Y', strtotime($staff->salary_shift_date)) : '' }}</td>
        @endif

    @elseif ($reportHeader->table_name == 'hrmis_staffs' && $reportHeader->field_name == 'dtmt_school')
        <td class="kh">{{ $staff->dtmt_school == 1 ? 'YES' : 'NO' }}</td>

    <!-- Qualification -->
    @elseif ($reportHeader->table_name == 'sys_qualification_codes' && $reportHeader->field_name == 'qualification_kh')
        <td class="kh">{{ $staff->highest_qualification_kh }}</td>

    @elseif ($reportHeader->table_name == 'hrmis_staff_qualifications')
        @if ($reportHeader->field_name == 'subject_id')
            <td class="kh">{{ $staff->qual_subject_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'country_id')
            <td class="kh">{{ $staff->qual_country_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'location_kh')
            <td class="kh">{{ $staff->qual_location_kh }}</td>
        @endif

    <!-- Profession -->
    @elseif ($reportHeader->table_name == 'hrmis_staff_professions')
        @if ($reportHeader->field_name == 'prof_category_id')
            <td class="kh">{{ $staff->highest_profession_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'subject_id1')
            <td class="kh">{{ $staff->profession_subject1 }}</td>
        @endif
        @if ($reportHeader->field_name == 'subject_id2')
            <td class="kh">{{ $staff->profession_subject2 }}</td>
        @endif
        @if ($reportHeader->field_name == 'prof_type_id')
            <td class="kh">{{ $staff->profession_type_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'location_code')
            <td class="kh">{{ $staff->profession_location_kh }}</td>
        @endif

    <!-- Familty -->
    @elseif ($reportHeader->table_name == 'hrmis_families')
        @if ($reportHeader->field_name == 'fullname_kh')
            <td class="kh">{{ $staff->family_fullname_kh }}</td>
        @endif
        @if ($reportHeader->field_name == 'occupation')
            <td class="kh">{{ $staff->familty_occupation }}</td>
        @endif
        @if ($reportHeader->field_name == 'allowance')
            <td class="kh">{{ $staff->familty_allowance }}</td>
        @endif
        @if ($reportHeader->field_name == 'phone_number')
            <td class="kh">{{ $staff->familty_phonenumber }}</td>
        @endif

    <!-- Teaching -->
    @elseif ($reportHeader->table_name == 'hrmis_staff_teachings')
        @if ($reportHeader->field_name == 'add_teaching')
            <td class="kh">{{ $staff->add_teaching == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'teach_english')
            <td class="kh">{{ $staff->teach_english == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'multi_grade')
            <td class="kh">{{ $staff->multi_grade == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'triple_grade')
            <td class="kh">{{ $staff->triple_grade == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'double_shift')
            <td class="kh">{{ $staff->double_shift == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'bi_language')
            <td class="kh">{{ $staff->bi_language == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'class_incharge')
            <td class="kh">{{ $staff->class_incharge == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'chief_technical')
            <td class="kh">{{ $staff->chief_technical == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'teach_cross_school')
            <td class="kh">{{ $staff->teach_cross_school == 1 ? 'YES' : 'NO' }}</td>
        @endif
        @if ($reportHeader->field_name == 'location_code')
            <td class="kh">{{ $staff->teaching_cross_school_kh }}</td>
        @endif

    @else
        <td class="kh">
            {{ $staff[$reportHeader->field_name] != '' ? 
                $staff[$reportHeader->field_name] : '' }}
        </td>
    @endif

@endforeach
