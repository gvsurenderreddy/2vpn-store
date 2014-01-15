<?php
class Flst_Vouchers_Model_Mysql4_Vouchers extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('vouchers/vouchers', 'voucher_id');
    }
}