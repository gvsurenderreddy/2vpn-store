<?php

class Flst_Vouchers_Block_Adminhtml_Vouchers_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct() {
        parent::__construct();
        $this->setId('vouchers');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareCollection() {
        $collection = Mage::getModel('vouchers/vouchers')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns() {
        $this->addColumn('voucher_id', array(
            'header' => 'ID',
            'align' => 'right',
            'width' => '50px',
            'index' => 'voucher_id'
            )
        );
        
        $this->addColumn('description', array(
            'header' => 'Description',
            'align' => 'left',
            'index' => 'description'
            )
        );
        
        $this->addColumn('amount', array(
            'header' => 'Montant',
            'align' => 'left',
            'index' => 'amount'
            )
        );

        return parent::_prepareColumns();
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->voucher_id));
    }
}