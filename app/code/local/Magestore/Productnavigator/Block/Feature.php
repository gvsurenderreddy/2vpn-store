<?php
class Magestore_Productnavigator_Block_Feature extends Mage_Catalog_Block_Product_List
{
	protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
			$this->_productCollection = Mage::getResourceModel('catalog/product_collection')
								->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
								->addAttributeToFilter('fb_product', 1)
								->addMinimalPrice()
								->addTaxPercents()
								->addStoreFilter();	
			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($this->_productCollection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($this->_productCollection);	
        }
        return $this->_productCollection;
    }
	
	public function getColumnCount()
	{
		return Mage::getStoreConfig('productnavigator/general/columns');
	}
	
	protected function _beforeToHtml()
    {
        $toolbar = $this->getToolbarBlock();
        $collection = $this->_getProductCollection();

        $toolbar->setAvailableOrders(array(
			'name'      => $this->__('Name'),
			'price'     => $this->__('Price')
			))
		->setDefaultOrder('price')
		->setDefaultDirection('desc');
		
        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);
        Mage::dispatchEvent('catalog_block_product_list_collection', array(
            'collection'=>$this->_getProductCollection(),
        ));

        $this->_getProductCollection()->load();
        Mage::getModel('review/review')->appendSummary($this->_getProductCollection());
        return parent::_beforeToHtml();
    }
	
	public function getTitlePage()
	{
		return Mage::getStoreConfig('productnavigator/feature/page_title');
	}
}