<?php

namespace App\Service\BusinessLogic\Payment\Adapter;

use App\Service\BusinessLogic\Payment\AbstractPaymentAdapter;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Exception;
class PaypalPaymentAdapter extends AbstractPaymentAdapter
{
    /**
     * @param PaypalPaymentProcessor $paypalPaymentProcessor
     */
    public function __construct(
        private readonly PaypalPaymentProcessor $paypalPaymentProcessor,
    ) {
    }

    /**
     * @param float $amount
     * @return bool
     * @throws Exception
     */
    public function pay(float $amount): bool
    {
        $amount = $this->formatAmount($amount);

        $this->paypalPaymentProcessor->pay($amount);

        return true;
    }

    /**
     * @param float $amount
     * @return string
     */
    protected function formatAmount(float $amount): string
    {
         return round($amount, 2) * 100;
    }
}