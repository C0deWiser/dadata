<?php

namespace Codewiser\Dadata\Taxpayer\Enum;

enum TaxpayerType: string
{
    case unknown = 'unknown';
    case legal = 'LEGAL';
    case individual = 'INDIVIDUAL';
}
