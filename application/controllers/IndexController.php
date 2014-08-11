<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $tableProducts = new Application_Model_DbTable_Products();
        $products = $tableProducts->fetchAll();
        $this->view->products = $products;
    }


}

