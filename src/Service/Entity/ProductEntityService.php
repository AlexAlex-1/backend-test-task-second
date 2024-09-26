<?php

namespace App\Service\Entity;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

readonly class ProductEntityService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param string $name
     * @param float $price
     * @return Product
     */
    public function create(
        string $name,
        float $price,
    ): Product {
        $product = new Product();

        $product->setName($name);
        $product->setPrice($price);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}