<table class="table table-bordered table-striped table-head-fixed text-nowrap">
	<thead>
        <tr>
            <th class="text-center kh" colspan="13"></th>
            <th class="kh" colspan="2" style="width:5%;">{{ __('ជាក់ស្តែង') }}</th>
            <th class="kh" colspan="2" style="width:5%;">{{ __('តាមនិយាម') }}</th>
        </tr>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('បុគ្គលិកទីចាត់ការ') }}</th>
            <th class="text-center kh" colspan="2">{{ __('គ្រូ.ឧត្តម') }}</th>
            <th class="text-center kh" colspan="2">{{ __('គ្រូ.មូលដ្ឋាន') }}</th>
            <th class="text-center kh" colspan="2">{{ __('កីឡា') }}</th>
            <th class="text-center kh" colspan="2">{{ __('បឋម') }}</th>
            <th class="text-center kh" colspan="2">{{ __('មត្តេយ្យ') }}</th>
            <th class="text-center kh" colspan="2">{{ __('សរុប') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('លើស/ខ្វះ') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('តម្រូវការ') }}</th>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;transform:rotate(-90deg);">{{ __('លើស/ខ្វះ') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
        </tr>
    </thead>

    <tbody>
    	@php 
    		$positions = ['នាយក', 'នាយក', 'លេខាធិការ', 'បណ្ណារក្ស', 'បេឡា', 'គណនេយ្យ', 'ទទួលបន្ទុកយុវជន', 
    						'បរិវច្ឆការី / ពិសោធន៍', 'ឆ្មាំ', 'បុគ្គលិកផ្សេងទៀត']; 
    	@endphp

    	@foreach ($positions as $position)
    		<tr>
    			<td class="kh">{{ $position }}</td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
    			<td class="text-center kh"></td>
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

    	<tr>
			<td class="kh"><strong>{{ __('បុគ្គលិកមិនបង្រៀន') }}</strong></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
		</tr>
		<tr>
			<td class="kh"><strong>{{ __('បុគ្គលិកបង្រៀន') }}</strong></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
		</tr>
		<tr>
			<td class="kh"><strong>{{ __('សរុបរួម') }}</strong></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
			<td class="text-center kh"></td>
		</tr>
    </tbody>
</table>
