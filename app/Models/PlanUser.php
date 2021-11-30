<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanUser extends Model
{
    use HasFactory;
    protected $table = "plan_user";
    public static $userPlanStatusValues=array(
        'inactive'=>'0',
        'active'=>'1'
    );

    public static function subscribeUser($data, $payload){

        $userPlan=PlanUser::where('plan_id',$data['plan_id'])->where('user_id',$data['user_id'])->first();
        $transaction=Transaction::where('transaction_code',$data['transaction_code'])->first();
        if(empty($transaction)){

            if(empty($userPlan)){
                self::createSubscription($data,$payload);
               
            }else{
    
                if($userPlan->end_date<date('Y-m-d')){
                    self::createSubscription($data,$payload);
                   
                }else{ 
    
                    if(!$userPlan->status==self::$userPlanStatusValues['active']){
                        self::createSubscription($data,$payload);
                    }
                    
                }
            }
        }
           

       

    }

    public static function createSubscription($data,$payload){
        $transaction=new Transaction();
        $transaction->user_id=$data['user_id'];
        $transaction->transaction_code=$data['transaction_code'];
        $transaction->amount=$data['amount'];
        $transaction->type=Transaction::$transactionTypesValues["Subscription"];
        $transaction->status=Transaction::$transactionStatusValues["complete"];
        $transaction->payload=json_encode($payload);
        $transaction->save();
        
        $plan=Plan::findOrFail($data['plan_id']);
        $userPlan= new PlanUser();
        $userPlan->plan_id= $plan->id;
        $userPlan->user_id=$data['user_id'];
        $userPlan->start_date=date('Y-m-d');
        $userPlan->end_date= date('Y-m-d', strtotime("+".$plan->duration." day"));
        $userPlan->transaction_id=$transaction->id;
        $userPlan->status=self::$userPlanStatusValues['active'];
        $userPlan->save();
    }
}
