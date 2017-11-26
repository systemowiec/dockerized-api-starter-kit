<?php

namespace Application\Http\Listeners;

use Application\Persistence\Exception\ProductNotFound;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class ExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = (new Response())->setContent(
            json_encode(
                [
                    "message" => $exception->getMessage(),
                ]
            )
        );

        $code = $this->calculateResponseCode($exception);

        $response->setStatusCode($code);
        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }

    /**
     * Calculate the response code for a given exception
     *
     * @param \Exception $exception
     *
     * @return int|mixed
     */
    private function calculateResponseCode(\Exception $exception)
    {
        // We currently use exception code as HTTP code, but in the future this will be reconsidered
        if ($exception instanceof ProductNotFound) {
            return $exception->getCode();
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
