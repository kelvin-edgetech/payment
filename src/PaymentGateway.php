<?php

namespace KelvinEdgetech\Payment;

class PaymentGateway
{
    public function charge($amount, $currency)
    {
        // Simulate payment processing
        return [
            'status' => 'success',
            'amount' => $amount,
            'currency' => $currency,
            'transaction_id' => uniqid('txn_', true)
        ];
    }
}
