<?php

class Flst_Vouchers_Block_Adminhtml_Vouchers_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct() {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'vouchers';
        $this->_controller = 'adminhtml_vouchers';
        $this->_updateButton('save', 'label', 'Save Voucher');
        $this->_updateButton('delete', 'label', 'Delete Voucher');
    }
    
    public function getHeaderText() 
    {
        if (Mage::registry('vouchers_data') && Mage::registry('vouchers_data')->getId()) {
            return 'Editer la Promotion '.$this->escapeHtml(Mage::registry('vouchers_data')->getId()).'<br />';
        } else {
            return 'Ajouter une Promotion';
        }
    }
}