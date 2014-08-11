<?php

class Application_Form_ContactUs extends Zend_Form
{

    function __construct($options = null)
    {
        parent::__construct($options);
        
        $tabIndex = 1;
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
		$this->first_name->getValidator('NotEmpty')->setMessage('You don\'t enter the First Name');
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
		$this->last_name->getValidator('NotEmpty')->setMessage('You don\'t enter Last Name');
        $this->addElement('Text', 'subject', array(
            'label' => 'Subject',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
            ),
            'tabindex' => $tabIndex++,
        ));
        
        $this->addElement('Textarea', 'message', array(
            'label' => 'Message',
            'required' => true,
            'allowEmpty' => false,
            'validators' => array(
              array('NotEmpty', true),
            ),
            'tabindex' => $tabIndex++,
        ));
		
		$this->addElement('Button', 'back', array(
          'label' => 'back',
          'type' => 'button',
          'ignore' => true,
          'tabindex' => $tabIndex++,
		  'onClick' => 'window.location.href="/"',
		   'decorators' => array(
                'ViewHelper'
            )
        ));
		
		$this->addElement('Button', 'submit', array(
          'label' => 'Next',
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
    }
}
