<?php


namespace Skowronline\QueryParamValidatorBundle\Tests\Validator;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @author Krzysztof Skaradziński <skaradzinski.krzysztof@gmail.com>
 */
final class FakeRequest
{
    /**
     * @var ParameterBag
     */
    public $query;

    /**
     * @param array $query
     */
    public function __construct(array $query = [])
    {
        $this->query = new ParameterBag($query);
    }
}
