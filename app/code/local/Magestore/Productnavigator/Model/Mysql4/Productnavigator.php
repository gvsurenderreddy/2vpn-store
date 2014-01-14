<?php

class Magestore_Productnavigator_Model_Mysql4_Productnavigator extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the productnavigator_id refers to the key field in your database table.
        $this->_init('productnavigator/productnavigator', 'productnavigator_id');
    }
}