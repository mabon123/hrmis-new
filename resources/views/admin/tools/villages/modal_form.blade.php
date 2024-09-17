<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['villages.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_village') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<!-- Province -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pro_code">{{ __('common.province') }} 
                                	<span class="required">*</span></label>
                                {{ Form::select('pro_code', ['' => __('common.choose').' ...'] + $provinces, null, 
				                	['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
				                		'required' => true]) 
				                }}
                            </div>
                        </div>

                        <!-- District -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dis_code">{{ __('common.district') }} 
                                	<span class="required">*</span></label>
                                {{ Form::select('dis_code', ['' => __('common.choose').' ...'] + $districts, null, 
				                	['id' => 'dis_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
				                		'required' => true]) 
				                }}
                            </div>
                        </div>

                        <!-- Commune -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="com_code">{{ __('common.commune') }} 
                                	<span class="required">*</span></label>
                                {{ Form::select('com_code', ['' => __('common.choose').' ...'] + $communes, null, 
				                	['id' => 'com_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
				                		'required' => true, 'disabled' => true]) 
				                }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="village_code">{{ __('common.vil_code') }} 
                                	<span class="required">*</span></label>

                                <div class="form-row">
                                    <div class="form-group col-auto mb-0 pr-0">
                                        {{ Form::text('commune_code', null, ['id' => 'commune_code', 'class' => 'form-control', 
                                        	'style' => 'width:120px;', 'disabled' => true]) }}
                                    </div>

                                    <div class="form-group col-auto mb-0 pr-0">
                                        {{ Form::text('village_code', null, ['id' => 'village_code', 'class' => 'form-control', 
                                        	'maxlength' => 2, 'autocomplete' => 'off', 'style' => 'width:80px;', 
                                        	'required' => true]) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name_kh">{{ __('common.village_kh') }} 
                                	<span class="required">*</span></label>
                                {{ Form::text('name_kh', null, ['id' => 'name_kh', 'class' => 'form-control kh', 
                                	'maxlength' => 150, 'autocomplete' => 'off', 'required' => true]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name_en">{{ __('common.village_en') }}</label>
                                {{ Form::text('name_en', null, ['id' => 'name_en', 'class' => 'form-control', 
                                	'maxlength' => 50, 'autocomplete' => 'off']) }}
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="note">{{ __('common.note') }}</label>
                                {{ Form::textarea('note', null, ['id' => 'note', 'class' => 'form-control', 'rows' => 4]) }}
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
