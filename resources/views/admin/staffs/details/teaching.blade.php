<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <!-- Teaching -->
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <strong>{{ __('number.num6').'. '.__('បង្រៀននៅឆ្នាំសិក្សា') }}</strong>
                    </div>
                    <div class="col-sm-6">: {{ !empty($teachingInfo->academicYear) ? 
                        $teachingInfo->academicYear->year_kh : '' }}</div>
                </div>
            </div>

            <!-- Add teaching -->
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">{{ __('common.add_teaching') }}</div>
                    <div class="col-sm-6">: 
                        @if( !empty($teachingInfo) and $teachingInfo->add_teaching )
                            <i class="far fa-check-square" style="font-size:20px;"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <!-- Overtime -->
        <div class="row profile-item">
            <div class="col-sm-6 padding-0">{{ __('ម៉ោងលើស') }}</div>
            <div class="col-sm-6">: {{ !empty($teachingInfo) ? $teachingInfo->overtime : '' }}</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <!-- Teach english -->
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <span class="indent-2">{{ __('common.teach_english') }}</span>
                    </div>
                    <div class="col-sm-6">: 
                        @if( !empty($teachingInfo) and $teachingInfo->teach_english )
                            <i class="far fa-check-square" style="font-size:20px;"></i>
                        @endif
                    </div>
                </div>

                <!-- triple_grade -->
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <span class="indent-2">{{ __('common.triple_grade') }}</span>
                    </div>
                    <div class="col-sm-6">: 
                        @if( !empty($teachingInfo) and $teachingInfo->triple_grade )
                            <i class="far fa-check-square" style="font-size:20px;"></i>
                        @endif
                    </div>
                </div>

                <!-- Teaching lead -->
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <span class="indent-2">{{ __('common.technical_lead') }}</span>
                    </div>
                    <div class="col-sm-6">: 
                        @if( !empty($teachingInfo) and $teachingInfo->chief_technical )
                            <i class="far fa-check-square" style="font-size:20px;"></i>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <!-- Double shift -->
                <div class="row profile-item">
                    <div class="col-sm-6">{{ __('common.double_shift') }}</div>
                    <div class="col-sm-6">: 
                        @if( !empty($teachingInfo) and $teachingInfo->double_shift )
                            <i class="far fa-check-square" style="font-size:20px;"></i>
                        @endif
                    </div>
                </div>

                <!-- Bi-languages -->
                <div class="row profile-item">
                    <div class="col-sm-6">{{ __('common.class_incharge') }}</div>
                    <div class="col-sm-6">: 
                        @if( !empty($teachingInfo) and $teachingInfo->class_incharge )
                            <i class="far fa-check-square" style="font-size:20px;"></i>
                        @endif
                    </div>
                </div>

                <!-- Teach Cross School -->
                <div class="row profile-item">
                    <div class="col-sm-6">{{ __('common.teach_cross_school') }}</div>
                    <div class="col-sm-6">: {{ !empty($teachingInfo->crossSchool) ? 
                        $teachingInfo->crossSchool->location_kh : '' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <!-- Multiple grade -->
        <div class="row profile-item">
            <div class="col-sm-6 padding-0">{{ __('common.multi_grade') }}</div>
            <div class="col-sm-6">: 
                @if( !empty($teachingInfo) and $teachingInfo->multi_grade )
                    <i class="far fa-check-square" style="font-size:20px;"></i>
                @endif
            </div>
        </div>

        <!-- Class incharge -->
        <div class="row profile-item">
            <div class="col-sm-6 padding-0">{{ __('common.bi_language') }}</div>
            <div class="col-sm-6">: 
                @if( !empty($teachingInfo) and $teachingInfo->bi_language )
                    <i class="far fa-check-square" style="font-size:20px;"></i>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>{{__('common.grade')}}</th>
                    <th>{{ __('មុខវិជ្ជាបង្រៀន') }}</th>
                    <th>{{__('common.day_teaching')}}</th>
                    <th>{{__('common.hour_teaching')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($teachingSubjects as $teachingSubject)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ !empty($teachingSubject->grade) ? 
                            $teachingSubject->grade->grade_kh.' '.($teachingSubject->grade_alias) : '' }}</td>
                        <td>{{ !empty($teachingSubject->subject) ? 
                            $teachingSubject->subject->subject_kh : '---' }}</td>
                        <td>{{ !empty($teachingSubject->dayTeaching) ? 
                            $teachingSubject->dayTeaching->day_kh : '' }}</td>
                        <td>{{ !empty($teachingSubject->hourTeaching) ? 
                            $teachingSubject->hourTeaching->hour_kh : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

</div>
