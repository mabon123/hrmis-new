<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['subjects.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_subject') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
	                        <div class="form-group">
	                            <label for="subject_kh">{{ __('common.subject_kh') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::text('subject_kh', null, 
	                            	['id' => 'subject_kh', 'class' => 'form-control kh', 'maxlength' => 180, 
	                            		'autocomplete' => 'off', 'required' => true]) }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="subject_en">{{ __('common.subject_en') }}</label>
	                            {{ Form::text('subject_en', null, 
	                            	['id' => 'subject_en', 'class' => 'form-control kh', 'maxlength' => 60, 
	                            		'autocomplete' => 'off']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="subject_shortcut">{{ __('common.subject_shortcut') }}</label>
	                            {{ Form::text('subject_shortcut', null, 
	                            	['id' => 'subject_shortcut', 'class' => 'form-control kh', 'maxlength' => 60, 
	                            		'autocomplete' => 'off']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="edu_level_id">{{ __('common.edu_level') }}</label>

	                            {{ Form::select('edu_level_id', ['' => __('common.choose').' ...'] + $educationLevels, null,
	                                ['id' => 'edu_level_id', 'data-old-value' => old('edu_level_id'), "class" => "form-control select2", 
	                                	'style' => 'width:100%;'])
	                            }}
	                        </div>
	                    </div>
	                </div>

	                <div class="row">
	                	<div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g7">{{ __('common.h_g7') }}</label>
	                            {{ Form::text('h_g7', null, 
	                            	['id' => 'h_g7', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g8">{{ __('common.h_g8') }}</label>
	                            {{ Form::text('h_g8', null, 
	                            	['id' => 'h_g8', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g9">{{ __('common.h_g9') }}</label>
	                            {{ Form::text('h_g9', null, 
	                            	['id' => 'h_g9', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g10">{{ __('common.h_g10') }}</label>
	                            {{ Form::text('h_g10', null, 
	                            	['id' => 'h_g10', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>


	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g11_sc">{{ __('common.h_g11_sc') }}</label>
	                            {{ Form::text('h_g11_sc', null, 
	                            	['id' => 'h_g11_sc', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g11_ss">{{ __('common.h_g11_ss') }}</label>
	                            {{ Form::text('h_g11_ss', null, 
	                            	['id' => 'h_g11_ss', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g12_sc">{{ __('common.h_g12_sc') }}</label>
	                            {{ Form::text('h_g12_sc', null, 
	                            	['id' => 'h_g12_sc', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-3">
	                        <div class="form-group">
	                            <label for="h_g12_ss">{{ __('common.h_g12_ss') }}</label>
	                            {{ Form::text('h_g12_ss', null, 
	                            	['id' => 'h_g12_ss', 'class' => 'form-control kh']) 
	                            }}
	                        </div>
	                    </div>

	                </div>

	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="subject_hierachy">{{ __('common.hierachy') }}</label>
	                            {{ Form::number('subject_hierachy', null, 
	                            	['id' => 'subject_hierachy', 'class' => 'form-control kh', 'autocomplete' => 'off']) 
	                            }}
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
