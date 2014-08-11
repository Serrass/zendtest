<?php
class ProductController extends Zend_Controller_Action
{
    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login', 'auth');
        }
    }
    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        $tableProducts = new Application_Model_DbTable_Products();
        $this->view->product = $tableProducts->getProduct($id);

    }
}

