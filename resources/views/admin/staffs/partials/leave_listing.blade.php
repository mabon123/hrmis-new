<div class="col-sm-12">
    <h4>{{ __('common.maternity_leave') }}</h4>

    <table class="table table-bordered table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>{{__('common.maternity_leave_type')}}</th>
                <th>{{__('common.description')}}</th>
                <th>{{__('common.start_date')}}</th>
                <th>{{__('common.end_date')}}</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            @foreach ($leaveHists as $index => $leaveHist)

            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="kh">{{ !empty($leaveHist->leaveType) ? $leaveHist->leaveType->leave_type_kh : '---' }}</td>
                <td class="kh">{{ $leaveHist->description }}</td>
                <td>{{ date('d-m-Y', strtotime($leaveHist->start_date)) }}</td>
                <td>{{ date('d-m-Y', strtotime($leaveHist->end_date)) }}</td>

                <td class="text-right">
                    <button type="button" class="btn btn-xs btn-info btn-edit-leave" data-edit-url="{{ route('leaves.edit', [app()->getLocale(), $leaveHist->leave_id]) }}" data-update-url="{{ route('leaves.update', [app()->getLocale(), $leaveHist->leave_id]) }}"><i class="far fa-edit"></i> {{ __('button.edit') }}</button>
                    <button type="button" class="btn btn-xs btn-danger btn-delete" value="{{ $leaveHist->workhis_id }}" data-route="{{ route('leaves.destroy', [app()->getLocale(), $leaveHist->leave_id]) }}"><i class="fas fa-trash-alt"></i> {{ __('button.delete') }}</button>
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>
</div>