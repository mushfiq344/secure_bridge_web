<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mail;
use App\Models\User;
use App\Jobs\SendBulkQueueEmail;

class MailController extends Controller
{
    /**
     * Display a listing of the resource. change
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $mails = Mail::all();
        return view('admin.mail.index', compact('mails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.mail.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if ($request->condition == "on") {
            $mail = new mail;
            $mail->title = $request->title;
            $mail->body = $request->body;
            $mail->active = 1;

            // $mail->scheduled_at =  $request->scheduled_at;
            // if (!empty($request->scheduled_at)) {
            //     $mail->is_scheduled = 1;
            // }



            $mail->start_user_id = User::min('id');
            $mail->current_user_id = User::min('id');
            $mail->end_user_id = User::max('id');
            $mail->save();
        } else {
            $mail = new mail;
            $mail->title = $request->title;
            $mail->body = $request->body;
            $mail->save();
            foreach ($request->users as $id) {
                $user = User::find($id);
                $this->sendMail($user->name, $mail->title, $mail->body, $user->email);
            }
        }



        return redirect(route('mails.index'))->with('success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back()->with('success', 'Deleted');
    }


    public  function sendMail(
        $name,
        $subject,
        $body,
        $email
    ) {


        \Mail::send(
            'admin.mail.template',
            ['name' => $name, 'body' => $body],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(env('MAIL_FROM_ADDRESS'), "Uncrowd.io");
                $mail->to($email, $name);
                $mail->subject($subject);
            }
        );

        if (\Mail::failures()) {
            return ['status' => 'error', 'message' => 'Something went wrong. Please try again'];
        }
        return ['status' => 'success', 'message' => 'Thanks for joining with us! You need to verify your account. We have sent you an activation code, please check your email.'];
    }
}
