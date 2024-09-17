@foreach ($thours as $h_index => $thour)
	<tr>
		<td class="kh">{{ $thour->hour_kh }}</td>

		@if ($h_index == 0)
			<td class="text-center kh" colspan="6" style="background:#28a745;color:#fff;">{{ __('គោរពទង់ជាតិ') }}</td>

		@elseif ($h_index == 3 || $h_index == 5)
			<td class="text-center" colspan="3" style="background:#e36464;color:#fff;">{{ __('timetables.break_time') }}</td>
			<td class="text-center" colspan="2" style="background:#e36464;color:#fff;">{{ __('timetables.break_time') }}</td>
		
		@else
			<!-- Subject -->
			@foreach ($tdays as $d_index => $tday)
				@if ($tday->day_id < 7)
					@php
						$tid = 'hour_'.$thour->hour_id.'_day_'.$tday->day_id;
					@endphp

					@php $slot =  $morningTimetables[$h_index][$d_index]; @endphp

					@if ($h_index == 1 && $d_index == 3)
						<td class="text-center" rowspan="7" style="vertical-align:middle;font-family:'Moul', 'Arial';">
							{{ __('បំប៉នបន្ថែម') }}</td>
					
					@elseif ($d_index != 3)
						<td>
							<select name="timetables[]" id="{{ $tid }}" 
			                    class="form-control select2 teacher_subject_dropdown" style="width:100%;"
			                    data-add-url="{{ route('timetable.storePriTimetable', app()->getLocale()) }}"
			                    data-academic-id="{{ $academicYearID }}"
			                    data-day-id="{{ $tday->day_id }}"
			                    data-hour-id="{{ $thour->hour_id }}" 
			                    data-shift="{{ $grade_level == '13' ? 'm1' : 'm2' }}">
			                    <option value="">{{ __('common.choose') }}</option>

			                    @foreach ($subjects as $s_index => $subject)
			                        @php $selected = ''; @endphp
			                        
			                        @if (!is_null($slot) && $slot['subject_id'] == $subject->subject_id)
			                            @php $selected = 'selected'; @endphp
			                        @endif

			                        <option value="{{ $subject->subject_id }}" {{ $selected }}>
			                            {{ $subject->subject_kh }}
			                        </option>
			                    @endforeach
			                </select>
						</td>
					@endif
				@endif
			@endforeach
		@endif
	</tr>
@endforeach
