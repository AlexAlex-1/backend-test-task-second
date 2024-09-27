<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundHttpException) {
            $response = new JsonResponse(
                [
                    'error' => 'No route found',
                    'message' => $exception->getMessage(),
                ],
                status: Response::HTTP_NOT_FOUND
            );

            $event->setResponse($response);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $response = new JsonResponse(
                [
                    'error' => 'Required method is not allowed',
                    'message' => $exception->getMessage(),
                ],
                status: Response::HTTP_METHOD_NOT_ALLOWED
            );

            $event->setResponse($response);
        }
    }
}