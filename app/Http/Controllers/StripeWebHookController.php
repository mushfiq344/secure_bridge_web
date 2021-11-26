<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class StripeWebHookController extends Controller
{
    public function handleWebhook(Request $request){
        $wishList=new WishList;
        $wishList->user_id=1;
        $wishList->opportunity_id=2;
        $wishList->status="sss";
        $wishList->save();
        return new Response('Webhook Handled 3', 200);
    }
}
