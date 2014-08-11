<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login', 'auth');
        }
    }

    public function indexAction()
    {
        $tableProducts = new Application_Model_DbTable_Products();
        $products = $tableProducts->fetchAll();
        $this->view->products = $products;
    }


}

