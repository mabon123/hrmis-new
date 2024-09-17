<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <strong>{{ __('number.num9').'. '.__('common.general_knowledge') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- General Knowledge Listing-->
<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>{{ __('common.qualification') }}</th>
                    <th>{{ __('common.skill') }}</th>
                    <th>{{ __('common.date_obtained') }}</th>
                    <th>{{ __('common.country') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($staffQualifications as $staffQualification)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ $staffQualification->qualificationCode->qualification_kh }}</td>
                        <td>{{ !empty($staffQualification->subject) ? $staffQualification->subject->subject_kh : '' }}</td>
                        <td>{{ $staffQualification->qual_date > 0 ? date('d-m-Y', strtotime($staffQualification->qual_date)) : '' }}</td>
                        <td>{{ !empty($staffQualification->country) ? $staffQualification->country->country_kh : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
