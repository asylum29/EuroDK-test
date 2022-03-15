<?php

namespace App\Controller;

use App\Exception\ApiException;
use App\Service\Interfaces\VATLoggerInterface;
use App\Service\Interfaces\VATValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vies", name="vies_")
 */
class VIESController extends BaseController
{
    /**
     * @Route("/vat/validate", name="vat_validate", methods={"GET"})
     *
     * @param Request $request
     * @param VATValidatorInterface $validator
     * @param VATLoggerInterface $logger
     *
     * @return Response
     * @throws ApiException
     */
    public function VATValidate(
        Request $request,
        VATValidatorInterface $validator,
        VATLoggerInterface $logger
    ): Response {
        $result = $validator->validate($request->get('vat'));
        if ($result->getValid()) {
            $logger->write($result);

            return $this->success($result);
        }

        $this->error('VAT not valid');
    }
}
