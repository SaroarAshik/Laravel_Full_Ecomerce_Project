<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller{

    public function store(Request $request){
        \Stripe\Stripe::setApiKey('sk_test_51PZBK5Rqrag8E52FZUe7EUnXB8XAmaQIYLANlch1RJaZyDfIAq1QZBiVs83MaYH6LoyE1fPvdBk2GjmcTxunmD9Y00R4bIKPDV');
        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
        'amount' => 999*100,
        'currency' => 'usd',
        'description' => 'Payment From Saroar Ashik',
        'source' => $token,
        'metadata' => ['order_id' => uniqid()],
        ]);

        dd($charge);

    }
}
