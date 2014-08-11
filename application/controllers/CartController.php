<?php
class CartController extends Zend_Controller_Action
{
    public $user_id;

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login', 'auth');
        }
        $userIns = Zend_Auth::getInstance()->getIdentity();
        $this->user_id = $userIns->user_id;
    }
    public function viewAction()
    {
        $cartSession = new Zend_Session_Namespace('cart_Session');
        $products = array();
        if (isset($cartSession->products[$this->user_id])) {
            $products = $cartSession->products[$this->user_id];
            $this->view->total = $cartSession->products[$this->user_id]['total'];
        }
        unset($products['total']);
        $this->view->products = $products;
    }
    public function addItemAction()
    {
        $productId = $this->getRequest()->getParam('product_id', false);
        if(!$productId) {
            return false;
        }
        $total = 0;
        $cartSession = new Zend_Session_Namespace('cart_Session');
        $tableProducts = new Application_Model_DbTable_Products();
        if (!empty($cartSession->products[$this->user_id][$productId])) {
            $cartSession->products[$this->user_id][$productId]['count']++;
            $price = $cartSession->products[$this->user_id][$productId]['price'];
            $count = $cartSession->products[$this->user_id][$productId]['count'];
            $coast = $price * $count;
            $cartSession->products[$this->user_id][$productId]['coast'] = $coast;
        } else {
            $cartSession->products[$this->user_id][$productId]=array();
            $product = $tableProducts->getProduct($productId);
            if(!empty($product)) {
                unset($product['product_id']);
                $product['count'] = 1;
                $product['coast'] = $product['price'];
                $cartSession->products[$this->user_id][$productId] = $product;
            }
        }
        if (!empty($cartSession->products[$this->user_id])) {
            foreach($cartSession->products[$this->user_id] as $products) {
                $total +=  $products['coast'];
            }
            $cartSession->products[$this->user_id]['total'] = $total;
        }
        exit;
    }
    public function deleteItemAction()
    {
        $productId = $this->getRequest()->getParam('product_id', false);
        if (!$productId) {
            return false;
        }
        $cartSession = new Zend_Session_Namespace('cart_Session');
        if (isset($cartSession->products[$this->user_id][$productId])) {
            unset($cartSession->products[$this->user_id][$productId]);
            $cartSession->products[$this->user_id]['total'] = 0;
            foreach($cartSession->products[$this->user_id] as $products) {
                $cartSession->products[$this->user_id]['total'] +=  $products['coast'];
            }
        }
        echo json_encode(array('total' =>  $cartSession->products[$this->user_id]['total']));
       exit;
    }
}

