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
    private $field;

    /**
     * @var null|array
     */
    private $allowed;

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
                'value'    => null,
                'allowed'  => null,
                'required' => false,
            ],
            $data
        );

        $this->validateField($data['value']);
        $this->setField($data['value']);

        $this->setAllowed($data['allowed']);

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
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return null|array
     */
    public function getAllowed()
    {
        return $this->allowed;
    }

    /**
     * @param array $allowed
     */
    public function setAllowed($allowed)
    {
        $this->allowed = $allowed;
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
     * @param mixed $field
     */
    private function validateField($field)
    {
        if (true === empty($field)) {
            throw new \RunTimeException('Field must not be empty');
        }

        if (false === is_string($field)) {
            throw new \RunTimeException(
                sprintf('Field must be string, but "%s" given', gettype($field))
            );
        }
    }

}
