<?php

namespace App\Service\BusinessLogic;

use App\DTO\PurchaseDTO;
use App\Service\BusinessLogic\Payment\PaymentAdapterInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Exception;
use Symfony\Component\DependencyInjection\ServiceLocator;

readonly class PaymentService
{
    /**
     * @param ServiceLocator $adapters
     * @param CalculatePriceService $calculatePriceService
     */
    public function __construct(
        private ServiceLocator $adapters,
        private CalculatePriceService $calculatePriceService,
    ) {
    }

    /**
     * @param PurchaseDTO $data
     * @return void
     * @throws Exception
     */
    public function processPayment(PurchaseDTO $data): void
    {
        $paymentAdapter = $this->getPaymentAdapter($data->getPaymentProcessor());
        $amount = $this->calculatePriceService->calculatePrice(
            $data->getProductId(),
            $data->getTaxNumber(),
            $data->getCouponCode(),
        );

        $paymentStatus = $paymentAdapter->pay($amount);

        /**
         * I chose this way cause payment methods doesn't return the text status.
         * So, no reason to return the false status in the response.
         */
        if ($paymentStatus === false) {
            throw new Exception(
                'Error processing payment. Please check your data and try again later.'
            );
        }
    }

    /**
     * @param string $paymentProcessor
     * @return PaymentAdapterInterface
     * @throws Exception
     */
    private function getPaymentAdapter(string $paymentProcessor): PaymentAdapterInterface
    {
        if ($this->adapters->has($paymentProcessor)) {
            return $this->adapters->get($paymentProcessor);
        }

        throw new Exception("Payment adapter for processor '$paymentProcessor' not found.");
    }
}