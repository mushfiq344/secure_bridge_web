var d = new Date();
var year = d.getFullYear();

$(function () {
    $("#year_founded_range_slider").slider({
        step: 1,
        range: true,
        min: 2000,
        max: year,
        values: [1900, year],
        slide: function (event, ui) {
            $('#year_low').html(ui.values[0]);
            $('#year_high').html(ui.values[1]);
        }
    });
    $('#year_low').html($("#year_founded_range_slider").slider("values", 0));
    $('#year_high').html($("#year_founded_range_slider").slider("values", 1));


    $("#outside_investors_range_slider").slider({
        step: 1,
        range: true,
        min: 0,
        max: 1000,
        values: [0, 1000],
        slide: function (event, ui) {
            $('#outside_investors_low').html(ui.values[0]);
            $('#outside_investors_high').html(ui.values[1]);
        }
    });

    $('#outside_investors_low').html($("#outside_investors_range_slider").slider("values", 0));
    $('#outside_investors_high').html($("#outside_investors_range_slider").slider("values", 1));


});