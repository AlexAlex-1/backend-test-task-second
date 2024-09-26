<?php

namespace App\Service\Entity;

use App\Entity\Tax;
use App\Enum\TaxCountryFormatEnum;
use Doctrine\ORM\EntityManagerInterface;

readonly class TaxEntityService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param TaxCountryFormatEnum $format
     * @param float $percentage
     * @return Tax
     */
    public function create(
        TaxCountryFormatEnum $format,
        float $percentage,
    ): Tax {
        $tax = new Tax();

        $tax->setFormat($format);
        $tax->setPercentage($percentage);

        $this->entityManager->persist($tax);
        $this->entityManager->flush();

        return $tax;
    }
}