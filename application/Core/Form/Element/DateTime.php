<?php

namespace Core\Form\Element;

class DateTime extends Text
{
    /**
     * {@inheritdoc}
     *
     * Add default element attributes.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->setAttrib('class', 'field datetime');
        $this->addValidator(new \Zend_Validate_Date());
    }
}