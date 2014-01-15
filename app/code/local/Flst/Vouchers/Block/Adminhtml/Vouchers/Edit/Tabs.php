<?php

class Flst_Vouchers_Block_Adminhtml_Vouchers_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct() {
        parent::__construct();
        $this->setId('vouchers_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Information sur la réduction');
    }
    
    public function _beforeToHtml() 
    {
        $this->addTab('form_section', array(
            'label' => 'Voucher information',
            'title' => 'Voucher information',
            'content' => $this->getLayout()
                ->createBlock('vouchers/adminhtml_vouchers_edit_tabs_form')
                ->toHtml()
        ));
        return parent::_beforeToHtml();
    }
}