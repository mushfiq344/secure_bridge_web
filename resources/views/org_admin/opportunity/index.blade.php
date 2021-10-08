@extends('org_admin.layouts.org-admin-layout')


@section('head')

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<style>
.float-right {
    float: right;
}

.page-link,
.page-item {
    color: #581e71;
    text-decoration: none;
    padding: 20px 20px;
}


.page-link:hover {
    border: 2px solid #581e71;
    color: #581e71;
    background-color: #fff3e9;




}

.enrolled,
.added-in-wishlist {
    color: red;
    cursor: pointer;
}

.un-enrolled,
.not-added-in-wishlist {
    color: white;
    cursor: pointer;
}


.pagination .page-item.active .page-link {
    border: 2px solid #581e71;
    color: #581e71 background-color: transparent;




}
</style>


@endsection

@section('main-banner')

@include("org_admin.partials.search-bar")
@endsection

@section('content')

<!-- Blog post list section -->
<div class="section blog-section">
    <div class="container">

        <div class="columns">



            <div class="column is-4">

                <div class="blog-sidebar">
                    <!--Diversity-->
                    <div class="blog-sidebar-categories">
                        <h4>Filters</h4>
                    </div>
                    <div class="single-toggle-wrapper">
                        <div class="toggle-wrap" style="padding-right:20px;">
                            <span class="trigger"><a href="#">OPPORTUNITY DATE<i class="im im-icon-Add"></i></a></span>
                            <div class="toggle-container">

                                <!--Legal Designation-->

                                <div class="field">
                                    <div class="control">
                                        <input id="opportunity_date" type="date" class="form-control"
                                            name="opportunity_date" style="width:100%">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="single-toggle-wrapper">
                        <div class="toggle-wrap" style="padding-right:20px;">
                            <span class="trigger"><a href="#">DURATION IN DAYS<i class="im im-icon-Add"></i></a></span>
                            <div class="toggle-container">


                                <!--Total Duration-->

                                <div class="field">
                                    <div class="control">
                                        <div class="px-2">
                                            <div id="duration_range_slider"></div>

                                            <span id="duration_low"></span>
                                            <span class="float-right" id="duration_high"></span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="single-toggle-wrapper">
                        <div class="toggle-wrap" style="padding-right:20px;">
                            <span class="trigger"><a href="#">REWARD ($)<i class="im im-icon-Add"></i></a></span>
                            <div class="toggle-container">


                                <!--REWARD ($)-->

                                <div class="field">
                                    <div class="control">
                                        <div class="px-2">
                                            <div id="reward_range_slider"></div>

                                            <span id="reward_low"></span>
                                            <span class="float-right" id="reward_high"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <a class="mt-30 button button-cta btn-outlined is-bold btn-align primary-btn rounded raised"
                        style="width: 100%" id="search_button_2">
                        Search
                    </a>
                </div>

            </div>
            <div class="column is-8">

                <div class="columns is-multiline" id="opportunity_index">
                </div>
            </div>


        </div>



    </div>
</div>

@endsection

@section('scripts')
@include('org_admin.opportunity.opportunities-ui-range-slider')
<!--initial load-->
<script>
// load all initially
var search_field = "";



let duration_low = parseInt("{{empty($minDuration)?0:$minDuration}}");
let duration_high = parseInt("{{empty($maxDuration)?0:$maxDuration}}");

let reward_low = parseInt("{{empty($minReward)?0:$minReward}}");
let reward_high = parseInt("{{empty($maxReward)?0:$maxReward}}");

let opportunity_date = $("#opportunity_date").val();

$.ajax({
    url: "{{route('fetch.opportunities')}}",
    method: "POST",
    data: {
        "_token": "{{ csrf_token() }}",
        search_field: search_field,
        duration_low: duration_low,
        duration_high: duration_high,
        reward_low: reward_low,
        reward_high: reward_high,
        opportunity_date: opportunity_date

    },
    success: function(data) {

        console.log("data", data);
        $("#opportunity_index").html(data);
    }
});
</script>
<script>
$(document).on('click', '.pagination a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
});



$(".search-field").keyup(function(e) {
    var enterKey = 13;
    if (e.which == enterKey) {

        let search_field = $("#search_field").val();
        fetch_data(page = 1, search_field);

    }

});

$(document).on('click', '#search_button_1,#search_button_2', function(event) {
    let search_field = $("#search_field").val();
    fetch_data(page = 1, search_field);
});

function fetch_data(page = 1, search_field = '') {



    let duration_low = $('#duration_low').html();
    console.log("clicked", duration_low);
    let duration_high = $('#duration_high').html();
    console.log("clicked", duration_high);
    let reward_low = $("#reward_low").html();
    console.log("clicked", reward_low);
    let reward_high = $("#reward_high").html();
    console.log("clicked", reward_high);
    let opportunity_date = $("#opportunity_date").val();


    $.ajax({
        url: "{{route('fetch.opportunities')}}",
        method: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            page: page,
            search_field: search_field,
            duration_low: duration_low,
            duration_high: duration_high,
            reward_low: reward_low,
            reward_high: reward_high,
            opportunity_date: opportunity_date


        },
        success: function(data) {
            console.log("data", data);
            $("#opportunity_index").html(data);
        }
    });
}




$(document).on('click', ".enrolled, .un-enrolled", function(event) {


    let task = $(this).attr("task");
    let opportunity_id = $(this).attr("opportunity-id");
    var icon = $(this);

    if (task == "enroll") {
        $.ajax({
            url: "{{route('user-opportunities.store')}}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                opportunity_id: opportunity_id
            },
            success: function(data, textStatus, xhr) {

                if (xhr.status == 201) {

                    $(icon).removeClass("un-enrolled");
                    $(icon).addClass("enrolled");
                    $(icon).attr("task", "un-enroll");
                }

            }
        });
    } else {
        $.ajax({
            url: "/user-opportunities/" + opportunity_id,
            method: "DELETE",
            data: {
                "_token": "{{ csrf_token() }}",
                opportunity_id: opportunity_id
            },
            success: function(data, textStatus, xhr) {
                console.log(data);
                console.log(xhr.status);

                if (xhr.status == 204) {

                    $(icon).removeClass("enrolled");
                    $(icon).addClass("un-enrolled");
                    $(icon).attr("task", "enroll");
                }

            }
        });
    }


});

$(document).on('click', ".added-in-wishlist, .not-added-in-wishlist", function(event) {


    let task = $(this).attr("task");
    let opportunity_id = $(this).attr("opportunity-id");
    var icon = $(this);


    if (task == "add") {
        $.ajax({
            url: "{{route('wish-list.store')}}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                opportunity_id: opportunity_id
            },
            success: function(data, textStatus, xhr) {

                if (xhr.status == 201) {

                    $(icon).removeClass("not-added-in-wishlist");
                    $(icon).addClass("added-in-wishlist");
                    $(icon).attr("task", "remove");
                }

            }
        });
    } else {
        $.ajax({
            url: "wish-list/" + opportunity_id,
            method: "DELETE",
            data: {
                "_token": "{{ csrf_token() }}",
                opportunity_id: opportunity_id
            },
            success: function(data, textStatus, xhr) {
                console.log(data);
                console.log(xhr.status);

                if (xhr.status == 204) {

                    $(icon).removeClass("added-in-wishlist");
                    $(icon).addClass("not-added-in-wishlist");
                    $(icon).attr("task", "add");
                }

            }
        });
    }


});
</script>
<script>

</script>
@endsection