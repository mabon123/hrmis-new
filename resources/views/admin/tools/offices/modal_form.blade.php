<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['offices.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_office') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="office_kh">
	                                {{ __('common.office_kh') }} <span class="required">*</span>
	                            </label>

	                            <input type="text" name="office_kh" id="office_kh" value="{{ old('office_kh') }}" maxlength="250" autocomplete="off" class="form-control kh" required>
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="office_en">{{ __('common.office_en') }}</label>

	                            <input type="text" name="office_en" id="office_en" value="{{ old('office_en') }}" maxlength="180" autocomplete="off" class="form-control">
	                        </div>
	                    </div>

	                    <div class="col-sm-12">
	                        <div class="form-group">
	                            <label for="note">{{ __('common.note') }}</label>
	                            <textarea name="note" id="note" rows="5" class="form-control kh">{{ old('note') }}</textarea>
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
