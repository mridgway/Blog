<?php

namespace Core\Form\Element;

class Submit extends \Zend_Form_Element_Submit
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

        $this->setAttrib('class', 'button');
    }
    
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                 ->addDecorator('Description',
                                array('placement' => 'prepend',
                                      'tag'       => 'div',
                                      'class'     => 'note'));
        }
    }
}