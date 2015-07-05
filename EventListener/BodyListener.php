<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 13/6/15
 * Time: 12:39
 */

namespace Fer\HelpersBundle\EventListener;


use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

/**
 * Si llega un peticion en formato json convierte el cuerpo de la peticion (objeto json) en params de Symfony
 *
 * Class BodyListener
 * @package Fer\HelpersBundle\EventListener
 */
class BodyListener {

    /**
     * Core request handler.
     *
     * @param GetResponseEvent $event
     *
     * @throws BadRequestHttpException
     * @throws UnsupportedMediaTypeHttpException
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $contentType = $request->headers->get('Content-Type');
        $format = null === $contentType
            ? $request->getRequestFormat()
            : $request->getFormat($contentType);
        $content = $request->getContent();

        if ($format === 'json' && !empty($content)) {
            $data = @json_decode($content, true);
            if (is_array($data)) {
                $request->request = new ParameterBag($data);
            }
        }

    }
}