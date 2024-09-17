{!! Form::open(['route' => ['teacher-primary.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
	<div class="row row-box">
		<div class="col-sm-12">
			<h4>{{ __('timetables.teacher_primary') }}</h4>

			<input type="hidden" name="academic_id" value="{{ $curAcademicYear->year_id }}">
		</div>
	</div>

	<!-- Subject -->
	<div class="row row-box">
		<div class="col-md-12">
            <div class="form-group">
                <label for="payroll_id">{{ __('timetables.choose_teacher') }} 
                	<span class="required">*</span></label>

                <select name="payroll_id" id="payroll_id" class="form-control select2" style="width:100%;" required>
                	<option value="">{{ __('common.choose') }}</option>

                	@foreach($staffs as $staff)
                		@php $selected = ''; @endphp

                		@if (old('payroll_id') && old('payroll_id') == $staff->payroll_id)
                			@php $selected = 'selected'; @endphp
                		@endif

                		<option value="{{ $staff->payroll_id }}" {{$selected}}>
                			{{ $staff->surname_kh.' '.$staff->name_kh }}
                		</option>
                	@endforeach
                </select>
            </div>
        </div>
	</div>

	<div class="row row-box">
		<div class="col-md-12">
            <div class="form-group">
                <label for="subject_id">{{ __('timetables.grade_level') }} 
                	<span class="required">*</span></label>
                <div class="col-sm-12 custom-checkbox teaching-box" style="background:#fff;height:auto;padding-top:0;">
                    <div class="form pt-xl-3 mt-xl-3 d-flex flex-wrap justify-content-sm-between" 
                    	style="padding-top:0px !important;">
                    	<div class="row">
                    		@foreach ($gradeLevels as $index => $gradeLevel)
                    			<div class="col-sm-12" style="margin-bottom:30px;">
                    				<h6 class="kh" style="border-bottom:2px #17a2b8 solid;font-weight:bold;font-size:15px;">
                    					<i>{{ $gradeLevel->grade_kh }}</i></h6>

                    				<div class="row">
                    					@foreach ($grades[$index] as $grade)
					                        <div class="col-sm-3">
					                        	<div class="form-group">
						                            <div class="icheck-primary">
						                                <input class="form-check-input" name="grades[]" id="grade_{{ $grade->tgrade_id }}" 
						                                	type="checkbox" value="{{ $grade->tgrade_id }}">
						                                <label class="kh" for="grade_{{ $grade->tgrade_id }}">
						                                	{{ $grade->grade->grade_kh.' '.$grade->grade_name }}</label>
						                            </div>
						                        </div>
					                        </div>
				                        @endforeach
                    				</div>
                    			</div>
	                        @endforeach
                    	</div>
                    </div>
                </div>
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
