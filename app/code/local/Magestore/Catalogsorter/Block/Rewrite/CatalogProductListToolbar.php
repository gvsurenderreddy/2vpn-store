<?php

class Magestore_Catalogsorter_Block_Rewrite_CatalogProductListToolbar
	extends Mage_Catalog_Block_Product_List_Toolbar
{
    /**
     * Default direction
     *
     * @var string
     */
    protected $_direction = 'desc';
	
    public function getCurrentOrder()
    {
		$filtered_orders = Mage::helper('catalogsorter')->getFilterredOrders();
		foreach($filtered_orders as $value=>$label){
			$this->_orderField = $value;
			break;
		}		
		return parent::getCurrentOrder();
    }		
}