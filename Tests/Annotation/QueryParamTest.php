<?php

namespace Skowronline\QueryParamValidatorBundle\Tests\Annotation;

use Skowronline\QueryParamValidatorBundle\Annotation\QueryParam;

/**
 * @author Krzysztof Skaradziński <skaradzinski.krzysztof@gmail.com>
 *
 * @covers QueryParam
 */
class QueryParamTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidKeyMissing()
    {
        $this->expectException(\RunTimeException::class);
        $this->expectExceptionMessage('Key must not be empty');

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

        new QueryParam(['key'=> $type]);
    }

    /**
     * @return array
     */
    public function invalidKeyDataProvider()
    {
        return [
            [12, 'Key must be string, but "integer" given'],
            [0.7, 'Key must be string, but "double" given'],
            [new \stdClass(), 'Key must be string, but "object" given'],
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

        new QueryParam(['key'=> 'sort', 'required'=> $type]);
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
        $queryParam = new QueryParam(['key'=> 'sort']);
        $this->assertFalse($queryParam->isRequired());
        $this->assertNull($queryParam->getValues());
        $this->assertSame('sort', $queryParam->getKey());

        $queryParam2 = new QueryParam(['key'=> 'sort', 'required'=> true]);
        $this->assertTrue($queryParam2->isRequired());
        $this->assertNull($queryParam2->getValues());
        $this->assertSame('sort', $queryParam2->getKey());

        $queryParam3 = new QueryParam(['key'=> 'sort', 'values'=> [], 'required'=> true]);
        $this->assertTrue($queryParam3->isRequired());
        $this->assertEmpty($queryParam3->getValues());
        $this->assertSame('sort', $queryParam3->getKey());

        $queryParam4 = new QueryParam(['key'=> 'sort', 'values'=> ['asc', 'desc'], 'required'=> true]);
        $this->assertTrue($queryParam4->isRequired());
        $this->assertSame(['asc', 'desc'],$queryParam4->getValues());
        $this->assertSame('sort', $queryParam4->getKey());
    }
}

