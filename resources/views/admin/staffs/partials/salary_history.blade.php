<div class="col-sm-12" style="margin-bottom:15px;">
	<div class="card card-default">
		<div class="card-header">
			<h4 style="border-bottom:none;margin-bottom:0px;">
				<span class="section-num">@lang('number.num5').</span>
            	{{ __('common.official_rank_degree') }}
            </h4>
		</div>

		<div class="card-body" style="padding-bottom:0;">
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-head-fixed text-nowrap">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ __('staff.cardretype') }}</th>
							<th class="text-center">{{ __('common.salary_type') }}</th>
							<th>{{ __('common.degree') }}</th>
							<th>{{ __('common.promotion_date_cycle') }}</th>
							<th>{{ __('common.sign_date') }}</th>
							<th>{{ __('common.rank_num') }}</th>
							<th>សំណើដំឡើងថ្នាក់</th>
							<th></th>
						</tr>
					</thead>

					@foreach ($staff->staffSalaries()->orderBy('salary_type_shift_date', 'Desc')->get() as $index => $staffSalary)

						<tr id="salary-{{$staffSalary->staff_sal_id}}">
							<td>{{ $index + 1 }}</td>
							<td class="kh">{{ !empty($staffSalary->cardreType) ? $staffSalary->cardreType->cardre_type_kh : '' }}</td>
							<td class="kh text-center">{{ !empty($staffSalary->salaryLevel) ? $staffSalary->salaryLevel->salary_level_kh : '' }}</td>
							<td>{{ $staffSalary->salary_degree }}</td>
							@if($staffSalary->request_cardre_check_status == 1)
								<td></td><td></td><td></td>
							@else
								<td>{{ $staffSalary->salary_type_shift_date > 0 ? date('d-m-Y', strtotime($staffSalary->salary_type_shift_date)) : '' }}</td>
								<td>{{ $staffSalary->salary_type_signdate > 0 ? date('d-m-Y', strtotime($staffSalary->salary_type_signdate)) : '' }}</td>
								<td class="text-center">{{ $staffSalary->salary_type_prokah_order }}</td>
							@endif
							<td>
								@if($staffSalary->request_cardre_check_status == 1)
									<span class="btn-xxs btn-info" style="padding: 2px 6px; border-radius: 2px; font-size: 12px;">បានបញ្ជូន</span>
								@elseif($staffSalary->request_cardre_check_status == 5)
									<span class="btn-xxs btn-success" style="padding: 2px 6px; border-radius: 2px; font-size: 12px;">បានឯកភាព</span>
								@endif 
							</td>
							<td class="text-left">
								
									<button type="button" class="btn btn-xs btn-info btn-edit-salary" data-edit-url="{{ route('salary-histories.edit', [app()->getLocale(), $staffSalary->staff_sal_id]) }}" data-update-url="{{ route('salary-histories.update', [app()->getLocale(), $staffSalary->staff_sal_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>
									
										<button type="button" class="btn btn-xs btn-danger btn-delete" data-route="{{ route('salary-histories.destroy', [app()->getLocale(), $staffSalary->staff_sal_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
									
							</td>
						</tr>

					@endforeach
				</table>
			</div>
		</div>

		<div class="card-footer text-right">
			@if (!isset($request_cardre_check_status))        
				<button type="button" id="btn-add-salary" class="btn btn-sm btn-primary" data-add-url="{{ route('salary-histories.store', app()->getLocale()) }}" style="width:120px;">
					<i class="fa fa-plus"></i> @lang('button.add')
				</button>
			@endif
		</div>
	</div>
</div>
