<div class="row" style="margin-top:20px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="color:#000;">{{ __('common.teaching') }}</h3>
            </div>

            <div class="card-body">
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>{{__('common.year')}}</th>
                                <th>{{__('common.add_teaching')}}</th>
                                <th>{{__('common.teach_english')}}</th>
                                <th>{{__('common.multi_grade')}}</th>
                                <th>{{__('common.double_shift')}}</th>
                                <th>{{__('common.bi_language')}}</th>
                                <th>{{__('common.class_incharge')}}</th>
                                <th>{{__('common.technical_lead')}}</th>
                                <th>{{__('common.teach_cross_school')}}</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="teaching-subject-listing">

                            @foreach($staff->teachings as $index => $teaching)

                                <tr id="record-{{ $teaching->teaching_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="kh">{{ $teaching->academicYear->year_kh }}</td>

                                    <td class="text-center">
                                        @if( $teaching->add_teaching == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if( $teaching->teach_english == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if( $teaching->multi_grade == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if( $teaching->double_shift == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if( $teaching->bi_language == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if( $teaching->class_incharge == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if( $teaching->chief_technical == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if( $teaching->teach_cross_school == 1 )
                                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                            <p style="margin-bottom:0px;">
                                                {{ !empty($teaching->crossSchool) ? $teaching->crossSchool->location_kh : '' }}
                                            </p>
                                        @else
                                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                        @endif
                                    </td>

                                    <td class="text-right">
                                        
                                        <a href="{{ route('teaching.edit', [app()->getLocale(), $teaching->teaching_id]) }}" class="btn btn-xs btn-info btn-edit"><i class="far fa-edit"></i> {{ __('button.edit') }}</a>
                                       
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
