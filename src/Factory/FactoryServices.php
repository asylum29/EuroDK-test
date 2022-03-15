<?php

namespace App\Factory;

use App\Service\Interfaces\VATValidatorInterface;
use App\Service\VIES;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FactoryServices
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createVIES(): VATValidatorInterface
    {
        $wsdl = $this->container->getParameter('vies_wsdl_url');

        return new VIES($wsdl);
    }
}
