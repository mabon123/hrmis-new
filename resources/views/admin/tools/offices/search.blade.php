{!! Form::open(['route' => ['offices.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="office_kh" class="kh">{{ __('common.office_kh') }}</label>
				{{ Form::text('office_kh', request()->office_kh, ['class' => 'form-control kh']) }}
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label for="office_en" class="kh">{{ __('common.office_en') }}</label>
				{{ Form::text('office_en', request()->office_en, ['class' => 'form-control kh']) }}
			</div>
		</div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('offices.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
