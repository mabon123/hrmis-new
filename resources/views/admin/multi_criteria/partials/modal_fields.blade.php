<div class="modal fade" id="modal-report-fields">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <form method="post" id="frmCreateQualification" action="{{ route('ajax-store-report-header', app()->getLocale()) }}">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">{{ __('ទីតាំងទិន្ន័យ') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-box">
                        <div class="col-sm">
                            <div class="form-group">
                                <select multiple class="form-control kh" name="name_fields" id="name_fields" style="height:450px">
                                    @foreach ($tableFields as $tableField)
                                        <option value="{{ $tableField->id }}" data-title-order="{{ $tableField->title_order }}" multiple="multiple">
                                            {{ $tableField->title_kh }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <button type="button" class="btn btn-xs btn-primary" id="reset-header-data"
                                style="width:50px;">
                                <i class="fas fa-sync"></i></button> -->
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group text-center" style="margin-top:32px;">
                                <button type="button" id="export-all" class="btn-btn-sm btn-secondary" style="width:100%;margin-bottom:15px;">
                                    <i class="fas fa-angle-double-right"></i></button>
                                <button type="button" id="export-single" class="btn-btn-sm btn-secondary" style="width:100%;margin-bottom:40px;">
                                    <i class="fas fa-angle-right"></i></button>
                                <button type="button" id="import-single" class="btn-btn-sm btn-secondary" style="width:100%;margin-bottom:15px;">
                                    <i class="fas fa-angle-left"></i></button>
                                <button type="button" id="import-all" class="btn-btn-sm btn-secondary" style="width:100%;">
                                    <i class="fas fa-angle-double-left"></i></button>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <select name="report_fields" id="report_fields" multiple class="custom-select kh" 
                                    style="height:450px;">
                                        @if ($reportHeaders)
                                            @foreach ($reportHeaders as $reportHeader)
                                                <option value="{{ $reportHeader->id }}">{{ $reportHeader->title_kh }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="button" id="btn-store-report-header" class="btn btn-info" style="width:150px;">
                        <i class="far fa-save"></i> {{ __('button.ok') }}
                    </button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
