<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

    <li class="nav-item">
        <a id="tab-detail" class="nav-link"
        	href="{{ route('contract-teachers.edit', [app()->getLocale(), $contract_teacher->payroll_id]) }}">
        	{{ __('menu.contract_teacher_info') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-workhistory" class="nav-link" 
        	href="{{ route('contract-teachers.work-histories.index', [app()->getLocale(),  $contract_teacher->payroll_id]) }}">
            {{ __('menu.work_history') }}
        </a>
    </li>

    <li class="nav-item">
        <a id="tab-teaching" class="nav-link" 
        	href="{{ route('contract-teachers.teaching.index', [app()->getLocale(), $contract_teacher->payroll_id]) }}">
            {{ __('common.teaching') }}
        </a>
    </li>
    
</ul>
