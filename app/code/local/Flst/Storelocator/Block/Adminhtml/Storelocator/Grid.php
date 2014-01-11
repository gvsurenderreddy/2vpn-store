<?php

class Flst_Storelocator_Block_Adminhtml_Storelocator_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct() {
        parent::__construct();
        $this->setId('storelocator');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareCollection() {
        $collection = Mage::getModel('storelocator/storelocator')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns() {
        $this->addColumn('store_id', array(
            'header' => 'ID',
            'align' => 'right',
            'width' => '50px',
            'index' => 'store_id'
            )
        );
        
        $this->addColumn('name', array(
            'header' => 'Nom',
            'align' => 'left',
            'index' => 'name'
            )
        );

        return parent::_prepareColumns();
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->store_id));
    }
}