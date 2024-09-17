<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['grades.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_grade') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="grade_kh">{{ __('common.grade_kh') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::text('grade_kh', null, 
	                            	['id' => 'grade_kh', 'class' => 'form-control kh', 'maxlength' => 180, 
	                            		'autocomplete' => 'off', 'required' => true]) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="grade_en">{{ __('common.grade_en') }}</label>
	                            {{ Form::text('grade_en', null, 
	                            	['id' => 'grade_en', 'class' => 'form-control', 'maxlength' => 60, 
	                            		'autocomplete' => 'off']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="edu_level_id">{{ __('common.edu_level') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::select('edu_level_id',['' => __('common.choose')] + $educationLevels, null,
	                                ['id' => 'edu_level_id', 'data-old-value' => old('edu_level_id'), 
	                                	"class" => "form-control select2", 'style' => 'width:100%;', 
	                                	'required' => true])
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="description">{{ __('common.description') }}</label>
	                            {{ Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control', 'rows' => 3]) }}
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
