<?php

namespace Blog\Form\Article;

class Factory
{
    public static function getIdElement()
    {
        $element = new \Core\Form\Element\Hidden('id');

        return $element;
    }

    public static function getSlugElement()
    {
        $element = new \Core\Form\Element\Text('slug');
        $element->setLabel('Slug');

        return $element;
    }

    public static function getTitleElement()
    {
        $element = new \Core\Form\Element\Text('title');
        $element->setLabel('Title');

        return $element;
    }

    public static function getDescriptionElement()
    {
        $element = new \Core\Form\Element\Textarea('description');
        $element->setLabel('Description');

        return $element;
    }

    public static function getContentElement()
    {
        $element = new \Core\Form\Element\Textarea('content');
        $element->setLabel('Content');

        return $element;
    }

    public static function getPublishedElement()
    {
        $element = new \Core\Form\Element\Checkbox('published');
        $element->setLabel('Published');

        return $element;
    }

    public static function getDateElement()
    {
        $element = new \Core\Form\Element\DateTime('date');
        $element->setLabel('Publish Date');
        $element->addValidator(new \Zend_Validate_Date(array('format' => 'Y-m-d H:i:s')));

        return $element;
    }
}