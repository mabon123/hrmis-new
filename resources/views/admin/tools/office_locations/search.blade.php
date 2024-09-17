{!! Form::open(['route' => ['office-locations.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="pro_code">{{ __('common.province') }}</label>
				{{ Form::select('pro_code', ['' => __('common.choose')] + $provinces, request()->pro_code,
                    ['id' => 'province_kh', 'data-old-value' => old('pro_code'), "class" => "form-control select2", 
                    	'style' => 'width:100%;'])
                }}
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label for="location_code">{{ __('common.location') }}</label>
				{{ Form::select('location_code', ['' => __('common.choose')] + $locations, request()->location_code,
                    ['id' => 'location_kh', 'data-old-value' => old('location_code'), "class" => "form-control select2", 
                    	'style' => 'width:100%;'])
                }}
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
