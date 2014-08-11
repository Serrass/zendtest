<?php

class Application_Form_SignupSecond extends Zend_Form
{

    function __construct($options = null)
    {
    	parent::__construct($options);
        
    	$this->setName('RegistrationForm2');
        $tabIndex = 1;
        $this->addElement('Text', 'first_name', array(
            'label' => 'First Name',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
              array('StringLength', true, array(1, 64)),
            ),
            'autofocus' => 'autofocus',
            'tabindex' => $tabIndex++,
        ));
		$this->first_name->getValidator('NotEmpty')->setMessage('You don\'t enter the First Name');
        $this->addElement('Text', 'last_name', array(
            'label' => 'Last Name',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
              array('StringLength', true, array(1, 64)),
            ),
            'tabindex' => $tabIndex++,
        ));
		$this->last_name->getValidator('NotEmpty')->setMessage('You don\'t enter Last Name');
        $this->addElement('Select', 'gender', array(
            'label' => 'Gender',
			'Multioptions' => array(
									''  	  => 'Please Select',
									'Male'    => 'Male',
									 'Female' => 'Female'
									),
            'required' => true,
            'allowEmpty' => false,
			'validators' => array(
              array('NotEmpty', true),
            ),
            'tabindex' => $tabIndex++,
        ));
		
		$this->gender->getValidator('NotEmpty')->setMessage('Choose you gender');
		
		$this->addElement('Textarea', 'about', array(
            'label' => 'About',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
              array('StringLength', true, array(1, 256)),
            ),
            'tabindex' => $tabIndex++,
        ));
		
		$this->addElement('Button', 'back', array(
          'label' => 'back',
          'type' => 'button',
          'ignore' => true,
          'tabindex' => $tabIndex++,
		  'onClick' => 'javascript:submitForm(\'RegistrationForm2\', \'one\')',
		   'decorators' => array(
                'ViewHelper'
            )
        ));
		
		$this->addElement('Button', 'submit', array(
          'label' => 'Next',
          'type' => 'button',
          'ignore' => true,
          'tabindex' => $tabIndex++,
		  'onClick' => 'javascript:submitForm(\'RegistrationForm2\', null)',
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


}
