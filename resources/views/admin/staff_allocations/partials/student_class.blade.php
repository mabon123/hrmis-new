<table class="table table-bordered table-striped table-head-fixed text-nowrap">
    <thead>
        <tr>
            <th class="text-center kh" rowspan="2" style="vertical-align:middle;">{{ __('ថ្នាក់ / សិស្ស') }}</th>
            <th class="text-center kh" colspan="2" style="width:30%;">{{ __('សិស្ស') }}</th>
            <th class="text-center kh" colspan="2" style="width:30%;">{{ __('ថ្នាក់') }}</th>
        </tr>
        <tr>
            <th class="text-center kh">{{ __('សរុប') }}</th>
            <th class="text-center kh">{{ __('ស្រី') }}</th>
            <th class="text-center kh">{{ __('ជាក់ស្តែង') }}</th>
            <th class="text-center kh">{{ __('តាមនិយាម') }}</th>
        </tr>
    </thead>

    <tbody>
    	@php
    		$lowerSecTotal = 0; $lowerSecFemale = 0; $lowerSecClass = 0; $lowerSecNorm = 0;
    		$upperSecTotal = 0; $upperSecFemale = 0; $upperSecClass = 0; $upperSecNorm = 0;
    	@endphp

    	@foreach($grades as $key => $grade)
    		@if ($key == 0)
    			<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->preschool_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->preschoolf_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->preschool_totalclass_num }}</td>
	    			<td class="text-center kh"></td>
	    		</tr>
	    	@elseif ($key == 1)
    			<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade1_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade1f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade1totalclass_num }}</td>
	    			<td class="text-center kh"></td>
	    		</tr>
	    	@elseif ($key == 7)
    			<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade7_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade7f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade7totalclass_num }}</td>
	    			@if ($schoolData->grade7_num == 0)
    					@php $g7Norm = 0; @endphp
    				@elseif ($schoolData->grade7_num <= 58)
    					@php $g7Norm = 1; @endphp
    				@elseif ($schoolData->grade7_num <= 112)
    					@php $g7Norm = 2; @endphp
    				@elseif ($schoolData->grade7_num <= 160)
    					@php $g7Norm = 3; @endphp
    				@else
    					@php $g7Norm = round($schoolData->grade7_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g7Norm }}</strong></td>
	    		</tr>
	    		@php 
	    			$lowerSecTotal += $schoolData->grade7_num; 
	    			$lowerSecFemale += $schoolData->grade7f_num; 
	    			$lowerSecClass += $schoolData->grade7totalclass_num;
	    			$lowerSecNorm += $g7Norm;
	    		@endphp
	    	@elseif ($key == 8)
    			<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade8_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade8f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade8totalclass_num }}</td>
	    			@if ($schoolData->grade8_num == 0)
    					@php $g8Norm = 0; @endphp
    				@elseif ($schoolData->grade8_num <= 58)
    					@php $g8Norm = 1; @endphp
    				@elseif ($schoolData->grade8_num <= 112)
    					@php $g8Norm = 2; @endphp
    				@elseif ($schoolData->grade8_num <= 160)
    					@php $g8Norm = 3; @endphp
    				@else
    					@php $g8Norm = round($schoolData->grade8_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g8Norm }}</strong></td>
	    		</tr>
	    		@php 
	    			$lowerSecTotal += $schoolData->grade8_num; 
	    			$lowerSecFemale += $schoolData->grade8f_num; 
	    			$lowerSecClass += $schoolData->grade8totalclass_num;
	    			$lowerSecNorm += $g8Norm;
	    		@endphp
	    	@elseif ($key == 9)
    			<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade9_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade9f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade9totalclass_num }}</td>
	    			@if ($schoolData->grade9_num == 0)
    					@php $g9Norm = 0; @endphp
    				@elseif ($schoolData->grade9_num <= 58)
    					@php $g9Norm = 1; @endphp
    				@elseif ($schoolData->grade9_num <= 112)
    					@php $g9Norm = 2; @endphp
    				@elseif ($schoolData->grade9_num <= 160)
    					@php $g9Norm = 3; @endphp
    				@else
    					@php $g9Norm = round($schoolData->grade9_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g9Norm }}</strong></td>
	    		</tr>
	    		@php 
	    			$lowerSecTotal += $schoolData->grade9_num; 
	    			$lowerSecFemale += $schoolData->grade9f_num; 
	    			$lowerSecClass += $schoolData->grade9totalclass_num;
	    			$lowerSecNorm += $g9Norm;
	    		@endphp
	    		<tr>
	    			<td class="kh" style="font-weight:bold;">{{ 'សរុប (ទី៧-៩)' }}</td>
	    			<td class="text-center bg-total kh"><strong>{{ $lowerSecTotal }}</strong></td>
	    			<td class="text-center bg-total kh"><strong>{{ $lowerSecFemale }}</strong></td>
	    			<td class="text-center bg-total kh"><strong>{{ $lowerSecClass }}</strong></td>
	    			<td class="text-center bg-warning kh"><strong>{{ $lowerSecNorm }}</strong></td>
	    		</tr>
	    	@elseif ($key == 10)
    			<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade10_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade10f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade10totalclass_num }}</td>
	    			@if ($schoolData->grade10_num == 0)
    					@php $g10Norm = 0; @endphp
    				@elseif ($schoolData->grade10_num <= 58)
    					@php $g10Norm = 1; @endphp
    				@elseif ($schoolData->grade10_num <= 112)
    					@php $g10Norm = 2; @endphp
    				@elseif ($schoolData->grade10_num <= 160)
    					@php $g10Norm = 3; @endphp
    				@else
    					@php $g10Norm = round($schoolData->grade10_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g10Norm }}</strong></td>
	    		</tr>
	    		@php
	    			$upperSecTotal += $schoolData->grade10_num;
	    			$upperSecFemale += $schoolData->grade10f_num; 
	    			$upperSecClass += $schoolData->grade10totalclass_num;
	    			$upperSecNorm += $g10Norm;
	    		@endphp
    		<!-- Applied only for grade 11 & 12 (science & social class) -->
    		@elseif ($key == 11)
    			<tr>
	    			<td class="kh">{{ $grade.' វិទ្យាសាស្រ្ត' }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade11_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade11f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade11totalclass_num }}</td>
	    			@if ($schoolData->grade11_num == 0)
    					@php $g11Norm = 0; @endphp
    				@elseif ($schoolData->grade11_num <= 58)
    					@php $g11Norm = 1; @endphp
    				@elseif ($schoolData->grade11_num <= 112)
    					@php $g11Norm = 2; @endphp
    				@elseif ($schoolData->grade11_num <= 160)
    					@php $g11Norm = 3; @endphp
    				@else
    					@php $g11Norm = round($schoolData->grade11_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g11Norm }}</strong></td>
	    		</tr>
    			<tr>
	    			<td class="kh">{{ $grade.' សង្គម' }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade11so_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade11sof_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade11sototalclass_num }}</td>
	    			@if ($schoolData->grade11so_num == 0)
    					@php $g11soNorm = 0; @endphp
    				@elseif ($schoolData->grade11so_num <= 58)
    					@php $g11soNorm = 1; @endphp
    				@elseif ($schoolData->grade11so_num <= 112)
    					@php $g11soNorm = 2; @endphp
    				@elseif ($schoolData->grade11so_num <= 160)
    					@php $g11soNorm = 3; @endphp
    				@else
    					@php $g11soNorm = round($schoolData->grade11so_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g11soNorm }}</strong></td>
	    		</tr>
	    		@php
	    			$upperSecTotal += ($schoolData->grade11_num + $schoolData->grade11so_num);
	    			$upperSecFemale += ($schoolData->grade11f_num + $schoolData->grade11sof_num); 
	    			$upperSecClass += ($schoolData->grade11totalclass_num + $schoolData->grade11sototalclass_num);
	    			$upperSecNorm += ($g11Norm + $g11soNorm);
	    		@endphp
	    	@elseif ($key == 12)
	    		<tr>
	    			<td class="kh">{{ $grade.' វិទ្យាសាស្រ្ត' }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade12_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade12f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade12totalclass_num }}</td>
	    			@if ($schoolData->grade12_num == 0)
    					@php $g12Norm = 0; @endphp
    				@elseif ($schoolData->grade12_num <= 58)
    					@php $g12Norm = 1; @endphp
    				@elseif ($schoolData->grade12_num <= 112)
    					@php $g12Norm = 2; @endphp
    				@elseif ($schoolData->grade12_num <= 160)
    					@php $g12Norm = 3; @endphp
    				@else
    					@php $g12Norm = round($schoolData->grade12_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g12Norm }}</strong></td>
	    		</tr>
    			<tr>
	    			<td class="kh">{{ $grade.' សង្គម' }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade12so_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade12sof_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->grade12sototalclass_num }}</td>
	    			@if ($schoolData->grade12so_num == 0)
    					@php $g12soNorm = 0; @endphp
    				@elseif ($schoolData->grade12so_num <= 58)
    					@php $g12soNorm = 1; @endphp
    				@elseif ($schoolData->grade12so_num <= 112)
    					@php $g12soNorm = 2; @endphp
    				@elseif ($schoolData->grade12so_num <= 160)
    					@php $g12soNorm = 3; @endphp
    				@else
    					@php $g12soNorm = round($schoolData->grade12so_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $g12soNorm }}</strong></td>
	    		</tr>
	    		@php
	    			$upperSecTotal += ($schoolData->grade12_num + $schoolData->grade12so_num);
	    			$upperSecFemale += ($schoolData->grade12f_num + $schoolData->grade12sof_num); 
	    			$upperSecClass += ($schoolData->grade12totalclass_num + $schoolData->grade12sototalclass_num);
	    			$upperSecNorm += ($g12Norm + $g12soNorm);
	    		@endphp
	    	@elseif ($key == 15)
	    		<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->technical_class_y1_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->technical_class_y1f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->technical_y1totalclass_num }}</td>
	    			@if ($schoolData->technical_class_y1_num == 0)
    					@php $gtechy1Norm = 0; @endphp
    				@elseif ($schoolData->technical_class_y1_num <= 58)
    					@php $gtechy1Norm = 1; @endphp
    				@elseif ($schoolData->technical_class_y1_num <= 112)
    					@php $gtechy1Norm = 2; @endphp
    				@elseif ($schoolData->technical_class_y1_num <= 160)
    					@php $gtechy1Norm = 3; @endphp
    				@else
    					@php $gtechy1Norm = round($schoolData->technical_class_y1_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $gtechy1Norm }}</strong></td>
	    		</tr>
	    		@php
	    			$upperSecTotal += $schoolData->technical_class_y1_num;
	    			$upperSecFemale += $schoolData->technical_class_y1f_num; 
	    			$upperSecClass += $schoolData->technical_y1totalclass_num;
	    			$upperSecNorm += $gtechy1Norm;
	    		@endphp
	    	@elseif ($key == 16)
	    		<tr>
	    			<td class="kh">{{ $grade }}</td>
	    			<td class="text-center kh">{{ $schoolData->technical_class_y2_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->technical_class_y2f_num }}</td>
	    			<td class="text-center kh">{{ $schoolData->technical_y2totalclass_num }}</td>
	    			@if ($schoolData->technical_class_y2_num == 0)
    					@php $gtechy2Norm = 0; @endphp
    				@elseif ($schoolData->technical_class_y2_num <= 58)
    					@php $gtechy2Norm = 1; @endphp
    				@elseif ($schoolData->technical_class_y2_num <= 112)
    					@php $gtechy2Norm = 2; @endphp
    				@elseif ($schoolData->technical_class_y2_num <= 160)
    					@php $gtechy2Norm = 3; @endphp
    				@else
    					@php $gtechy2Norm = round($schoolData->technical_class_y2_num / 45); @endphp
    				@endif
	    			<td class="text-center kh"><strong>{{ $gtechy2Norm }}</strong></td>
	    		</tr>
	    		@php
	    			$upperSecTotal += $schoolData->technical_class_y2_num;
	    			$upperSecFemale += $schoolData->technical_class_y2f_num; 
	    			$upperSecClass += $schoolData->technical_y2totalclass_num;
	    			$upperSecNorm += $gtechy2Norm;
	    		@endphp
	    		<tr>
	    			<td class="kh" style="font-weight:bold;">{{ 'សរុប (ទី១០-១២)' }}</td>
	    			<td class="text-center bg-total kh"><strong>{{ $upperSecTotal }}</strong></td>
    				<td class="text-center bg-total kh"><strong>{{ $upperSecFemale }}</strong></td>
    				<td class="text-center bg-total kh"><strong>{{ $upperSecClass }}</strong></td>
	    			<td class="text-center bg-warning kh"><strong>{{ $upperSecNorm }}</strong></td>
	    		</tr>
    		@else
	    		<tr>
	    			<td class="kh">{{ $grade.' - '.$key }}</td>
	    			<td class="text-center kh"></td>
	    			<td class="text-center kh"></td>
	    			<td class="text-center kh"></td>
	    			<td class="text-center kh"></td>
	    		</tr>
    		@endif
    	@endforeach

    	<tr>
    		<td class="text-center kh" style="font-family:'Moul', 'Arial';">{{ __('សរុបរួម') }}</td>
    		<td class="text-center bg-total kh"><strong>{{ $lowerSecTotal + $upperSecTotal }}</strong></td>
    		<td class="text-center bg-total kh"><strong>{{ $lowerSecFemale + $upperSecFemale }}</strong></td>
    		<td class="text-center bg-total kh"><strong>{{ $lowerSecClass + $upperSecClass }}</strong></td>
    		<td class="text-center bg-warning kh"><strong>{{ $lowerSecNorm + $upperSecNorm }}</strong></td>
    	</tr>
    </tbody>
</table>
