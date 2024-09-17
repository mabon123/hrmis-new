<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['profession-categories.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('tcp.create_profession_category') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="tcp_prof_cat_kh">{{ __('tcp.profession_category_kh') }} 
	                            	<span class="required">*</span></label>
	                            
	                            {{ Form::text('tcp_prof_cat_kh', old('tcp_prof_cat_kh'), 
	                            	['id' => 'tcp_prof_cat_kh', 'class' => 'form-control kh', 'maxlength' => 150, 
	                            		'autocomplete' => 'off', 'required' => true]) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="tcp_prof_cat_en">{{ __('tcp.profession_category_en') }} 
	                            	<span class="required">*</span></label>
	                            
	                            {{ Form::text('tcp_prof_cat_en', old('tcp_prof_cat_en'), 
	                            	['id' => 'tcp_prof_cat_en', 'class' => 'form-control kh', 'maxlength' => 50, 
	                            		'autocomplete' => 'off', 'required' => true]) 
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
