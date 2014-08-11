<?php

class Application_Model_DbTable_Products extends Zend_Db_Table_Abstract
{

    protected $_name = 'products';

    public function getProduct($productId)
    {
        $select = $this->select()
				->where('product_id = ?', (int)$productId);
        $product = $this->getAdapter()->fetchRow($select);
        if (!$product) {
            return false;
        }
        return $product;
    }
}

