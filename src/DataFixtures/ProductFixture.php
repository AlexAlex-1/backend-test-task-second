<?php

namespace App\DataFixtures;

use App\Service\Entity\ProductEntityService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    /**
     * @param ProductEntityService $productEntityService
     */
    public function __construct(
        private readonly ProductEntityService $productEntityService,
    ) {
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getProductsData() as $productData) {
            $this->productEntityService->create(
                $productData['name'],
                $productData['price'],
            );
        }
    }

    /**
     * @return array[]
     */
    public function getProductsData(): array
    {
        return [
            [
                'name' => 'Iphone',
                'price' => 100,
            ],
            [
                'name' => 'Наушники',
                'price' => 20,
            ],
            [
                'name' => 'Чехол',
                'price' => 10,
            ],
        ];
    }
}