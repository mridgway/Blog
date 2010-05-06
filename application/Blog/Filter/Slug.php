<?php

namespace Blog\Filter;

class Slug implements \Zend_Filter_Interface
{
    /**
     * @var Object
     */
    protected $_fetchObject;

    /**
     * @var string
     */
    protected $_fetchFunction;

    /**
     *
     *
     * @param Object $object object to call the function on
     * @param string $function function to call to get duplicates
     */
    public function __construct($object, $function)
    {
        $this->_fetchObject = $object;
        $this->_fetchFunction = $function;
    }

    /**
     * @param string $value
     * @return string
     */
    public function filter($value, $suffix = '')
    {
        $slug = self::sluggify($value) . $suffix;
        $results = $this->_fetchObject->{$this->_fetchFunction}($slug);
        if (!is_null($results) && (is_object($results) || (is_array($results) && count($results) > 0))) {
            $suffix = ($suffix == '') ? 2 : ++$suffix;
            return $this->filter($value, $suffix);
        }
        return $slug;
    }

    /**
     * Creates a URL friendly slug (NOT UNIQUE)
     *
     * @param string $str
     * @return string
     */
    public static function sluggify($str)
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        return preg_replace('/-+/', "-", $str);
    }
}