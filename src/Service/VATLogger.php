<?php

namespace App\Service;

use App\Dto\VAT;
use App\Entity\VATLog;
use App\Service\Interfaces\VATLoggerInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class VATLogger implements VATLoggerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param VAT $data
     *
     * @return VATLog
     *
     * @throws Exception
     */
    public function write(VAT $data): VATLog
    {
        $log = new VATLog();
        $log->setCountryCode($data->getCountryCode());
        $log->setVatNumber($data->getVatNumber());
        $log->setRequestDate(new DateTime($data->getRequestDate()));
        $log->setValid($data->getValid());
        $log->setAddress($data->getAddress());
        $log->setName($data->getName());

        $this->em->persist($log);
        $this->em->flush();

        return $log;
    }
}
