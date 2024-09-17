<div class="table-responsive" style="margin-top:20px;">
    <table class="table table-hover table-bordered table-head-fixed text-nowrap">
        <thead>
            <tr>
                <th>{{ __('login.module_name') }}</th>
                <th class="text-center">{{ __('login.read') }}</th>
                <th class="text-center">{{ __('login.create') }}</th>
                <th class="text-center">{{ __('login.update') }}</th>
                <th class="text-center">{{ __('login.delete') }}</th>
            </tr>
        </thead>

        @php

        $permission_items = [
            ['ពត៌មានបុគ្គលិក', 'staffs', 1, 1, 1, 1],
            ['ពត៌មានបុគ្គលិកកិច្ចសន្យា', 'cont-staffs', 1, 1, 1, 1],
            ['ពត៌មានសាលារៀន', 'schools', 1, 1, 1, 1],
            ['ព័ត៌មានគរុសិស្ស-និស្សិត', 'trainee-teacher', 1, 1, 1, 1],
            ['បញ្ជីគ្រូចេញថ្មី', 'trainee-teacher-list', 1, 0, 1, 0],
            ['អ្នកផ្តល់សេវា អវប (CPD)', 'cpd-provider', 1, 1, 1, 1],
            ['Scheduled CPD Offerings', 'cpd-schedule-course', 1, 1, 1, 1],
            ['CPD Offerings', 'cpd-structured-course', 1, 1, 1, 1],
            ['គ្រប់គ្រងការចុះឈ្មោះអ្នកប្រើប្រាស់ក្នុងប្រព័ន្ធ', 'manage-user-registration', 1, 0, 0, 0],
            ['គ្រប់គ្រង Multi-Criteria Search', 'manage-multi-criteria-search', 1, 0, 0, 0],
            ['មើលរបាយការណ៍ & តារាងទិន្នន័យ', 'report-and-chart', 1, 0, 0, 0],
            ['គ្រប់គ្រង ម៉ូឌុលគន្លងអាជីព', 'tcp-appraisal', 1, 1, 1, 1],
            ['ត្រួតពិនិត្យការស្នើសុំគន្លងអាជីព', 'tcp-appraisal-requests', 1, 0, 0, 0],
            ['គ្រប់គ្រងកាលវិភាគ', 'manage-timetables', 1, 0, 0, 0], 
            ['គ្រប់គ្រងរបាយការណ៍លើសខ្វះគ្រូ', 'manage-staff-allocation', 1, 0, 0, 0],
        ];

        @endphp

        <tbody>

            @foreach($permission_items as $index => $permissions)

                @php
                    $view = 'view-'.$permissions[1];
                    $create = 'create-'.$permissions[1];
                    $update = 'edit-'.$permissions[1];
                    $delete = 'delete-'.$permissions[1];
                @endphp

                <tr>
                    <td>{{ $permissions[0] }}</td>

                    <td class="text-center">
                        @if ($permissions[2] == 1)
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="{{ $view }}" id="{{ $view }}" 
                                    value="1" {{ (isset($role) and $role->can($view)) ? 'checked' : '' }}>
                                <label for="{{ $view }}"></label>
                            </div>
                        @endif
                    </td>

                    <td class="text-center">
                        @if ($permissions[3] == 1)
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="{{ $create }}" id="{{ $create }}" 
                                    value="1" {{ (isset($role) and $role->can($create)) ? 'checked' : '' }}>
                                <label for="{{ $create }}"></label>
                            </div>
                        @endif
                    </td>

                    <td class="text-center">
                        @if ($permissions[4] == 1)
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="{{ $update }}" id="{{ $update }}" 
                                    value="1" {{ (isset($role) and $role->can($update)) ? 'checked' : '' }}>
                                <label for="{{ $update }}"></label>
                            </div>
                        @endif
                    </td>

                    <td class="text-center">
                        @if ($permissions[5] == 1)
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="{{ $delete }}" id="{{ $delete }}" 
                                    value="1" {{ (isset($role) and $role->can($delete)) ? 'checked' : '' }}>
                                <label for="{{ $delete }}"></label>
                            </div>
                        @endif
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
</div>
