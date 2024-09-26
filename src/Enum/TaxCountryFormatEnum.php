<?php

namespace App\Enum;

enum TaxCountryFormatEnum: string
{
    case TAX_GERMANY_FORMAT = 'DEXXXXXXXXX';
    case TAX_ITALY_FORMAT = 'ITXXXXXXXXXXX';
    case TAX_GREECE_FORMAT = 'GRXXXXXXXXX';
    case TAX_FRANCE_FORMAT = 'FRYYXXXXXXXXX';
}