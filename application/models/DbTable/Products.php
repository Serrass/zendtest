<?php

/**
 * Class Application_Model_DbTable_Products
 */
class Application_Model_DbTable_Products extends Zend_Db_Table_Abstract
{

    /**
     * @var string
     */
    protected $_name = 'products';


    /**
     * getting product by product_id
     *
     * @param $productId
     * @return array|bool
     */
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

