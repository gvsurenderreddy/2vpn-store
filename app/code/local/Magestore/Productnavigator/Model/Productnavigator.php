<?php

class Magestore_Productnavigator_Model_Productnavigator extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productnavigator/productnavigator');
    }
}