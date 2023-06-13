<?php
namespace swdevelopment\craftcalapi\services;

use craft\base\Component;

class Stripe extends Component
{

    public function createCustomer( $data ){
        $stripe = new \Stripe\StripeClient( getenv('STRIPE_SECRET') );
        $customer = $stripe->customers->create([
            'description' => '',
            'email' => $data['email'],
            'name' => $data['name']
        ]);

        return $customer->getLastResponse()->headers['Request-Id'];
    }

}
