<?php

namespace Blog\Form\Article;

class Form extends \Core\Form\AbstractForm
{
    public function init()
    {
        $submit = new \Core\Form\Element\Submit('submit');
        $submit->setLabel('Submit');
        
        $this->addElements(array(
            Factory::getIdElement(),
            Factory::getSlugElement(),
            Factory::getTitleElement(),
            Factory::getDescriptionElement(),
            Factory::getContentElement(),
            Factory::getPublishedElement(),
            Factory::getDateElement(),
            $submit
        ));
    }
}