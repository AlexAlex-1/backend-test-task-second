<?php

namespace App\Service\BusinessLogic\Payment\Adapter;

use App\Service\BusinessLogic\Payment\AbstractPaymentAdapter;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;
use Exception;

class StripePaymentAdapter extends AbstractPaymentAdapter
{
    /**
     * @param StripePaymentProcessor $stripePaymentProcessor
     */
    public function __construct(
        private readonly StripePaymentProcessor $stripePaymentProcessor,
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

        return $this->stripePaymentProcessor->processPayment($amount);
    }
}