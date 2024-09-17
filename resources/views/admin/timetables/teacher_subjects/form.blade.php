{!! Form::open(['route' => ['teacher-subjects.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
	<div class="row row-box">
		<div class="col-sm-12">
			<h4>{{ __('timetables.teacher_subject') }}</h4>
		</div>
	</div>

	<!-- Subject -->
	<div class="row row-box">
		<div class="col-md-12">
            <div class="form-group">
                <label for="subject_id">{{ __('timetables.choose_subject') }} 
                	<span class="required">*</span></label>
                {{ Form::select('subject_id', ['' => __('common.choose')] + $subjects, null,
                    ['id' => 'subject_id', "class" => "form-control select2", 'style' => 'width:100%;', 
                    'required' => true])
                }}
            </div>
        </div>
	</div>

	<div class="row row-box">
		<div class="col-md-12">
            <div class="form-group">
                <label for="subject_id">{{ __('timetables.grade_level') }} 
                	<span class="required">*</span></label>
                <div class="col-sm-12 custom-checkbox teaching-box" style="background:#fff;height:auto;padding-top:0;">
                    <div class="form pl-xl-3 pt-xl-3 mt-xl-3 d-flex-OLD flex-wrap justify-content-sm-between" 
                    	style="padding-top:0px !important;">
                    	<div class="row">
                    		@foreach ($grades as $key => $grade)
		                        <div class="col-sm-3">
		                        	<div class="form-group">
			                            <div class="icheck-primary">
			                                <input class="form-check-input" name="grades[]" id="grade_{{ $key }}" type="checkbox" value="{{ $key }}">
			                                <label class="kh" for="grade_{{ $key }}">{{ $grade }}</label>
			                            </div>
			                        </div>
		                        </div>
	                        @endforeach
                    	</div>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<!-- Teacher Listing -->
	<div class="row row-box">
		<div class="col-sm-12">
			<div class="card-body table-responsive p-0">
				<table class="table table-bordered table-striped table-head-fixed text-nowrap">
					<thead>
                        <tr>
                            <th></th>
                            <th>{{ __('timetables.teacher_name') }}</th>
                            <th>{{ __('qualification.first_subject') }}</th>
                            <th>{{ __('qualification.second_subject') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                    	@foreach ($staffs as $staff)
                    		<tr>
                    			<td class="text-center">
                    				<div class="icheck-primary">
                    					<input class="form-check-input" name="teachers[]" id="teacher_{{ $staff->payroll_id }}" type="checkbox" value="{{ $staff->payroll_id }}">
                    					<label for="teacher_{{ $staff->payroll_id }}"></label>
                    				</div>
                    			</td>
                    			<td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
                    			<td class="kh">
                    				{{ (!empty($staff->highestPrefession[0]) && !empty($staff->highestPrefession[0]->firstSubject)) ? 
                    					$staff->highestPrefession[0]->firstSubject->subject_kh : '' }}
                    			</td>
                    			<td class="kh">
                    				{{ (!empty($staff->highestPrefession[0]) && !empty($staff->highestPrefession[0]->secondSubject)) ? 
                    					$staff->highestPrefession[0]->secondSubject->subject_kh : '' }}
                    			</td>
                    		</tr>
                    	@endforeach
                    </tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row row-box">
		<div class="col-sm-12">
			<button type="submit" class="btn btn-info btn-flat" style="width:100%;">
				<i class="far fa-save"></i> {{ __('button.save') }}</button>
		</div>
	</div>
{!! Form::close() !!}
