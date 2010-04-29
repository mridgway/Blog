<?php

namespace Core\Form;

class DisplayGroup extends \Zend_Form_DisplayGroup
{
    /**
     * Get the default form group decorators
     * 
     * @return array
     */
    public static function getDefaultDecorators()
    {
        return array(
            'FormElements',
            array('Description', array('placement' => 'prepend',
                                       'class'     => 'description')),
            'Fieldset',
        );
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
            $this->setDecorators(self::getDefaultDecorators());
        }
    }
}
