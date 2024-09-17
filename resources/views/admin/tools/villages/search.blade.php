{!! Form::open(['route' => ['villages.index', app()->getLocale()], 'method' => 'get']) !!}
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
                	['id' => 'district_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
                		'disabled' => (request()->dis_code ? false : true)]) 
                }}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="com_code">{{ __('common.commune') }} <span class="required">*</span></label>
                {{ Form::select('com_code', ['' => __('common.choose').' ...'] + $communes, request()->com_code, 
                	['id' => 'search_commune_code', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
                		'disabled' => (request()->com_code ? false : true), 'required' => true]) 
                }}
            </div>
        </div>
	</div>

	<div class="row justify-content-md-center">
		<div class="col-sm-3">
            <div class="form-group">
                <label for="vil_code">{{ __('common.vil_code') }}</label>
                {{ Form::text('vil_code', request()->vil_code, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="village_kh">{{ __('common.village_kh') }}</label>
                {{ Form::text('village_kh', request()->village_kh, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="village_en">{{ __('common.village_en') }}</label>
                {{ Form::text('village_en', request()->village_en, ['class' => 'form-control']) }}
            </div>
        </div>
	</div>

	<div class="row row-box">
		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('villages.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
