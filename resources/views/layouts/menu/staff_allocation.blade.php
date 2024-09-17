@if (auth()->user()->can('view-manage-staff-allocation'))

	<li id="staff-allocation-menu" class="nav-item">
        <a href="{{ route('staff-allocation.index', app()->getLocale()) }}" class="nav-link">
            <i class="nav-icon fas fa-book-reader"></i>
            <p>@lang('menu.staff_allocation')</p>
        </a>
    </li>

@endif
