<?php

namespace Blog\Form;

class Article extends \Core\Form\AbstractForm
{
    public function init()
    {
        $id = new \Core\Form\Element\Hidden('id');

        $title = new \Core\Form\Element\Text('title');
        $title->setLabel('Title');

        $content = new \Core\Form\Element\Textarea('content');
        $content->setLabel('Content');

        $publish = new \Core\Form\Element\Checkbox('published');
        $publish->setLabel('Published');

        $date = new \Core\Form\Element\DatePicker('date');
        $date->setLabel('Publish Date');
        $date->addValidator(new \Zend_Validate_Date(array('format' => 'Y-m-d H:i:s')));

        $submit = new \Core\Form\Element\Submit('submit');
        $submit->setLabel('Submit');
        
        $this->addElements(array($id, $title, $content, $publish, $date, $submit));
    }
}