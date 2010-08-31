<?php

namespace Blog\Form\Article;

class Mediator extends \ZendX\Doctrine2\FormMediator
{
    public function init ()
    {
        $this->setFields(
            array(
                'id' => array(
                    'setMethod' => false
                ),
                'slug' => array(),
                'title' => array(),
                'description' => array(),
                'content' => array(),
                'date' => array(
                    'getMethod' => function ($instance) {
                        return $instance->getDate()->format('Y-m-d H:i:s');
                    },
                    'filterMethod' => function ($instance, $value) {
                        return $value ? new \DateTime($value) : new \DateTime();
                    }
                ),
                'published' => array()
            )
        );
    }
    
    /**
     * Creates an article from an array of data
     *
     * @param array $data
     * @return Blog\Model\Article
     */
    public function createArticle(array $data)
    {
        if (!array_key_exists('title', $data)) {
            throw new \Exception('Title must be set.');
        }

        $this->_instance = new \Blog\Model\Article($data['title']);
        $this->setData($data);

        return $this->_instance;
    }
}