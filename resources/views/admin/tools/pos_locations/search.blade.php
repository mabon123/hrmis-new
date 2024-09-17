{!! Form::open(['route' => ['position-locations.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-md-4">
            <div class="form-group">
                <label for="location_type_id">{{ __('common.position_level') }}</label>
                {{ Form::select('location_type_id', ['' => __('common.choose')] + $locations, 
                	request()->location_type_id,
                    ["class" => "form-control select2", 'style' => 'width:100%;'])
                }}
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label for="position_id">{{ __('common.position') }}</label>
                {{ Form::select('position_id',['' => __('common.choose')] + $positions, 
                	request()->position_id,
                    ["class" => "form-control select2", 'style' => 'width:100%;'])
                }}
            </div>
        </div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('position-locations.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
