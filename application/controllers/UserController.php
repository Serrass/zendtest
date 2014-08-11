<?php

class UserController extends Zend_Controller_Action
{
	
    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login', 'auth');
	    }
    }
   
    public function indexAction()
    {
		$userIns = Zend_Auth::getInstance()->getIdentity();
		$tableUsers = new Application_Model_DbTable_Users();
		$user = $tableUsers->getUser($userIns->user_id);
		$this->view->user = $user;
    }
    public function editAction()
    {
		$this->view->form = $form = new Application_Form_Edit();
		$userIns = Zend_Auth::getInstance()->getIdentity();
		$tableUsers = new Application_Model_DbTable_Users();
		$user = $tableUsers->getUser($userIns->user_id);
		$this->view->user = $user;
		$populateData = $user;
		unset($populateData['password'], $populateData['user_id']);
		
		$params = $this->_getAllParams();
		
		$form->populate($populateData);
		
		if ($this->getRequest()->isPost()) {
		        if (!empty($params['username'])) {
			    if ($form->isValid($params)) {
				$values = $form->getValues();
				$values['user_id'] = $userIns->user_id;
				if (empty($values['password'])) {
				    unset($values['password'], $values['passconf']);
				}elseif (!empty($values['password']) and !empty($values['passconf'])
				    and $values['password']  == $values['passconf']) {
				    unset($values['passconf']);
				    $values['password'] = md5($values['password']);
				}
				$tableUsers->updateProfile($values);
			    }
			}
			
		}
    }
}
