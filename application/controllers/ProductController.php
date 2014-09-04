<?php

/**
 * Class ProductController
 */
class ProductController extends Zend_Controller_Action
{
    /**
     * redirect to login page if not logged
     */
    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login', 'auth');
        }
    }

    /**
     * show product profile
     */
    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        $tableProducts = new Application_Model_DbTable_Products();
        $this->view->product = $tableProducts->getProduct($id);

    }
}

