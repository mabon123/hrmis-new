<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['shortcourse-categories.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('common.create_shortcourse_cat') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="shortcourse_cat_kh">
	                                {{ __('common.shortcourse_cat_kh') }} <span class="required">*</span>
	                            </label>

	                            <input type="text" name="shortcourse_cat_kh" id="shortcourse_cat_kh" value="{{ old('shortcourse_cat_kh') }}" maxlength="100" autocomplete="off" class="form-control kh" required>
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="shortcourse_cat_en">{{ __('common.shortcourse_cat_en') }}</label>

	                            <input type="text" name="shortcourse_cat_en" id="shortcourse_cat_en" value="{{ old('shortcourse_cat_en') }}" maxlength="50" autocomplete="off" class="form-control">
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
