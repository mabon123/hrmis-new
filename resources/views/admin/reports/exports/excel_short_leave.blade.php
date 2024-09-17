<h1 class="text-center"> {{ __('បញ្ជីរាយនាមបុគ្គលិកអប់រំដែលសុំច្បាប់រយៈពេលខ្លី') }}</h1>
<table class="table table-bordered table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th>{{ __('ល.រ') }}</th>
            <th>{{ __('common.payroll_num') }}</th>
            <th>{{ __('common.name') }}</th>
            <th>{{ __('common.sex') }}</th>
            <th>{{ __('common.dob') }}</th>
            <th>{{ __('common.position') }}</th>
            <th>{{ __('ចំនួនថ្ងៃសុំច្បាប់') }}</th>
            <th>{{ __('common.start_date') }}</th>
            <th>{{ __('common.end_date') }}</th>
            <th>{{ __('មូលហេតុ') }}</th>
            <th>{{ __('common.location') }}</th>
            <th>{{ __('ផ្សេងៗ') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach($staffs as $index => $staff)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $staff->payroll_id }}</td>
            <td class="kh">{{ $staff->surname_kh.' '.$staff->name_kh }}</td>
            <td class="kh">{{ $staff->sex == 1 ? 'ប្រុស' : 'ស្រី' }}</td>
            <td>{{ date('d-m-Y', strtotime($staff->dob)) }}</td>
            <td class="kh">
                {{ $staff->is_cont_staff == 1 ? $staff->contractPosition()->contract_type_kh : $staff->currentPosition()->position_kh }}
            </td>
            <td>{{ $staff->days }}</td>
            <td>{{ date('d-m-Y', strtotime($staff->start_date)) }}</td>
            <td>{{ date('d-m-Y', strtotime($staff->end_date)) }}</td>
            <td class="kh">{{ $staff->description }}</td>
            <td class="kh">{{ !empty($staff->currentWorkPlace()) ? $staff->currentWorkPlace()->location_kh : (!empty($staff->latestWorkPlace()) ? $staff->latestWorkPlace()->location_kh : '---') }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>