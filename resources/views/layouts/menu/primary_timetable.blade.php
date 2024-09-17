<li id="timetable_primary_1" class="nav-item">
    <a href="{{ route('timetable.createFirstPrimaryTimetable', [app()->getLocale(), '13']) }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>{{ __('menu.timetable_primary_1') }}</p>
    </a>
</li>

<li id="timetable_primary_2" class="nav-item">
    <a href="{{ route('timetable.createSecondPrimaryTimetable', [app()->getLocale(), '24']) }}" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>{{ __('menu.timetable_primary_2') }}</p>
    </a>
</li>
