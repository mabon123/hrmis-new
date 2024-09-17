<div class="table-responsive">
    <table class="table table-bordered table-head-fixed text-nowrap">
        <thead>
            <th>#</th>
            <th>@lang('common.professional_level')</th>
            <th>@lang('common.current_location')</th>
            <th>@lang('common.cur_position')</th>
            <th>@lang('common.start_date')</th>
            <th>@lang('common.end_date')</th>
            <th></th>
        </thead>

        <tbody>
            
            @foreach($workHistories as $index => $workHistory)

                <tr id="record-{{ $workHistory->constaff_his_id }}">
                    <td>{{ $index +  1 }}</td>

                    <td class="kh">{{ !empty($workHistory->position) ? $workHistory->position->position_kh : '' }}</td>

                    <td class="kh">{{ !empty($workHistory->location) ? $workHistory->location->location_kh : '' }}</td>

                    <td class="text-center">
                        @if( $workHistory->curpos == 1 )
                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                        @else
                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                        @endif
                    </td>

                    <td>{{ $workHistory->start_date > 0 ? date('d-m-Y', strtotime($workHistory->start_date)) : '' }}</td>

                    <td>{{ $workHistory->end_date > 0 ? date('d-m-Y', strtotime($workHistory->end_date)) : '' }}</td>

                    <td class="text-right">
                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('contract-teachers.work-histories.edit', [app()->getLocale(), $contract_teacher->contstaff_payroll_id, $workHistory->constaff_his_id]) }}" data-update-url="{{ route('contract-teachers.work-histories.update', [app()->getLocale(), $contract_teacher->contstaff_payroll_id, $workHistory->constaff_his_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                        <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $workHistory->constaff_his_id }}" data-delete-url="{{ route('contract-teachers.work-histories.destroy', [app()->getLocale(), $contract_teacher->contstaff_payroll_id, $workHistory->constaff_his_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
</div>
