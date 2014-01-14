<?php

class Magestore_Catalogsorter_Model_Rewrite_CatalogLayer extends Mage_Catalog_Model_Layer
{
    
	/**
     * Retrieve current layer product collection
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
     */
    public function getProductCollection()
    {
		if(!Mage::helper('catalogsorter')->isActive()){
			return parent::getProductCollection();
		}
		
		$productToolbar = Mage::getBlockSingleton('catalog/product_list_toolbar');
        $order = $productToolbar->getCurrentOrder();
        $direction = $productToolbar->getCurrentDirection();
		$storeId = Mage::app()->getStore()->getId();

		if (isset($this->_productCollections[$this->getCurrentCategory()->getId()])) {
            $collection = $this->_productCollections[$this->getCurrentCategory()->getId()];
        } else {
			$collection = $this->getCurrentCategory()->getProductCollection();
			$this->prepareProductCollection($collection);
			
			if(in_array($order,array_keys(Magestore_Catalogsorter_Model_Catalogsorter::$SORT_ORDERS))){
				$collection = Mage::helper('catalogsorter')->sort($collection, $order, $direction);
				$collection->addCategoryFilter($this->getCurrentCategory());
				$this->prepareProductCollection($collection);
			}
          
            $this->_productCollections[$this->getCurrentCategory()->getId()] = $collection;
        }

        return $collection;	
    }
}