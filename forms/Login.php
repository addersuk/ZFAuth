<?php
/**
 * Login Form
 * @author Adam Leach <adam@adders.eu>
 *
 */
class Auth_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName("login");
        $this->setMethod('post');
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', FALSE, array(0, 50)),
            ),
            'required'   => TRUE,
            'label'      => 'Username:',
            'class'      => 'large',
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', FALSE, array(0, 50)),
            ),
            'required'   => TRUE,
            'label'      => 'Password:',
            'class'      => 'large',
        ));

        $this->addElement('submit', 'login', array(
            'required' => FALSE,
            'ignore'   => TRUE,
            'label'    => 'Log in',
        ));
    }
}