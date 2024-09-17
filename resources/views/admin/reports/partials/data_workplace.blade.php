<p style="margin-top:5px;margin-bottom:0px;">
    {{ __('common.work_place').'៖' }} <span style="font-family: 'Moul', 'Arial';margin-right:20px;">
        {{ $staffs[$i]->workplace_kh }}
    </span>
    {{ __('school.id').'៖ ' }} <span style="margin-right:20px;">{{ $staffs[$i]->location_code }}</span>
    {{ __('common.province').'៖ ' }} <span style="margin-right:20px;">{{ $staffs[$i]->province_kh }}</span>
    {{ __('common.district').'៖ ' }} <span style="margin-right:20px;">{{ $staffs[$i]->district_kh }}</span>
    {{ __('common.commune').'៖ ' }} <span style="margin-right:0px;">{{ $staffs[$i]->commune_kh }}</span>
</p>