<?php


namespace Skowronline\QueryParamValidatorBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Skowronline\QueryParamValidatorBundle\Annotation\QueryParam;
use Skowronline\QueryParamValidatorBundle\Validator\QueryParamValidator;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Krzysztof Skaradziński <skaradzinski.krzysztof@gmail.com>
 */
class QueryParamValidatorListener
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var QueryParamValidator
     */
    private $queryParamValidator;

    /**
     * @param Reader $reader
     * @param QueryParamValidator $queryParamValidator
     */
    public function __construct(Reader $reader, QueryParamValidator $queryParamValidator)
    {
        $this->reader = $reader;
        $this->queryParamValidator = $queryParamValidator;
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @throws NotFoundHttpException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (false === is_array($controller = $event->getController())) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        $annotations = $this->reader->getMethodAnnotations($method);
        if (true === empty($annotations)) {
            return;
        }

        foreach ($annotations as $annotation) {
            if (false === ($annotation instanceof QueryParam)) {
                continue;
            }

            if (true === $this->queryParamValidator->validate($annotation)) {
                continue;
            }

            throw new NotFoundHttpException;
        }

    }
}
