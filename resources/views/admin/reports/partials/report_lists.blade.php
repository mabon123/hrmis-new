<div id="accordion" style="margin-top:15px;">
	<div class="card card-secondary">
		<div class="card-header">
			<h4 class="card-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#educationStaff">{{ __('menu.report_all_staffs') }}</a>
			</h4>
		</div>

		@php $file_icon = 'fas fa-file-pdf report-icon'; @endphp
		@php $excel_icon = 'fas fa-file-excel report-icon'; @endphp

		<div id="educationStaff" class="panel-collapse collapse show">
			<div class="card-body">
				<div class="row">
					<?php /* ?><div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon"><a href="{{ route('reports.index', app()->getLocale()) }}">
								<i class="{{ $file_icon }}"></i></a></span>
							<div class="info-box-content">{{ __('School Census') }}</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon"><a href="{{ route('reports.allStaff', [app()->getLocale()]) }}">
								<i class="{{ $file_icon }}"></i></a></span>
							<div class="info-box-content">{{ __('ស្ថិតិបុគ្គលិកបង្រៀន') }}</div>
						</div>
					</div><?php */ ?>
					<div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-staff-list" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.generateAllStaff', [app()->getLocale()]) }}" onclick="loading();"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">{{ __('report.staff_information') }}</div>
						</div>
					</div>
					<!--
					<div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-staff-workplace" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.generateStaffOnePageOneWorkplace', [app()->getLocale()]) }}" onclick="loading();"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">{{ __('report.staff_in_Timetable') }}</div>
						</div>
					</div>
					-->
					<!-- Leave Report -->
					<div class="col-sm-12">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<div class="form-group">
									<button type="button" id="btn-short-leave" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.generateShortLeave', [app()->getLocale()]) }}" onclick="loading();"><i class="{{ $file_icon }}"></i>
									</button>
								</div>
							</span>
							<div class="info-box-content">
								<div class="row">
									<div class="col-sm-3 report-title">{{ __('report.staff_short_leaves') }}</div>
									<div class="col-sm-4">
										<div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
											{{ Form::text('start_date', null, ['class' => 'form-control datepicker '.($errors->has('start_date') ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => __('common.start_date').'*'.'(dd-mm-yyyy)', 'required' => true]) }}
											<div class="input-group-addon">
												<span class="far fa-calendar-alt"></span>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
											{{ Form::text('end_date', null, ['class' => 'form-control datepicker '.(($errors->has('end_date') or $errors->has('date_error')) ? ' is-invalid' : null), 'autocomplete' => 'off', 'data-inputmask-alias' => 'datetime', 'data-inputmask-inputformat' => 'dd-mm-yyyy', 'data-mask', 'placeholder' => __('common.end_date').'*'.'(dd-mm-yyyy)', 'required' => true]) }}
											<div class="input-group-addon">
												<span class="far fa-calendar-alt"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Leave -->
					<div class="col-sm-12">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-staff-position" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.generateStaffbyProfession', [app()->getLocale()]) }}" onclick="loading();"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">{{ __('report.staff_by_profession') }}</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<div class="form-group">
									<button type="button" id="btn-staff-position" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.generateStaffbyPosition', [app()->getLocale()]) }}" onclick="loading();"><i class="{{ $file_icon }}"></i>
									</button>
								</div>
							</span>
							<div class="info-box-content">
								<div class="row">
									<div class="col-sm-3 report-title">{{ __('report.staff_by_positions') }}</div>
									<div class="col-sm-4">
										<div class="form-group @error('position_from') has-error @enderror">
											{{ Form::select('position_from', ['' => __('common.choose').' ...'] + $positions, null, 
												['id' => 'position_from', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
													'required' => true]) 
											}}
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group @error('position_to') has-error @enderror">
											{{ Form::select('position_to', ['' => __('common.choose').' ...'] + $positions, null, 
												['id' => 'position_to', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
													'required' => true]) 
											}}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Report by Age -->
					<div class="col-sm-12">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<div class="form-group">
									<button type="button" id="btn-staff-position" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.generateStaffbyAge', [app()->getLocale()]) }}" onclick="loading();"><i class="{{ $file_icon }}"></i>
									</button>
								</div>
							</span>
							<div class="info-box-content">
								<div class="row">
									<div class="col-sm-3 report-title">{{ __('report.staff_by_age') }}</div>
									<div class="col-sm-1">
										<div class="form-group">
											{{ Form::text('age_from', null, ['class' => 'form-control '.($errors->has('age_from') ? 'is-invalid' : null)]) }}
										</div>
									</div>
									<div class="col-sm-1">
										<div class="form-group">
											{{ Form::text('age_to', null, ['class' => 'form-control '.($errors->has('age_to') ? 'is-invalid' : null)]) }}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- reportRequestCardreByCertification -->
					<div class="col-sm-12">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-staff-reportRequestCardreByCertification" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.reportRequestCardreByCertification', [app()->getLocale()]) }}"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<span class="info-box-icon ml-n4">
								<button type="button" id="btn-staff-reportRequestCardreByCercle" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.exportCardreByCertification', [app()->getLocale()]) }}"><i class="{{ $excel_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">ស្នើដំឡើងថ្នាក់តាមសញ្ញាបត្រ</div>
						</div>
					</div>

					<!-- reportRequestCardreByCercle -->
					<div class="col-sm-12">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-staff-reportRequestCardreByCercle" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.reportRequestCardreByCercle', [app()->getLocale()]) }}"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<span class="info-box-icon ml-n4">
								<button type="button" id="btn-staff-reportRequestCardreByCercle" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.exportCardreByCercle', [app()->getLocale()]) }}"><i style="color: green;" class="{{ $excel_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">ស្នើដំឡើងថ្នាក់តាមវេន</div>
						</div>
					</div>
					
					<?php /* ?><div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon"><a href="{{ route('reports.index', app()->getLocale()) }}">
								<i class="{{ $file_icon }}"></i></a></span>
							<div class="info-box-content">
								<div class="row">
									<div class="col-sm-5 report-title">{{ __('បុគ្គលិកដែលមានភាសាជំនាញ') }}</div>
									<div class="col-sm-7">
										{{ Form::select('province', ['' => __('common.choose').' ...'] + $languages, null, 
											['class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
									</div>
								</div>
							</div>
						</div>
					</div><?php */ ?>
				</div>
			</div>
		</div>
	</div>

	<div class="card card-secondary">
		<div class="card-header">
			<h4 class="card-title kh">
				<a data-toggle="collapse" data-parent="#accordion" href="#statistic">{{ __('ស្ថិតិ និង អាំងឌីការទ័របុគ្គលិកអប់រំ') }}</a>
			</h4>
		</div>

		<div id="statistic" class="panel-collapse collapse">
			<div class="card-body">Body here....</div>
		</div>
	</div>

	<div class="card card-secondary">
		<div class="card-header">
			<h4 class="card-title kh">
				<a data-toggle="collapse" data-parent="#accordion" href="#wrongInfo">{{ __('ការបញ្ចូលទិន្ន័យមានបញ្ហា') }}</a>
			</h4>
		</div>

		<div id="wrongInfo" class="panel-collapse collapse">
	<!-- Report of Schedule -->
		<div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-staff-workplace" class="btn btn-link btn-generate-report" data-report-url="{{ route('reports.generateStaffOnePageOneWorkplace', [app()->getLocale()]) }}" onclick="loading();"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">{{ __('report.staff_in_Timetable') }}</div>
						</div>
					</div>
		<!-- End Report of Schedule -->
		</div>
	</div>
</div>