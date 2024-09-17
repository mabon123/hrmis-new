<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['districts.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_district') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<!-- Province -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="pro_code">{{ __('common.province') }} 
                                	<span class="required">*</span></label>
                                {{ Form::select('pro_code', ['' => __('common.choose').' ...'] + $provinces, null, 
				                	['id' => 'pro_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;', 
				                		'required' => true]) 
				                }}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dis_code">{{ __('common.dis_code') }} 
                                    <span class="required">*</span></label>
                                <input type="text" name="dis_code" id="dis_code" value="{{ old('dis_code') }}" maxlength="4" autocomplete="off" class="form-control @error('dis_code') is-invalid @enderror" required>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="name_kh">
                                    {{ __('common.district_kh') }} <span class="required">*</span>
                                </label>

                                <input type="text" name="name_kh" id="name_kh" value="{{ old('name_kh') }}" maxlength="50" 
                                    autocomplete="off" class="form-control kh" required>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="name_en">{{ __('common.district_en') }}</label>

                                <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" maxlength="150" autocomplete="off" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="note">{{ __('common.note') }}</label>
                                <textarea name="note" id="note" rows="4" class="form-control kh" maxlength="255" required></textarea>
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
