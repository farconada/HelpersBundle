<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 30/06/15
 * Time: 10:42
 */

namespace Fer\HelpersBundle\EventListener;



use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use Fer\HelpersBundle\Annotation\Csrf;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class AnnotationSubscriber
 * @package Krtv\Bundle\CsrfValidatorBundle\EventListener
 */
class CsrfAnnotationSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;
    /**
     * @var
     */
    protected $csrfManager;
    /**
     * @var Reader
     */
    protected $reader;
    /**
     * @var string
     */
    protected $annotationClass = Csrf::class;

    public function __construct(RequestStack $requestStack, CsrfTokenManagerInterface $csrfManager, Reader $reader)
    {
        $this->requestStack = $requestStack;
        $this->csrfManager =  $csrfManager;
        $this->reader =       $reader;
    }
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        list($controller, $action) = $event->getController();
        $method = new \ReflectionMethod($controller, $action);
        if ($annotation = $this->supports($method)) {
            if (!$this->validate($annotation)) {
                throw new BadRequestHttpException('Token is invalid');
            }
        }
    }

    /**
     * @param Annotation $annotation
     * @return bool
     */
    public function validate(Annotation $annotation)
    {
        $token = $this->requestStack->getMasterRequest()->get($annotation->param);
        $request_method = $this->requestStack->getMasterRequest()->getMethod();
        $csrfToken = new CsrfToken($annotation->intention, $token);
        $result = $this->csrfManager->isTokenValid($csrfToken);
        if ($result && !($request_method === 'OPTIONS')) {
            $this->csrfManager->removeToken($csrfToken->getId());
        }
        return $result;
    }

    /**
     * @param \ReflectionMethod $action
     * @return bool|Annotation
     */
    public function supports(\ReflectionMethod $action)
    {
        $annotation = $this->reader->getMethodAnnotation($action, $this->annotationClass);
        if ($annotation !== null) {
            return $annotation;
        }
        return false;
    }
}