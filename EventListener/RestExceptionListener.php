<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 23/6/15
 * Time: 17:33
 */

namespace Fer\HelpersBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\HttpKernel\KernelEvents;
use Tbbc\RestUtil\Error\ErrorResolverInterface;

class RestExceptionListener extends ExceptionListener
{
    private $errorResolver;

    public function __construct(ErrorResolverInterface $errorResolver, $controller, LoggerInterface $logger = null)
    {
        $this->errorResolver = $errorResolver;
        parent::__construct($controller, $logger);
    }

    /**
     * @param GetResponseForExceptionEvent $event
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        static $handling;

        if (true === $handling) {
            return;
        }

        $exception = $event->getException();
        $error = $this->errorResolver->resolve($exception);
        if (null == $error) {
            return;
        }

        $handling = true;

        $response = new Response(json_encode($error->toArray()), $error->getHttpStatusCode(), array(
            'Content-Type' => 'application/json'
        ));

        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException', 10),
        );
    }
}