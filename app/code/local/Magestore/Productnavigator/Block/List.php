<?php
class Magestore_Productnavigator_Block_List extends Mage_Catalog_Block_Product_List
{
	public function _prepareLayout()
    {
		parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('productnavigator/list.phtml');
        }
        return $this;
    }
	
	public function getProductType()
    {
        return ($type=$this->getData('product_type')) ? $type : 'bestseller';
    }
	
	public function getProductCollection()
    {
		switch ($this->getProductType())
		{	
			case 'all': 
				$collection = Mage::getBlockSingleton('productnavigator/all')->getLoadedProductCollection();
				break;
			case 'new': 
				$collection = Mage::getBlockSingleton('productnavigator/new')->getLoadedProductCollection();
				break;
			case 'bestseller': 
				$collection = Mage::getBlockSingleton('productnavigator/bestseller')->getLoadedProductCollection();
				break;
			case 'mostview': 
				$collection = Mage::getBlockSingleton('productnavigator/mostview')->getLoadedProductCollection();
				break;
			case 'special': 
				$collection = Mage::getBlockSingleton('productnavigator/special')->getLoadedProductCollection();
				break;
			case 'feature': 
				$collection = Mage::getBlockSingleton('productnavigator/feature')->getLoadedProductCollection();
				break;
			default:
				$collection = Mage::getBlockSingleton('productnavigator/all')->getLoadedProductCollection();
				break;
		}
		
		return $collection;
	}	
	
	public function getTitle()
	{
		$type = $this->getProductType();
		$config = 'productnavigator/'.$type.'/page_title';
		return Mage::getStoreConfig($config);
	}
	
	public function isShowPrice()
	{
		$type = $this->getProductType();
		$config = 'productnavigator/'.$type.'/show_price';
		return Mage::getStoreConfig($config);
	}
	
	public function isShowProductName()
	{
		$type = $this->getProductType();
		$config = 'productnavigator/'.$type.'/show_name';
		return Mage::getStoreConfig($config);
	}
}