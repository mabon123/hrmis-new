<table class="table table-bordered table-striped table-head-fixed text-nowrap">
	<thead>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('ឆ្នាំសិក្សា') }}</th>
            <th class="text-center kh" colspan="2">{{ __('ក្របខណ្ឌ នឹងបាត់បង់') }}</th>
            <th class="text-center kh" colspan="2">{{ __('គ្រូចេញថ្មី') }}</th>
            <th class="text-center kh" colspan="2">{{ __('ចំនួនថ្នាក់ កើន/ថយ') }}</th>
            <th class="text-center kh" colspan="2">{{ __('ចំនួនគ្រូបង្រៀន លើស /ខ្វះ') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('ឧត្តម') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន') }}</th>
            <th class="text-center kh">{{ __('ឧត្តម') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន') }}</th>
            <th class="text-center kh">{{ __('10-12') }}</th>
            <th class="text-center kh">{{ __('7-9') }}</th>
            <th class="text-center kh">{{ __('ឧត្តម') }}</th>
            <th class="text-center kh">{{ __('ម.ដ្ឋាន') }}</th>
        </tr>
    </thead>

    <tbody>
    	@php 
    		$years = ['2021-2022', '2022-2023', '2023-2024', '2024-2025']; 
    	@endphp

    	@foreach ($years as $year)
    		<tr>
    			<td class="kh">{{ $year }}</td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    		</tr>
    	@endforeach
    </tbody>
</table>
