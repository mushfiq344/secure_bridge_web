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
        $id = $request->receiver_id;
        if (!empty($id)) {

            $checkUser = User::find($id);

            if (empty($checkUser)) {
                $userTypeNames = \App\Models\User::getTypeNames();

                return redirect('/' . $userTypeNames[Auth::user()->type] . '/dashboard')->with('error', 'no such id exists');
            }
            $ids = Message::messageIds();

            $users = DB::select("select users.id, users.name, users.email, users.type, count(is_read) as unread
            from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
            where users.id != " . Auth::id() . " and users.id != " . $id . " and users.reg_steps_completed>=2 and users.id in(" . $ids . ")
            group by users.id, users.name,  users.email,users.type");

            $usersSelect = DB::select("select users.id, users.name, users.email, users.type, count(is_read) as unread
            from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
            where users.id != " . Auth::id() . " and users.id = " . $id . " and users.reg_steps_completed>=2
            group by users.id, users.name,  users.email,users.type");

            $users = array_merge($usersSelect, $users);
            return view('common.chat.users', ['users' => $users, 'receiverId' => $request->receiver_id]);
        } else {
            $users = [];

            $ids = Message::messageIds();

            if (!empty($ids)) {

                $derivableTable = "select users.id, users.name, users.email, users.user_type,messages.created_at,messages.is_read
                from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . auth()->user()->id . "
                where users.id in(" . $ids . ") order by messages.created_at desc";

                // count how many message are unread from the selected user
                $users = DB::select("select id, name, email,user_type, count(is_read) as unread from (" . $derivableTable . ")AS derivedTable  group by derivedTable.id, derivedTable.name,  derivedTable.email,derivedTable.user_type order by derivedTable.created_at desc
    ");

            }
            return view('common.chat.users', ['users' => $users, 'receiverId' => $request->receiver_id]);
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
        $to = $request->receiver_id;
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