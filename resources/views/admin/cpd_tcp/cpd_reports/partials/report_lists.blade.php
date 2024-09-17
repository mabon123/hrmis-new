<div id="accordion" style="margin-top:15px;">
	<div class="card card-secondary">
		<div class="card-header">
			<h4 class="card-title">
				<a data-toggle="collapse" data-parent="#accordion" 
					href="#educationStaff">{{ __('report.reports_list') }}</a>
			</h4>
		</div>

		@php $file_icon = 'fas fa-file-pdf report-icon'; @endphp

		<div id="educationStaff" class="panel-collapse collapse show">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-credited-staff-list" class="btn btn-link btn-generate-report" 
									data-report-url="{{ route('cpd-reports.got-credits', [app()->getLocale()]) }}" 
									onclick="loading();"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">{{ __('report.cpd_credited_teachers_list') }}</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="info-box mb-3 cust-info-box">
							<span class="info-box-icon">
								<button type="button" id="btn-cpd-offering-list" class="btn btn-link btn-generate-report" 
									data-report-url="{{ route('cpd-reports.cpd-offerings-list', [app()->getLocale()]) }}" 
									onclick="loading();"><i class="{{ $file_icon }}"></i>
								</button>
							</span>
							<div class="info-box-content">{{ __('report.cpd_offerings_list') }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
