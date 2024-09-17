<div class="col-md-12">
    <h4>{{ __('common.work_history') }}</h4>

    <table class="table table-bordered table-head-fixed text-nowrap">
        <thead>
            <th>#</th>
            <th>@lang('common.description')</th>
            <th>@lang('common.location')</th>
            <th>@lang('common.cur_position')</th>
            <th>@lang('common.start_date')</th>
            <th>@lang('common.end_date')</th>
            <th></th>
        </thead>

        <tbody>
            
            @foreach($workHistories as $index => $workHistory)

                <tr id="record-{{ $workHistory->workhis_id }}">
                    <td>{{ $index +  1 }}</td>
                    <td class="kh">{{ $workHistory->description }}</td>

                    <td class="kh">{{ !empty($workHistory->location) ? $workHistory->location->location_kh : '---' }}</td>

                    <td>
                        @if( $workHistory->cur_pos == 1 )
                            <i class="far fa-check-square" style="color:green;font-size:16px;"></i>
                        @else
                            <i class="far fa-window-close" style="color:red;font-size:16px;"></i>
                        @endif
                    </td>

                    <td>{{ $workHistory->start_date > 0 ? date('d-m-Y', strtotime($workHistory->start_date)) : '' }}</td>

                    <td>{{ $workHistory->end_date > 0 ? date('d-m-Y', strtotime($workHistory->end_date)) : '' }}</td>

                    <td class="text-right">
                        <button type="button" class="btn btn-xs btn-info btn-edit" data-edit-url="{{ route('work-histories.edit', [app()->getLocale(), $workHistory->workhis_id]) }}" data-update-url="{{ route('work-histories.update', [app()->getLocale(), $workHistory->workhis_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>

                        @if( count($workHistories) > 1 and $workHistory->cur_pos == 0 )
                            <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $workHistory->workhis_id }}" data-route="{{ route('work-histories.destroy', [app()->getLocale(), $workHistory->workhis_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                        @endif
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
</div>
