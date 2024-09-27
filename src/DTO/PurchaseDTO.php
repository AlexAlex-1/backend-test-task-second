<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\DTO\DtoValidator;

readonly class PurchaseDTO
{
    use DtoValidator;

    /**
     * @var int
     */
    #[Assert\NotBlank(message: "The productId field should`t be empty")]
    private int $productId;

    /**
     * @var string
     */
    #[Assert\NotBlank(message: "The taxNumber field should`t be empty")]
    private string $taxNumber;

    /**
     * @var string|null
     */
    private ?string $couponCode;

    /**
     * @var string
     */
    #[Assert\NotBlank(message: "The paymentProcessor field should`t be empty")]
    private string $paymentProcessor;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return void
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     * @return void
     */
    public function setTaxNumber(string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @param string|null $couponCode
     * @return void
     */
    public function setCouponCode(?string $couponCode): void
    {
        $this->couponCode = $couponCode;
    }

    /**
     * @return string|null
     */
    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    /**
     * @return string
     */
    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    /**
     * @param string $paymentProcessor
     * @return void
     */
    public function setPaymentProcessor(string $paymentProcessor): void
    {
        $this->paymentProcessor = $paymentProcessor;
    }
}