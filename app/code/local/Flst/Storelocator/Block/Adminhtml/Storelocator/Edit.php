<?php

class Flst_Storelocator_Block_Adminhtml_Storelocator_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct() {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'storelocator';
        $this->_controller = 'adminhtml_storelocator';
        $this->_updateButton('save', 'label', 'Save Store');
        $this->_updateButton('delete', 'label', 'Delete Store');
    }
    
    public function getHeaderText() 
    {
        if (Mage::registry('storelocator_data') && Mage::registry('storelocator_data')->getId()) {
            return 'Editer le Store '.$this->escapeHtml(Mage::registry('storelocator_data')->getId()).'<br />';
        } else {
            return 'Ajouter un Store';
        }
    }
}