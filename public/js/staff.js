function addValueToOfficeDropdown(locationName) {

    if( locationName !== "" ) {

        $.ajax({
            type: "GET",
            url: "/locations/" + locationName + "/offices",
            success: function (offices) {
                
                if( offices.length > 0 ) {

                    $("#sys_admin_office_id").find('option:not(:first)').remove();
                    $("#sys_admin_office_id").prop("disabled", false);

                    for(var index in offices) {
                        $("#sys_admin_office_id").append('<option value="'+offices[index].office_id+'">'+ offices[index].office_kh +'</option>');
                    }
                }
                else { $("#sys_admin_office_id").prop("disabled", true); }
            },
            error: function (err) {
                console.log('Error:', err);
            }
        });
    }
    else {
        $("#sys_admin_office_id").prop("disabled", true);
        $("#sys_admin_office_id").empty();
        $("#sys_admin_office_id").append('<option value="">ជ្រើសរើស ...</option>');
    }
}

function addValueToPositionDropdown(locationName) {

    if( locationName !== "" ) {

        $.ajax({
            type: "GET",
            url: "/locations/" + locationName + "/positions",
            success: function (positions) {
                
                if( positions.length > 0 ) {

                    $("#position_id").find('option:not(:first)').remove();
                    //$("#position_id").prop("disabled", false);

                    for(var index in positions) {
                        $("#position_id").append('<option value="'+positions[index].position_id+'">'+ positions[index].position_kh +'</option>');
                    }
                }
                //else { $("#sys_admin_office_id").prop("disabled", true); }
            },
            error: function (err) {
                console.log('Error:', err);
            }
        });
    }
    else {
        $("#position_id").find('option:not(:first)').remove();
        //$("#sys_admin_office_id").prop("disabled", true);
        //$("#sys_admin_office_id").append('<option value="">ជ្រើសរើស ...</option>');
    }
}

// Find staff info
function ajaxFindStaff() {
    staff = null;
    $.ajax({
        type: "GET",
        url: `/staff/`+$('#payroll_id').val(),
        success: function (staff) {
            if (staff) {
                $('#payroll_id').addClass('is-invalid').attr('aria-describedby', 'payroll_id-error')
                if ($('#payroll_id').parent('.form-group').find('#payroll_id-error').length) {
                    $('#payroll_id')
                        .parent('.form-group')
                        .find('#payroll_id-error')
                        .html('{{ __("trainee.is_staff_msg") }}')
                        .css('display', 'block')
                } else {
                    $('#payroll_id')
                        .parent('.form-group')
                        .append(
                            '<span id="payroll_id-error" class="error invalid-feedback">អត្តលេខមន្ត្រីមានរួចហើយ</span>'
                        )
                }
            }
        },
        error: function (err) {
            console.log('Error:', err);
        }
    });
}

$(function() {

    // District autocomplete
    var districts = JSON.parse($("#districtinfo").val());

    $("#birth_district").autocomplete({
        source: districts,
    });


    // Current location autocomplete
    /*var locations = JSON.parse($("#locationinfo").val());

    $("#location_code").autocomplete({
        source: locations,
        select: function(event, ui) {
            var locationName = ui.item.value.replace("/", "");
            addValueToOfficeDropdown(locationName);
            addValueToPositionDropdown(locationName)
        }
    });

    $("#location_code").blur(function() {
        var locationName = $(this).val();
        //addValueToOfficeDropdown(locationName);
    });*/

    $("#location_code").change(function() {
        var locationName = $(this).val();
        //console.log(locationName);
        addValueToOfficeDropdown(locationName);
        addValueToPositionDropdown(locationName);
    });

    // If there is a value of location_code, then unable office dropdown
    if ($("#location_code").attr("data-old-value")) {

    	var locationKH = $("#location_code").data("old-value").replace("/", "");

        $.ajax({
            type: "GET",
            url: "/locations/" + locationKH + "/offices",
            success: function (offices) {
                
                if( offices.length > 0 ) {

                    $("#sys_admin_office_id").prop("disabled", false);

                    for(var index in offices) {

                        $("#sys_admin_office_id").append('<option value="'+offices[index].office_id+'">'+ offices[index].office_kh +'</option>');
                    }

                    if( $("#sys_admin_office_id").attr('data-old-value') ) {
                        $("#sys_admin_office_id").val($("#sys_admin_office_id").attr('data-old-value')).trigger('change');
                        $("#sys_admin_office_id").attr('data-old-value', '');
                    }
                }
                else { $("#sys_admin_office_id").prop("disabled", true); }
            },
            error: function (err) {
                console.log('Error:', err);
            }
        });
    }


    // Browse profile photo
    $("#profile_photo").on("change", function({target}) {
        readImageURL(this, "image-thumbnail");

        $("#profile-photo-sec").removeClass("d-none");
        $(".upload-section").addClass("d-none");

        // Fixed issue for same image upload
        //const files = target.files;
        //target.value = '';
    });

    $("#btn-cancel-profile").click(function() {
        $("#profile-photo-sec").addClass("d-none");
        $(".upload-section").removeClass("d-none");
        $("#profile_photo_asset").val("");
    });

    // Event on prokah
    $("#prokah").change(function() {
        $("#prokah_num").val("");
        $("#prokah_num").prop('disabled', !this.checked);
        $("#prokah_attachment").prop('disabled', !this.checked);

        // Remove required
        $("#prokah_num").prop("required", this.checked);

        if (!this.checked) {
            $("#subject_req").addClass("d-none");
            $("#prokah_num").removeClass("is-invalid");
        } else {
            $("#subject_req").removeClass("d-none");
        }
    });

    // Event on sbsk
    $("#sbsk").change(function() {
        $("#sbsk_num").val("");
        $("#sbsk_num").prop('disabled', !this.checked);
    });

    // Event on disability
    $("#disability_teacher").change(function() {
        $("#select2-disability_id-container").text("ជ្រើសរើស ...");
        $("#disability_id").prop('disabled', !this.checked);
        $("#disability_note").prop('disabled', !this.checked);
    });

    // If there is data value in the province dropdown of birth place, then auto
    // generate autocomplete data for commune & village
    if( $("#pro_code_autocomplete").attr("data-old-value") ) {
        $("#pro_code_autocomplete").trigger("change");
    }

    // If prokah is checked, then unable prokah_num & prokah_attachment
    if ($("#prokah").is(":checked")) {
        $("#prokah_num").prop("disabled", false);
        $("#prokah_attachment").prop("disabled", false);

        // Add required
        $("#subject_req").removeClass("d-none");
        $("#prokah_num").prop("required", true);
    }

    // Choose salary_level => auto fill salary_degree
    $("#salary_level_id").change(function() {
        var locationKH = $("#location_code").val().replace("/", "");
        if(locationKH == "") { locationKH = $("#location_code2").val().replace("/", ""); }
        
    	if ($(this).val() > 0 && locationKH != "") {
	        $.ajax({
	            type: "GET",
	            url: "/salary-level/" + $(this).val() +"/"+ locationKH + "/official-rank",
	            success: function (data) {
	                if( data.length > 0 ) {
	                	$("#official_rank_id").find('option').remove();
	                    for(var index in data) {
	                        $("#official_rank_id").append('<option value="'+data[index].official_rank_id+'">'+ data[index].official_rank_kh +'</option>');
	                    }
	                }
	            },
	            error: function (err) {
	                console.log('Error:', err);
	            }
	        });
        }
        else { $("#official_rank_id").find('option:not(:first)').remove(); }
    });

    // If salary level selected, then auto fill data for official rank
    if( $("#salary_level_id").attr("data-old-value") ) {
        $("#salary_level_id").trigger("change");
    }

    // if sbsk is checked, set disabled attr of member_card to false
    $("#sbsk_num").prop("disabled", !$("#sbsk").is(":checked"));

    // if disability_teacher is checked, set disabled attr of disability_type to false
    $("#disability_id").prop("disabled", !$("#disability_teacher").is(":checked"));
    $("#disability_note").prop("disabled", !$("#disability_teacher").is(":checked"));

    // Event on current position checkbox
    $("#cur_pos").change(function() {
        $("#end_date").prop("disabled", $(this).is(":checked"));
    });

    // Add new staff work history
    $("#btn-add-workhistory").click(function() {
        var addURL = $(this).data("add-url");

        //$('#workinfo_procode').prop('disabled', true);
        $('#end_date').val('');

        $("input[name='_method']").remove();
        $("#frmCreateWorkHistory").attr("action", addURL);
        $("#modalCreateWorkHistory").modal("show");
    });

    // Edit work history
    $(document).on("click", ".btn-edit", function() {

        var editURL = $(this).data("edit-url");
        var updateURL = $(this).data("update-url");

        $.get(editURL, function (workhistory) {
            //console.log(workhistory.location_code);
            //$("#location_code option[value='"+workhistory.location_code+"']").prop("selected", true);
            //$("#select2-location_code-container")
                //.text($("#location_code option[value='"+workhistory.location_code+"']").text());
            //$("#location_code").val(workhistory.location_kh);

            if( workhistory.sys_admin_office_id != null ) {
                // Add values to office dropdown
                for(var index in workhistory.sys_admin_offices) {
                    $("#sys_admin_office_id").append("<option value='"+workhistory.sys_admin_offices[index].office_id+"'>"+workhistory.sys_admin_offices[index].office_kh+"</option>");
                }

                $("#sys_admin_office_id option[value='"+workhistory.sys_admin_office_id+"']").prop("selected", true);
                $("#select2-sys_admin_office_id-container").text(workhistory.sys_admin_office);
                $("#sys_admin_office_id").prop("disabled", false);
            } else {
                $("#sys_admin_office_id").prop("disabled", true);
                $("#sys_admin_office_id").empty();
                $("#sys_admin_office_id").append("<option value=''>ជ្រើសរើស ...</option>");
                $("#select2-sys_admin_office_id-container").text('ជ្រើសរើស ...');
            }

            if( workhistory.position_id != null ) {
                $("#position_id option[value='"+workhistory.position_id+"']").prop("selected", true);
                $("#select2-position_id-container")
                    .text($("#position_id option[value='"+workhistory.position_id+"']").text());
            } else {
                $("#select2-position_id-container").text('ជ្រើសរើស ...');
                $("#position_id").find("option").prop("selected", false);
            }

            if( workhistory.additional_position_id != null ) {
                $("#additional_position_id option[value='"+workhistory.additional_position_id+"']")
                    .prop("selected", true);
                $("#select2-additional_position_id-container")
                    .text($("#additional_position_id option[value='"+workhistory.additional_position_id+"']").text());
            } else {
                $("#select2-additional_position_id-container").text('ជ្រើសរើស ...');
                $("#additional_position_id").find("option").prop("selected", false);
            }

            $("#main_duty").val(workhistory.main_duty);
            $("#prokah").prop("checked", workhistory.prokah);
            $("#prokah_num").prop("disabled", ! $("#prokah").is(":checked"));
            $("#prokah_num").val(workhistory.prokah_num);
            $("#cur_pos").prop("checked", workhistory.cur_pos);
            $("#start_date").val(workhistory.start_date);

            if( workhistory.cur_pos == null || workhistory.cur_pos == 0 ) {
                $("#end_date").val(workhistory.end_date);
                $("#end_date").prop("disabled", false);
            } else {
                $("#end_date").val('');
                $("#end_date").prop("disabled", true);
            }

            $("input[name='_method']").remove();
            $("#frmCreateWorkHistory").attr("action", updateURL);
            var putMethod = '<input name="_method" type="hidden" value="PUT">';
            $("#frmCreateWorkHistory").prepend(putMethod);
            $("#modalCreateWorkHistory").modal("show");
        });

    });

    // Add new staff salary
    $("#btn-add-salary").click(function() {
        var addURL = $(this).data("add-url");

        $("#frmCreateSalary").trigger("reset");
        $("#select2-salary_level_id-container").text('ជ្រើសរើស ...');
        $("#select2-official_rank_id-container").text('ជ្រើសរើស ...');
        $("#select2-cardre_type_id-container").text('ជ្រើសរើស ...');
        $("#select2-salary_degree-container").text('ជ្រើសរើស ...');

        $("input[name='_method']").remove();
        $("#frmCreateSalary").attr("action", addURL);
        $("#modalCreateSalary").modal("show");
    });

    // Edit staff salary info
    $(document).on("click", ".btn-edit-salary", function() {
        $("#frmCreateSalary").trigger("reset");
        $("#select2-salary_level_id-container").text('ជ្រើសរើស ...');
        $("#select2-official_rank_id-container").text('ជ្រើសរើស ...');
        $("#select2-cardre_type_id-container").text('ជ្រើសរើស ...');
        $("#select2-salary_degree-container").text('ជ្រើសរើស ...');
        var editURL = $(this).data("edit-url");
        var updateURL = $(this).data("update-url");

        $.get(editURL, function (salary) {

            if( salary.salary_level_id != '' ) {
                $("#salary_level_id option[value='"+salary.salary_level_id+"']").prop("selected", true);
                $("#select2-salary_level_id-container")
                    .text($("#salary_level_id option[value='"+salary.salary_level_id+"']").text());
            } else {
                $("#select2-salary_level_id-container").text('ជ្រើសរើស ...');
                $("#salary_level_id").find("option").prop("selected", false);
            }

            if (salary.official_rank_id > 0) {
                $("#salary_level_id").trigger("change");
            }

            if( salary.cardre_type_id != '' ) {
                $("#cardre_type_id option[value='"+salary.cardre_type_id+"']").prop("selected", true);
                $("#select2-cardre_type_id-container")
                    .text($("#cardre_type_id option[value='"+salary.cardre_type_id+"']").text());
            } else {
                $("#select2-cardre_type_id-container").text('ជ្រើសរើស ...');
                $("#cardre_type_id").find("option").prop("selected", false);
            }
            
            if (salary.salary_type_signdate != '') {
                $("#salary_type_signdate").val(salary.salary_type_signdate);
            }
            
            if (salary.salary_type_shift_date != '') {
                $("#salary_type_shift_date").val(salary.salary_type_shift_date);
            }

            if (salary.salary_special_shift_date != '') {
                $("#salary_special_shift_date").val(salary.salary_special_shift_date);
            }
            
            $("#salary_degree").val(salary.salary_degree);
            $('#salary_degree').trigger('change');

            $("#salary_type_prokah_num").val(salary.salary_type_prokah_num);
            $("#salary_type_prokah_order").val(salary.salary_type_prokah_order);

            $("input[name='_method']").remove();
            $("#frmCreateSalary").attr("action", updateURL);
            var putMethod = '<input name="_method" type="hidden" value="PUT">';
            $("#frmCreateSalary").prepend(putMethod);
            $("#modalCreateSalary").modal("show");
        });

    });

    $("select").change(function() {
        if ($(this).val() != "") {
            $(this).closest('.form-group').removeClass('has-error');
            $("#"+$(this).attr("id")+"-error").addClass("d-none");
        }
        else {
            $(this).closest('.form-group').addClass('has-error');
            $("#"+$(this).attr("id")+"-error").removeClass("d-none");
        }
    });

    // Event on payroll_id
    $('#payroll_id').change(function() {
        ajaxFindStaff();
    });

    // Event on start_date
    $('#start_work_date').change(function() {
        var startDate = $(this).val().split('-');
        $("#appointment_date").val(startDate[0] + "-" + startDate[1] + "-" + (parseInt(startDate[2]) + 1));
    });

    // Add TCP Profession Info
    $("#btn-add-tcp-profession").click(function() {
        var addURL = $(this).data("add-url");

        $("#frmCreateTCPProfession").trigger("reset");
        $("#select2-tcp_prof_cat_id-container").text('ជ្រើសរើស ...');
        $("#select2-tcp_prof_rank_id-container").text('ជ្រើសរើស ...');

        $("input[name='_method']").remove();
        $("#frmCreateTCPProfession").attr("action", addURL);
        $("#modalCreateTCPProfession").modal("show");
    });

    // Event on change TCP profession category => filter out profession rank info
    $("#tcp_prof_cat_id").change(function() {
        $("#tcp_prof_rank_id").find('option:not(:first)').remove();

        if ($(this).val() != '') {
            $.ajax({
                type: "GET",
                url: "/ajax/prof-category/" + $(this).val() +"/prof-ranks",
                success: function (data) {
                    if( data.length > 0 ) {
                        for(var index in data) {
                            $("#tcp_prof_rank_id").append('<option value="'+data[index].tcp_prof_rank_id+'">'+ data[index].tcp_prof_rank_kh +'</option>');
                        }
                    }
                },
                error: function (err) {
                    console.log('Error:', err);
                }
            });
        }
    });

    // Edit TCP Profession
    $(document).on("click", ".btn-edit-tcp-prof", function() {
        var editURL = $(this).data("edit-url");
        var updateURL = $(this).data("update-url");

        $.get(editURL, function (data) {
            $("#tcp_prof_cat_id option[value='"+data.tcp_prof_cat_id+"']").prop("selected", true);
            $("#select2-tcp_prof_cat_id-container")
                .text($("#tcp_prof_cat_id option[value='"+data.tcp_prof_cat_id+"']").text());
            //$("#tcp_prof_cat_id").val(data.tcp_prof_cat_id).change();
            $("#tcp_prof_rank_id").val(data.tcp_prof_rank_id).change();
            $("#date_received").val(data.date_received);
            $("#tcp_prof_prokah_num").val(data.prokah_num);
            $("#description").val(data.description);
            $("#ref-name").text(" : " + data.ref_document);
            $('#ref_document').prop('required', false);

            $("input[name='_method']").remove();
            $("#frmCreateTCPProfession").attr("action", updateURL);
            var putMethod = '<input name="_method" type="hidden" value="PUT">';
            $("#frmCreateTCPProfession").prepend(putMethod);
            $("#modalCreateTCPProfession").modal("show");
        });
    });
});
