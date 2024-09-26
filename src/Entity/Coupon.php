<?php

namespace App\Entity;

use App\Enum\CouponTypeEnum;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $code = null;

    /**
     * @var CouponTypeEnum|null
     */
    #[ORM\Column(
        type: "string",
        length: 255,
        enumType: CouponTypeEnum::class
    )]
    private ?CouponTypeEnum $discountType = null;

    /**
     * @var float|null
     */
    #[ORM\Column]
    private ?float $discountValue = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return CouponTypeEnum|null
     */
    public function getDiscountType(): ?CouponTypeEnum
    {
        return CouponTypeEnum::tryFrom($this->discountType);
    }

    /**
     * @param CouponTypeEnum $discountType
     * @return $this
     */
    public function setDiscountType(CouponTypeEnum $discountType): static
    {
        $this->discountType = $discountType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getDiscountValue(): ?float
    {
        return $this->discountValue;
    }

    /**
     * @param float $discountValue
     * @return $this
     */
    public function setDiscountValue(float $discountValue): static
    {
        $this->discountValue = $discountValue;

        return $this;
    }
}
