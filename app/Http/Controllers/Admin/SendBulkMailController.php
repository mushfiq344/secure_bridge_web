<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendBulkQueueEmail;

class SendBulkMailController extends Controller
{
    public function sendBulkMail(Request $request)
    {
        $details = [
            'subject' => 'Weekly Notification'
        ];

        // send all mail in the queue.
        //$job = (new \App\Jobs\SendBulkQueueEmail($details));

        \App\Jobs\SendBulkQueueEmail::dispatch($details);

        return "done";
    }
}
