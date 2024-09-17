<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['positions.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_position') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="position_kh">{{ __('common.position_kh') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::text('position_kh', old('position_kh'), 
	                            	['id' => 'position_kh', 'class' => 'form-control kh', 'maxlength' => 180, 
	                            		'autocomplete' => 'off', 'required' => true]) }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="position_en">{{ __('common.position_en') }}</label>
	                            {{ Form::text('position_en', old('position_en'), 
	                            	['id' => 'position_en', 'class' => 'form-control kh', 'maxlength' => 60, 
	                            		'autocomplete' => 'off']) }}
	                        </div>
	                    </div>

	                    <div class="col-sm-12">
	                        <div class="form-group">
	                            <label for="pos_category_id">{{ __('common.position_category') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::select('pos_category_id', ['' => __('common.choose').' ...'] + $positionCats, null, 
	                            	['id' => 'pos_category_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
	                            		'required' => true]) }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="pos_level_id">{{ __('common.position_level') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::select('pos_level_id', ['' => __('common.choose').' ...'] + $locationTypes, null, 
	                            	['id' => 'pos_level_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
	                            		'required' => true]) }}
	                        </div>
	                    </div>

	                    <!-- Hierachy -->
	                    <div class="col-sm-12">
	                        <div class="form-group">
	                            <label for="position_hierarchy">{{ __('common.hierachy') }} 
	                            	<span class="required">*</span></label>
	                            {{ Form::number('position_hierarchy', old('position_hierarchy'), 
	                            	['id' => 'position_hierarchy', 'class' => 'form-control', 'required' => true]) }}
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
