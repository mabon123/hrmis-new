<div class="modal fade" id="modal-form">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content rounded-0">
			{!! Form::open(['route' => ['profession-ranks.store', app()->getLocale()], 'method' => 'post', 'id' => 'frmNewRecord']) !!}
				<div class="modal-header">
					<h4 class="modal-title">{{ __('tcp.create_profession_rank') }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ Form::hidden('page_num', request()->get('page')) }}
				</div>

				<div class="modal-body">
					<div class="row">
						<!-- Profession Category -->
						<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="tcp_prof_cat_id">{{ __('tcp.profession_category') }} 
	                            	<span class="required">*</span></label>
	                            
	                            {{ Form::select('tcp_prof_cat_id', ['' => __('common.choose')] + $profCategories, null, 
	                            	['id' => 'tcp_prof_cat_id', 'class' => 'form-control select2 kh', 'style' => 'width:100%;', 
	                            		'required' => true]) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="tcp_prof_rank_kh">{{ __('tcp.profession_rank_kh') }} 
	                            	<span class="required">*</span></label>
	                            
	                            {{ Form::text('tcp_prof_rank_kh', null, 
	                            	['id' => 'tcp_prof_rank_kh', 'class' => 'form-control kh', 'maxlength' => 150, 
	                            		'autocomplete' => 'off', 'maxlength' => 30, 'required' => true]) 
	                            }}
	                        </div>
	                    </div>

	                    <div class="col-md-12">
	                        <div class="form-group">
	                            <label for="tcp_prof_rank_en">{{ __('tcp.profession_rank_en') }} 
	                            	<span class="required">*</span></label>
	                            
	                            {{ Form::text('tcp_prof_rank_en', null, 
	                            	['id' => 'tcp_prof_rank_en', 'class' => 'form-control kh', 'maxlength' => 50, 
	                            		'autocomplete' => 'off', 'maxlength' => 30, 'required' => true]) 
	                            }}
	                        </div>
	                    </div>

	                    <!-- Profession Hierachy -->
	                    <div class="col-sm-4">
	                    	<div class="form-group">
	                    		<label for="rank_hierarchy">{{ __('tcp.profession_rank_hierachy') }} 
	                    			<span class="required">*</span></label>
	                    		{{ Form::number('rank_hierarchy', null, 
	                    			['id' => 'rank_hierarchy', 'class' => 'form-control', 'required' => true]) }}
	                    	</div>
	                    </div>

	                    <div class="col-sm-4">
	                    	<div class="form-group">
	                    		<label for="rank_low">{{ __('tcp.profession_rank_low') }}</label>
	                    		{{ Form::number('rank_low', null, ['id' => 'rank_low', 'class' => 'form-control']) }}
	                    	</div>
	                    </div>

	                    <div class="col-sm-4">
	                    	<div class="form-group">
	                    		<label for="rank_high">{{ __('tcp.profession_rank_high') }}</label>
	                    		{{ Form::number('rank_high', null, ['id' => 'rank_high', 'class' => 'form-control']) }}
	                    	</div>
	                    </div>
					</div>
				</div>

				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-danger btn-flat" data-dismiss="modal" style="width:150px;">
						<i class="far fa-times-circle"></i> {{ __('button.cancel') }}</button>
					<button type="submit" class="btn btn-info btn-flat" style="width:150px;">
						<i class="far fa-save"></i> {{ __('button.save') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
