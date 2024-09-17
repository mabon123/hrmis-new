{!! Form::open(['route' => ['user.need.approvalpoe', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box" style="margin-top:20px;">
		<!-- User Role -->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="role" class="kh">{{ __('login.role') }}</label>
				{{ Form::select('role', ['' => 'ជ្រើសរើស ...'] + $roles, request()->role, 
					['class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
			</div>
		</div>

		<!-- User Level -->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="level" class="kh">{{ __('login.level') }}</label>
				{{ Form::select('level', ['' => 'ជ្រើសរើស ...'] + $levels, request()->level, 
					['class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
			</div>
		</div>

		<!-- Fullname KH -->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="name_kh" class="kh">{{ __('common.fullname_kh') }}</label>
				{{ Form::text('name_kh', request()->name_kh, ['class' => 'form-control kh']) }}
			</div>
		</div>

		<!-- Username & Payroll ID -->
		<div class="col-sm-3">
			<div class="form-group">
				<label for="keyword" class="kh">{{ __('login.username_payroll') }}</label>
				{{ Form::text('keyword', request()->keyword, ['class' => 'form-control kh']) }}
			</div>
		</div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('users.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
