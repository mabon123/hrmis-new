<table class="table table-bordered table-striped table-head-fixed text-nowrap">
	<thead>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('សញ្ញាបត្រ') }}</th>
            <th class="text-center kh" colspan="9">{{ __('ក្របខណ្ឌ និង ឋានន្តរស័ក្តិ') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('ភេទ') }}</th>
            <th class="text-center kh">{{ __('ក.1') }}</th>
            <th class="text-center kh">{{ __('ក.2') }}</th>
            <th class="text-center kh">{{ __('ក.3') }}</th>
            <th class="text-center kh">{{ __('ខ.1') }}</th>
            <th class="text-center kh">{{ __('ខ.2') }}</th>
            <th class="text-center kh">{{ __('ខ.3') }}</th>
            <th class="text-center kh">{{ __('គ') }}</th>
            <th class="text-center kh">{{ __('សរុប') }}</th>
        </tr>
    </thead>

    <tbody>
    	@php 
    		$quals = ['បណ្ឌិត', 'អនុបណ្ឌិត', 'បរិញ្ញាបត្រ', 'មធ្យមសិក្សាទុតិយភូមិ', 'មធ្យមសិក្សាបឋមភូមិ', 'ក្រោមមធ្យម.បឋមភូមិ']; 
    	@endphp

    	@foreach ($quals as $qual)
    		<tr>
    			<td class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ $qual }}</td>
    			<td class="text-center kh">{{ __('សរុប') }}</td>
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
                <td class="text-center kh">{{ __('ស្រី') }}</td>
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
            <td class="text-center kh" rowspan="2" style="vertical-align:middle;"><strong>{{ __('សរុបរួម') }}</strong></td>
            <td class="text-center kh">{{ __('សរុប') }}</td>
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
            <td class="text-center kh">{{ __('ស្រី') }}</td>
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
