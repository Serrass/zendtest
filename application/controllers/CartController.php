<?php
class CartController extends Zend_Controller_Action
{

    public function viewAction()
    {
        $cartSession = new Zend_Session_Namespace('cart_Session');
        $products = array();
        if (isset($cartSession->products)) {
            $products = $cartSession->products;
            $this->view->total = $cartSession->total;
        }
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
        if (!empty($cartSession->products[$productId])) {
            $cartSession->products[$productId]['count']++;
            $price = $cartSession->products[$productId]['price'];
            $count = $cartSession->products[$productId]['count'];
            $coast = $price * $count;
            $cartSession->products[$productId]['coast'] = $coast;
        } else {
            $cartSession->products[$productId]=array();
            $product = $tableProducts->getProduct($productId);
            if(!empty($product)) {
                unset($product['product_id']);
                $product['count'] = 1;
                $product['coast'] = $product['price'];
                $cartSession->products[$productId] = $product;
            }
        }
        if (!empty($cartSession->products)) {
            foreach($cartSession->products as $products) {
                $total +=  $products['coast'];
            }
            $cartSession->total = $total;
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
        if (isset($cartSession->products[$productId])) {
            unset($cartSession->products[$productId]);
            $cartSession->total = 0;
            foreach($cartSession->products as $products) {
                $cartSession->total +=  $products['coast'];
            }
        }
        echo json_encode(array('total' =>  $cartSession->total));
       exit;
    }
    public function clearCartAction()
    {
//        $str = 'Mystring';
//        $count = strlen($str);
//        $newStr = '';
//        for($i=$count; $i>=0; $i--) {
//            $newStr .= $str[$i];
//        }
//        foreach(range(1,100) as $index) {
//          echo (''==($x=($index%3==0 ? 'Fizz' : '').($index%5==0 ? 'Bizz' : '')) ? $index : $x) . '<br    />';
//        }
            exit;
//
//        Zend_Session::namespaceUnset('cart_Session');
//        exit;
    }

}

