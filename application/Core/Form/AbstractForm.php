<?php

namespace Core\Form;

class AbstractForm extends \Zend_Form
{

    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $_defaultDisplayGroupClass = 'Core\Form\DisplayGroup';


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
            $this->addDecorator('FormElements')
                 ->addDecorator('Form');
        }
    }
}