<?php

class Application_Form_Signup extends Zend_Form
{

    function __construct($options = null)
    {
    	parent::__construct($options);
        
    	$this->setName('RegistrationForm');
        $tabIndex = 1;
        
        $this->addElement('Text', 'username', array(
            'label' => 'UserName',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              'NotEmpty',
            ),
            'autofocus' => 'autofocus',
            'tabindex' => $tabIndex++,
        ));
        $this->username->getValidator('NotEmpty')->setMessage('Please enter your UserName.');
       
        $this->addElement('Text', 'email', array(
            'label' => 'Email',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
                array('NotEmpty', true),
                array('EmailAddress', true),
            ) ,
            'filters' => array(
              'StringTrim'
            ),
            // fancy stuff
            'inputType' => 'email',
            'tabindex' => $tabIndex++,
        ));
		$this->email->getValidator('NotEmpty')->setMessage('You don\'t enter the Email');
		
        $this->addElement('Password', 'password', array(
        'label' => 'Password',
        'required' => true,
        'allowEmpty' => false,
        'validators' => array(
            array('NotEmpty', true),
            //array('StringLength', false, array(8, 12)),
        ),
        'tabindex' => $tabIndex++,
        ));
		$this->password->getValidator('NotEmpty')->setMessage('Please enter password');
		      // Element: passconf
        $this->addElement('Password', 'passconf', array(
          'label' => 'Password Again',
          'required' => true,
          'validators' => array(
            array('NotEmpty', true),
          ),
          'tabindex' => $tabIndex++,
        ));
//		$this->addElement('Hidden', 'step', array(
//          'value' => 'one'
//        ));
        //$this->passconf->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
        $this->passconf->getValidator('NotEmpty')->setMessage('Please make sure the "password" and "password again" fields match.', 'isEmpty');
		
		$this->addElement('Button', 'back', array(
          'label' => 'back',
          'type' => 'button',
          'ignore' => true,
          'tabindex' => $tabIndex++,
		  'onClick' => 'window.history.back()',
		   'decorators' => array(
                'ViewHelper'
            )
        ));
		
		$this->addElement('Button', 'submit', array(
          'label' => 'Next',
          'type' => 'button',
          'ignore' => true,
          'tabindex' => $tabIndex++,
		  'onClick' => 'javascript:submitForm(\'RegistrationForm\',null)',
		   'decorators' => array(
                'ViewHelper'
            )
        ));
		$this->addDisplayGroup(array(
			'back',
			'submit'
		), 'buttons');
	}

	public function isValid($data)
	{
		$isValid = parent::isValid($data);
		
		if (empty($data['password']) or empty($data['passconf'])) {
			$this->getElement('password')->addError('Please enter password');
			$isValid = false;
		}
		if ((!empty($data['password']) and !empty($data['passconf']))
			and ($data['password'] != $data['passconf'])){
			$this->getElement('password')->addError('Passwords doesn\'t match');
			$isValid = false;
		}
		if (!empty($data['password'])) {
			$uppercase = preg_match('@[A-Z]@', $data['password']);
			$lowercase = preg_match('@[a-z]@', $data['password']);
			$number    = preg_match('@[0-9]@', $data['password']);
			
			if(!$uppercase || !$lowercase || !$number || strlen($data['password']) < 8) {
			  $this->getElement('password')->addError('“Password” must contain at least one digit, one special char and one capital letter. Length must be 6 to 12 chars.');
			  $isValid = false;
			}
		}
		if (!empty($data['username'])) {
			$tableUsers = new Application_Model_DbTable_Users();
			$user = $tableUsers->getUserByParams(array('username' => $data['username']));
			if ($user) {
				$this->getElement('username')->addError('A profile with this username already exists.');
				$isValid = false;
			}
		}
		if (!empty($data['email'])) {
			$tableUsers = new Application_Model_DbTable_Users();
			$user = $tableUsers->getUserByParams(array('email' => $data['email']));
			if ($user) {
				$this->getElement('email')->addError('A profile with this email address already exists.');
				$isValid = false;
			}
		}
		return $isValid;
	}
}
