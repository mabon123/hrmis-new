$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if($('.btn-confirm').length > 0){
        $('.btn-confirm').click(function(){
            confirmHandler($(this));
        });
    }

    var confirmHandler = function(_this){
        Swal.fire({
            title: _this.data('title'),
            text: _this.data('text'),
            html: _this.data('html'),
            icon: _this.data('icon'),
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'យល់ព្រម',
            cancelButtonText: 'បោះបង់',
            reverseButtons: true,
            allowOutsideClick: () => !Swal.isLoading(),
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            preConfirm: (value) => {
                form = createForm(_this.data('route'), _this.data('method'));
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


    var createForm = function(route, method = 'POST') {
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

            var method =
            $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': method
            });

        return form.append(token).append(method)
            .appendTo('body');
    }
});
