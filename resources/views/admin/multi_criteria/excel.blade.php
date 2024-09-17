<h1 class="text-center">{{ __('បញ្ជីរាយនាមបុគ្គលិក') }}</h1>

<table class="table table-bordered table-head-fixed text-nowrap">
	<thead>
        <tr>
            <th class="kh">{{ __('ល.រ') }}</th>
            @foreach ($reportHeaders as $reportHeader)
            	<th class="kh">{{ $reportHeader->title_kh }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
    	@foreach($staffs as $index => $staff)
            <tr>
                <td>{{ $index + 1 }}</td>
                
                @include('admin.multi_criteria.partials.table_body')
            </tr>
        @endforeach
    </tbody>
</table>
