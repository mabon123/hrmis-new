<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <strong>{{ __('number.num11').'. '.__('common.short_course') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Short Course Listing-->
<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>{{__('common.category')}}</th>
                    <th>{{__('common.skill')}}</th>
                    <th>{{__('common.start_date')}}</th>
                    <th>{{__('common.end_date')}}</th>
                    <th>{{__('common.duration')}}</th>
                    <th>{{__('common.organised_by')}}</th>
                    <th>{{__('common.donor')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($staffShortCourses as $staffShortCourse)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ !empty($staffShortCourse->category) ? $staffShortCourse->category->shortcourse_cat_kh : '' }}</td>
                        <td>{{ $staffShortCourse->qualification }}</td>
                        <td>{{ $staffShortCourse->start_date > 0 ? date('d-m-Y', strtotime($staffShortCourse->start_date)) : '' }}</td>
                        <td>{{ $staffShortCourse->end_date > 0 ? date('d-m-Y', strtotime($staffShortCourse->end_date)) : '' }}</td>
                        <td>{{ $staffShortCourse->duration.' '.(!empty($staffShortCourse->durationType) ? $staffShortCourse->durationType->dur_type_kh : '') }}</td>
                        <td>{{ !empty($staffShortCourse->organizer) ? $staffShortCourse->organizer->partner_type_kh : '' }}</td>
                        <td>{{ !empty($staffShortCourse->donator) ? $staffShortCourse->donator->partner_type_kh : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Languages -->
<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <strong>{{ __('number.num12').'. '.__('common.foreign_language') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Languages Listing-->
<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>{{__('common.languages')}}</th>
                    <th>{{__('common.reading')}}</th>
                    <th>{{__('common.writing')}}</th>
                    <th>{{__('common.conversation')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($staffLanguages as $staffLanguage)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ !empty($staffLanguage->language) ? $staffLanguage->language->language_kh : '' }}</td>
                        <td>{{ $staffLanguage->reading }}</td>
                        <td>{{ $staffLanguage->writing }}</td>
                        <td>{{ $staffLanguage->conversation }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
