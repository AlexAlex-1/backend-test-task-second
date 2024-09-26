<?php

namespace App\Enum;

enum CouponTypeEnum: string
{
    case DISCOUNT_FIX = 'discount_fix';
    case DISCOUNT_PERCENTAGE = 'discount_percentage';
}