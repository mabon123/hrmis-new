{!! Form::open(['route' => ['reports.showStaffTransferInInfo', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box">
		<div class="col-sm-2">
			<div class="form-group">
				<label for="payroll">{{ __('common.payroll_num') }}</label>
				{{ Form::text('payroll', request()->payroll, ['class' => 'form-control']) }}
			</div>
		</div>

		<div class="col-sm-3">
			<div class="form-group">
				<label for="fullname">{{ __('common.name') }}</label>
				{{ Form::text('fullname', request()->fullname, ['class' => 'form-control']) }}
			</div>
		</div>

		<div class="col-sm">
			<div class="form-group">
				<label for="old_location">{{ __('staff.old_location') }}</label>
				{{ Form::select('old_location', ['' => __('common.choose').' ...'] + $oldLocations, request()->old_location, 
					['class' => 'form-control select2', 'style' => 'width:100%;']) }}
			</div>
		</div>

		<div class="col-sm">
			<div class="form-group">
				<label for="new_location">{{ __('staff.new_location') }}</label>
				{{ Form::select('new_location', ['' => __('common.choose').' ...'] + $newLocations, request()->new_location, 
					['class' => 'form-control select2', 'style' => 'width:100%;']) }}
			</div>
		</div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('reports.showStaffTransferInInfo', app()->getLocale()) }}" 
				class="btn btn-danger btn-flat kh" onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info btn-flat kh" onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
