<?php

class Flst_Storelocator_Block_Adminhtml_Storelocator extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {
        $this->_controller = 'adminhtml_storelocator';
        $this->_blockGroup = 'storelocator';
        $this->_headerText= 'Gestion du Store Locator';
        $this->_addButtonLabel = 'Ajouter un Store';
        parent::__construct();
    }
}