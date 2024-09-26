<?php

namespace App\Entity;

use App\Enum\TaxCountryFormatEnum;
use App\Repository\TaxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaxRepository::class)]
class Tax
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var TaxCountryFormatEnum|null
     */
    #[ORM\Column(
        type: "string",
        length: 255,
        enumType: TaxCountryFormatEnum::class
    )]
    private ?TaxCountryFormatEnum $format = null;

    /**
     * @var float|null
     */
    #[ORM\Column]
    private ?float $percentage = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return TaxCountryFormatEnum|null
     */
    public function getFormat(): ?TaxCountryFormatEnum
    {
        return TaxCountryFormatEnum::tryFrom($this->format);
    }

    /**
     * @param TaxCountryFormatEnum $format
     * @return $this
     */
    public function setFormat(TaxCountryFormatEnum $format): static
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     * @return $this
     */
    public function setPercentage(float $percentage): static
    {
        $this->percentage = $percentage;

        return $this;
    }
}
