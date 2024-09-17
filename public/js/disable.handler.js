$(document).ready(function(){
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    if ($('.btn-disable').length > 0){
        $('.btn-disable').click(function(){
            disableRecord($(this));
        });
    }

    var disableRecord = function(_this){
        Swal.fire({
            title: _this.data('title') ?? 'តើអ្នកប្រាកដទេ?',
            text: _this.data('text') ?? "ទិន្នន័យនេះនឹងត្រូវបិទចេញពីប្រព័ន្ធ",
            icon: _this.data('icon') ?? 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'បិទគណនី',
            cancelButtonText: 'បោះបង់',
            reverseButtons: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: false,
            showLoaderOnConfirm: true,
            preConfirm: (value) => {
                form = createForm(_this.data('route'));
                form.submit();
                return new Promise(function(resolve, reject) {
                    setTimeout(function(){
                        resolve()
                    }, 2000)
                })
            },
        }).then((result) => {

        });
    }


    var createForm = function(route) {
        var form =
            $('<form>', {
                'method': 'POST',
                'action': route
            });

        var token =
            $('<input>', {
                'name': '_token',
                'type': 'hidden',
                'value': $('meta[name="csrf-token"]').attr('content')
            });

        var hiddenInput =
            $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': 'PUT'
            });

        return form.append(token, hiddenInput).appendTo('body');
    }
});
