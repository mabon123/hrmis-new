<div class="modal fade" id="modalCrossTeaching">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="cross_school">
                                @lang('common.school_name')
                                <span class="required">*</span>
                            </label>

                            <select class="form-control select2" name="cross_school" id="cross_school" style="width:100%;">
                                <option value="">{{ __('common.choose') }} ...</option>

                                @foreach($locations as $key => $location)
                                    
                                    <option value="{{ $key }}">{{ $location }}</option>

                                @endforeach

                                <option value="0">--- ផ្សេងៗ ---</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" id="btn-cancel-cross-school" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                    <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                </button>

                <button type="button" id="btn-save-cross-school" class="btn btn-info" style="width:150px;">
                    <i class="far fa-save"></i> {{ __('button.ok') }}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
