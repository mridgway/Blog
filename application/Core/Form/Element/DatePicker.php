<?php

namespace Core\Form\Element;

class DatePicker extends Text
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

        $this->setAttrib('class', 'field datepicker');
    }
}