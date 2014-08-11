<?php
class AuthController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_helper->redirector('login');
    }

    public function loginAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'index');
        }

        $form = new Application_Form_Login();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

                $authAdapter->setTableName('users')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password');

                $values = $form->getValues();
                $username = $values['email'];
                $password = md5($values['password']);

                $authAdapter->setIdentity($username)
                    ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {

                    $identity = $authAdapter->getResultRowObject();
                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);

                    $this->_helper->redirector('index', 'index');

                }
            }
        }
    }
    public function logoutAction()
    {
        //clear data
        $cartSession = new Zend_Session_Namespace('cart_Session');
        $userIns = Zend_Auth::getInstance()->getIdentity();
        if(isset($cartSession->products[$userIns->user_id])){
            unset($cartSession->products[$userIns->user_id]);
        }
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }

    public function signupAction()
    {
        $session = new Zend_Session_Namespace('SignUpData');
        //$session->unsetAll();
        $formData = $this->getRequest()->getPost();
        $stepBack = $this->_getParam('step', '');
        $session->step = !empty($session->step) ? $session->step : 1;
        $this->view->step = $session->step;
        if (!empty($stepBack) and $stepBack != 'null') {
            if ($stepBack == 'one') {
                $this->view->step = $session->step = 1;
                $this->view->headTitle('Registration Step 1');
                $this->view->title = 'Registration Step 1';
                $form = new Application_Form_Signup();
                $form->populate($session->regData);

            } elseif($stepBack == 'two') {
                $this->view->step = $session->step = 2;
                $this->view->headTitle('Registration Step 2');
                $this->view->title = 'Registration Step 2';
                $form = new Application_Form_SignupSecond();
                $form->populate($session->regData);
            }
        } else {
            if ($session->step == 1) {
                $this->view->headTitle('Registration Step 1');
                $this->view->title = 'Registration Step 1';
                $form = new Application_Form_Signup();
            } elseif( $session->step == 2) {
                $this->view->headTitle('Registration Step 2');
                $this->view->title = 'Registration Step 2';
                $form = new Application_Form_SignupSecond();

            } else {
                $form = new Application_Form_Signup();
            }
        }

        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            if (!empty($stepBack) and $stepBack != 'null') {
                $formData = $session->regData;
            } else {
                $formData = $this->getRequest()->getPost();
            }
            $form->populate($formData);

            if ($form->isValid($formData)) {
                $values = $form->getValues();
                if($session->step == 1 and $stepBack == 'null') {
                    $this->view->title = 'Registration Step 2';
                    $session->step = 2;
                    $session->regData = $values;
                    $this->view->form = new Application_Form_SignupSecond();
                } elseif($session->step == 2 and $stepBack == 'null') {
                    $session->regData['first_name'] = $values['first_name'];
                    $session->regData['last_name'] = $values['last_name'];
                    $session->regData =  array_merge($session->regData, $values);
                    $this->view->step =  $session->step = 3;
                    $this->view->data = $session->regData;
                }
            }
        } else {
            if (!empty($session->regData)) {
                $this->view->data = $session->regData;
            }
            //$this->view->step = !empty($session->step) ? $session->step : 1;
        }
    }
    public function confirmAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'user');
        }
        $session = new Zend_Session_Namespace('SignUpData');
        $data = $session->regData;
        $users = new Application_Model_DbTable_Users();
        unset($data['passconf']);

        $users->addUser($data);

        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
            ->setIdentityColumn('email')
            ->setCredentialColumn('password');
        $username = $data['email'];
        $password = md5($data['password']);

        $tr = new Zend_Mail_Transport_Sendmail('-freturn_to_me@example.com');
        Zend_Mail::setDefaultTransport($tr);

        $mail = new Zend_Mail();
        $mail->setBodyText('Thank you for registration');
        $mail->setFrom('admin@test.com', 'Great Man');
        $mail->addTo($data['username'], $username);
        $mail->setSubject('Thank you for registration');
        $mail->send();

        $authAdapter->setIdentity($username)
            ->setCredential($password);
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        if ($result->isValid()) {
            $identity = $authAdapter->getResultRowObject();
            $authStorage = $auth->getStorage();
            $authStorage->write($identity);
            $session->unsetAll();
            $this->_helper->redirector('index', 'user');

        }
    }
    public function contactUsAction()
    {

        $this->view->form = $form = new Application_Form_ContactUs();
        if (Zend_Auth::getInstance()->hasIdentity()) {

            $form->removeElement('first_name');
            $form->removeElement('last_name');
            $userIns = Zend_Auth::getInstance()->getIdentity();
            $tableUsers = new Application_Model_DbTable_Users();
            $user = $tableUsers->getUser($userIns->user_id);
            $firsName = $user['first_name'];
            $lastName = $user['last_name'];
        }

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $firsName = !empty($formData['first_name']) ? $formData['first_name'] : $firsName;
                $lastName = !empty($formData['last_name']) ? $formData['last_name'] : $lastName;

                $username = $firsName . ' ' . $lastName;
                $adminEmail = 'admin@email.com';

                $tr = new Zend_Mail_Transport_Sendmail('-freturn_to_me@example.com');
                Zend_Mail::setDefaultTransport($tr);

                $mail = new Zend_Mail();
                $mail->setBodyText($formData['message']);
                $mail->setFrom('contuctus@test.com', 'Contact');
                $mail->addTo($adminEmail, $username);
                $mail->setSubject($formData['subject']);
                $mail->send();
                $this->view->message = 'Your message sent!';


            }

        }



    }
}
