<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
jQuery(document).ready(function($) {






    $("#duration_range_slider").slider({
        step: 1,
        range: true,
        min: parseInt("{{empty($minDuration)?0:$minDuration}}"),
        max: parseInt("{{empty($maxDuration)?0:$maxDuration}}"),
        values: [parseInt("{{empty($minDuration)?0:$minDuration}}"), parseInt(
            "{{empty($maxDuration)?0:$maxDuration}}")],
        slide: function(event, ui) {
            console.log("ui values of duration", ui.values[0]);
            $('#duration_low').html(String(ui.values[0]));
            $('#duration_high').html(String(ui.values[1]));
        }
    });

    $('#duration_low').html($("#duration_range_slider").slider("values", 0));
    $('#duration_high').html($("#duration_range_slider").slider("values", 1));






    $("#reward_range_slider").slider({
        step: 1,
        range: true,
        min: parseInt("{{empty($minReward)?0:$minReward}}"),
        max: parseInt("{{empty($maxReward)?0:$maxReward}}"),
        values: [parseInt("{{empty($minReward)?0:$minReward}}"), parseInt(
            "{{empty($maxReward)?0:$maxReward}}")],
        slide: function(event, ui) {
            $('#reward_low').html(ui.values[0]);
            $('#reward_high').html(ui.values[1]);
        }
    });

    $('#reward_low').html($("#reward_range_slider").slider("values", 0));
    $('#reward_high').html($("#reward_range_slider").slider("values", 1));


});
</script>