function check(str = 0) {

    if (str === 0) return confirm('Are you sure you want to remove this entry?');

    return confirm(str);
}

function readImageURL(input, element) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            $("#" + element).attr("src", e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// LOAD MODAL OVERLAY
function loadModalOverlay(timeout = false, second = 1000) {

    $("#modal-overlay").modal({
        show: true,
        backdrop: false,
    });

    if (timeout == true) {
        setTimeout(function () { $("#modal-overlay").modal("hide"); }, second);
    }
}

function loading() {
    $('#modal-overlay').modal('show');
}
function hideLoading() {
    $('#modal-overlay').modal('hide');
}

// TOAST
function toastMessage(classStatus, messageBody, delayTime = 5000, autoHide = true) {

    $(document).Toasts('create', {
        class: classStatus,
        autohide: autoHide,
        delay: delayTime,
        title: 'ពត៌មានលម្អិត',
        body: messageBody,
    });
}

function generateChildDropdownInfo(p_val, p_url, childSelector, p_key) {

    if (!childSelector.length) return;

    var lang = $('html').attr('lang');
    var defaultOption = lang === 'en' ? '<option value="">Choose ...</option>' : '<option value="">ជ្រើសរើស ...</option>';

    if (p_val !== "" && p_val !== '9916') {

        childSelector.empty();
        childSelector.html(defaultOption);

        $.ajax({
            type: "GET",
            url: p_url,
            success: function (data) {
                for (var index in data) {
                    childSelector.append('<option value="' + data[index][p_key] + '">' + data[index]['name_kh'] + '</option>');
                }

                if (childSelector.attr('data-old-value')) {
                    childSelector.val(childSelector.attr('data-old-value')).trigger('change')
                    childSelector.attr('data-old-value', '')
                }

                $('#modal-overlay').modal('hide');
            },
            error: function (err) {
                console.log('Error:', err);
            }
        });

        childSelector.prop("disabled", false);
    } else {
        childSelector.empty();
        childSelector.append(defaultOption);
        childSelector.prop("disabled", true);
    }

    childSelector.trigger('change');
}


$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Province dropdown
    $("#pro_code, #search_pro_code").change(function () {
        if ($(this).attr('id') == 'search_pro_code') {
            generateChildDropdownInfo($(this).val(), `/provinces/${$(this).val()}/districts`, $('#search_dis_code'), 'dis_code');
        } else {
            generateChildDropdownInfo($(this).val(), `/provinces/${$(this).val()}/districts`, $('#dis_code'), 'dis_code');
        }
    });

    if ($("#pro_code").attr('data-old-value')) {
        $("#pro_code").trigger('change');
    }
    if ($("#search_pro_code").attr('data-old-value')) {
        $("#search_pro_code").trigger('change');
    }

    // District dropdown
    $("#dis_code").change(function () {
        if ($(this).val() > 0) {
            generateChildDropdownInfo($(this).val(), `/districts/${$(this).val()}/communes`, $('#com_code'), 'com_code');
        }
    });

    // Commune dropdown
    $("#com_code").change(function () {
        generateChildDropdownInfo($(this).val(), `/communes/${$(this).val()}/villages`, $('#vil_code'), 'vil_code');
    });


    // Province dropdown event, then generate commune & village data for autocomplete
    $("#pro_code_autocomplete").change(function () {

        if ($("#birth_commune").val() == "") { $("#birth_commune").val(""); }
        if ($("#birth_village").val() == "") { $("#birth_village").val(""); }

        var proCode = $(this).val();

        if (proCode !== "") {
            // Commune autocomplete
            $.ajax({
                type: "GET",
                url: "/provinces/" + proCode + "/communes",
                success: function (communes) {
                    $("#birth_commune").autocomplete({
                        source: communes,
                    });
                },
                error: function (err) {
                    console.log('Error:', err);
                }
            });

            // Village autocomplete
            $.ajax({
                type: "GET",
                url: "/provinces/" + proCode + "/villages",
                success: function (villages) {
                    $("#birth_village").autocomplete({
                        source: villages,
                    });
                },
                error: function (err) {
                    console.log('Error:', err);
                }
            });
        }

    });

    // Event change on province => then auto fill the location info
    $(".procode_location").change(function () {
        $.ajax({
            type: "GET",
            url: "/provinces/" + $(this).val() + "/locations",
            success: function (locations) {
                var locationCount = Object.keys(locations).length;
                $("#location_code").find('option:not(:first)').remove();

                if (locationCount > 0) {
                    for (var key in locations) {
                        $("#location_code").append('<option value="' + key + '">' + locations[key] + '</option>');
                    }
                }
            },
            error: function (err) {
                console.log('Error:', err);
            }
        });

        //if ($(this).val() == "99") { $("#dis_code").prop("disabled", true); }
    });

});
