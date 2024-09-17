{!! Form::open(['route' => ['districts.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row justify-content-md-center">
		<div class="col-sm-3">
            <div class="form-group">
                <label for="pro_code">{{ __('common.province') }}</label>
                {{ Form::select('pro_code', ['' => __('common.choose').' ...'] + $provinces, request()->pro_code, 
                	['id' => 'province_code', 'class' => 'form-control kh select2', 'style' => 'width:100%;']) 
                }}
            </div>
        </div>
        
		<div class="col-sm-3">
            <div class="form-group">
                <label for="dis_code">{{ __('common.dis_code') }}</label>
                {{ Form::text('dis_code', request()->dis_code, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="district_kh">{{ __('common.district_kh') }}</label>
                {{ Form::text('district_kh', request()->district_kh, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="district_en">{{ __('common.district_en') }}</label>
                {{ Form::text('district_en', request()->district_en, ['class' => 'form-control']) }}
            </div>
        </div>
	</div>

	<div class="row row-box">
		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('districts.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
