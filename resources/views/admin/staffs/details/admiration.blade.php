<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <strong>{{ __('number.num8').'. '.__('menu.group_admiration') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admiration/Blame listing-->
<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th style="width:650px;">{{ __('common.admiration_type') }}</th>
                    <th>{{ __('common.provided_by') }}</th>
                    <th>{{ __('common.date_obtained') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($staffAdmirations as $staffAdmiration)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ $staffAdmiration->admiration }}</td>
                        <td>{{ !empty($staffAdmiration->admirationSource) ? $staffAdmiration->admirationSource->source_kh : '' }}</td>
                        <td>{{ $staffAdmiration->admiration_date > 0 ? date('d-m-Y', strtotime($staffAdmiration->admiration_date)) : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
