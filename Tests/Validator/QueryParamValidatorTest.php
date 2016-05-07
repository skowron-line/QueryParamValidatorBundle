<?php

namespace Skowronline\QueryParamValidatorBundle\Tests\Validator;

use Skowronline\QueryParamValidatorBundle\Annotation\QueryParam;
use Skowronline\QueryParamValidatorBundle\Validator\QueryParamValidator;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Krzysztof Skaradziński <skaradzinski.krzysztof@gmail.com>
 *
 * @covers Skowronline\QueryParamValidatorBundle\Validator\QueryParamValidator
 */
class QueryParamValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testRequestWithoutQuery()
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this->mockRequestStack();

        $queryParamValidator = new QueryParamValidator($requestStack);
        $this->assertTrue($queryParamValidator->validate(new QueryParam(['value' => 'sort'])));
    }

    public function testRequestWithoutQueryButRequiredParam()
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this->mockRequestStack();

        $queryParamValidator = new QueryParamValidator($requestStack);
        $this->assertFalse($queryParamValidator->validate(new QueryParam(['value' => 'sort', 'required'=> true])));
    }

    public function testRequestWithInvalidKey()
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this->mockRequestStack(['order']);

        $queryParamValidator = new QueryParamValidator($requestStack);
        $this->assertFalse($queryParamValidator->validate(new QueryParam(['value' => 'sort'])));
    }

    public function testRequestWithKeyButInvalidValue()
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this->mockRequestStack(['order'=> 'random']);

        $queryParamValidator = new QueryParamValidator($requestStack);
        $this->assertFalse(
            $queryParamValidator->validate(new QueryParam(['value' => 'order', 'allowed' => ['asc', 'desc']]))
        );
    }

    public function testRequestValidValue()
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this->mockRequestStack(['order'=> 'asc']);

        $queryParamValidator = new QueryParamValidator($requestStack);
        $this->assertTrue(
            $queryParamValidator->validate(new QueryParam(['value' => 'order', 'allowed' => ['asc', 'desc']]))
        );
    }

    /**
     * @param array $queryArray
     *
     * @return RequestStack
     */
    private function mockRequestStack(array $queryArray = [])
    {
        /** @var RequestStack $requestStack */
        $requestStack = $this
            ->getMockBuilder(RequestStack::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestStack
            ->expects($this->once())
            ->method('getMasterRequest')
            ->willReturn(new FakeRequest($queryArray));

        return $requestStack;
    }

}
