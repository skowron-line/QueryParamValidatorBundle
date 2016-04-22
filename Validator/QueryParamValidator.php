<?php

namespace Skowronline\QueryParamValidatorBundle\Validator;

use Skowronline\QueryParamValidatorBundle\Annotation\QueryParam;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Krzysztof Skaradziński <skaradzinski.krzysztof@gmail.com>
 */
class QueryParamValidator
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param QueryParam $queryParam
     *
     * @return bool
     */
    public function validate(QueryParam $queryParam)
    {
        $key = $queryParam->getKey();
        $resolver = new OptionsResolver();
        $resolver->setDefined($key);

        if (true === $queryParam->isRequired()) {
            $resolver->setRequired($key);
        }

        if (null !== $queryParam->getValues()) {
            $resolver->setAllowedValues($key, $queryParam->getValues());
        }

        try {
            $resolver->resolve($this->requestStack->getMasterRequest()->query->all());
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
