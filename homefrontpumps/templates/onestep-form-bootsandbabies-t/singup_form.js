jQuery(document).ready(function($) {
    var validator;

    window.intlTelInput(document.querySelector("#phone"), {
        // any initialisation options go here
        initialCountry:"us",
        utilsScript: utilsScriptURL
    });
    window.intlTelInput(document.querySelector("#doctorNumber"), {
        // any initialisation options go here
        initialCountry:"us",
        utilsScript: utilsScriptURL
    });
    
    initValidation();
    $('#regForm').on('submit', function(e) {
        if ($(this).hasClass('loading')) return;
        e.preventDefault();
        if ($(this).valid()) {
            $('#regForm').addClass('loading');
            motherInfoSubmission();
        };
    })
  
    if (validate_prescription == "option_set1") {
        $('#option_set1').show();
    } else if (validate_prescription == "option_set2") {
        $('#option_set2').show();
    } else if (validate_prescription == "option_set3") {
        $('#option_set3').show();
    } else {
        $('#option_set1').show();
    }
    // Calls Mother Info form submission
    function motherInfoSubmission() {

        $.ajax({
            url: global_creiden.ajax_url,
            type: "POST",
            data: {
                action: 'homefrontpump_register_login_onestep_form_bootsandbabies_t',
                
                firstname: $("#firstname").val(),
                lastname: $("#lastname").val(),					
                monthDOB: $("#monthDOB").val(),
                dayDOB: $("#dayDOB").val(),
                yearDOB: $("#yearDOB").val(),

                monthDUE: $("#monthDUE").val(),					
                dayDUE: $("#dayDUE").val(),					
                yearDUE: $("#yearDUE").val(),

                phone: $("#phone").val(),					
                email: $("#email").val(),
                password: $("#password").val(),

                streetAddress: $("#streetAddress").val(),
                unit: $("#unit").val(),
                city: $("#city").val(),
                state: $("#state").val(),
                postcode: $("#postcode").val(),

                register_for_showers: ($('#register_for_showers').is(":checked") === true) ? "on" : "",
                accept_msgs: $("#accept_msgs").is(":checked") ? "on" : "",
                register_page: $("#register_page").val(),
                statement: $("#statement").is(":checked") ? "on" : "",
                terms: $("#terms").is(":checked") ? "on" : "",
                event_tricare : $('#event_tricare').is(":checked") ? "on" : "",
                event_sponsors : $('#event_sponsors').is(":checked") ? "on" : "",
                
                register_giveaway: ($("#register_giveaway").is(":checked") === true) ? "on" : "",
                giveaway_groupname: $('#giveaway_groupname').val()
            },
            success: function(data) {
                // AFter a successfull submission, Call next form submission
                data = JSON.parse(data);
                if (data.success == 'true') {
                    $("#email_div").hide();
                    $("#password_div").hide();
                    $('.js-registrationMessage').parent().removeClass('active');
                    primaryInsuranceSubmission();
                } else {
                    $('.js-registrationMessage').parent().addClass('active');
                    $('.js-registrationMessage').empty().append(data.message);
                    $('#regForm').removeClass('loading');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('#regFrom').removeClass('loading');
                alert('Something went wrong in Mother\'s Information');
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }

    // Calls Primary Insurance Info form submission
    function primaryInsuranceSubmission() {

        var form_data = new FormData();
        form_data.append('action', 'homefrontpump_step_2_onestep_form_bootsandbabies_t');
        
        // form_data.append('doctorNameFirst', $("#doctorNameFirst").val());
        // form_data.append('doctorNameLast', $("#doctorNameLast").val());
        // form_data.append('doctorNumber', $("#doctorNumber").val());
        form_data.append('primaryInsurance', $("#primaryInsurance").val());
        form_data.append('sponsorName', $("#sponsorName").val());
        form_data.append('dodNumber', $("#dodNumber").val());			
        form_data.append('sponsorRelationship', $("#sponsorRelationship").val());
        form_data.append('receptionConfirmation', $("#receptionConfirmation").val());
        form_data.append('productChoose', $("#productChoose select").val());
        form_data.append('fbody', $("#fbody select").val());
        $.ajax({
            url: global_creiden.ajax_url,
            type: "POST",
            data: form_data,
            contentType: false,
            processData: false,
            success: function(data) {
                // AFter a successfull submission, Call next form submission
                data = JSON.parse(data);
                console.log(data);
                if (data.success == 'true') {
                    $('.js-registrationMessage').parent().removeClass('active');
                    accessoriesSubmission();
                } else {
                    $('.js-registrationMessage').parent().addClass('active');
                    $('.js-registrationMessage').empty().append(data.message);
                    $('#regForm').removeClass('loading');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('#regFrommotherInfoSubmission').removeClass('loading');
                alert('Something went wrong in Primary Insurance Information');
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    };

    function accessoriesSubmission() {
        var file_data = document.getElementById('prescription').files.length;
        var form_data = new FormData();
        form_data.append('action', 'homefrontpump_step_3_onestep_form_bootsandbabies_t');


        if ( jQuery('#option_set1_radio').prop('checked') ) validate_prescription = "option_set1";
        if ( jQuery('#option_set2_radio').prop('checked') ) validate_prescription = "option_set2";
        if ( jQuery('#option_set3_radio').prop('checked') ) validate_prescription = "option_set3";

        form_data.append('validate_prescription', validate_prescription);
        form_data.append('doctorNameFirst', $('#doctorNameFirst').val());
        form_data.append('doctorNameLast', $('#doctorNameLast').val());
        form_data.append('doctorNumber', $('#doctorNumber').val());

        form_data.append('assigned_sex', $('#assigned_sex').val());
        form_data.append('currently_pregnant', $('#currently_pregnant').val());

        form_data.append('breastfeeding_past', $('#breastfeeding_past').val());
        form_data.append('breastfeeding_pain', $('#breastfeeding_pain').val());
        form_data.append('breastfeeding_pain_comments', $('#breastfeeding_pain_comments textarea').val());

        form_data.append('breast_red_swelling', $('#breast_red_swelling').val());
        form_data.append('breast_red_swelling_comments', $('#breast_red_swelling_comments textarea').val());

        form_data.append('breast_milk_amount_change', $('#breast_milk_amount_change').val());
        form_data.append('breast_milk_amount_change_comments', $('#breast_milk_amount_change_comments textarea').val());
        form_data.append('additionalInfo', $('#additionalInfo').val());

        var file_data = document.getElementById('prescription').files.length;
        for (var index = 0; index < file_data; index++) {
            form_data.append("prescription[]", document.getElementById('prescription').files[index]);
        }
        

        if (document.getElementById('face_file').files.length > 0)
            form_data.append("face_file", document.getElementById('face_file').files[0]);

        if ( document.getElementById('national_id_file').files.length > 0)
            form_data.append("national_id_file", document.getElementById('national_id_file').files[0]);

        
        // form_data.append('hear', $("#hear").val());
        // form_data.append('otherReason', $("#otherReason").val());


        $.ajax({
            url: global_creiden.ajax_url,
            type: "POST",
            data: form_data,
            contentType: false,
            processData: false,
            success: function(data) {
                // AFter a successfull submission, Call next form submission
                $('#regForm').submit();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('#regFrom').removeClass('loading');
                alert('Something went wrong in Breast Pump and Accessories');
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    }



    function initValidation() {
        validator = $('#regForm').validate({
            // Validate only visible fields
            ignore: ":hidden",

            // Validation rules
            rules: {
                'prescription[]': {
                    required: true,
                },
                face_file: {
                    required: true,
                },
                national_id_file: {
                    required: true,
                },
                national_id_file1: {
                    required: true,
                },
                phone: {
                    intlTelNumber: true  // must contain a valid phone number
                },
                doctorNumber: {
                    intlTelNumber: true
                },
                validate_prescription : {
                    required: true,
                },

            },
            messages: {
                phone: {
                    phoneUS: "Please specify a valid US phone number (10 digits)"
                },
                doctorNumber: {
                    phoneUS: "Please specify a valid US phone number (10 digits)"
                },
                errorPlacement: function(error, element) {
                    if ($(element).is('input[type="checkbox"]') || $(element).is('input[type="check"]')) {

                        error.insertAfter($(element).parent('.hfp-checkbox'));
                    } else {
                        error.insertAfter($(element));
                    }
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "validate_prescription") {
                    error.insertAfter("div.option_sets_selector div:nth-child(1)");
                } else if ($(element).is('input[type="checkbox"]')){
                    error.insertAfter(element.parent());
                }else {
                    error.insertAfter(element);
                }
            }

        });
        // create a custom phone number rule called 'intlTelNumber'
        jQuery.validator.addMethod("intlTelNumber", function(value, element) {
            // return this.optional(element) || $(element).intlTelInput("isValidNumber");
            const iti = window.intlTelInputGlobals.getInstance(element);
            return this.optional(element) || iti.isValidNumber();
        }, "Please enter a valid International Phone Number");

        jQuery.validator.addMethod("ssnId", function(value, element) {
            return this.optional(element) || /^(\d{3})-?\d{2}-?\d{4}$/i.test(value) || /^(\d{2})-?\d{7}$/i.test(value)
        }, "Invalid Sponsor Social security number");
        jQuery.validator.addMethod("csnId", function(value, element) {
            return this.optional(element) || /^(\d{3})-?\d{2}-?\d{4}$/i.test(value) || /^(\d{2})-?\d{7}$/i.test(value)
        }, "Invalid Customer Social security number");
        jQuery.validator.addMethod("exactlength", function(value, element, param) {
            return this.optional(element) || value.length == param;
        }, $.validator.format("Please enter exactly {0} digits."));

        jQuery.validator.addMethod("numberofdigits", function(value, element, param) {
            return this.optional(element) || (value.length >=8 && value.length <=12 );
        }, $.validator.format("Please enter 8 ~ 12 digits/letters."));


        jQuery.validator.addMethod("DBN", function(value, element, param){
            const myRe = new RegExp(param, 'i');
            var match = myRe.exec(value);
            if (match != null) {
                const found = match[0];

                if (found == value) {
                    jQuery('#dodNumber').css('color', 'black');
                    return true;
                }  else {
                    jQuery('#dodNumber').css('color', 'red');
                    return false;
                }
                
            }
            jQuery('#dodNumber').css('color', 'red');
            return false;
        }, "It doesn't look like your DBN or Policy Number is in the correct format. <br> If you feel like this is an error, please contact support at <a href='mailto:info@homefrontpumps.com'>info@homefrontpumps.com</a> or <b>click the support icon to the bottom right.</b>");
    }

    // jQuery("#dodNumber").on("change paste input", function (e) {
    //     this.value = this.value.replace(/\D/g, "");
    // });
    function addvalidation_DBN() {
        selected_payer_id = $('#primaryInsurance option:selected').data('payer-id');
        if (selected_payer_id == null) return;        

        const payer = payer_data.filter(payer => payer.id == selected_payer_id)[0]
        const reg_exp = payer['member_number_regexp'];

        if (reg_exp == "" || reg_exp == null) {
            reg_exp = "\d{8,12}";
        }
        console.log('current reg expression ' + reg_exp );
        $('#dodNumber').rules( "remove");
        $('#dodNumber').rules( "add", {DBN: reg_exp } );

    }
    addvalidation_DBN()
    //Add DBN validation only when Tricare insurance
    $('#primaryInsurance').on('change',function(){
        addvalidation_DBN()
        // $('#dodNumber').valid();
    })

    // the selector will match all input controls of type :checkbox
    // and attach a click event handler
    $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });

    $("#receptionConfirmation").on('change', function() {
        var selectValue = $(this).val();

        if (selectValue == 'No') {
            //If pump is selectable
            $("#productReceived").hide();
            $("#productChoose").show();
            //Bag might be empty but enable "No pouches"
            jQuery('select[name="fooby"]').children('option[value="-1"]').attr('disabled', false);
        } else {
            //If pump is not selectable, then bag should not be empty
            $("#productReceived").show();
            $("#productChoose").hide();
            //bag should not be empty so "No pouches" should be disabled
            jQuery('select[name="fooby"]').children('option[value="-1"]').attr('disabled', true);
        }
    });
    
    $("#hear").on('change', function() {
        var selectValue = $(this).val();
        if (selectValue == 'Other') {
            $("#otherReason").show();
        } else {
            $("#otherReason").hide();
        }
    });

    function showSelectedOptionSets(selectedValue){
        
        if (selectedValue == 'option_set1') {
            $('#option_set1').show();
            $('#option_set2').hide();
            $('#option_set3').hide();
        } else if (selectedValue == 'option_set2') {
            $('#option_set1').hide();
            $('#option_set2').show();
            $('#option_set3').hide();

        } else if (selectedValue == 'option_set3') {
            $('#option_set1').hide();
            $('#option_set2').hide();
            $('#option_set3').show();
        } else {
            $('#option_set1').hide();
            $('#option_set2').hide();
            $('#option_set3').hide();
        }
    }


    $('input[name="validate_prescription"]').click(function(){
        selectedValue = $(this).val();
        showSelectedOptionSets(selectedValue);
    });
    $('#breastfeeding_past').on('change', function(){
        var selectedValue = $(this).val();
        if ( selectedValue == "Yes") {
            $('.breastfeed_yes').show();
        } else {
            $('.breastfeed_yes').hide();
        }
    });

    $('#breastfeeding_pain').on('change', function(){
        var selectedValue = $(this).val();
        if ( selectedValue == "Yes") {
            $('#breastfeeding_pain_comments').show();
        } else {
            $('#breastfeeding_pain_comments').hide();
        }
    });

    $('#breast_red_swelling').on('change', function(){
        var selectedValue = $(this).val();
        if ( selectedValue == "Yes") {
            $('#breast_red_swelling_comments').show();
        } else {
            $('#breast_red_swelling_comments').hide();
        }
    });


    $('#breast_milk_amount_change').on('change', function(){
        var selectedValue = $(this).val();
        if ( selectedValue == "Yes") {
            $('#breast_milk_amount_change_comments').show();
        } else {
            $('#breast_milk_amount_change_comments').hide();
        }
    });

    function visibleOptionsets()
    {
        let val = $('#state').val();
        if ( val == 'AZ' || val == 'PA' || val == 'WI' || val == 'OH' || val == 'NY' || val == 'AE' || val == 'AP' || val == 'AA') {
            // $('.option_sets_selector').hide();

            $('.option_sets_selector').hide();
            $('#option_set1').hide();
            $('#option_set2').show();
            $('#option_set2 .authorize').hide();
            $('#option_set3').show();
        } else {
            $('#option_set3').hide();
            $('#option_set2 .authorize').show();
            $('.option_sets_selector').show();
        }
    }
    $('#state').on('change', function(){			
        visibleOptionsets();
    });

    $('#sponsorRelationship').on('change', function(){
        if ($(this).val() == "Self") {
            $('#sponsorName').val( $('#firstname').val() );
        }
    });
    $('#firstname').on('change', function(){
        if ($('#sponsorRelationship').val() == "Self") {
            $('#sponsorName').val( $('#firstname').val() );
        }
    });


});