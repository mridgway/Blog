<?php

namespace Core\Service;

abstract class AbstractService
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    private static $_em = null;

    /**
     * @param EntityManager $em
     */
    public static function setEntityManager(\Doctrine\ORM\EntityManager $em)
    {
        self::$_em = $em;
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public static function getEntityManager()
    {
        if (null === self::$_em) {
            self::$_em = \Zend_Registry::get('em');
        }
        return self::$_em;
    }
}