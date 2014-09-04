<?php

/**
 * Class Application_Form_Login
 */
class Application_Form_Login extends Zend_Form
{
    /**
     * form init
     */
    public function init()
    {
        $this->setName('login');
        
        $tabindex = 1;
        
        $this->addElement('Text', 'email', array(
            'label' => 'Email',
            'required' => true,
            'allowEmpty' => false,
            'filters' => array(
              'StringTrim',
            ),
            'validators' => array(
                'NotEmpty',
            ),
            // Fancy stuff
            'tabindex' => $tabindex++,
            'inputType' => 'email',
        ));
        $this->email->getValidator('NotEmpty')->setMessage('Please enter your email address.');
        
        $this->addElement('Password', 'password', array(
            'label' => 'Password',
            'required' => true,
            'allowEmpty' => false,
            'tabindex' => $tabindex++,
            'filters' => array(
              'StringTrim',
            ),
            'validators' => array(
                'NotEmpty',
            ),
        ));
        $this->password->getValidator('NotEmpty')->setMessage('Please enter password.');
        
        $this->addElement('Button', 'submit', array(
            'label' => 'Login',
            'type' => 'submit',
            'ignore' => true,
            'tabindex' => $tabindex++,
            'decorators' => array(
                'ViewHelper'
            )
        ));
        $this->submit
            ->setDescription('or <a href="/auth/signup">Register</a> a new user')
            ->setDecorators(array(
                'ViewHelper',
                array('Description', array('escape' => false, 'tag' => false)),
                array('HtmlTag', array('tag' => 'dd')),
                array('Label', array('tag' => 'dt')),
                'Errors',
            ));
    }

    /**
     * @param array $data
     * @return bool
     */
    public function isValid($data)
    {
        $isValid = parent::isValid($data);
        if (!empty($data['email']) and !empty($data['password'])) {
            $tableUsers = new Application_Model_DbTable_Users();
            $user = $tableUsers->getUserByParams(array('email' => $data['email']));
            if (!$user) {
                $this->getElement('email')->addError('Users with this address does not exist in the system.');
                $isValid = false;
            }
        }
        return $isValid;
    }
}
