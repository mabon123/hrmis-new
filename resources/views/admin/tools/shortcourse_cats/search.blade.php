{!! Form::open(['route' => ['shortcourse-categories.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-md-4">
            <div class="form-group">
                <label for="shortcourse_cat_kh">
                    {{ __('common.shortcourse_cat_kh') }} <span class="required">*</span>
                </label>
                {{ Form::text('shortcourse_cat_kh', request()->shortcourse_cat_kh, ['class' => 'form-control kh']) }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="shortcourse_cat_en">{{ __('common.shortcourse_cat_en') }}</label>
                {{ Form::text('shortcourse_cat_en', request()->shortcourse_cat_en, ['class' => 'form-control']) }}
            </div>
        </div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('shortcourse-categories.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
