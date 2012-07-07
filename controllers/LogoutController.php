<?php
class Auth_LogoutController extends Zend_Controller_Action
{
    public function indexAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_redirector->setGotoUrl('/auth/login');
    }
}