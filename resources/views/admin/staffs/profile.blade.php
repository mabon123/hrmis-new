@extends('layouts.admin')

@push('styles')
	
	<style>
		.card-primary.card-outline{border-top:3px solid #0087b2 !important;}
		.card-header{background-color:#0087b2 !important;}
		.card-title{color:#fff !important;}
		.profile-item{margin-bottom:15px;}
		.card-sub-title{font-size:16px;margin-top:15px;margin-bottom:15px;border-bottom:2px solid #0a7698;padding-bottom:4px;}
	</style>

@endpush

@section('content')
	
	<section class="content-header">
	    <div class="container-fluid">
	        <div class="row mb-2">
	            <div class="col-sm-6">
	                <h1>
	                    <i class="fa fa-file"></i> {{ __('menu.staff_info') }}
	                </h1>
	            </div>
	            <div class="col-sm-6">
	                <ol class="breadcrumb float-sm-right">
	                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i>
	                            {{ __('menu.home') }}</a></li>
	                    <li class="breadcrumb-item active">{{ __('menu.staff_info') }}</li>
	                    <li class="breadcrumb-item active">{{ __('menu.personal_list') }}</li>
	                </ol>

	            </div>
	        </div>
	    </div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<!-- Profile Image -->
					<div class="card card-primary card-outline">
						<div class="card-body box-profile">
							<div class="text-center">
								<img src="{{ asset('storage/images/staffs/'.$profile->photo) }}" class="profile-user-img img-fluid img-circle" alt="Staff Photo">
							</div>

							<h3 class="profile-username text-center kh">{{ $profile->surname_kh.' '.$profile->name_kh }}</h3>

							<p class="text-muted text-center kh">{{ (!empty($curPos) and !empty($curPos->position)) ? $curPos->position->position_kh : '' }}</p>

							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item">
									<b>@lang('common.payroll_num')</b> <a class="float-right">{{ $profile->payroll_id }}</a>
								</li>

								<li class="list-group-item">
									<b>@lang('common.sex')</b> <a class="float-right">{{ $profile->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</a>
								</li>

								<li class="list-group-item">
									<b>@lang('common.dob')</b> <a class="float-right">{{ date('d-m-Y', strtotime($profile->dob)) }}</a>
								</li>

								<li class="list-group-item">
									<b>@lang('common.current_status')</b> <a class="float-right">{{ $profile->status->status_kh }}</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-9">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-info-circle"></i> @lang('common.basic_info')
							</h3>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.surname_kh') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->surname_kh }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.surname_latin') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->surname_en }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.bankacc_num') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->bank_account }}</div>
									</div>

									@if (!empty($profile->ethnic))

										<div class="row profile-item">
											<div class="col-sm-5 col-xs-5">
												<span class="indent">{{ __('common.ethnic') }}</span>
											</div>
											<div class="col-sm-7">: {{ $profile->ethnic->ethnic_kh }}</div>
										</div>

									@endif
								</div>

								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5">
											<span class="indent">{{ __('common.name_kh') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->name_kh }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5">
											<span class="indent">{{ __('common.name_latin') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->name_en }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.nid') }}</span>
										</div>
										<div class="col-sm-7">: {{ substr($profile->nid_card, 10, 1) == '_' ? substr($profile->nid_card, 0, 9) : $profile->nid_card }}</div>
									</div>
								</div>
							</div>

							<!-- Place of Birth -->
							<h3 class="card-sub-title">{{ __('ទីកន្លែងកំណើត') }}</h3>

							<div class="row">
								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.village') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->birth_village }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.district') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->birth_district }}</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.commune') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->birth_commune }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.province') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->birthProvince->name_kh }}</div>
									</div>
								</div>
							</div>

							<!-- Work info -->
							<h3 class="card-sub-title">{{ __('common.datestart_work') }}</h3>

							<div class="row">
								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.start_date') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->start_date > 0 ? date('d-m-Y', strtotime($profile->start_date)) : '' }}</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.appointment_date') }}</span>
										</div>
										<div class="col-sm-7">: {{ $profile->appointment_date > 0 ? date('d-m-Y', strtotime($profile->appointment_date)) : '' }}</div>
									</div>
								</div>
							</div>

							<!-- Current working place -->
							<h3 class="card-sub-title">{{ __('common.current_location') }}</h3>

							<div class="row">
								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.work_place') }}</span>
										</div>
										<div class="col-sm-7">: {{ !empty($curPos->location) ? $curPos->location->location_kh : '' }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.village') }}</span>
										</div>
										<div class="col-sm-7">: {{ !empty($curPos->location->village) ? $curPos->location->village->name_kh : '' }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.district') }}</span>
										</div>
										<div class="col-sm-7">: {{ !empty($curPos->location->district) ? $curPos->location->district->name_kh : '' }}</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">@lang('common.office')</span>
										</div>
										<div class="col-sm-7">: {{ !empty($curPos->office) ? $curPos->office->office_kh : '' }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.commune') }}</span>
										</div>
										<div class="col-sm-7">: {{ !empty($curPos->location->commune) ? $curPos->location->commune->name_kh : '' }}</div>
									</div>

									<div class="row profile-item">
										<div class="col-sm-5 col-xs-5">
											<span class="indent">{{ __('common.province') }}</span>
										</div>
										<div class="col-sm-7">: {{ !empty($curPos->location->province) ? $curPos->location->province->name_kh : '' }}</div>
									</div>
								</div>
							</div>

							<!-- Salary info -->
							<h3 class="card-sub-title">{{ __('common.official_rank_degree') }}</h3>

						</div> <!-- .card-body -->
					</div> <!-- .card-primary -->

					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-building"></i> @lang('menu.work_history')
							</h3>
						</div>

						<div class="card-body">
							<div class="table-responsive">
                                <table class="table table-bordered table-head-fixed text-nowrap">
                                    <thead>
                                        <th>#</th>
                                        <th>@lang('common.description')</th>
                                        <th>@lang('common.cur_position')</th>
                                        <th>@lang('common.start_date')</th>
                                        <th>@lang('common.end_date')</th>
                                    </thead>

                                    <tbody>
                                        
                                        @foreach($workHistories as $index => $workHistory)

                                            <tr id="record-{{ $workHistory->workhis_id }}">
                                                <td>{{ $index +  1 }}</td>
                                                <td class="kh">{{ $workHistory->description }}</td>

                                                <td class="text-center">
                                                    @if( $workHistory->cur_pos == 1 )
                                                        <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                                                    @else
                                                        <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                                                    @endif
                                                </td>

                                                <td>{{ $workHistory->start_date > 0 ? date('d-m-Y', strtotime($workHistory->start_date)) : '' }}</td>

                                                <td>{{ $workHistory->end_date > 0 ? date('d-m-Y', strtotime($workHistory->end_date)) : '' }}</td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
						</div> <!-- .card-body -->
					</div> <!-- .card-primary -->
				</div>
			</div>
		</div>
	</section>

@endsection
