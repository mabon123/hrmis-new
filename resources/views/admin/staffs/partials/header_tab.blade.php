<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

    <li class="nav-item">
        <a id="tab-detail" class="nav-link" href="{{ route('staffs.edit', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('common.personal_details') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-workhistory" class="nav-link" href="{{ route('work-histories.index', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('menu.work_history') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-admiration" class="nav-link" href="{{ route('admirations.index', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('menu.group_admiration') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-knowledge" class="nav-link" href="{{ route('general-knowledge.index', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('common.general_knowledge') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-qualification" class="nav-link" href="{{ route('qualifications.index', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('menu.teaching_qualifications') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-shortcourse" class="nav-link" href="{{ route('shortcourses.index', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('menu.short_course_lang') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-family" class="nav-link" href="{{ route('families.index', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('menu.family_details') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-teaching" class="nav-link" href="{{ route('teaching.index', [app()->getLocale(), $staff->payroll_id]) }}">
            {{ __('common.teaching') }}
        </a>
    </li>

</ul>