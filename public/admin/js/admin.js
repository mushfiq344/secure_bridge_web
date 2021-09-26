$(document).ready(function () {
    // global call of csrf token. use ajax call below this function
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name="csrf-token"]').attr('content') }
    });

    // save staic pages data
    $('#staticpagesForm').submit(function(e){

        e.preventDefault();

        let data = {
            'about_us': $('#editorAboutus').val(),
            'shipping_policy': $('#editorShipping').val(),
            'return_policy': $('#editorReturn').val(),
            'term_and_conditions': $('#editorTerms').val(),
            'privacy_policy': $('#editorPrivacy').val(),
            'how_to_buy': $('#editorHowtobuy').val()
        };

        $.ajax({
            type     : "POST",
            url      : "/admin/static-pages/update",
            data     : data,
            async    : true,
        }).done(function(resp){
            console.log(resp);
            if(resp.status == 'success'){
                $.notify({
                    icon: 'pe-7s-check',
                    message: resp.message
                },{
                    type: 'success',
                    timer: 4000
                });
            }
            else if(resp.status == 'error'){
                $.notify({
                    icon: 'pe-7s-check',
                    message: resp.message
                },{
                    type: 'danger',
                    timer: 4000
                });
            }
        }).fail(function(resp){
            alert("Something went wrong. Please try again");
        });
    });
});