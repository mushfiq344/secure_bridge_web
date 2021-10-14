<div class="message-wrapper">
    <div class="messages">

        <div class="section" style="padding-top: 0px;margin-top:0px;padding-bottom:0px;margin-bottom:0px;">
            <div class="container">
                <div class="columns is-vcentered">
                    <div class="column is-12">
                        <!-- Timeline -->

                        <div class="timeline">
                            @foreach($messages as $message)
                            <!-- Timeline item -->
                            <div class="timeline-item">
                                <div class="timeline-icon g-item" style="background-color: #fff;">
                                    <img class="timeline-avatar" src="{{url(\App\Models\User::getUserPhoto($message->from))}}" alt="" data-demo-src="assets/img/avatars/carolin.png">
                                </div>
                                <div class="timeline-content {{ ($message->from == Auth::id()) ? 'right' : '' }}">
                                    <div class="content-body">
                                        <div class="timeline-text">
                                            <div>{{\App\Models\User::getUserName($message->from)}}</div>
                                            <div>{{ $message->message }}</div>
                                            <span class="timestamp">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="section" style="padding-top: 0px;margin-top:0px;padding-bottom:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;">

    <input id="send_message_field" type="text" name="message" class="submit">

</div>