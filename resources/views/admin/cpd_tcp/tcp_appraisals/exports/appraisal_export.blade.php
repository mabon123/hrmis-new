@if(!empty($province_name))
<div class="row">
    <h3>{{ __('common.province').' - '. $province_name }}</h3>
</div>
@endif
@if(!empty($district_name))
<div class="row">
    <h3>{{ __('common.district').' - '. $district_name }}</h3>
</div>
@endif
<h1 class="text-center"> {{ __('menu.tcp_appraisals_list'). ' - '.$status_name }} </h1>
<table class="table table-bordered table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('tcp.profession_category') }}</th>
            <th>{{ __('tcp.staff_name') }}</th>
            <th>{{ __('tcp.appraisal_date') }}</th>
            <th>{{ __('common.province') }}</th>
            <th>{{ __('common.district') }}</th>
            <th>{{ __('tcp.in_workplace') }}</th>
            <th>{{ __('tcp.appraisal_score') }}</th>
            <th>{{ __('tcp.profession_rank') }}</th>
            <th>{{ __('tcp.tcp_status') }}</th>
        </tr>
    </thead>

    <tbody id="data_tbody">

        @foreach($appraisals as $index => $appraisal)
        @php
        $total_score = ($appraisal->cat1_score+$appraisal->cat2_score+$appraisal->cat3_score+$appraisal->cat4_score+$appraisal->cat5_score);
        @endphp

        <tr id="record-{{ $appraisal->tcp_appraisal_id }}">
            <td>{{ $index + 1 }}</td>
            <td class="kh"> {{ $appraisal->professionCategory->tcp_prof_cat_kh }}</td>
            <td class="kh">{{ $appraisal->staffInfo->surname_kh.' '.$appraisal->staffInfo->name_kh }}</td>
            <td>{{ date('d-m-Y', strtotime($appraisal->tcp_appraisal_date)) }}</td>
            <td class="kh"> {{ $appraisal->province_name }}</td>
            <td class="kh"> {{ $appraisal->district_name }}</td>
            <td class="kh"> {{ $appraisal->workplace->location_kh }}</td>
            <td>{{ $total_score}}</td>
            <td class="kh"> {{ $appraisal->professionRank->tcp_prof_rank_kh }}</td>
            <td class="kh">{{ $status_name }}</td>
        </tr>

        @endforeach

    </tbody>
</table>