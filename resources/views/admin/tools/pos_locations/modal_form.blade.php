<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['position-locations.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_position_location') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="location_type_id">{{ __('common.position_level') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::select('location_type_id', ['' => __('common.choose')] + $locations, null,
	                                ['id' => 'location_type_id', 'data-old-value' => old('location_type_id'), 
	                                	"class" => "form-control select2", 'style' => 'width:100%;', 
	                                	'required' => true])
	                            }}
	                        </div>
	                    </div>
	                    
	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="position_id">{{ __('common.position') }} 
	                            	<span class="required">*</span></label>

	                            {{ Form::select('position_id',['' => __('common.choose')] + $positions, null,
	                                ['id' => 'position_id', 'data-old-value' => old('position_id'), 
	                                	"class" => "form-control select2", 'style' => 'width:100%;', 
	                                	'required' => true])
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
