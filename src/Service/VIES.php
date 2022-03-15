<?php

namespace App\Service;

use App\Classes\DtoManager;
use App\Dto\VAT;
use App\Service\Interfaces\VATValidatorInterface;
use Exception;
use ReflectionException;
use SoapClient;

class VIES implements VATValidatorInterface
{
    private $client;

    public function __construct(string $wsdlUrl)
    {
        $this->client = new SoapClient($wsdlUrl);
    }

    /**
     * @param string $vat
     *
     * @return VAT
     *
     * @throws ReflectionException
     */
    public function validate(string $vat): VAT
    {
        if (!preg_match('/^([A-Z]*)([0-9]*)$/u', $vat, $matches)) {
            throw new Exception('Invalid VAT format');
        }
        /** @noinspection PhpUndefinedMethodInspection */
        $response = $this->client->checkVat([
            'countryCode' => $matches[1],
            'vatNumber' => $matches[2],
        ]);
        $response = json_decode(json_encode($response), true);

        return DtoManager::fill(VAT::class, $response);
    }
}
