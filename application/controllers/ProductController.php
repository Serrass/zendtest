<?php
class ProductController extends Zend_Controller_Action
{

    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        $tableProducts = new Application_Model_DbTable_Products();
        $this->view->product = $tableProducts->getProduct($id);

    }
}

