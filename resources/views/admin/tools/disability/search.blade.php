{!! Form::open(['route' => ['disabilities.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-md-4">
            <div class="form-group">
                <label for="disability_kh">{{ __('common.disability_kh') }}</label>
                {{ Form::text('disability_kh', request()->disability_kh, ['class' => 'form-control kh']) }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="disability_en">{{ __('common.disability_en') }}</label>
                {{ Form::text('disability_en', request()->disability_en, ['class' => 'form-control']) }}
            </div>
        </div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('disabilities.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
