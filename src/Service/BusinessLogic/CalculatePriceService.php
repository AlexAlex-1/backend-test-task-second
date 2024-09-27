<?php

namespace App\Service\BusinessLogic;

use App\DTO\CalculatePriceDTO;
use App\Entity\Coupon;
use App\Enum\CouponTypeEnum;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use Exception;

readonly class CalculatePriceService
{
    /**
     * @param TaxRepository $taxRepository
     * @param ProductRepository $productRepository
     * @param CouponRepository $couponRepository
     */
    public function __construct(
        private TaxRepository     $taxRepository,
        private ProductRepository $productRepository,
        private CouponRepository  $couponRepository,
    ) {
    }

    /**
     * @param CalculatePriceDTO $data
     * @return float
     * @throws Exception
     */
    public function calculatePrice(
        CalculatePriceDTO $data,
    ): float {
        $product = $this->productRepository->find($data->getProductId());

        if (!$product) {
            throw new Exception('Product not found');
        }

        $price = $product->getPrice();

        if ($couponCode = $data->getCouponCode()) {
            $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);

            if (!$coupon) {
                throw new Exception('Coupon code not found');
            }

            $price = $this->applyCoupon($price, $coupon);
        }

        $price = $this->applyTax($price, $data->getTaxNumber());

        return $price;
    }

    /**
     * @param float $price
     * @param Coupon $coupon
     * @return float
     */
    private function applyCoupon(float $price, Coupon $coupon): float
    {
        switch ($coupon->getDiscountType()) {
            case CouponTypeEnum::DISCOUNT_FIX:
                $price = $price - $coupon->getDiscountValue();
                break;
            case CouponTypeEnum::DISCOUNT_PERCENTAGE:
                $price = $price - ($price * ($coupon->getDiscountValue() / 100));
                break;
        }

        return max($price, 0);
    }

    /**
     * @param float $price
     * @param string $customerTaxNumber
     * @return float
     * @throws Exception
     */
    private function applyTax(float $price, string $customerTaxNumber): float
    {
        $taxFormat = $this->getTaxFormatByCustomerTaxNumber($customerTaxNumber);
        $tax = $this->taxRepository->getByTaxFormat($taxFormat);

        if (!$tax) {
            throw new Exception("Tax number is incorrect");
        }

        $taxTotal = ($tax->getPercentage() / 100) * $price;

        return $price + $taxTotal;
    }

    /**
     * @param string $customerTaxNumber
     * @return string
     */
    public function getTaxFormatByCustomerTaxNumber(string $customerTaxNumber): string
    {
        $countryCode = substr($customerTaxNumber, 0, 2);

        $taxFormat = substr($customerTaxNumber, 2);
        $taxFormat = preg_replace('/[A-Z]/', 'Y', $taxFormat);
        $taxFormat = preg_replace('/\d/', 'X', $taxFormat);

        return $countryCode . $taxFormat;
    }
}