{!! Form::open(['route' => ['subjects.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-md-3">
            <div class="form-group">
                <label for="edu_level_id">{{ __('common.edu_level') }}</label>
                {{ Form::select('edu_level_id', ['' => __('common.choose').' ...'] + $educationLevels, 
                    request()->edu_level_id ? request()->edu_level_id : null,
                    ["class" => "form-control kh select2", 'style' => 'width:100%;'])
                }}
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="subject_hierachy">{{ __('common.hierachy') }}</label>
                {{ Form::number('subject_hierachy', request()->subject_hierachy, ['class' => 'form-control kh']) }}
            </div>
        </div>

        <div class="col-md">
            <div class="form-group">
                <label for="subject_kh">{{ __('common.subject_kh') }}</label>
                {{ Form::text('subject_kh', request()->subject_kh, ['class' => 'form-control kh']) }}
            </div>
        </div>

        <div class="col-md">
            <div class="form-group">
                <label for="subject_en">{{ __('common.subject_en') }}</label>
                {{ Form::text('subject_en', request()->subject_en, ['class' => 'form-control kh']) }}
            </div>
        </div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('subjects.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
