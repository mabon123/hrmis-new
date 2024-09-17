jQuery(function ($) {
    $.datepicker.regional['km'] = {
        closeText: 'រួច​រាល់',
        prevText: 'ថយ​ក្រោយ',
        nextText: 'ទៅ​មុខ',
        currentText: 'ថ្ងៃ​នេះ',
        monthNames: ['ខែ​មករា', 'ខែ​កុម្ភៈ', 'ខែ​មិនា', 'ខែ​មេសា', 'ខែ​ឧសភា', 'ខែ​មិថុនា',
            'ខែ​កក្កដា', 'ខែ​សីហា', 'ខែ​កញ្ញា', 'ខែ​តុលា', 'ខែ​វិច្ឆិកា', 'ខែ​ធ្នូ'],
        monthNamesShort: ['មករា', 'កុម្ភៈ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា',
            'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'],
        dayNames: ['ថ្ងៃ​អាទិត្យ', 'ថ្ងៃ​ចន្ទ', 'ថ្ងៃ​អង្គារ', 'ថ្ងៃ​ពុធ', 'ថ្ងៃ​ព្រហស្បត្តិ៍', 'ថ្ងៃ​សុក្រ', 'ថ្ងៃ​សៅរ៍'],
        dayNamesShort: ['អា', 'ចន្ទ', 'អង្គ', 'ពុធ', 'ព្រហ', 'សុ', 'សៅរ៍'],
        dayNamesMin: ['អា', 'ច', 'អ', 'ពុ', 'ព្រ', 'សុ', 'ស'],
        weekHeader: 'Wk',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['km']);

    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        //maxDate: new Date,
        changeYear: true,
        yearRange: '1900:' + ((new Date).getFullYear() + 10)
    });

    var max = 3;
    var ii = 1;
    var replaceMe = function () {
        var obj = $(this);
        if ($("#file_upload").length > max) {
            alert('Maximum upload 3 files');
            obj.val("");
            return false;
        }
        $(obj).css({ 'position': 'absolute', 'left': '-9999px', 'display': 'none' }).parent().prepend('<input id="file_upload" type="file" name="' + obj.attr('name') + '" class="browse" accept="image/jpeg,image/jpg,image/gif,image/png"/>');

        $('#upload_list').append('<div class="upload-list file_' + ii + '"><i class="flaticon-file"></i> <span class="file-name">' + this.files[0].name + '</span> <span class="">' + (this.files[0].size / 1000).toFixed(0) + 'kb</span> <span id="file_' + ii + '" class="delete pull-right fa fa-times"></span> <div>');

        $('#upload_list2').append('<div class="upload-list file_' + ii + '"><i class="flaticon-file"></i> <span class="file-name">' + this.files[0].name + '<div>');
        ii++;

        //$("#file_upload").change(replaceMe);
        $(".delete").click(function () {
            var delete_id = $(this).attr("id");
            $(".upload-list." + delete_id).remove();
            // $(this).parent().remove();
            $(obj).remove();
            return false; //safari fixes
        });
    }
    $("#file_upload").change(replaceMe);

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    // $('select').selectmenu()
    //   .selectmenu("menuWidget")
    //   .addClass("overflow");

    $('.btn-delete-record').on('click', function (e) {
        return confirm('តើអ្នកពិតជាចង់លប់ទិន្នន័យនេះមែនទេ?');
    });

    $('.numeric').keyup(function (e) {
        if (/\D/g.test(this.value)) {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
        }
    });

    $('#loadingDiv').hide()  // Hide it initially
    .ajaxStart(function () {
        $(this).show();
    })
    .ajaxStop(function () {
        $(this).hide();
    });

    /** search option */
    checkSearchOption();
    $("input[name='search_opt']").change(function () {
        checkSearchOption();
    });
    /** end search option */

});

function checkSearchOption() {
    var radioValue = $("input[name='search_opt']:checked").val();
    if (radioValue == '1') {
        $('.search-element1').css('display', 'block');
        $('.search-element2').css('display', 'none');
    } else {
        $('.search-element1').css('display', 'none');
        $('.search-element2').css('display', 'block');
    }
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}