<?php

class Flst_Storelocator_Block_Adminhtml_Storelocator_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct() {
        parent::__construct();
        $this->setId('storelocator_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle('Information sur le Store');
    }
    
    public function _beforeToHtml() 
    {
        $this->addTab('form_section', array(
            'label' => 'Store information',
            'title' => 'Store information',
            'content' => $this->getLayout()
                ->createBlock('storelocator/adminhtml_storelocator_edit_tabs_form')
                ->toHtml()
        ));
        return parent::_beforeToHtml();
    }
}