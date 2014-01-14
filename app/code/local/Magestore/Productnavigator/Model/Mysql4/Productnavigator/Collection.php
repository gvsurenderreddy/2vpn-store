<?php

class Magestore_Productnavigator_Model_Mysql4_Productnavigator_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productnavigator/productnavigator');
    }
}