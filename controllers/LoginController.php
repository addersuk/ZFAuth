<?php
class Auth_LoginController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $form              = new Auth_Form_Login();
        $request           = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->_process($form->getValues())) {
                    // We're authenticated! Redirect to the home page
                    $this->_redirector->setGotoUrl('/options/');
                }
            }
        }
        $this->view->form = $form;
    }

    protected function _process($values)
    {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['username']);
        $adapter->setCredential($values['password']);
        $auth    = Zend_Auth::getInstance();
        $result  = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return TRUE;
        }
        return FALSE;
    }

    protected function _getAuthAdapter()
    {
        $dbAdapter   = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('SHA1(CONCAT(?,salt))');
        return $authAdapter;
    }
}