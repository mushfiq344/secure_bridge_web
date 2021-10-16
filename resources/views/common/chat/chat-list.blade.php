<ul class="users">
    <li class="gradient-background px-4 py-4">
        <h3 class="text-light text-center">SENDERS</h3>
    </li>
    @foreach($users as $user)
    <li class="user " id="{{ $user->id }}">
        {{--will show unread count notification--}}
        @if(\App\Models\Message::unreadMessagesSentFromUserExists($user->id))
        <span class="pending">{{\App\Models\Message::totalUnreadMessagesSentFromUser($user->id)}}</span>
        @endif


        <div class="media">
            <div class="media-left">
                <img src="{{url(\App\Models\User::getUserPhoto($user->id))}}" alt="" class="media-object">
            </div>

            <div class="media-body">
                <p class="name">{{ \App\Models\User::getUserName($user->id) }}</p>
                <p class="email">{{ $user->email }}</p>
            </div>
        </div>
    </li>
    @endforeach
</ul>
