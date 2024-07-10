<?php

namespace KelvinEdgetech\Payment;

class PaymentService
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function processPayment($amount, $currency = 'USD')
    {
        // Basic validation
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Amount must be greater than zero.");
        }

        // Call the payment gateway to process the payment
        return $this->paymentGateway->charge($amount, $currency);
    }
}
