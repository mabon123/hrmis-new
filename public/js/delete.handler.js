$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if($('.btn-delete').length > 0){
        $('.btn-delete').click(function(){
            deleteRecord($(this), 'លុប', 'ទិន្នន័យនេះនឹងត្រូវលុបចេញពីប្រព័ន្ធ');
        });
    }
    if($('.btn-reject').length > 0){
        $('.btn-reject').click(function(){
            deleteRecord($(this), 'បដិសេធ', 'ទិន្នន័យនេះនឹងត្រូវបដិសេធចេញពីតារាង');
        });
    }

    var deleteRecord = function(_this, btnConf, message){
        Swal.fire({
            title: _this.data('title') ?? 'តើអ្នកប្រាកដទេ?',
            text: _this.data('text') ?? message,
            icon: _this.data('icon') ?? 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: btnConf,
            cancelButtonText: 'បោះបង់',
            reverseButtons: true,
            allowOutsideClick: () => !Swal.isLoading(),
            closeOnConfirm: false,
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
                'value': 'DELETE'
            });

        return form.append(token, hiddenInput)
            .appendTo('body');
    }
});
