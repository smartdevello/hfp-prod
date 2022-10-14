// jQuery(document).ready(function($){


//     $(document).on('change', '#state', function(){
//         let state = $('#state').val();
//         // data-payer-id
//         $('#primaryInsurance').prop('selectedIndex',0);
//         $('select[name="primaryInsurance"] option').each(function(){
//             payer_id = $(this).attr('data-payer-id');
//             if (payer_id == undefined) return;

//             var payers = payer_data.filter(payer => payer.id == payer_id);
//             payer = payers[0];
//             flag = false;
//             for (i = 0; i< payer.states.length; i++) {
//                 if (payer.states[i].short_code == state) {
//                     flag = true; break;
//                 }
//             }
//             if (flag) {
//                 $(this).show();
//                 $(this).prop("disabled", false);
//             }
//             else 
//             {
//                 $(this).hide();
//                 $(this).prop("disabled", true);
//             }
//         });

//     });

//     if ($('#state').val() !='') {
//         let state = $('#state').val();
//         $('select[name="primaryInsurance"] option').each(function(){
//             payer_id = $(this).attr('data-payer-id');
//             if (payer_id == undefined) return;

//             var payers = payer_data.filter(payer => payer.id == payer_id);
//             payer = payers[0];
//             flag = false;
//             for (i = 0; i< payer.states.length; i++) {
//                 if (payer.states[i].short_code == state) {
//                     flag = true; break;
//                 }
//             }
//             if (flag) {
//                 $(this).show();
//                 $(this).prop("disabled", false);
//             }
//             else {
//                 $(this).hide();
//                 $(this).prop("disabled", true);
//             }


//         });

//         $('select[name="productChoose"] option').each(function(index){
//             $(this).hide();
//             $(this).prop("disabled", true);
//         });

//     }
    
//     function initforPrimaryInsurance(optionSelected){
//         if (optionSelected.val() != 'Tricare East' && optionSelected.val() != 'Tricare West' && optionSelected.val() != 'Tricare Overseas') {
//             $('.sponsorName_label').text('Policy Holder');
//             $('#sponsorName').attr('placeholder', 'Policy Holder');

//             $('.dodNumber_label').text('Policy Number');
//             $('#dodNumber').attr('placeholder', 'Policy Number');

//             $('.sponsorRelationship_label').text('Relationship to Policy Holder');
//             $('.dodNumber_explainer').hide(); 
//             $('.howtofinddbn').hide();
//             $('.dbn_position').hide();
//         } else {
//             $('.sponsorName_label').text('Sponsor Name');
//             $('#sponsorName').attr('placeholder', 'Sponsor Name');

//             $('.dodNumber_label').text('DoD Benefits Number (DBN)');
//             $('#dodNumber').attr('placeholder', 'DoD Benefits Number');

//             $('.sponsorRelationship_label').text('Relationship to Sponsor');
//             $('.dodNumber_explainer').show();
//             $('.howtofinddbn').show();
//             $('.dbn_position').show();
//         }


//         payer_id = optionSelected.attr('data-payer-id');
//         var payers = payer_data.filter(payer => payer.id == payer_id);
//         payer = payers[0];

//         $('select[name="fooby"]').prop('selectedIndex', 0);
//         $('select[name="productChoose"]').prop('selectedIndex', 0);

//         $('select[name="fooby"] option').each(function(index){
//             data_sku = $(this).attr('data-sku');
//             if (data_sku == undefined) return;
//             flag = false;

//             for (i = 0; i< payer.items.length; i++) {
//                 if ( ('sku' in payer.items[i] ) && payer.items[i].sku == data_sku) {
//                     flag = true; break;
//                 }
//             }

//             if (flag == true) {
//                 $(this).show();
//                 $(this).prop("disabled", false);
//             }
//             else {
//                 $(this).hide();
//                 $(this).prop("disabled", true);
//             }
//         });
//         cnt = $('select[name="fooby"] option').length - $('select[name="fooby"] option:disabled').length
//         if (cnt == 1) $('#fooby').hide()
//         else $('#fooby').show()

//         $('select[name="productChoose"] option').each(function(index){

//             data_sku = $(this).attr('data-sku');
//             if (data_sku == undefined) return;
//             flag = false;

//             for (i = 0; i< payer.items.length; i++) {
//                 if (('sku' in payer.items[i] ) && payer.items[i].sku == data_sku) {
//                     flag = true; break;
//                 }
//             }

//             if (flag == true) {
//                 $(this).show();
//                 $(this).prop("disabled", false);
//                 if ( !$('select[name="productChoose"]').prop('selectedIndex') ) {
//                     $('select[name="productChoose"]').prop('selectedIndex', index)
//                 }
//             }
//             else {
//                 $(this).hide();
//                 $(this).prop("disabled", true);
//             }
//         });
//     }
//     initforPrimaryInsurance($('select[name="primaryInsurance"] option:selected'));
//     $(document).on('change', 'select[name="primaryInsurance"]', function(){	
//         var optionSelected = $("option:selected", this);
//         initforPrimaryInsurance(optionSelected);

//     });

// });



jQuery(document).ready(function($){


    $(document).on('change', '#state', function(){
        let state = $('#state').val();
        // data-payer-id
        $('#primaryInsurance').prop('selectedIndex',0);
        $('select[name="primaryInsurance"] option').each(function(){
            payer_id = $(this).attr('data-payer-id');
            if (payer_id == undefined) return;

            var payer = payer_data.filter(payer => payer.id == payer_id);
            payer = payer[0];
            flag = false;
            for (i = 0; i< payer.states.length; i++) {
                if (payer.states[i].short_code == state) {
                    flag = true; break;
                }
            }
            if (flag) {
                $(this).show();
                $(this).prop("disabled", false);
            }
            else 
            {
                $(this).hide();
                $(this).prop("disabled", true);
            }
        });

    });

    if ($('#state').val() !='') {
        let state = $('#state').val();
        $('select[name="primaryInsurance"] option').each(function(){
            payer_id = $(this).attr('data-payer-id');
            if (payer_id == undefined) return;

            var payer = payer_data.filter(payer => payer.id == payer_id);
            payer = payer[0];
            flag = false;
            for (i = 0; i< payer.states.length; i++) {
                if (payer.states[i].short_code == state) {
                    flag = true; break;
                }
            }
            if (flag) {
                $(this).show();
                $(this).prop("disabled", false);
            }
            else {
                $(this).hide();
                $(this).prop("disabled", true);
            }


        });

        $('select[name="productChoose"] option').each(function(index){
            $(this).hide();
            $(this).prop("disabled", true);
        });

    }


    $(document).on('change', 'select[name="primaryInsurance"]', function(){	

        var optionSelected = $("option:selected", this);

        if (optionSelected.val() != 'Tricare East' && optionSelected.val() != 'Tricare West' && optionSelected.val() != 'Tricare Overseas') {
            $('.sponsorName_label').text('Policy Holder');
            $('#sponsorName').attr('placeholder', 'Policy Holder');

            $('.dodNumber_label').text('Policy Number');
            $('#dodNumber').attr('placeholder', 'Policy Number');

            $('.sponsorRelationship_label').text('Relationship to Policy Holder');
            $('.dodNumber_explainer').hide(); 
            $('.howtofinddbn').hide();
            $('.dbn_position').hide();
        } else {
            $('.sponsorName_label').text('Sponsor Name');
            $('#sponsorName').attr('placeholder', 'Sponsor Name');

            $('.dodNumber_label').text('DoD Benefits Number (DBN)');
            $('#dodNumber').attr('placeholder', 'DoD Benefits Number');

            $('.sponsorRelationship_label').text('Relationship to Sponsor');
            $('.dodNumber_explainer').show();
            $('.howtofinddbn').show();
            $('.dbn_position').show();
        }


        payer_id = optionSelected.attr('data-payer-id');
        var payer = payer_data.filter(payer => payer.id == payer_id);
        payer = payer[0];

        $('select[name="fooby"]').prop('selectedIndex', 0);
        $('select[name="productChoose"]').prop('selectedIndex', 0);

        $('select[name="fooby"] option').each(function(index){
            data_sku = $(this).attr('data-sku');
            if (data_sku == undefined) return;
            flag = false;

            for (i = 0; i< payer.items.length; i++) {
                if ( ('sku' in payer.items[i] ) && payer.items[i].sku == data_sku) {
                    flag = true; break;
                }
            }

            if (flag == true) {
                $(this).show();
                $(this).prop("disabled", false);
            }
            else {
                $(this).hide();
                $(this).prop("disabled", true);
            }
        });
        cnt = $('select[name="fooby"] option').length - $('select[name="fooby"] option:disabled').length
        if (cnt == 1) $('#fooby').hide()
        else $('#fooby').show()

        $('select[name="productChoose"] option').each(function(index){

            data_sku = $(this).attr('data-sku');
            if (data_sku == undefined) return;
            flag = false;

            for (i = 0; i< payer.items.length; i++) {
                if (('sku' in payer.items[i] ) && payer.items[i].sku == data_sku) {
                    flag = true; break;
                }
            }

            if (flag == true) {
                $(this).show();
                $(this).prop("disabled", false);
                if ( !$('select[name="productChoose"]').prop('selectedIndex') ) {
                    $('select[name="productChoose"]').prop('selectedIndex', index)
                }
            }
            else {
                $(this).hide();
                $(this).prop("disabled", true);
            }
        });
    });


    if ($('select[name="primaryInsurance"]').val())
    {
        var optionSelected = $('select[name="primaryInsurance"] option:selected');
        if (optionSelected.val() == 'Tricare East' || optionSelected.val() == 'Tricare West' || optionSelected.val() == 'Tricare Overseas') {
            $('.sponsorName_label').text('Policy Holder');
            $('#sponsorName').attr('placeholder', 'Policy Holder');

            $('.dodNumber_label').text('Policy Number');
            $('#dodNumber').attr('placeholder', 'Policy Number');

            $('.sponsorRelationship_label').text('Relationship to Policy Holder');
        } else {
            $('.sponsorName_label').text('Sponsor Name');
            $('#sponsorName').attr('placeholder', 'Sponsor Name');

            $('.dodNumber_label').text('DoD Benefits Number (DBN)');
            $('#dodNumber').attr('placeholder', 'DoD Benefits Number');

            $('.sponsorRelationship_label').text('Relationship to Sponsor');
        }


        payer_id = optionSelected.attr('data-payer-id');
        var payer = payer_data.filter(payer => payer.id == payer_id);
        payer = payer[0];

        $('select[name="fooby"]').prop('selectedIndex', 0);
        $('select[name="productChoose"]').prop('selectedIndex', 0);

        $('select[name="fooby"] option').each(function(index){
            data_sku = $(this).attr('data-sku');
            if (data_sku == undefined) return;
            flag = false;

            for (i = 0; i< payer.items.length; i++) {
                if ( ('sku' in payer.items[i] ) && payer.items[i].sku == data_sku) {
                    flag = true; break;
                }
            }

            if (flag == true) {
                $(this).show();
                $(this).prop("disabled", false);
            }
            else 
            {
                $(this).hide();
                $(this).prop("disabled", true);
            }
        });

        $('select[name="productChoose"] option').each(function(index){

            data_sku = $(this).attr('data-sku');
            if (data_sku == undefined) return;
            flag = false;

            for (i = 0; i< payer.items.length; i++) {
                if (('sku' in payer.items[i] ) && payer.items[i].sku == data_sku) {
                    flag = true; break;
                }
            }

            if (flag == true) 
            {
                $(this).show();
                $(this).prop("disabled", false);
                if ( !$('select[name="productChoose"]').prop('selectedIndex') ) {
                    $('select[name="productChoose"]').prop('selectedIndex', index)
                }
            }
            else 
            {
                $(this).hide();
                $(this).prop("disabled", true);
            }
        });
    }

});