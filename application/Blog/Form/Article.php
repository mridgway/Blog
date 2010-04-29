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

        $publishDate = new \Core\Form\Element\DatePicker('publishDate');
        $publishDate->setLabel('Publish Date');

        $submit = new \Core\Form\Element\Submit('submit');
        $submit->setLabel('Submit');
        
        $this->addElements(array($id, $title, $content, $publish, $publishDate, $submit));
    }
}