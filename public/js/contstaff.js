function disableRefilledAttributes() {
	$("#literacy-teacher-section").addClass("d-none");
    $("#equivalent-section").addClass("d-none");
    $("#edu-specialist-section").addClass("d-none");
    $("#back-school-section").addClass("d-none");
}

$(function() {
	var contractType = $("#contract_type_dropdown").val();

    // District autocomplete
    var districts = JSON.parse($("#districtinfo").val());

    $("#birth_district").autocomplete({
        source: districts,
    });


    // Browse profile photo
    $("#profile_photo").change(function({target}) {
        readImageURL(this, "image-thumbnail");

        $("#profile-photo").removeClass("d-none");
        $(".upload-section").addClass("d-none");

        // Fixed issue for same image upload
        //const files = target.files;
        //target.value = '';
    });

    $("#btn-cancel-profile").click(function() {
        $("#profile-photo").addClass("d-none");
        $(".upload-section").removeClass("d-none");
    });

    // Contract type
    $("#contract_type_dropdown").change(function() {
        
        if( $(this).val() !== "" ) {
            $("#cont_pos_id").empty();
            $("#cont_pos_id").append('<option value="">ជ្រើសរើស ...</option>');

            $.ajax({
                type: "GET",
                url: "/contract-type/" + $(this).val() + "/contract-position",
                success: function (contractpos) {
                    if( contractpos.length > 0 ) {
                        for(var index in contractpos) {
                            $("#cont_pos_id").append('<option value="'+contractpos[index].cont_pos_id+'">'+ contractpos[index].cont_pos_kh +'</option>');
                        }

                        if( $("#cont_pos_id").attr('data-old-value') ) {
                            $("#cont_pos_id").val( $("#cont_pos_id").attr('data-old-value')).trigger('change')
                            $("#cont_pos_id").attr('data-old-value', '')
                        }
                    } else {
                        $("#cont_pos_id").prop("disabled", true);
                    }
                },
                error: function (err) {
                    console.log('Error:', err);
                }
            });

            $("#cont_pos_id").prop("disabled", false);

            // If contract_type == Out of Education System
            if ($(this).val() == 3) {
                $("#location-address").removeClass("d-none");
                $("#p_code").prop("disabled", false);
            }
            else {
                $("#location-address").addClass("d-none");
                $("#p_code").prop("disabled", true);

                disableRefilledAttributes();
            }
        }
        else {
            $("#cont_pos_id").empty();
            $("#cont_pos_id").append('<option value="">ជ្រើសរើស ...</option>');
            $("#cont_pos_id").prop("disabled", true);
        }
    });

    // Event on contract staff position change
    $("#cont_pos_id").change(function() {
    	var posID = $(this).val();

    	disableRefilledAttributes();

    	if (posID == 1) { $("#literacy-teacher-section").removeClass("d-none"); }
    	else if (posID == 2 || posID == 3) { $("#equivalent-section").removeClass("d-none"); }
    	else if (posID == 4) { $("#back-school-section").removeClass("d-none"); }
    	else if (posID == 5) { $("#edu-specialist-section").removeClass("d-none"); }
    });

    // If contract_type, then unable contract position
    if( contractType ) { $("#contract_type_dropdown").trigger('change'); }

    if( $("#pro_code_autocomplete").attr("data-old-value") ) {
        $("#pro_code_autocomplete").trigger("change");
    }

    // CURRENT POSITION CHECKBOX
    $("#curpos").change(function() {
        $("#end_date").prop("disabled", $(this).is(":checked"));
    });

    // Create new work history event
    $("#frmCreateWorkHistory").submit(function() {
        $("#modalCreateWorkHistory").modal("hide");
        loadModalOverlay();
    });

    // ADD WORK HISTORY
    $("#btn-add-hist").click(function() {
        var addURL = $(this).data("add-url");

        $("#frmCreateWorkHistory").trigger("reset");
        $("#select2-contract_type_dropdown-container").text('ជ្រើសរើស ...');
        $("#select2-cont_pos_id-container").text('ជ្រើសរើស ...');
        $('#location-address').addClass('d-none');
        $('#equivalent-section').addClass('d-none');
        $('#back-school-section').addClass('d-none');
        $('#edu-specialist-section').addClass('d-none');
        $('#literacy-teacher-section').addClass('d-none');

        $("input[name='_method']").remove();
        $("#frmCreateWorkHistory").attr("action", addURL);
        $("#modalCreateWorkHistory").modal("show");
    });

    // Edit work history
    $(document).on("click", ".btn-edit", function() {

        var editURL = $(this).data("edit-url");
        var updateURL = $(this).data("update-url");

        $.get(editURL, function (workhistory) {
            $("#location_code").val(workhistory.location_code).trigger('change');
            
            if (workhistory.location_pro_code != null) {
                $("#p_code option[value='"+workhistory.location_pro_code+"']").prop("selected", true);
                $("#select2-p_code-container").text($("#p_code option[value='"+workhistory.location_pro_code+"']").text());
            }

            if (workhistory.location_dis_code != null) {
                $("#d_code option[value='"+workhistory.location_dis_code+"']").prop("selected", true);
                $("#select2-d_code-container").text($("#d_code option[value='"+workhistory.location_dis_code+"']").text());
            }

            if (workhistory.location_com_code != null) {
                $("#c_code option[value='"+workhistory.location_com_code+"']").prop("selected", true);
                $("#select2-c_code-container").text($("#c_code option[value='"+workhistory.location_com_code+"']").text());
            }

            if (workhistory.location_vil_code != null) {
                $("#v_code option[value='"+workhistory.location_vil_code+"']").prop("selected", true);
                $("#select2-v_code-container").text($("#v_code option[value='"+workhistory.location_vil_code+"']").text());
            }

            if( workhistory.contract_type_id != null ) {
                $("#contract_type_dropdown").val(workhistory.contract_type_id).trigger('change');
            } else {
                $("#select2-contract_type_dropdown-container").text('ជ្រើសរើស ...');
                $("#contract_type_dropdown").find("option").prop("selected", false);
            }

            $("#cont_pos_id").prop("disabled", false);

            for(var index in workhistory.cont_positions) {
                $("#cont_pos_id").append('<option value="'+workhistory.cont_positions[index].cont_pos_id+'">'+ workhistory.cont_positions[index].cont_pos_kh +'</option>');
            }

            if( workhistory.cont_pos_id != null ) {
                $("#cont_pos_id option[value='"+workhistory.cont_pos_id+"']").prop("selected", true);
                $("#select2-cont_pos_id-container")
                    .text($("#cont_pos_id option[value='"+workhistory.cont_pos_id+"']").text());
            } else {
                $("#select2-cont_pos_id-container").text('ជ្រើសរើស ...');
                $("#cont_pos_id").find("option").prop("selected", false);
            }

            $("#duty").val(workhistory.main_duty);
            $("#annual_eval").val(workhistory.annual_eval);
            $("#curpos").prop("checked", workhistory.curpos);
            $("#start_date").val(workhistory.start_date);

            if( workhistory.curpos == null || workhistory.curpos == 0 ) {
                $("#end_date").val(workhistory.end_date);
                $("#end_date").prop("disabled", false);
            } else {
                $("#end_date").val('');
                $("#end_date").prop("disabled", true);
            }

            if (workhistory.cont_pos_id == 1) {
                $('#refilled_literacy_teacher').prop('checked', (workhistory.has_refilled_training == 1 ? true : false));
                $('#refilled_literacy_teacher_year').val(workhistory.year_refilled_num);
            }
            else if (workhistory.cont_pos_id == 2 || workhistory.cont_pos_id == 3) {
                $('#refilled_equivalent').prop('checked', (workhistory.has_refilled_training == 1 ? true : false));
                $('#refilled_equivalent_year').val(workhistory.year_refilled_num);
            }
            else if (workhistory.cont_pos_id == 4) {
                $('#refilled_back_school').prop('checked', (workhistory.has_refilled_training == 1 ? true : false));
                $('#refilled_back_school_year').val(workhistory.year_refilled_num);
            }
            else if (workhistory.cont_pos_id == 5) {
                $('#refilled_edu_specialist').prop('checked', (workhistory.has_refilled_training == 1 ? true : false));
                $('#refilled_edu_specialist_year').val(workhistory.year_refilled_num);
            }

            $("#frmCreateWorkHistory input[name='_method']").remove();
            $("#frmCreateWorkHistory").attr("action", updateURL);
            var putMethod = '<input name="_method" type="hidden" value="PUT">';
            $("#frmCreateWorkHistory").prepend(putMethod);
            $("#modalCreateWorkHistory").modal("show");
        });

    });

    // Remove work history
    $(document).on("click", ".btn-delete", function() {
        var deleteURL = $(this).data('delete-url');
        var deleted = confirm('Are you sure you want to remove this entry?');

        if( deleted ) {
            var itemID = $(this).val();

            $.ajax({
                type: "DELETE",
                url: deleteURL,
                success: function (data) {
                    $("#record-" + itemID).remove();
                    
                    toastMessage("bg-success", "{{ __('validation.delete_success') }}");
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });

});
