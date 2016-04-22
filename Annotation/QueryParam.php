<?php


namespace Skowronline\QueryParamValidatorBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @author Krzysztof Skaradziński <skaradzinski.krzysztof@gmail.com>
 *
 * @Annotation
 * @Annotation\Target({"METHOD"})
 */
class QueryParam
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var null|array
     */
    private $values;

    /**
     * @var bool
     */
    private $required;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $data = array_replace(
            [
                'key'      => null,
                'values'   => null,
                'required' => false,
            ],
            $data
        );

        $this->validateKey($data['key']);
        $this->setKey($data['key']);

        $this->setValues($data['values']);

        if (false === is_bool($data['required'])) {
            throw new \RunTimeException(
                sprintf('Required must be boolean, but "%s" given', gettype($data['required']))
            );
        }

        $this->setRequired($data['required']);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return null|array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    /**
     * @param mixed $key
     */
    private function validateKey($key)
    {
        if (true === empty($key)) {
            throw new \RunTimeException('Key must not be empty');
        }

        if (false === is_string($key)) {
            throw new \RunTimeException(
                sprintf('Key must be string, but "%s" given', gettype($key))
            );
        }
    }

}
