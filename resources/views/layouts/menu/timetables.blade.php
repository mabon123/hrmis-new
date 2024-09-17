@if (auth()->user()->can('view-manage-timetables'))
    <li id="timetables-section" class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
                @lang('menu.manage_timetables')
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            <!-- Grade -->
            <li id="manage-grades" class="nav-item">
                <a href="{{ route('tgrades.index', app()->getLocale()) }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>@lang('menu.manage_grades')</p>
                </a>
            </li>

            <!-- Lower Secondary School -->
            @if (auth()->user()->work_place->location_type_id == 10 || auth()->user()->work_place->location_type_id == 15)
                @if (auth()->user()->work_place->multi_level_edu > 0)
                    @include('layouts.menu.teacher_primary')
                @endif

                <!-- Teacher Subject -->
                <li id="teacher-subjects" class="nav-item">
                    <a href="{{ route('teacher-subjects.index', app()->getLocale()) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>@lang('menu.manage_teacher_secondary')</p>
                    </a>
                </li>

            <!-- Upper Secondary School -->
            @elseif (auth()->user()->work_place->location_type_id == 5 || auth()->user()->work_place->location_type_id == 14)
                @if (auth()->user()->work_place->multi_level_edu >= 2)
                    @include('layouts.menu.teacher_primary')
                @endif

                <li id="teacher-subjects" class="nav-item">
                    <a href="{{ route('teacher-subjects.index', app()->getLocale()) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>@lang('menu.manage_teacher_secondary')</p>
                    </a>
                </li>

            <!-- Primary School -->
            @else
                @include('layouts.menu.teacher_primary')
            @endif


            <!-- =================================================================================================== -->


            <!-- Pre-School -->
            @if (auth()->user()->work_place->location_type_id == 18)
                @include('layouts.menu.pre_timetable')

            <!-- Primary School -->
            @elseif (auth()->user()->work_place->location_type_id == 11 || auth()->user()->work_place->location_type_id == 17)
                @if (auth()->user()->work_place->multi_level_edu == 1)
                    @include('layouts.menu.pre_timetable')
                @endif

                @include('layouts.menu.primary_timetable')

            <!-- Lower Secondary School -->
            @elseif (auth()->user()->work_place->location_type_id == 15 || auth()->user()->work_place->location_type_id == 10)
                @if (auth()->user()->work_place->multi_level_edu == 2)
                    @include('layouts.menu.pre_timetable')
                    @include('layouts.menu.primary_timetable')

                @elseif (auth()->user()->work_place->multi_level_edu == 1)
                    @include('layouts.menu.primary_timetable')
                @endif

                <li id="timetable" class="nav-item">
                    <a href="{{ route('timetable.create', app()->getLocale()) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>@lang('menu.timetable')</p>
                    </a>
                </li>

            <!-- Upper Secondary School -->
            @else
                @if (auth()->user()->work_place->multi_level_edu == 3)
                    @include('layouts.menu.pre_timetable')
                    @include('layouts.menu.primary_timetable')

                @elseif (auth()->user()->work_place->multi_level_edu == 2)
                    @include('layouts.menu.primary_timetable')
                @endif

                <li id="timetable" class="nav-item">
                    <a href="{{ route('timetable.create', app()->getLocale()) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>@lang('menu.timetable')</p>
                    </a>
                </li>
            @endif

            @if (auth()->user()->work_place->location_type_id == 10 || auth()->user()->work_place->location_type_id == 15 || 
                auth()->user()->work_place->location_type_id == 9 || auth()->user()->work_place->location_type_id == 14)
                <li id="all-teacher-student" class="nav-item">
                    <a href="{{ route('timetable.printTeacherStudentTimetable', app()->getLocale()) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('កាលវិភាគរួម គ្រូ-សិស្ស') }}</p>
                    </a>
                </li>

                <li id="all-teacher-student" class="nav-item">
                    <a href="{{ route('timetable.printBulkTeacherTimetable', app()->getLocale()) }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('កាលវិភាគគ្រូប្រចាំសប្តាហ៍') }}</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
