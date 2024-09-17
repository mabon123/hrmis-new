<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['countries.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_country') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
                            <div class="form-group">
                                <label for="country_kh">{{ __('common.country_kh') }} 
                                	<span class="required">*</span></label>
                                {{ Form::text('country_kh', request()->country_kh, 
                                	['id' => 'country_kh', 'class' => 'form-control kh', 'maxlength' => 150, 
                                		'autocomplete' => 'off', 'required' => true]) 
                                }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country_en">{{ __('common.country_en') }}</label>
                                {{ Form::text('country_en', null, 
                                	['id' => 'country_en', 'class' => 'form-control', 'maxlength' => 50, 
                                		'autocomplete' => 'off']) 
                                }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group clearfix" style="margin-top:10px;">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="active" name="active" value="1" checked>
                                    <label for="active">{{__('login.active')}}</label>
                                </div>
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
