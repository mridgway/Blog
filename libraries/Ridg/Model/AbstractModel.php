<?php
/*
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 */

namespace Ridg\Model;

abstract class AbstractModel
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    private static $_em = null;
    
    public function __get ($name) {
        $method = 'get'.ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }
        return $this->{$name};
    }

    public function __isset ($name) {
        if (property_exists($this, $name)) {
            return true;
        }
        return false;
    }

    public function __set ($name, $value) {
        $method = 'set'.ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->{$method}($value);
        } else {
            $this->{$name} = $value;
        }

        return $this;
    }

    public function __call ($name, $args) {
        $var = lcfirst(substr($name, 3));
        if (property_exists($this, $var)) {
            if (substr($name, 0, 3) == 'get') {
                return $this->__get($var);
            } else if (substr($name, 0, 3) == 'set') {
                return $this->__set($var, $args[0]);
            }
        }

        throw new \Exception('Method `'.$name.'` does not exist.');
    }

    public function setter($variable)
    {
        if (property_exists($this, $variable)) {
            $setter = 'set' . ucfirst($variable);
            return function ($value) {
                $this->$setter($value);
            };
        }
    }

    public function getter($variable) {
        if (property_exists($this, $variable)) {
            $getter = 'get' . ucfirst($variable);
            return function ($value) {
                $this->$setter($value);
            };
        }
    }

    public static function setEntityManager($em)
    {
        self::$_em = $em;
    }

    private static function getEntityManager()
    {
        if (null === self::$_em) {
            self::setEntityManager(\Zend_Registry::get('em'));
        }
        return self::$_em;
    }

    /**
     * @return Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return self::getEntityManager()->getRepository(get_class($this));
    }

}