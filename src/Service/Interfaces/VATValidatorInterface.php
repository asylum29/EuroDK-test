<?php

namespace App\Service\Interfaces;

use App\Dto\VAT;

interface VATValidatorInterface
{
    public function validate(string $vat): VAT;
}
