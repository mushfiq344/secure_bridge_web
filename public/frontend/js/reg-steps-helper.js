

function readURL(input, id) {

    if (input.files && input.files[0] && Math.ceil(input.files[0].size / 1000000) < 5) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + id + '-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    } else {

        alert(`The file "${input.files[0].name}" exceeds the maximum size of 5Mb`);
    }
}



function checkValue(element) {

    // check if the input has any value (if we've typed into it)
    if ($(element).val()) {
        console.log($(element).attr('value'));
        $(element).addClass('has-value');
    }
    else
        $(element).removeClass('has-value');
}

$(document).ready(function () {
    // Run on page load
    $('.form-control').each(function () {
        checkValue(this);
    })
    // Run on input exit
    $('.form-control').blur(function () {
        checkValue(this);
    });

    $(".image-file").change(function () {
        readURL(this, $(this).attr('id'));

    });

    $(".form-image-upload-button").click(function (event) {
        event.preventDefault();
        id = $(this).attr('reference-id');
        document.querySelector('#' + id).click();
    });


});

function checkURL(abc) {
    var string = abc.value;
    if (!~string.indexOf("http") && string !== "") {
        string = "http://" + string;
    }

    abc.value = string;
    return abc
}
