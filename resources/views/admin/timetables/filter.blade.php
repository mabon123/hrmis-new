{!! Form::open(['route' => ['timetable.create', app()->getLocale()], 
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

        <div class="col-md-3">
            <div class="form-group">
                <label for="grade_id">{{ __('timetables.grade_level') }}</label>
                
                <?php /* ?><select name="grade_id" id="grade_id" class="form-control select2">
                	<option value="">{{ __('common.choose').'...' }}</option>

                	@foreach ($numGrades as $numGrade)
                		@php $selected = ''; @endphp
                		@if (request()->grade_id == $numGrade->grade_id)
                			@php $selected = 'selected'; @endphp
                		@endif
                		<option value="{{ $numGrade->grade_id }}" {{$selected}}>{{ $numGrade->grade_id }}</option>
                	@endforeach
                </select><?php */ ?>

                {{ Form::select('grade_id',['' => __('common.choose')] + $grades, 
                	(request()->grade_id ? request()->grade_id : null),
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
