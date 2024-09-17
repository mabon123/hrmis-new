<div class="row">
    <!-- Salary - cardre -->
    <div class="col-sm-5">
        <div class="row profile-item">
            <div class="col-sm-6">
                <strong>{{ __('number.num5').'. '.__('ឋានន្តរស័ក្តិ និងថ្នាក់') }}</strong>
            </div>
            <div class="col-sm">: {{ $staff->salary_level_kh.'.'.$staff->salary_degree_kh }}</div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row profile-item">
            <div class="col-sm-5">{{ __('ថ្ងៃខែឡើងកាំប្រាក់ចុងក្រោយ') }}</div>
            <div class="col-sm">: {{ (!empty($staffSalary) and $staffSalary->salary_type_shift_date > 0) ? 
                date('d-m-Y', strtotime($staffSalary->salary_type_shift_date)) : '' }}</div>
        </div>
    </div>

    <div class="col-sm-10">
        <div class="row">
            <!-- Prokah number -->
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">
                        <span class="indent-2">{{ __('យោង') }}</span>
                    </div>
                    <div class="col-sm-6">: {{ !empty($staffSalary) ? $staffSalary->salary_type_prokah_num : '' }}</div>
                </div>
            </div>

            <!-- Salary signed date -->
            <div class="col-sm-6">
                <div class="row profile-item">
                    <div class="col-sm-6">{{ __('common.sign_date') }}</div>
                    <div class="col-sm-6">: {{ (!empty($staffSalary) and $staffSalary->salary_type_signdate > 0) ? 
                        date('d-m-Y', strtotime($staffSalary->salary_type_signdate)) : '' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary rank number -->
    <div class="col-sm-2">
        <div class="row profile-item">
            <div class="col-sm-6 padding-0">{{ __('common.rank_num') }}</div>
            <div class="col-sm-6">: {{ (!empty($staffSalary) and $staffSalary->salary_type_prokah_order > 0) ? 
                $staffSalary->salary_type_prokah_order : '' }}</div>
        </div>
    </div>
</div>
