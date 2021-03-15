<?php

namespace App\Cart\Payments\Gateways;

use App\Cart\Payments\Gateway;
use App\Models\User;
use Stripe\Customer as StripeCustomer;

class StripeGateway implements Gateway
{
    protected User $user;

    public function withUser(User $user): StripeGateway
    {
        $this->user = $user;

        return $this;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function createCustomer(): StripeGatewayCustomer
    {
        if ($this->user->gateway_customer_id) {
            return $this->getCustomer();
        }

        $customer = new StripeGatewayCustomer(
            $this, $this->createStripeCustomer()
        );

        $this->user->update([
            'gateway_customer_id' => $customer->id()
        ]);

        return $customer;
    }

    public function getCustomer(): StripeGatewayCustomer
    {
        return new StripeGatewayCustomer(
            $this, StripeCustomer::retrieve($this->user->gateway_customer_id)
        );
    }

    protected function createStripeCustomer(): StripeCustomer
    {
        return StripeCustomer::create([
            'email' => $this->user->email
        ]);
    }
}
