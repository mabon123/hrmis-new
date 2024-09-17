<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['office-locations.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_office_location') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="office_id">{{ __('common.office') }} <span class="required">*</span></label>

	                            {{ Form::select('office_id', ['' => __('common.choose')] + $offices, null,
	                                ['id' => 'office_id', 'data-old-value' => old('office_id'), "class" => "form-control select2", 
	                                	'style' => 'width:100%;', 'required' => true])
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="pro_code">{{ __('common.province') }} <span class="required">*</span></label>

	                            {{ Form::select('pro_code', ['' => __('common.choose')] + $provinces, null,
	                                ['id' => 'pro_code', 'data-old-value' => old('pro_code'), "class" => "form-control select2", 
	                                	'style' => 'width:100%;', 'required' => true])
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="location_code">{{ __('common.location') }} <span class="required">*</span></label>

	                            {{ Form::select('location_code', ['' => __('common.choose')] + $locations, null,
	                                ['id' => 'location_code', 'data-old-value' => old('location_code'), "class" => "form-control select2", 
	                                	'style' => 'width:100%;', 'required' => true])
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
