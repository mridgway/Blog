<?php

namespace Core\Form\Element;

class Checkbox extends \Zend_Form_Element_Checkbox
{
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
                                      'tag'       => 'span',
                                      'class'     => 'note'))
                 ->addDecorator('Label')
                 ->addDecorator('Errors')
                 ->addDecorator('HtmlTag',
                                array('tag'   => 'div',
                                      'class' => 'element checkbox'));
        }
    }
}