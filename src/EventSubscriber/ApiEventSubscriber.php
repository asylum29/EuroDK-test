<?php

namespace App\EventSubscriber;

use App\Exception\ApiException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ApiEventSubscriber implements EventSubscriberInterface
{
    private $serializer;
    private $prod;

    public function __construct(
        ContainerInterface $container,
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
        $this->prod = 'prod' === $container->getParameter('kernel.environment');
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();
        $meta = [
            'success' => false,
            'error_message' => $throwable->getMessage(),
        ];
        if (!$this->prod) {
            $details = [
                'error_code' => $throwable->getCode(),
                'error_traceback' => $throwable->getTrace(),
                'error_file' => $throwable->getFile(),
                'error_line' => $throwable->getLine(),
            ];
            $meta = array_merge($meta, $details);
        }
        $responseData = $this->serializer->serialize([], 'api', $meta);

        $response = new JsonResponse();
        $response->setContent($responseData);
        if ($throwable instanceof ApiException) {
            $response->setStatusCode($throwable->getStatusCode());
        } else {
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
