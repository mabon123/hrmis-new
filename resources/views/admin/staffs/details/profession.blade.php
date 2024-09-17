<div class="row">
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <strong>{{ __('number.num10').'. '.__('qualification.teaching_qual') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Qualification Listing-->
<div class="row">
    <div class="col-sm-12">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>{{__('qualification.prof_skill_desc')}}</th>
                    <th>{{__('qualification.first_subject')}}</th>
                    <th>{{__('qualification.second_subject')}}</th>
                    <th>{{__('qualification.training_sys')}}</th>
                    <th>{{__('qualification.date_obtained')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($staffProfessions as $staffProfession)
                    <tr style="border:1px #ddd solid;border-left:none;border-right:none;">
                        <td>{{ $staffProfession->professionalCategory->prof_category_kh }}</td>
                        <td>{{ !empty($staffProfession->firstSubject) ? $staffProfession->firstSubject->subject_kh : '---' }}</td>
                        <td>{{ !empty($staffProfession->secondSubject) ? $staffProfession->secondSubject->subject_kh : '---' }}</td>
                        <td>{{ !empty($staffProfession->professionalType) ? $staffProfession->professionalType->prof_type_kh : '---' }}</td>
                        <td>{{ $staffProfession->prof_date > 0 ? date('d-m-Y', strtotime($staffProfession->prof_date)) : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
