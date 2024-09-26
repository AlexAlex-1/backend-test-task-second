<?php

namespace App\DataFixtures;

use App\Enum\CouponTypeEnum;
use App\Service\Entity\CouponEntityService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixture extends Fixture
{
    /**
     * @param CouponEntityService $couponEntityService
     */
    public function __construct(
        private readonly CouponEntityService $couponEntityService,
    ) {
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getCouponsData() as $couponData) {
            $this->couponEntityService->create(
                $couponData['code'],
                $couponData['discount_type'],
                $couponData['discount_value'],
            );
        }
    }

    /**
     * @return array[]
     */
    public function getCouponsData(): array
    {
        return [
            [
                'code' => 'P10',
                'discount_type' => CouponTypeEnum::DISCOUNT_PERCENTAGE,
                'discount_value' => 10,
            ],
            [
                'code' => 'P40',
                'discount_type' => CouponTypeEnum::DISCOUNT_FIX,
                'discount_value' => 40,
            ],
            [
                'code' => 'P50',
                'discount_type' => CouponTypeEnum::DISCOUNT_FIX,
                'discount_value' => 50,
            ],
            [
                'code' => 'P70',
                'discount_type' => CouponTypeEnum::DISCOUNT_PERCENTAGE,
                'discount_value' => 70,
            ],
        ];
    }
}