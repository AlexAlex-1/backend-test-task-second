<?php

namespace App\Service\BusinessLogic\Payment;

interface PaymentAdapterInterface
{
    /**
     * @param float $amount
     * @return bool
     */
    public function pay(float $amount): bool;
}