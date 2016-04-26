<?php

namespace Skowronline\QueryParamValidatorBundle\Tests\Annotation;

use Skowronline\QueryParamValidatorBundle\Annotation\QueryParam;

/**
 * @author Krzysztof Skaradziński <skaradzinski.krzysztof@gmail.com>
 *
 * @covers Skowronline\QueryParamValidatorBundle\Annotation\QueryParam
 */
class QueryParamTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidKeyMissing()
    {
        $this->expectException(\RunTimeException::class);
        $this->expectExceptionMessage('Field must not be empty');

        new QueryParam();
    }

    /**
     * @dataProvider invalidKeyDataProvider
     *
     * @param mixed $type
     * @param string $exceptionMessage
     */
    public function testInvalidKeyType($type, $exceptionMessage)
    {
        $this->expectException(\RunTimeException::class);
        $this->expectExceptionMessage($exceptionMessage);

        new QueryParam(['value'=> $type]);
    }

    /**
     * @return array
     */
    public function invalidKeyDataProvider()
    {
        return [
            [12, 'Field must be string, but "integer" given'],
            [0.7, 'Field must be string, but "double" given'],
            [new \stdClass(), 'Field must be string, but "object" given'],
        ];
    }

    /**
     * @dataProvider invalidRequiredTypeProvider
     *
     * @param $type
     * @param $exceptionMessage
     */
    public function testInvalidRequiredType($type, $exceptionMessage)
    {
        $this->expectException(\RunTimeException::class);
        $this->expectExceptionMessage($exceptionMessage);

        new QueryParam(['value'=> 'sort', 'required'=> $type]);
    }

    /**
     * @return array
     */
    public function invalidRequiredTypeProvider()
    {
        return [
            [12, 'Required must be boolean, but "integer" given'],
            [0.7, 'Required must be boolean, but "double" given'],
            [new \stdClass(), 'Required must be boolean, but "object" given'],
            [[], 'Required must be boolean, but "array" given'],
            ['true', 'Required must be boolean, but "string" given'],
        ];
    }

    public function testObject()
    {
        $queryParam = new QueryParam(['value'=> 'sort']);
        $this->assertFalse($queryParam->isRequired());
        $this->assertNull($queryParam->getAllowed());
        $this->assertSame('sort', $queryParam->getField());

        $queryParam2 = new QueryParam(['value'=> 'sort', 'required'=> true]);
        $this->assertTrue($queryParam2->isRequired());
        $this->assertNull($queryParam2->getAllowed());
        $this->assertSame('sort', $queryParam2->getField());

        $queryParam3 = new QueryParam(['value'=> 'sort', 'allowed'=> [], 'required'=> true]);
        $this->assertTrue($queryParam3->isRequired());
        $this->assertEmpty($queryParam3->getAllowed());
        $this->assertSame('sort', $queryParam3->getField());

        $queryParam4 = new QueryParam(['value'=> 'sort', 'allowed'=> ['asc', 'desc'], 'required'=> true]);
        $this->assertTrue($queryParam4->isRequired());
        $this->assertSame(['asc', 'desc'],$queryParam4->getAllowed());
        $this->assertSame('sort', $queryParam4->getField());
    }
}

