function removeValue(txt_value, numrow) {
    $('#'+txt_value+'_'+numrow).val('');
}

function addNewValue(section, txt_value, btn_remove, num) {
	$('#'+section).append(
			'<div class="row justify-content-md-center">' + 
				'<div class="col-sm-3"></div>' + 
				'<div class="col-sm-2"></div>' + 
				'<div class="col-sm-3">' + 
					'<div class="form-group">' + 
						'<input class="form-control kh" name="'+txt_value+'[]" id="'+txt_value+'_'+num+'" type="text">' + 
					'</div>' + 
				'</div>' + 
				'<div class="col-sm-1">' + 
					'<button type="button" class="btn btn-sm" id="'+btn_remove+'-'+num+'" style="margin-top:2px;"' + 
						'onclick="removeValue(\''+txt_value+'\', '+num+')" title="Remove Value">' + 
						'<i class="far fa-times-circle" style="color:red;font-size:25px;"></i>' + 
					'</button>' + 
				'</div>' + 
			'</div>'
		);
}

// Add value to dropdown at button near  "Add report fields" button
function addDefaultValueDropdown(field_name, is_date_format, operator, value_field='first_value_0', p_section='first') {
	if (field_name != '') {
		var firstOperators = {'equal':'ស្មើ', 'not-equal':'មិនស្មើ', 'like':'មាន', 'like-f':'ខាងមុខដូច', 'like-b':'ខាងក្រោយដូច'};
		var secondOperations = {'equal':'ស្មើ', 'not-equal':'មិនស្មើ', 'greater-than':'ធំជាង', 'smaller-than':'តូចជាង', 'in':'ក្នុង'};

		$('#'+operator).find('option').remove();

		// If is date format
		if (is_date_format == 0) {
			for (var key in firstOperators) {
				$('#'+operator).append('<option value="'+key+'">'+firstOperators[key]+'</option>');
			}
		}
		else {
			for (var key in secondOperations) {
				$('#'+operator).append('<option value="'+key+'">'+secondOperations[key]+'</option>');
			}
		}
		
		// Remove auto-dropdown for some fields
		if (field_name == 'hrmis_staffs.payroll_id' || field_name == 'hrmis_staffs.nid_card' 
			|| field_name == 'hrmis_staffs.bank_account' || field_name == 'hrmis_staffs.dob' 
			|| field_name == 'hrmis_work_histories.prokah_num' || field_name == 'tcp_prof_recordings.prokah_num' 
			|| field_name == 'hrmis_staff_salaries.salary_type_shift_date') {

			$('#'+p_section+'_multiple').addClass('d-none');
			$('#'+p_section+'_single').removeClass('d-none');
			
		} else {
			$('#'+p_section+'_multiple').removeClass('d-none');
			$('#'+p_section+'_single').addClass('d-none');

			$.ajax({
	            type: "GET",
	            url: "ajax/multi-criteria-search/" + field_name,
	            success: function (table_values) {
	            	$("#"+value_field).find('option').remove();
	            	console.log(table_values);
	                if( table_values.length > 0 ) {
	                    for(var index in table_values) {
	                        $("#"+value_field).append('<option value="'+table_values[index]+'">'+ table_values[index] +'</option>');
	                    }
	                }
	            },
	            error: function (err) {
	                console.log('Error:', err);
	            }
	        });
		}
	}
}

$(function() {
	var index_1 = 1, index_2 = 1, index_3 = 1, index_4 = 1, index_5 = 1;
	var valueField = '';

	// 1st Copy
	$('#btn-first-copy').click(function() {
		var numrow = index_1++;
		valueField = 'first_value_'+numrow;
		addNewValue('section-first-value', 'first_value', 'btn-first-remove', numrow);
	});

	// 2nd Copy
	$('#btn-second-copy').click(function() {
		var numrow = index_2++;
		valueField = 'second_value_'+numrow;
		addNewValue('section-second-value', 'second_value', 'btn-second-remove', numrow);
	});

	// 3rd Copy
	$('#btn-third-copy').click(function() {
		var numrow = index_3++;
		valueField = 'third_value_'+numrow;
		addNewValue('section-third-value', 'third_value', 'btn-third-remove', numrow);
	});

	// 4th Copy
	$('#btn-fourth-copy').click(function() {
		var numrow = index_4++;
		valueField = 'fourth_value_'+numrow;
		addNewValue('section-fourth-value', 'fourth_value', 'btn-fourth-remove', numrow);
	});

	// 5th Copy
	$('#btn-fifth-copy').click(function() {
		var numrow = index_5++;
		valueField = 'fifth_value_'+numrow;
		addNewValue('section-fifth-value', 'fifth_value', 'btn-fifth-remove', numrow);
	});

	// Button Add Report Fields Event
	$('#btn-add-report-fields').click(function() {
		$('#modal-report-fields').modal('show');
	});

	// Event of selecting table fields/headers
	$('#export-all').click(function() {
		$('#name_fields > option').each(function() {
			$("#report_fields").append('<option value="'+$(this).val()+'" data-title-order="'+$(this).data('title-order')+'">'+$(this).text()+'</option>');

			//$('#name_fields option[value='+$(this).val()+']').remove();
			$('#name_fields option[value='+$(this).val()+']').prop('hidden', true);
		});
	});

	$('#export-single').click(function() {
		if ($('#name_fields').val() != '') {
			//console.log($('#name_fields option[value="'+$('#name_fields').val()+'"]').data('title-order'));
			var titleOrder = $('#name_fields option[value="'+$('#name_fields').val()+'"]').data('title-order');

			$("#report_fields").append('<option value="'+$('#name_fields').val()+'" data-title-order="'+titleOrder+'">' + 
											$('#name_fields option[value="'+$('#name_fields').val()+'"]').text() + 
										'</option>');

			// Remove
			//$('#name_fields option[value='+$('#name_fields').val()+']').remove();
			$('#name_fields option[value='+$('#name_fields').val()+']').prop('hidden', true);
		}
	});

	$('#import-single').click(function() {
		if ($('#report_fields').val() != '') {
			var titleOrder = $('#report_fields option[value="'+$('#report_fields').val()+'"]').data('title-order');
			//console.log($("#name_fields").find('option[data-title-order=2]').val());

			
				$("#name_fields").find('option[data-title-order='+titleOrder+']').prop('hidden', false);
				/*$("#name_fields").append('<option value="'+$('#report_fields').val()+'" data-title-order="'+titleOrder+'">' +
										$('#report_fields option[value="'+$('#report_fields').val()+'"]').text() +
									'</option>');*/

			// Remove
			$('#report_fields option[value='+$('#report_fields').val()+']').remove();
		}
	});

	$('#import-all').click(function() {
		$('#report_fields > option').each(function() {
			var titleOrder = $(this).data('title-order');
			$("#name_fields").find('option[data-title-order='+titleOrder+']').prop('hidden', false);
			//$("#name_fields").append('<option value="'+$(this).val()+'" data-title-order="'+$(this).data('title-order')+'">'+$(this).text()+'</option>');

			$('#report_fields option[value='+$(this).val()+']').remove();
		});
	});

	$('#reset-header-data').click(function() {
		$.ajax({
            type: "GET",
            url: "ajax/multi-criteria-search/report-fields",
            success: function (report_fields) {
            	$("#name_fields").empty();

                if( report_fields.length > 0 ) {
                    for(var index in report_fields) {
                    	$("#name_fields").append('<option value="'+report_fields[index].id+'">' + 
											report_fields[index].title_kh + 
										'</option>');
                        //console.log(report_fields[index].title_kh);
                    }
                }
            },
            error: function (err) {
                console.log('Error:', err);
            }
        });
	});

	// Table Field Event
	$('#first_field').change(function() {
		valueField = 'first_value_0';
		var isDateFormat = $(this).find(':selected').attr('data-field');
		var section = $(this).find(':selected').attr('data-section');
		addDefaultValueDropdown($(this).val(), isDateFormat, 'first_operator', 'first_value_0', section);
	});

	$('#second_field').change(function() {
		valueField = 'second_value_0';
		var isDateFormat = $(this).find(':selected').attr('data-field');
		var section = $(this).find(':selected').attr('data-section');
		addDefaultValueDropdown($(this).val(), isDateFormat, 'second_operator', 'second_value_0', section);

		// check/un-check AND operator
		$('#first_and').prop('checked', ($(this).val() ? true : false));
	});

	$('#third_field').change(function() {
		valueField = 'third_value_0';
		var isDateFormat = $(this).find(':selected').attr('data-field');
		var section = $(this).find(':selected').attr('data-section');
		addDefaultValueDropdown($(this).val(), isDateFormat, 'third_operator', 'third_value_0', section);

		// check/un-check AND operator
		$('#second_and').prop('checked', ($(this).val() ? true : false));
	});

	$('#fourth_field').change(function() {
		valueField = 'fourth_value_0';
		var isDateFormat = $(this).find(':selected').attr('data-field');
		var section = $(this).find(':selected').attr('data-section');
		addDefaultValueDropdown($(this).val(), isDateFormat, 'fourth_operator', 'fourth_value_0', section);

		// check/un-check AND operator
		$('#third_and').prop('checked', ($(this).val() ? true : false));
	});

	$('#fifth_field').change(function() {
		valueField = 'fifth_value_0';
		var isDateFormat = $(this).find(':selected').attr('data-field');
		var section = $(this).find(':selected').attr('data-section');
		addDefaultValueDropdown($(this).val(), isDateFormat, 'fifth_operator', 'fifth_value_0', section);

		// check/un-check AND operator
		$('#fourth_and').prop('checked', ($(this).val() ? true : false));
	});

	// Add value to the value textbox event
	$('#default_value').change(function() {
		$('#'+valueField).val($(this).val());
	});

	// Store report header event
	$('#btn-store-report-header').click(function(e) {
		e.preventDefault();
		$('#modal-report-fields').modal('hide');
		loadModalOverlay();
		var ajaxURL = $("#frmCreateQualification").attr("action");
		var report_fields = [];

		$('#report_fields > option').each(function() {
			report_fields.push($(this).val());
		});
		
		$.ajax({
            type: "POST",
            url: ajaxURL,
            data: { report_fields: report_fields },
            success: function (data) {
				//console.log("data: " + data);
                $("#modal-overlay").hide();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
	});
});
