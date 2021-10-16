<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id = "")
    {
        if (!empty($id)) {

            return view('common.chat.home', ['selectedId' => $id]);
        } else {

            return view('common.chat.home');
        }
    }

    public function loadUsers(Request $request)
    {
        $users = [];

        $fromIds = Message::orWhere('to', auth()->user()->id)->orWhere('from', auth()->user()->id)->distinct()->pluck('from')->toArray();
        $toIds = Message::orWhere('to', auth()->user()->id)->orWhere('from', auth()->user()->id)->distinct()->pluck('to')->toArray();
        $usersList = collect(array_merge($fromIds, $toIds))->unique();
        $usersList = $usersList->reject(function ($element) {
            return $element == auth()->user()->id;
        });

        if ($usersList->count()) {
            $priorityUserid = $request->priority_user_id;

            if (!empty($priorityUserid)) {

                $usersList = $usersList->reject(function ($element) use ($priorityUserid) {
                    return $element == $priorityUserid;
                });

                $users = \DB::table('users')

                    ->leftJoin('messages', function ($join) {
                        $join->on(function ($query) {
                            $query->orOn('users.id', '=', 'messages.from');
                            $query->orOn('users.id', '=', 'messages.to');
                        });

                    })
                    ->whereIn('users.id', array_values($usersList->toArray()))
                    ->select('users.id', 'users.email', \DB::raw("MAX(messages.id) AS last_message"), \DB::raw("MIN(messages.id) AS first_message"))
                    ->groupBy('users.id', 'users.email')
                    ->orderBy('last_message', 'desc');

                $usersWithPriorityUserOnTop = \DB::table('users')

                    ->leftJoin('messages', function ($join) {
                        $join->on(function ($query) {
                            $query->orOn('users.id', '=', 'messages.from');
                            $query->orOn('users.id', '=', 'messages.to');
                        });

                    })
                    ->whereIn('users.id', [$priorityUserid])
                    ->select('users.id', 'users.email', \DB::raw("MAX(messages.id) AS last_message"), \DB::raw("MIN(messages.id) AS first_message"))
                    ->groupBy('users.id', 'users.email')
                    ->orderBy('last_message', 'desc')
                    ->union($users)
                    ->get();

                return view('common.chat.chat-list', ['users' => $usersWithPriorityUserOnTop]);
            } else {

                $users = \DB::table('users')

                    ->leftJoin('messages', function ($join) {
                        $join->on(function ($query) {
                            $query->orOn('users.id', '=', 'messages.from');
                            $query->orOn('users.id', '=', 'messages.to');
                        });

                    })
                    ->whereIn('users.id', array_values($usersList->toArray()))
                    ->select('users.id', 'users.email', \DB::raw("MAX(messages.id) AS last_message"), \DB::raw("MIN(messages.id) AS first_message"))
                    ->groupBy('users.id', 'users.email')
                    ->orderBy('last_message', 'desc')
                    ->get();
                return view('common.chat.chat-list', ['users' => $users]);
            }
        } else {
            return view('common.chat.chat-list', ['users' => $users]);
        }

    }

    public function getMessageList()
    {
        $my_id = Auth::id();
        $data = array();
        $i = 0;

        $messages = Message::where('to', $my_id)->where('is_read', 0)->orderBy('created_at', 'desc')->limit(3)->get();

        foreach ($messages as $message) {
            $data[$i]['userName'] =
            \App\Models\User::getUserName($message->from);
            $data[$i]['message'] = $message->message;
            $data[$i]['userPhoto'] = url(\App\Models\User::getUserPhoto($message->from));
            $data[$i]['created_at'] = $message->created_at->diffForHumans();
            $i++;
        }

        return view('startup.partials.message-index', ['messages' => $messages]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();

        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->get();

        return view('common.chat.index', ['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->active_tab_sender_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'mt1',
            'useTLS' => true,
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}