@foreach ($tdays as $d_index => $tday)
    <tr>
        <td class="kh" rowspan="10">{{ $tday->day_kh }}</td>
        <td style="padding-left:1.5rem;vertical-align:middle;">{{ $thours[0]->hour_kh }}</td>

        @foreach ($tgrades as $g_index => $tgrade)
            <td>
                @php
                    $tid = 'day_'.$tday->day_id.'_hour_'.$thours[0]->hour_id.'_g'.$tgrade->tgrade_id;
                @endphp

                @php $slot =  $timetables[$d_index][0][$g_index]; @endphp
                
                <select name="timetables[]" id="{{ $tid }}" 
                    class="form-control select2 teacher_subject_dropdown" style="width:100%;"
                    data-add-url="{{ route('timetable.store', app()->getLocale()) }}"
                    data-academic-id="{{ $academicYearID }}"
                    data-location-code="{{ $userLocationCode }}"
                    data-day-id="{{ $tday->day_id }}"
                    data-hour-id="{{ $thours[0]->hour_id }}" 
                    data-tgrade-id="{{ $tgrade->tgrade_id }}">
                    <option value="">{{ __('common.choose') }}</option>
                    @foreach ($subjectGrades[$tgrade->grade_id-1] as $s_index => $teacherSubject)

                        @php $selected = ''; @endphp

                        @if (!is_null($slot) && $slot['teacher_subject_id'] == $teacherSubject->teacher_subject_id)
                            @php $selected = 'selected'; @endphp
                        @endif

                        <option value="{{ $teacherSubject->teacher_subject_id }}" {{ $selected }}>
                            {{ 
                                $teacherSubject->teacher_subject.'-'.                                
                                $teacherSubject->staff->surname_kh.' '.
                                $teacherSubject->staff->name_kh 
                            }}
                        </option>
                    @endforeach
                </select>

                <div style="margin-top:5px;">
                    <button type="button" id="" class="btn btn-xs btn-danger btn_remove_timetable" 
                        data-delete-url="{{ route('timetable.remove', [app()->getLocale(), 
                            $academicYearID, $userLocationCode, $tday->day_id, $thours[0]->hour_id, $tgrade->tgrade_id
                        ]) }}">
                        <i class="fas fa-minus-circle"></i></button>
                </div>
            </td>
        @endforeach
    </tr>

    @foreach ($thours as $h_index => $thour)
        @if ($h_index > 0)
            <tr>
                <td style="vertical-align:middle;">{{ $thour->hour_kh }}</td>

                <!-- Break Time -->
                @if ($thour->hour_id == 0 || $thour->hour_id == 100)
                    <td colspan="{{ count($tgrades) }}" class="text-center" 
                        style="background:#e36464;color:#fff;">{{ __('timetables.break_time') }}</td>
                @else
                    @foreach ($tgrades as $tg_index => $tgrade)
                        <td>
                            @php $slot =  $timetables[$d_index][$h_index][$tg_index]; @endphp

                            @php
                                $tid = 'day_'.$tday->day_id.'_hour_'.$thour->hour_id.'_g'.$tgrade->tgrade_id;
                            @endphp
                            <select name="timetables[]" id="{{ $tid }}" 
                                class="form-control select2 teacher_subject_dropdown" style="width:100%;background:pink !important;" 
                                data-add-url="{{ route('timetable.store', app()->getLocale()) }}" 
                                data-academic-id="{{ $academicYearID }}" 
                                data-location-code="{{ $userLocationCode }}" 
                                data-day-id="{{ $tday->day_id }}" 
                                data-hour-id="{{ $thour->hour_id }}" 
                                data-tgrade-id="{{ $tgrade->tgrade_id }}">
                                <option value="">{{ __('common.choose') }}</option>
                                @foreach ($subjectGrades[($tgrade->grade_id-1)] as $teacherSubject)
                                    
                                    @php $other_selected = ''; @endphp

                                    @if (!is_null($slot) && $slot['teacher_subject_id'] == $teacherSubject->teacher_subject_id)
                                        @php $other_selected = 'selected'; @endphp
                                    @endif

                                    <option value="{{ $teacherSubject->teacher_subject_id }}" {{ $other_selected }}>{{ $teacherSubject->teacher_subject.'-'.$teacherSubject->staff->surname_kh.' '.$teacherSubject->staff->name_kh }}</option>
                                @endforeach
                            </select>

                            <div style="margin-top:5px;">
                                <button type="button" id="" class="btn btn-xs btn-danger btn_remove_timetable" 
                                    data-delete-url="{{ route('timetable.remove', [app()->getLocale(), 
                                        $academicYearID, $userLocationCode, $tday->day_id, $thour->hour_id, $tgrade->tgrade_id
                                    ]) }}">
                                    <i class="fas fa-minus-circle"></i></button>
                            </div>
                        </td>
                    @endforeach
                @endif
            </tr>
        @endif
    @endforeach
@endforeach
