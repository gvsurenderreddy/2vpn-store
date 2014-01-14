<?php

class Magestore_Catalogsorter_Model_Mysql4_Product_Collection 
	extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
{	
	public function getSelectCountSql()
    {
        $order = Mage::helper('catalogsorter')->getCurrentOrder();
		
		$this->_renderFilters();
        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
		$countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
		$countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
		$countSelect->reset(Zend_Db_Select::COLUMNS);
		
		if(in_array($order,array_keys(Magestore_Catalogsorter_Model_Catalogsorter::$SORT_ORDERS))){
			$countSelect->reset(Zend_Db_Select::GROUP);
		}
		
        $countSelect->columns('COUNT(DISTINCT e.entity_id)');
        $countSelect->resetJoinLeft();
		
        return $countSelect;
    }
	
	public function getSetIds()
    {
        $order = Mage::helper('catalogsorter')->getCurrentOrder();
		if(in_array($order,array_keys(Magestore_Catalogsorter_Model_Catalogsorter::$SORT_ORDERS)))
		{
			$select = clone $this->getSelect();
			$select->reset(Zend_Db_Select::COLUMNS);
			$select->reset(Zend_Db_Select::ORDER);
			$select->distinct(true);
			$select->columns('e.attribute_set_id');
			return $this->getConnection()->fetchCol($select);
		} else {
			return parent::getSetIds();
		}
    }
	
}