<?php

class Magestore_Catalogsorter_Model_Rewrite_CatalogConfig extends Mage_Catalog_Model_Config
{
    /**
     * Retrieve Attributes Used for Sort by as array
     * key = code, value = name
     *
     * @return array
     */
    public function getAttributeUsedForSortByArray()
    {
		if(Mage::helper('catalogsorter')->isActive()){
			return Mage::helper('catalogsorter')->getFilterredOrders();
		} else {
			return parent::getAttributeUsedForSortByArray();
		}
    }
	
}