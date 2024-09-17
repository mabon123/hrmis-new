{!! Form::open(['route' => ['positions.index', app()->getLocale()], 'method' => 'get']) !!}
	<div class="row row-box justify-content-md-center">
		<div class="col-sm-4">
            <div class="form-group">
                <label for="pos_category_id">{{ __('common.position_category') }}</label>
                {{ Form::select('pos_category_id', ['' => __('common.choose').' ...'] + $positionCats, request()->pos_category_id, 
                	['id' => 'position_category', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
            </div>
        </div>

		<div class="col-md-4">
            <div class="form-group">
                <label for="pos_level_id">{{ __('common.position_level') }}</label>
                {{ Form::select('pos_level_id', ['' => __('common.choose').' ...'] + $locationTypes, request()->pos_level_id, 
                	['id' => 'position_level', 'class' => 'form-control select2 kh', 'style' => 'width:100%;']) }}
            </div>
        </div>

        <!-- Hierachy -->
        <div class="col-sm-4">
            <div class="form-group">
                <label for="position_hierarchy">{{ __('common.hierachy') }}</label>
                {{ Form::number('position_hierarchy', request()->position_hierarchy, ['class' => 'form-control']) }}
            </div>
        </div>

        <!-- Name KH -->
       	<div class="col-md-6">
            <div class="form-group">
                <label for="position_kh">{{ __('common.position_kh') }}</label>
                {{ Form::text('position_kh', request()->position_kh, ['class' => 'form-control kh']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="position_en">{{ __('common.position_en') }}</label>
                {{ Form::text('position_en', request()->position_en, ['class' => 'form-control kh']) }}
            </div>
        </div>

		{{ Form::hidden('search', 'true') }}

		<div class="col-sm-12 text-center">
			<a href="{{ route('positions.index', app()->getLocale()) }}" class="btn btn-danger kh" 
				style="width:160px;" onclick="loadModalOverlay();">
				<i class="fas fa-undo"></i> {{ __('កំណត់ឡើងវិញ') }}</a>
			<button type="submit" class="btn btn-info kh" 
				onclick="loadModalOverlay();" style="width:160px;">
				<i class="fas fa-search"></i> {{ __('ស្វែងរក') }}</button>
		</div>
	</div>
{!! Form::close() !!}
