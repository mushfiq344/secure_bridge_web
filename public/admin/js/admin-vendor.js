// change is_active column of a vendor
$(".vendor-activator-btn").click(function (event) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        }
    });
    var element = this;
    $.ajax({
        type: 'POST',
        url: "{{ route('admin.vendors.toggle-activation') }}",
        data: {
            id: parseInt($(this).attr("vendor_id"))
        },
        success: function (data) {
            console.log(data);
            $(element).removeClass("btn-danger");
            $(element).removeClass("btn-success");
            if (data['new_is_active']) {
                $(element).attr("is_active", "1");
                $(element).addClass(" btn-danger");
                $(element).html("Deactivate");
            } else {

                $(element).attr("is_active", "0");
                $(element).addClass(" btn-success");
                $(element).html("Activate");
            }
        }
    });

});
// change is_featured column of a vendor
$(".vendor-feature-btn").click(function (event) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        }
    });
    var element = this;
    $.ajax({
        type: 'POST',
        url: "{{ route('admin.vendors.toggle-feature') }}",
        data: {
            id: parseInt($(this).attr("vendor_id"))
        },
        success: function (data) {
            console.log(data);
            $(element).removeClass("btn-danger");
            $(element).removeClass("btn-success");
            if (data['new_is_featured']) {
                $(element).attr("is_featured", "1");
                $(element).addClass(" btn-danger");
                $(element).html("Stop Featuring");
            } else {

                $(element).attr("is_featured", "0");
                $(element).addClass(" btn-success");
                $(element).html("Start Featuring");
            }
        }
    });

});
