<div class="row">
    @if (count($academicYears) && $academicYear)
    <div class="col-md-12">
        <div class="row-box">
            <div class="form-group">
                <label for="year_id" class="mr-3">{{__('common.year')}}</label>
                <div class="dropdown d-inline">
                    <a class="btn btn-default dropdown-toggle py-1" href="#" role="button" id="dropdownYear" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ request()->get('year_id') ? $academicYears[request()->get('year_id')] : $academicYears[$academicYear->year_id] }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownYear" style="max-height: 300px; overflow: scroll">
                        @foreach ($academicYears as $id => $year)
                            <a class="dropdown-item" href="{{ route('schools.edit', [app()->getLocale(), $location]) }}?year_id={{ $id }}">{{ $year }}</a>
                        @endforeach
                    </div>
                    <input type="hidden" name="student_info[year_id]" value="{{ isset($academicYear) ? $academicYear->year_id : '' }}">
                </div>
            </div>
            <hr class="border-info">
        </div>
    </div>
    @endif
    <div class="col-md-12">
        <div class="row-box">
            <div class="row">
                <div class="col-sm-10 col-md-8 mx-auto">
                    <div class="table-responsive table-student_number_info">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>@lang('school.grading_type')</th>
                                    <th style="width:100px">@lang('school.total')</th>
                                    <th style="width:100px">@lang('school.female')</th>
                                    <th style="width:100px">@lang('school.class')</th>
                                </tr>
                            </thead>
                        </table>
                        @foreach($gradingTypes as $index => $types)
                        <div class="group group-{{$index}}">
                            <table class="table table-head-fixed text-nowrap table-borderless">
                                @foreach ($types as $type)
                                    <tbody class="id_{{ $type['id'] }}" id="{{ $type['key'] }}" style="display: none">
                                        @if ($type['name'])
                                            <tr>
                                                <td colspan="4">{{ $type['name'] }}</td>
                                            </tr>
                                        @endif
                                        @foreach ($type['grades'] as $grade)
                                        <tr>
                                            <td>{{ $grade['name'] }}</td>
                                            @foreach ($grade['keys'] as $key)
                                                <td style="width: 100px">
                                                    {{
                                                        Form::number(
                                                            "student_info[$key]",
                                                            isset($locationHistory) ? $locationHistory->$key : null,
                                                            [
                                                                "class" => "form-control form-control-sm",
                                                                'min' => 0,
                                                                'max' => 2000,
                                                                'placeholder' => '0',
                                                                'onKeyPress' => "if(this.value.length==4) return false;",
                                                                'readonly' => !$isEditableStudentInfo
                                                            ]
                                                        )
                                                    }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endforeach
                            </table>
                            <table class="table table-head-fixed total-table text-nowrap my-4">
                                <tfoot class="total">
                                    <tr class="bg-info">
                                        <td><b>@lang('school.total')</b></td>
                                        <td style="width: 100px">{{ Form::number('student_info[tstud_num]', isset($locationHistory) ? $locationHistory->tstud_num : 0, ["class" => "form-control form-control-sm", 'readonly']) }}</td>
                                        <td style="width: 100px">{{ Form::number('student_info[fstud_num]', isset($locationHistory) ? $locationHistory->fstud_num : 0, ["class" => "form-control form-control-sm", 'readonly']) }}</td>
                                        <td style="width: 100px">{{ Form::number('student_info[class_num]', isset($locationHistory) ? $locationHistory->class_num : 0, ["class" => "form-control form-control-sm", 'readonly']) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="border-info">
        </div>
    </div>
</div>
