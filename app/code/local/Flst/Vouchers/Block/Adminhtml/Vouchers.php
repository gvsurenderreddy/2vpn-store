<?php

class Flst_Vouchers_Block_Adminhtml_Vouchers extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {
        $this->_controller = 'adminhtml_vouchers';
        $this->_blockGroup = 'vouchers';
        $this->_headerText= 'Gestion des Bons de réduction';
        $this->_addButtonLabel = 'Ajouter une Promotion';
        parent::__construct();
    }
}