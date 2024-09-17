<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fa fa-file"></i> {{ __('menu.staff_info') }}
                    @if (isset($staff))
                        <span class="kh" style="font-size:2rem;">- {{ $staff->surname_kh.' '.$staff->name_kh }}</span>
                        <a href="{{ route('staffs.show', [app()->getLocale(), $staff->payroll_id]) }}" 
                            style="margin-left:15px;margin-top:-6px;padding-left:30px;padding-right:30px;" 
                            class="btn btn-success"  target="_blank">
                            <i class="fas fa-print"></i> {{ __('button.print') }}
                        </a>
                    @endif
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('index', app()->getLocale()) }}">
                            <i class="fas fa-tachometer-alt"></i> {{ __('menu.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('staffs.index', app()->getLocale()) }}">
                            @lang('menu.staff_info')</a>
                    </li>
                    @if (isset($staff))
                        <li class="breadcrumb-item active">@lang('staff.edit_staff')</li>
                    @else
                        <li class="breadcrumb-item active">{{ __('menu.new_staff') }}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</section>
