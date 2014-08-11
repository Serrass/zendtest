<?php

class Application_Form_Edit extends Zend_Form
{

    function __construct($options = null)
    {
    	parent::__construct($options);
        
        $tabIndex = 1;
        
    	$this->setName('EditForm');
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
            'tabindex' => $tabIndex++,
        ));
		      // Element: passconf
        $this->addElement('Password', 'passconf', array(
            'label' => 'Password Again',
            'tabindex' => $tabIndex++,
        ));
		
        $this->addElement('Text', 'first_name', array(
            'label' => 'First Name',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
              array('StringLength', true, array(4, 64)),
            ),
            'autofocus' => 'autofocus',
            'tabindex' => $tabIndex++,
        ));
        $this->addElement('Text', 'last_name', array(
            'label' => 'Last Name',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
              array('StringLength', true, array(4, 64)),
            ),
            'tabindex' => $tabIndex++,
        ));
        $this->addElement('Select', 'gender', array(
            'label' => 'Gender',
			'Multioptions' => array(
									''  	  => 'Please Select',
									'Male'    => 'Male',
									 'Female' => 'Female'
									),
            'required' => true,
            'allowEmpty' => false,
            'tabindex' => $tabIndex++,
        ));
		$this->addElement('Textarea', 'about', array(
            'label' => 'About',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
              array('StringLength', true, array(4, 256)),
            ),
            'tabindex' => $tabIndex++,
        ));
		
		$this->addElement('Button', 'back', array(
          'label' => 'cancel',
          'type' => 'button',
          'ignore' => true,
          'tabindex' => $tabIndex++,
		  'onClick' => 'window.location.href="/"',
		   'decorators' => array(
                'ViewHelper'
            )
        ));
		
		$this->addElement('Button', 'submit', array(
          'label' => 'Save',
          'type' => 'submit',
          'ignore' => true,
          'tabindex' => $tabIndex++,
		   'decorators' => array(
                'ViewHelper'
            )
        ));
		$this->addDisplayGroup(array(
			'back',
			'submit'
		), 'buttons');
        /* Form Elements & Other Definitions Here ... */
    }
    public function isValid($data)
    {
        $isValid = parent::isValid($data);
        
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
        return $isValid;
        
        
    }

}
