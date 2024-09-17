<!-- Error validation message -->
@if ($errors->any())

    <div class="alert alert-danger">
        <ul style="margin-bottom:0;">

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>
    </div>

@endif


<!-- Success message -->
@if (session()->has('success'))

    <div class="alert alert-success">

        @if(is_array(session()->get('success')))
        	<ul>
            	@foreach (session()->get('success') as $message)
            		<li>{{ $message }}</li>
            	@endforeach
        	</ul>
        @else
        	{{ session()->get('success') }}
        @endif

        <button class="close" data-dismiss="alert" type="button">×</button>

    </div>

@endif
