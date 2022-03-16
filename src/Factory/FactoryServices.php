<?php

namespace App\Factory;

use App\Service\VIES;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FactoryServices
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createVIES(): VIES
    {
        $wsdl = $this->container->getParameter('vies_wsdl_url');

        return new VIES($wsdl);
    }
}
