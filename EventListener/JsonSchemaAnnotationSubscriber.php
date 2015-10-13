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
use Fer\HelpersBundle\Annotation\JsonSchema;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class AnnotationSubscriber
 */
class JsonSchemaAnnotationSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * folder with json schemes
     * @var string
     */
    protected $schemaFolder;

    /**
     * @var string
     */
    protected $annotationClass = JsonSchema::class;

    public function __construct(RequestStack $requestStack, Reader $reader, $schemaFolder)
    {
        $this->requestStack = $requestStack;
        $this->reader =       $reader;
        $this->schemaFolder = $schemaFolder;
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
                throw new BadRequestHttpException('Not valid JSON Schema');
            }
        }
    }

    /**
     * @param Annotation $annotation
     * @return bool
     */
    public function validate(Annotation $annotation)
    {
        $request = $this->requestStack->getMasterRequest();
        $body = $request->getContent();
        $retriever = new \JsonSchema\Uri\UriRetriever();
        $isValid = true;
        try {
            $schema = $retriever->retrieve('file://' . $this->schemaFolder . '/' . $annotation->file);
            $refResolver = new \JsonSchema\RefResolver($retriever);
            $refResolver->resolve($schema, 'file://' . $this->schemaFolder);

            // Validate
            $validator = new \JsonSchema\Validator();
            $validator->check(@json_decode($body), $schema);
            $isValid = $validator->isValid();
        } catch (\Exception $ex) {
            return true;
        }
        return $isValid;

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