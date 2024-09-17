{!! Form::open(['route' => ['communes.index', app()->getLocale()], 'method' => 'get']) !!}
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
                <label for="dis_code">{{ __('common.district') }}</label>
                {{ Form::select('dis_code', ['' => __('common.choose').' ...'] + $districts, request()->dis_code, 
                	['id' => 'search_district_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
                		'disabled' => (request()->dis_code ? false : true)]) 
                }}
            </div>
        </div>
	</div>

	<div class="row justify-content-md-center">
		<div class="col-sm-3">
            <div class="form-group">
                <label for="com_code">{{ __('common.com_code') }}</label>
                {{ Form::text('com_code', request()->com_code, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="commune_kh">{{ __('common.commune_kh') }}</label>
                {{ Form::text('commune_kh', request()->commune_kh, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="commune_en">{{ __('common.commune_en') }}</label>
                {{ Form::text('commune_en', request()->commune_en, ['class' => 'form-control']) }}
            </div>
        </div>
	</div>

	<div class="row row-box">
		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('communes.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
