{!! Form::open(['route' => ['grades.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-md-3">
            <div class="form-group">
                <label for="edu_level_id">{{ __('common.edu_level') }}</label>
                {{ Form::select('edu_level_id',['' => __('common.choose')] + $educationLevels, 
                	request()->edu_level_id,
                    ["class" => "form-control select2", 'style' => 'width:100%;'])
                }}
            </div>
        </div>

		<div class="col-md-3">
            <div class="form-group">
                <label for="grade_kh">{{ __('common.grade_kh') }}</label>
                {{ Form::text('grade_kh', request()->grade_kh, ['class' => 'form-control kh']) }}
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="grade_en">{{ __('common.grade_en') }}</label>
                {{ Form::text('grade_en', request()->grade_en, ['class' => 'form-control']) }}
            </div>
        </div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('grades.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
