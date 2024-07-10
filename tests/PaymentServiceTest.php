<?php

use PHPUnit\Framework\TestCase;
use KelvinEdgetech\Payment\PaymentService;
use KelvinEdgetech\Payment\PaymentGateway;

class PaymentServiceTest extends TestCase
{
    public function testProcessPayment()
    {
        $paymentGateway = new PaymentGateway();
        $paymentService = new PaymentService($paymentGateway);

        $result = $paymentService->processPayment(100, 'USD');

        $this->assertEquals('success', $result['status']);
        $this->assertEquals(100, $result['amount']);
        $this->assertEquals('USD', $result['currency']);
        $this->assertNotEmpty($result['transaction_id']);
    }

    public function testProcessPaymentThrowsExceptionForInvalidAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $paymentGateway = new PaymentGateway();
        $paymentService = new PaymentService($paymentGateway);

        $paymentService->processPayment(0, 'USD');
    }
}
