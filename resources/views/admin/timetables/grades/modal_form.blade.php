<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['tgrades.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('timetables.create_new_grade') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<!-- Academic Year -->
					<div class="row row-box">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="academic_id">{{ __('menu.academic_year') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::select('academic_id', ['' => __('common.choose')] + $academicYears, 
	                            	(request()->academic_id ? request()->academic_id : $curAcademicYear->year_id),
	                                ['id' => 'academic_id', 'data-old-value' => old('academic_id'), 
	                                	"class" => "form-control select2", 'style' => 'width:100%;', 
	                                	'required' => true])
	                            }}
	                        </div>
	                    </div>
					</div>

	                <!-- Grade Level -->
	                <div class="row row-box">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="grade_id">{{ __('timetables.grade_level') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::select('grade_id', ['' => __('common.choose')] + $grades, null, 
	                            	['id' => 'grade_id', 'class' => 'form-control select2', 
	                            	'style' => 'width:100%;', 'required' => true]) 
	                            }}
	                        </div>
	                    </div>
	                </div>

	                <!-- Grade Name (KH) -->
	                <div class="row row-box">
	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="grade_name">{{ __('timetables.grade_name_kh') }}</label>
	                            <div class="row row-box">
	                            	<div class="col-sm">
	                            		{{ Form::text('grade_name[]', null, 
			                            	['id' => 'grade_name_1', 'class' => 'form-control text-uppercase kh', 
			                            	'maxlength' => 2, 'autocomplete' => 'off']) 
			                            }}
	                            	</div>

	                            	@for($i = 2; $i <= 10; $i++)
		                            	<div class="col-sm">
		                            		{{ Form::text('grade_name[]', null, 
				                            	['id' => 'grade_name_'.$i, 'class' => 'form-control text-uppercase kh', 
				                            	'maxlength' => 2, 'autocomplete' => 'off']) 
				                            }}
		                            	</div>
	                            	@endfor
	                            </div>

	                            <div id="grade-sec-2" class="row row-box">
	                            	@for($i = 11; $i <= 20; $i++)
		                            	<div class="col-sm">
		                            		{{ Form::text('grade_name[]', null, 
				                            	['id' => 'grade_name_'.$i, 'class' => 'form-control text-uppercase kh', 
				                            	'maxlength' => 2, 'autocomplete' => 'off']) 
				                            }}
		                            	</div>
	                            	@endfor
	                            </div>

	                            <div id="grade-sec-3" class="row">
	                            	@for($i = 21; $i <= 30; $i++)
		                            	<div class="col-sm">
		                            		{{ Form::text('grade_name[]', null, 
				                            	['id' => 'grade_name_'.$i, 'class' => 'form-control text-uppercase kh', 
				                            	'maxlength' => 2, 'autocomplete' => 'off']) 
				                            }}
		                            	</div>
	                            	@endfor
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <!-- Class Incharge -->
	                <div class="row row-box">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="payroll_id">{{ __('timetables.class_incharge') }}</label>
	                            <select name="payroll_id" id="payroll_id" class="form-control select2" style="width:100%;">
	                            	<option value="">{{ __('common.choose') }}</option>
	                            	@foreach ($staffs as $staff)
	                            		<option value="{{ $staff->payroll_id }}">
	                            			{{ $staff->surname_kh .' '. $staff->name_kh }}
	                            		</option>
	                            	@endforeach
	                            </select>
	                        </div>
	                    </div>
	                </div>
				</div>

				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-danger btn-flat" data-dismiss="modal" style="width:150px;">
						<i class="far fa-times-circle"></i> {{ __('button.cancel') }}</button>
					<button type="submit" class="btn btn-info btn-flat" style="width:150px;">
						<i class="far fa-save"></i> {{ __('button.save') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
