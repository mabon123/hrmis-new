<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6"><strong>{{ __('number.num7').'. '.__('common.work_history') }}</strong></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">{{ __('common.current_status') }}</div>
                    <div class="col-sm-6">: {{ $staff->status->status_kh }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th style="width:650px;">{{ __('ការងារបន្តបន្ទាប់') }}</th>
                    <th style="width:650px;">{{ __('common.current_location') }}</th>
                    <th>{{ __('ថ្ងៃចាប់ផ្ដើម') }}</th>
                    <th>{{ __('ថ្ងៃបញ្ចប់') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($staffWorkHistories as $workHistory)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ $workHistory->description }}</td>
                        <td>{{ !empty($workHistory->location) ? $workHistory->location->location_kh : '' }}</td>
                        <td>{{ $workHistory->start_date > 0 ? date('d-m-Y', strtotime($workHistory->start_date)) : '' }}</td>
                        <td>{{ $workHistory->end_date > 0 ? date('d-m-Y', strtotime($workHistory->end_date)) : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Leave Infomration -->
<div class="row">
    <div class="col-sm-10">
        <div class="row profile-item">
            <div class="col-sm-12">
                <strong>{{ __('common.maternity_leave') }}</strong>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th style="width:650px;">{{ __('common.description') }}</th>
                    <th>{{ __('common.start_date') }}</th>
                    <th>{{ __('common.end_date') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($staffLeaves as $staffLeave)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ $staffLeave->description }}</td>
                        <td>{{ date('d-m-Y', strtotime($staffLeave->start_date)) }}</td>
                        <td>{{ date('d-m-Y', strtotime($staffLeave->end_date)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

