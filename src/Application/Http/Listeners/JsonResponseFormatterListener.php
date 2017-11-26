<?php

namespace Application\Http\Listeners;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Serializer\Serializer;

class JsonResponseFormatterListener
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * QuoteResponseListener constructor.
     *
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelResponse(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        $response = new Response($this->serializer->serialize($result, 'json'), Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }
}
