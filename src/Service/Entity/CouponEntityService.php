<?php

namespace App\Service\Entity;

use App\Entity\Coupon;
use App\Enum\CouponTypeEnum;
use Doctrine\ORM\EntityManagerInterface;

readonly class CouponEntityService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param string $code
     * @param CouponTypeEnum $couponType
     * @param float $discountValue
     * @return Coupon
     */
    public function create(
        string $code,
        CouponTypeEnum $couponType,
        float $discountValue,
    ): Coupon {
        $coupon = new Coupon();

        $coupon->setCode($code);
        $coupon->setDiscountType($couponType);
        $coupon->setDiscountValue($discountValue);

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        return $coupon;
    }
}