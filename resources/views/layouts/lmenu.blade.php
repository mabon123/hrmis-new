<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-navy elevation-4">
    <a href="{{ route('index', app()->getLocale()) }}" id="brand_link" class="brand-link">
        <img src="{{ asset('images/moeys-logo.png') }}" alt="Moeys Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">@lang('menu.hrmis_long')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Users: POE, DOE & School Admin -->
                @if (Auth::user()->hasRole('administrator', 'school-admin', 'dept-admin', 'doe-admin', 'poe-admin', 'central-admin', 'leader'))

                <li id="personal-list" class="nav-item">
                    <a href="{{ route('staffs.index', app()->getLocale()) }}" class="nav-link" onclick="loading();">
                        <i class="nav-icon fas fa-users"></i>
                        <p>@lang('menu.personal_list')</p>
                    </a>
                </li>

                @if (auth()->user()->can('create-staffs'))
                <li id="create-staff" class="nav-item">
                    <a href="{{ route('staffs.create', app()->getLocale()) }}" class="nav-link" onclick="loading();">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>@lang('menu.new_staff')</p>
                    </a>
                </li>
                @endif

                <!-- Contract Teacher -->
                @if (auth()->user()->hasRole('administrator'))
                    <li id="contract-teacher" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                @lang('menu.contract_teacher_info')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li id="new-contract-teacher" class="nav-item">
                                <a href="{{ route('contract-teachers.create', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.new_contract_teacher')</p>
                                </a>
                            </li>

                            <li id="contract-teacher-listing" class="nav-item">
                                <a href="{{ route('contract-teachers.index', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.contract_teaching_listing')</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                @elseif (Auth::user()->hasRole('school-admin', 'dept-admin', 'doe-admin', 'poe-admin', 'central-admin', 'leader'))
                    <li id="contract-teacher-listing" class="nav-item">
                        <a href="{{ route('contract-teachers.index', app()->getLocale()) }}" class="nav-link" onclick="loading()">
                            <i class="nav-icon fas fa-users"></i>
                            <p>@lang('menu.contract_teaching_listing')</p>
                        </a>
                    </li>

                    @if (auth()->user()->can('create-cont-staffs'))
                        <li id="new-contract-teacher" class="nav-item">
                            <a href="{{ route('contract-teachers.create', app()->getLocale()) }}" class="nav-link" onclick="loading()">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>@lang('menu.new_contract_teacher')</p>
                            </a>
                        </li>
                    @endif
                @endif

                @if(auth()->user()->can('view-trainee-teacher-list') && !auth()->user()->hasRole('administrator') && (!auth()->user()->hasRole('dept-admin') || (auth()->user()->hasRole('dept-admin') && auth()->user()->is_ttd_or_doper)))
                <li id="staff-trainee-list" class="nav-item">
                    <a href="{{ route('staffs.trainee-list', app()->getLocale()) }}" class="nav-link" onclick="loading()">
                        <i class="nav-icon fas fa-users"></i>
                        <p>@lang('menu.staff_trainee_list')</p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->can('view-trainee-teacher') && (auth()->user()->is_ttd_or_doper || auth()->user()->is_ttc))
                <li id="trainee-teacher-list" class="nav-item">
                    <a href="{{ route('trainees.index', app()->getLocale()) }}" class="nav-link" onclick="loading()">
                        <i class="nav-icon fas fa-users"></i>
                        <p>@lang('menu.trainee_teacher_list')</p>
                    </a>
                </li>

                @if (auth()->user()->can('create-trainee-teacher') && auth()->user()->is_ttc)
                <li id="create-trainee-teacher-menu" class="nav-item">
                    <a href="{{ route('trainees.create', app()->getLocale()) }}" class="nav-link" onclick="loading()">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>@lang('menu.new_trainee_teacher')</p>
                    </a>
                </li>
                @endif
                @endif

                <!-- POE & DOE Administrator -->
                @if (auth()->user()->hasRole('administrator', 'poe-admin','doe-admin') or auth()->user()->can('view-schools'))
                <li id="location-list" class="nav-item">
                    <a href="{{ route('schools.index', app()->getLocale()) }}" class="nav-link {{ in_array(\Route::currentRouteName(), ['schools.index']) ? 'active' : '' }}" onclick="loading()">
                        <i class="nav-icon fas fa-building"></i>
                        <p>@lang('menu.school_list')</p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasRole('administrator', 'poe-admin','doe-admin') or auth()->user()->can('create-schools'))
                <li id="create-location" class="nav-item">
                    <a href="{{ route('schools.create', app()->getLocale()) }}" class="nav-link" onclick="loading()">
                        <i class="nav-icon fas fa-building"></i>
                        <p>@lang('menu.new_school')</p>
                    </a>
                </li>
                @endif

                @if (auth()->user()->level_id == 5)
                <li id="create-location" class="nav-item">
                    <a href="{{ route('schools.edit', [app()->getLocale(), auth()->user()->work_place->location_code]) }}" class="nav-link {{ in_array(\Route::currentRouteName(), ['schools.index']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>@lang('menu.school_info')</p>
                    </a>
                </li>
                @endif

                <!-- Reports -->
                @if (auth()->user()->hasRole('administrator') or auth()->user()->can('view-report-and-chart'))
                <li id="reports-page" class="nav-item">
                    <a href="{{ route('reports.index', app()->getLocale()) }}" class="nav-link" onclick="loading()">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>@lang('menu.report_and_chart')</p>
                    </a>
                </li>
                @endif

                <!-- CPD Provider -->
                @elseif (auth()->user()->hasRole('cpd_provider'))
                <li id="schedule-course-list" class="nav-item">
                    <a href="{{ route('cpd-schedule-courses.index', app()->getLocale()) }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p style="font-size:14px;">@lang('menu.schedule_course_list')</p>
                    </a>
                </li>

                <li id="create-schedule-course" class="nav-item">
                    <a href="{{ route('cpd-schedule-courses.create', app()->getLocale()) }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-plus"></i>
                        <p>@lang('menu.new_schedule_course')</p>
                    </a>
                </li>

                <li id="cpd-credits-list" class="nav-item">
                    <a href="{{ route('cpd-credits.index', app()->getLocale()) }}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p style="font-size:14px;">@lang('menu.cpd_credited_offerings_list')</p>
                    </a>
                </li>

                <li id="create-cpd-credit" class="nav-item">
                    <a href="{{ route('cpd-credits.create', app()->getLocale()) }}" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>@lang('menu.add_staff_received_credits')</p>
                    </a>
                </li>
                @endif

                <!-- Multi-Criteria Search -->
                @if (auth()->user()->can('view-manage-multi-criteria-search'))
                    <li id="multi-criteria-search-menu" class="nav-item">
                        <a href="{{ route('multi-criteria-search.index', app()->getLocale()) }}" class="nav-link">
                            <i class="nav-icon fas fa-laptop-code"></i>
                            <p>@lang('menu.manage_multi_criteria_search')</p>
                        </a>
                    </li>
                @endif

                <!-- Timetables -->
                @include('layouts.menu.timetables')

                <!-- Staff allocation report -->
                @include('layouts.menu.staff_allocation')

                <!-- Only system administrator user can access these below menu -->
                @if (auth()->user()->hasRole('administrator'))
                    <!-- CPD Modules -->
                    <li class="nav-header">@lang('menu.cpd_module')</li>

                    <li id="cpd-pending-list" class="nav-item">
                        <a href="{{ route('cpd-credits.cpd-pending-list', app()->getLocale()) }}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>@lang('menu.pending_cpd_offerings_list')</p>
                        </a>
                    </li>

                    <li id="cpd-provider" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                @lang('menu.cpd_provider')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li id="create-provider" class="nav-item">
                                <a href="{{ route('cpd-providers.create', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.new_provider')</p>
                                </a>
                            </li>

                            <li id="provider-list" class="nav-item">
                                <a href="{{ route('cpd-providers.index', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.provider_list')</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li id="cdp_field_of_study" class="nav-item">
                        <a href="{{ route('cpd-field-of-studies.index', app()->getLocale()) }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>@lang('cpd.field_of_study')</p>
                        </a>
                    </li>

                    <li id="subject-study" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                @lang('menu.subject_of_study')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li id="create-subject-study" class="nav-item">
                                <a href="{{ route('subject-of-study.create', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.new_subject_study')</p>
                                </a>
                            </li>

                            <li id="subject-study-list" class="nav-item">
                                <a href="{{ route('subject-of-study.index', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.subject_study_list')</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li id="structured-course" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                @lang('menu.cpd_structured_course')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li id="create-structured-course" class="nav-item">
                                <a href="{{ route('cpd-courses.create', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.new_structured_course')</p>
                                </a>
                            </li>

                            <li id="structured-course-list" class="nav-item">
                                <a href="{{ route('cpd-courses.index', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.structured_course_list')</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li id="schedule-course" class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                @lang('menu.cpd_schedule_course')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li id="create-schedule-course" class="nav-item">
                                <a href="{{ route('cpd-schedule-courses.create', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>@lang('menu.new_schedule_course')</p>
                                </a>
                            </li>

                            <li id="schedule-course-list" class="nav-item">
                                <a href="{{ route('cpd-schedule-courses.index', app()->getLocale()) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p style="font-size:14px;">@lang('menu.schedule_course_list')</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- TCP Modules -->
                @if(auth()->user()->can('view-tcp-appraisal-requests') || auth()->user()->can('view-tcp-appraisal'))
                <li class="nav-header">@lang('menu.tcp_module')</li>
                @endif

                @if(auth()->user()->can('view-tcp-appraisal-requests') &&
                (auth()->user()->level_id==1 || auth()->user()->level_id==3 || auth()->user()->level_id==4))
                <li id="view-tcp-appraisals" class="nav-item">
                    <a href="{{ route('tcp-appraisals.view-tcp-appraisals', app()->getLocale()) }}" class="nav-link" onclick="loading();">
                        <i class="nav-icon fas fa-exclamation"></i>
                        <p>@lang('menu.view_tcp_appraisals')</p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('view-tcp-appraisal'))
                <li id="tcp-appraisals-list" class="nav-item">
                    <a href="{{ route('tcp-appraisals.index', app()->getLocale()) }}" class="nav-link" onclick="loading();">
                        <i class="nav-icon fas fa-list"></i>
                        <p>@lang('menu.tcp_appraisals_list')</p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->can('create-tcp-appraisal'))
                <li id="create-new-tcp-appraisal" class="nav-item">
                    <a href="{{ route('tcp-appraisals.create', app()->getLocale()) }}" class="nav-link" onclick="loading();">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>@lang('menu.new_tcp_appraisal')</p>
                    </a>
                </li>
                @endif

                <!-- ADMINISTRATIVE SECTION -->
                @if (Auth::user()->hasRole('administrator'))
                <li class="nav-header">@lang('menu.data_administration_tool')</li>

                <li id="gen-management" class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            @lang('menu.data_administration')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Office -->
                        <li id="office" class="nav-item">
                            <a href="{{ route('offices.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.office')</p>
                            </a>
                        </li>

                        <!-- Office Location -->
                        <li id="office-location" class="nav-item">
                            <a href="{{ route('office-locations.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.office_location')</p>
                            </a>
                        </li>

                        <!-- Official Rank -->
                        <li id="official-rank" class="nav-item">
                            <a href="{{ route('official-ranks.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.official_rank')</p>
                            </a>
                        </li>

                        <!-- Position -->
                        <li id="position" class="nav-item">
                            <a href="{{ route('positions.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.position')</p>
                            </a>
                        </li>

                        <!-- Position Category -->
                        <li id="position-category" class="nav-item">
                            <a href="{{ route('position-categories.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.position_category')</p>
                            </a>
                        </li>

                        <!-- Position Level -->
                        <li id="position-level" class="nav-item">
                            <a href="{{ route('position-levels.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.position_level')</p>
                            </a>
                        </li>

                        <!-- Qualification -->
                        <li id="qualification" class="nav-item">
                            <a href="{{ route('qualification-codes.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.qualifiction')</p>
                            </a>
                        </li>

                        <!-- Subject -->
                        <li id="subject" class="nav-item">
                            <a href="{{ route('subjects.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.subject')</p>
                            </a>
                        </li>

                        <!-- Professional category -->
                        <li id="professional-category" class="nav-item">
                            <a href="{{ route('professional-category.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.professional_category')</p>
                            </a>
                        </li>

                        <!-- Professional type -->
                        <li id="professional-type" class="nav-item">
                            <a href="{{ route('professional-type.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.professional_type')</p>
                            </a>
                        </li>

                        <!-- Location Type -->
                        <li id="location-type" class="nav-item">
                            <a href="{{ route('location-types.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.location_type')</p>
                            </a>
                        </li>

                        <!-- Others -->
                        <li id="others" class="nav-item">
                            <a href="{{ route('page.othertools', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.others') <i class="far fa-arrow-alt-circle-right"></i></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User management -->
                <li id="user" class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            @lang('menu.user_and_permission')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <!-- Create new user -->
                        <li id="create-user" class="nav-item">
                            <a href="{{ route('users.create', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('login.create_user')</p>
                            </a>
                        </li>

                        <li id="manage-user" class="nav-item">
                            <a href="{{ route('users.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.manage_user')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User role -->
                <li id="user-role" class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            @lang('menu.manage_role_permission')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li id="create-role" class="nav-item">
                            <a href="{{ route('roles.create', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('login.create_role')</p>
                            </a>
                        </li>

                        <li id="manage-role" class="nav-item">
                            <a href="{{ route('roles.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('login.manage_role')</p>
                            </a>
                        </li>

                        <li id="manage-permission" class="nav-item">
                            <a href="{{ route('permissions.index', app()->getLocale()) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('menu.manage_permission')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>