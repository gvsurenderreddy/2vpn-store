<?php

class Magestore_Themeswitcher_Model_Mysql4_Themebrowser_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('themeswitcher/themebrowser');
    }
}