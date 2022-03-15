<?php

namespace App\Controller;

use App\Exception\ApiException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractController
{
    /** @var ValidatorInterface */
    protected $validator;
    /** @var SerializerInterface */
    protected $serializer;

    /**
     * @required
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @required
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function success($data = null, array $meta = []): JsonResponse
    {
        $meta['success'] = true;
        $responseData = $this->serializer->serialize($data, 'api', $meta);
        $response = new JsonResponse();
        $response->setContent($responseData);
        $response->setStatusCode(JsonResponse::HTTP_OK);

        return $response;
    }

    protected function error($message = 'An error occurred')
    {
        throw new ApiException($message, JsonResponse::HTTP_BAD_REQUEST);
    }

    protected function validate($dto, array $groups = null)
    {
        $errors = $this->validator->validate($dto, null, $groups);
        if (count($errors) > 0) {
            $message = [];
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $message[] = $error->getMessage();
            }
            $this->error(implode("\n", $message));
        }
    }
}
