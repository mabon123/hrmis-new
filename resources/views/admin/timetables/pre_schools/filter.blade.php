{!! Form::open(['route' => ['timetable.createPreSchoolTimetable', app()->getLocale()], 
	'method' => 'get', 'id' => 'frmSearchTimetable']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-md-3">
            <div class="form-group">
                <label for="academic_id">{{ __('menu.academic_year') }}</label>
                {{ Form::select('academic_id',['' => __('common.choose')] + $academicYears, 
                	(request()->academic_id ? request()->academic_id : $academicYearID),
                    ["class" => "form-control select2", 'style' => 'width:100%;'])
                }}
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
