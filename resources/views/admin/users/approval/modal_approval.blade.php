<div class="modal fade" id="modal-user-approval">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post" id="form-user-approval" action="#">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h4 class="modal-title">User Account Approval</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-box">
                        <div class="col-sm-12">
                            <h4 class="text-center">
                                Are you sure you want to approve this user account?
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px;">
                        <i class="far fa-times-circle"></i> {{ __('button.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-info" style="width:150px;">
                        <i class="fas fa-unlock-alt"></i> {{ __('button.approve') }}
                    </button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal work info -->
