<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\API\User\UserBaseController;
use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\OpportunityUser;
use App\Models\WishList;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class RewardsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success['user_wishes'] = WishList::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        $success['user_enrollments'] = OpportunityUser::where('user_id', auth()->user()->id)->pluck('opportunity_id')->toArray();
        $success['upload_path'] = Opportunity::$_uploadPath;
        $success["opportunities"]=OpportunityUser::userRewardingOpportunities();
        $success["total_credits"]=auth()->user()->credits;
        return $this->sendResponse($success, 'opportunities fetch successfully.', 200);
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            // $success["balance"]=$stripe->accounts->create(['type' => 'standard']);
            
            $success["balance"]=$stripe->transfers->create([
                'amount' => 400,
                'currency' => 'usd',
                'destination' => 'acct_1KcbBAR5WnwwLEmZ',
                'transfer_group' => 'ORDER_95',
              ]);
              return $this->sendResponse( $success, 'payment created', 200);
    
            }catch (\Exception $e) {
              
                return $this->sendError($e->getMessage(),[]);
               
            }
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
        //
    }
}
