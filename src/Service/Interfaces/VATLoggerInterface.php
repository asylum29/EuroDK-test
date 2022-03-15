<?php

namespace App\Service\Interfaces;

use App\Dto\VAT;
use App\Entity\VATLog;

interface VATLoggerInterface
{
    public function write(VAT $data): VATLog;
}
