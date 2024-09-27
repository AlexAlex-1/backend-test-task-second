<?php

namespace App\Service\BusinessLogic\Payment;

abstract class AbstractPaymentAdapter implements PaymentAdapterInterface
{
    /**
     * @param float $amount
     * @return bool
     */
    abstract public function pay(float $amount): bool;

    /**
     * @param float $amount
     * @return mixed
     */
    protected function formatAmount(float $amount): mixed
    {
        return round($amount, 2);
    }
}