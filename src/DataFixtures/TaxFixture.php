<?php

namespace App\DataFixtures;

use App\Enum\TaxCountryFormatEnum;
use App\Service\Entity\ProductEntityService;
use App\Service\Entity\TaxEntityService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaxFixture extends Fixture
{
    /**
     * @param TaxEntityService $taxEntityService
     */
    public function __construct(
        private readonly TaxEntityService $taxEntityService,
    ) {
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getTaxesData() as $taxData) {
            $this->taxEntityService->create(
                $taxData['format'],
                $taxData['percentage'],
            );
        }
    }

    /**
     * @return array[]
     */
    public function getTaxesData(): array
    {
        return [
            [
                'format' => TaxCountryFormatEnum::TAX_GERMANY_FORMAT,
                'percentage' => 19,
            ],
            [
                'format' => TaxCountryFormatEnum::TAX_ITALY_FORMAT,
                'percentage' => 22,
            ],
            [
                'format' => TaxCountryFormatEnum::TAX_FRANCE_FORMAT,
                'percentage' => 20,
            ],
            [
                'format' => TaxCountryFormatEnum::TAX_GREECE_FORMAT,
                'percentage' => 24,
            ],
        ];
    }
}