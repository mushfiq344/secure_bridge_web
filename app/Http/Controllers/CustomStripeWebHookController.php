<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\Plan;
use App\Models\PlanUser;
use App\Models\Transaction;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookHandled;
use Laravel\Cashier\Events\WebhookReceived;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;
use Laravel\Cashier\Payment;
use Laravel\Cashier\Subscription;
use Stripe\PaymentIntent as StripePaymentIntent;
use Symfony\Component\HttpFoundation\Response;

class CustomStripeWebHookController extends Controller
{
    /**
     * Create a new WebhookController instance.
     *
     * @return void
     */
    public function __construct()
    {
      
            $this->middleware(VerifyWebhookSignature::class);
     
    }

    /**
     * Handle a Stripe webhook call.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle'.Str::studly(str_replace('.', '_', $payload['type']));

        WebhookReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod();
    }

    /**
     * Handle customer subscription updated.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $data = $payload['data']['object'];

            $user->subscriptions->filter(function (Subscription $subscription) use ($data) {
                return $subscription->stripe_id === $data['id'];
            })->each(function (Subscription $subscription) use ($data) {
                if (isset($data['status']) && $data['status'] === 'incomplete_expired') {
                    $subscription->delete();

                    return;
                }

                // Quantity...
                if (isset($data['quantity'])) {
                    $subscription->quantity = $data['quantity'];
                }

                // Plan...
                if (isset($data['plan']['id'])) {
                    $subscription->stripe_plan = $data['plan']['id'];
                }

                // Trial ending date...
                if (isset($data['trial_end'])) {
                    $trialEnd = Carbon::createFromTimestamp($data['trial_end']);

                    if (! $subscription->trial_ends_at || $subscription->trial_ends_at->ne($trialEnd)) {
                        $subscription->trial_ends_at = $trialEnd;
                    }
                }

                // Cancellation date...
                if (isset($data['cancel_at_period_end'])) {
                    if ($data['cancel_at_period_end']) {
                        $subscription->ends_at = $subscription->onTrial()
                            ? $subscription->trial_ends_at
                            : Carbon::createFromTimestamp($data['current_period_end']);
                    } else {
                        $subscription->ends_at = null;
                    }
                }

                // Status...
                if (isset($data['status'])) {
                    $subscription->stripe_status = $data['status'];
                }

                $subscription->save();
            });
        }

        return $this->successMethod();
    }

    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $user->subscriptions->filter(function ($subscription) use ($payload) {
                return $subscription->stripe_id === $payload['data']['object']['id'];
            })->each(function ($subscription) {
                $subscription->markAsCancelled();
            });
        }

        return $this->successMethod();
    }

    /**
     * Handle customer updated.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerUpdated(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['id'])) {
            $user->updateDefaultPaymentMethodFromStripe();
        }

        return $this->successMethod();
    }

    /**
     * Handle deleted customer.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerDeleted(array $payload)
    {
        if ($user = $this->getUserByStripeId($payload['data']['object']['id'])) {
            $user->subscriptions->each(function (Subscription $subscription) {
                $subscription->skipTrial()->markAsCancelled();
            });

            $user->forceFill([
                'stripe_id' => null,
                'trial_ends_at' => null,
                'card_brand' => null,
                'card_last_four' => null,
            ])->save();
        }

        return $this->successMethod();
    }

    /**
     * Handle payment action required for invoice.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleInvoicePaymentActionRequired(array $payload)
    {
        if (is_null($notification = config('cashier.payment_notification'))) {
            return $this->successMethod();
        }

        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            if (in_array(Notifiable::class, class_uses_recursive($user))) {
                $payment = new Payment(StripePaymentIntent::retrieve(
                    $payload['data']['object']['payment_intent'],
                    $user->stripeOptions()
                ));

                $user->notify(new $notification($payment));
            }
        }

        return $this->successMethod();
    }

    /**
     * Get the billable entity instance by Stripe ID.
     *
     * @param  string|null  $stripeId
     * @return \Laravel\Cashier\Billable|null
     */
    protected function getUserByStripeId($stripeId)
    {
        return Cashier::findBillable($stripeId);
    }

    /**
     * Handle successful calls on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function successMethod($parameters = [])
    {
        return new Response('Webhook Handled', 200);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function missingMethod($parameters = [])
    {
        return new Response;
    }


    protected function handlePaymentIntentCreated(array $payload)
    {   

        //$payload['data']['object']['id'];
        //$payload['data']['object']['amount'];
        if($payload['data']['object']['metadata']['type']==1){
            $opportunity=Opportunity::find($payload['data']['object']['metadata']['opportunity_id']);
            $opportunity->is_paid=1;
            $opportunity->status=Opportunity::$opportunityStatusValues["Published"];
            $opportunity->budget=$payload['data']['object']['amount']/100;
            $opportunity->transaction_code=$payload['data']['object']['id'];
            $opportunity->save();
            $transaction=new Transaction();
            $transaction->user_id=$payload['data']['object']['metadata']['user_id'];
            $transaction->transaction_code=$payload['data']['object']['id'];
            $transaction->amount=$payload['data']['object']['amount']/100;
            $transaction->type=Transaction::$transactionTypesValues["opportunity_publish"];
            $transaction->status=Transaction::$transactionStatusValues["complete"];
            $transaction->payload=json_encode($payload);
            $transaction->save();

        }else{
            $data=array();
            $data['user_id']=$payload['data']['object']['metadata']['user_id'];
            $data['plan_id']=$payload['data']['object']['metadata']['plan_id'];
            $data['transaction_code']=$payload['data']['object']['id'];
            $data['amount']=$payload['data']['object']['amount']/100;
    
            PlanUser::subscribeUser($data,$payload);
        };
      

        

        
        

        return $this->successMethod();
    }
}