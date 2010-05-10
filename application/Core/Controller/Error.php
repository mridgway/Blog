<?php

namespace Core\Controller;

class Error extends \Ridg\Controller\Action
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        switch ($errors->type) {
            case \Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case \Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                die('Page not found');
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                die('Application error');
                break;
        }

        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
    }
}