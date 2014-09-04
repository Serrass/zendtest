<?php

/**
 * Class IndexController
 */
class IndexController extends Zend_Controller_Action
{

    /**
     *  redirect to login page if not logged
     */
    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login', 'auth');
        }
    }

    /**
     * show all products
     */
    public function indexAction()
    {
        $tableProducts = new Application_Model_DbTable_Products();
        $products = $tableProducts->fetchAll();
        $this->view->products = $products;
    }


}

