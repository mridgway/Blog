<?php

namespace User\Filter;

class PassHash implements \Zend_Filter_Interface
{
    /**
     * @var string
     */
    protected $_algorithm;

    /**
     * @var string
     */
    protected $_key;

    /**
     * @param string $algorithm
     * @param integer $keyLength
     */
    public function __construct($algorithm = 'sha256', $key = '6pmEbL')
    {
        $this->setAlgorithm($algorithm);
        $this->setKey($key);
    }

    public function filter($value)
    {
        return hash_hmac($this->_algorithm, $value, $this->_key);
    }

    /**
     * @param string $algorithm
     * @return PassHash
     */
    public function setAlgorithm($algorithm)
    {
        if (!in_array($algorithm, hash_algos())) {
            throw new \Exception('Hashing algorithm is invalid.');
        }
        $this->_algorithm = $algorithm;
        return $this;
    }

    /**
     * @param integer $keyLength
     * @return PassHash
     */
    public function setKey($key)
    {
        $this->_key = $key;
        return $this;
    }
}