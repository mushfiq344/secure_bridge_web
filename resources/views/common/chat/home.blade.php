@extends('theme.frontend.layouts.app')
@section('head')
<style>
/* width */
::-webkit-scrollbar {
    width: 7px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #a7a7a7;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #929292;
}

ul {
    margin: 0;
    padding: 0;
}

li {
    list-style: none;
}

.user-wrapper,
.message-wrapper {
    border: 1px solid #dddddd;
    overflow-y: auto;
}

.user-wrapper {
    height: 600px;
}

.user {
    cursor: pointer;
    padding: 5px 0;
    position: relative;
}

.user:hover {
    background: #eeeeee;
}

.user:last-child {
    margin-bottom: 0;
}

.pending {
    position: absolute;
    left: 13px;
    top: 9px;
    background: #b600ff;
    margin: 0;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    line-height: 18px;
    padding-left: 5px;
    color: #ffffff;
    font-size: 12px;
}

.media-left {
    margin: 0 10px;
}

.media-left img {
    width: 64px;
    border-radius: 64px;
}

.media-body p {
    margin: 6px 0;
}

.message-wrapper {
    height: 536px;
    background: #eeeeee;
}

.messages .message {
    margin-bottom: 15px;
}

.messages .message:last-child {
    margin-bottom: 0;
}

.received,
.sent {
    width: 45%;
    padding: 3px 10px;
    border-radius: 10px;
}

.received {
    background: #ffffff;
}

.sent {
    background: #3bebff;
    float: right;
    text-align: right;
}

.message p {
    margin: 5px 0;
}

.date {
    color: #777777;
    font-size: 12px;
}

.active {
    background: #eeeeee;
}

input[type=text] {
    width: 100%;
    padding: 12px 20px;
    margin: 15px 0 0 0;
    display: inline-block;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
    border: 1px solid #cccccc;
}

input[type=text]:focus {
    border: 1px solid #aaaaaa;
}
</style>
@endsection
@section('content')
<div class="section blog-section">
    <div class="container">
        <div class="columns">
            <div class="column is-4">
                <div class="user-wrapper ">

                </div>
            </div>
            <div class="column is-8">

                <div class="gradient-background px-4 py-4">
                    <h3 class="text-light text-center">MESSAGES</h3>
                </div>
                <div id="messages">

                </div>
            </div>


        </div>
    </div>
</div>
<audio id="chat-alert-sound" style="display: none">
    <source src="{{ asset('sounds/facebook_chat.mp3') }}" />
</audio>
@endsection

@section('scripts')

<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
var active_tab_sender_id = "{{!empty($selectedId)?$selectedId:''}}";
var my_id = "{{ Auth::id() }}";
var priority_user_id = "{{!empty($selectedId)?$selectedId:''}}";

// ajax setup form csrf token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
    cluster: 'mt1',
    forceTLS: true
})

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
    // alert(JSON.stringify(data));
    if (my_id == data.from) {
        $('#' + data.to).click();
    } else if (my_id == data.to) {
        // play the alarm
        var alert_sound = document.getElementById("chat-alert-sound");
        alert_sound.play();
        if (active_tab_sender_id == data.from) {
            loadUsers();
            // if receiver is selected, reload the selected user ...
            $('#' + data.from).click();
        } else {
            console.log('here');

            loadUsers();

            // if receiver is not seleted, add notification for that user
            var pending = parseInt($('#' + data.from).find('.pending').html());

            if (pending) {
                $('#' + data.from).find('.pending').html(pending + 1);
            } else {
                $('#' + data.from).append('<span class="pending">1</span>');
            }
        }
    }
});

$(document).on("click", ".user", function() {

    $('.user').removeClass('active');
    $(this).addClass('active');
    $(this).find('.pending').remove();

    active_tab_sender_id = $(this).attr('id');
    $.ajax({
        type: "get",
        url: "/message/" + active_tab_sender_id, // need to create this route
        data: "",
        cache: false,
        success: function(data) {
            console.log('message from user', data);
            $('#messages').html(data);
            scrollToBottomFunc();
        }
    });
});

$(document).on('keyup', '#send_message_field', function(e) {
    var message = $(this).val();
    // alert(message);

    // check if enter key is pressed and message is not null also receiver is selected
    if (e.keyCode == 13 && message != '' && active_tab_sender_id != '') {
        $(this).val(''); // while pressed enter text box will be empty

        var datastr = "active_tab_sender_id=" + active_tab_sender_id + "&message=" + message;
        $.ajax({
            type: "post",
            url: "{{url('message')}}", // need to create this post route
            data: datastr,
            cache: false,
            success: function(data) {

            },
            error: function(jqXHR, status, err) {},
            complete: function() {
                scrollToBottomFunc();
            }
        })
    }
});


// make a function to scroll down auto
function scrollToBottomFunc() {
    $('.message-wrapper').animate({
        scrollTop: $('.message-wrapper').get(0).scrollHeight
    }, 50);
}
</script>



<script>
function loadUsers() {

    $.ajax({
        type: "post",
        url: "{{route('load.users')}}",
        data: {
            "_token": "{{ csrf_token() }}",


        },
        cache: false,
        success: function(data) {
            $('.user-wrapper').html(data);

            $('.user').removeClass("active");
            $('#' + active_tab_sender_id).addClass("active");
            $('#' + active_tab_sender_id).find('.pending').remove();
        }
    });
}
</script>




@if(isset($selectedId))
<script>
function initialLoadingWithPriorityUser() {

    $.ajax({
        type: "post",
        url: "{{route('load.users')}}",
        data: {
            "_token": "{{ csrf_token() }}",
            "priority_user_id": priority_user_id

        },
        cache: false,
        success: function(data) {
            $('.user-wrapper').html(data);

            $('.user').removeClass("active");
            $('#' + priority_user_id).addClass("active");
            activateTabForPriorityUser();
        }
    });
}

function activateTabForPriorityUser() {
    $('.user').removeClass('active');
    $('#' + priority_user_id).addClass('active');
    $('#' + priority_user_id).find('.pending').remove();


    $.ajax({
        type: "get",
        url: "/message/" + priority_user_id, // need to create this route
        data: "",
        cache: false,
        success: function(data) {
            console.log('message from user', data);
            $('#messages').html(data);
            scrollToBottomFunc();
        }
    });
}

initialLoadingWithPriorityUser()
</script>

@else
<script>
loadUsers();
</script>

@endif

@endsection
