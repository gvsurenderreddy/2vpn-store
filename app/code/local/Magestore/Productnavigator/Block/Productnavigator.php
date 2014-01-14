<?php
class Magestore_Productnavigator_Block_Productnavigator extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('productnavigator/productnavigator.phtml');
        }
        return $this;
    }
    
	public function getShow()
	{
		$array = array();
		$controller = $this->getRequest()->getControllerName();
		
		if (Mage::getStoreConfig('productnavigator/all/is_show'))
		{
			$class = ($controller == 'all') ? 'active' : 'inactive';
			$array[] = array(
							'order'=>Mage::getStoreConfig('productnavigator/all/order'),
							'url'=>Mage::getUrl('product-navigator/all'),
							'title'=>Mage::getStoreConfig('productnavigator/all/title'),
							'class' => $class,
							);
		}
		if (Mage::getStoreConfig('productnavigator/new/is_show'))
		{
			$class = ($controller == 'new') ? 'active' : 'inactive';
			$array[] = array(
							'order'=>Mage::getStoreConfig('productnavigator/new/order'),
							'url'=>Mage::getUrl('product-navigator/new'),
							'title'=>Mage::getStoreConfig('productnavigator/new/title'),
							'class' => $class,
						);
		}
		if (Mage::getStoreConfig('productnavigator/bestseller/is_show'))
		{
			$class = ($controller == 'bestseller') ? 'active' : 'inactive';
			$array[] = array(
							'order'=>Mage::getStoreConfig('productnavigator/bestseller/order'),
							'url'=>Mage::getUrl('product-navigator/bestseller'),
							'title'=>Mage::getStoreConfig('productnavigator/bestseller/title'),
							'class' => $class,
							);
		}
		if (Mage::getStoreConfig('productnavigator/mostview/is_show'))
		{
			$class = ($controller == 'mostview') ? 'active' : 'inactive';
			$array[] = array(
							'order'=>Mage::getStoreConfig('productnavigator/mostview/order'),
							'url'=>Mage::getUrl('product-navigator/mostview'),
							'title'=>Mage::getStoreConfig('productnavigator/mostview/title'),
							'class' => $class,
							);
		}
		if (Mage::getStoreConfig('productnavigator/special/is_show'))
		{
			$class = ($controller == 'special') ? 'active' : 'inactive';
			$array[] = array(
							'order'=>Mage::getStoreConfig('productnavigator/special/order'),
							'url'=>Mage::getUrl('product-navigator/special'),
							'title'=>Mage::getStoreConfig('productnavigator/special/title'),
							'class' => $class,
							);
		}
		if (Mage::getStoreConfig('productnavigator/feature/is_show'))
		{
			$class = ($controller == 'feature') ? 'active' : 'inactive';
			$array[] = array(
							'order'=>Mage::getStoreConfig('productnavigator/feature/order'),
							'url'=>Mage::getUrl('product-navigator/feature'),
							'title'=>Mage::getStoreConfig('productnavigator/feature/title'),
							'class' => $class,
							);
		}
		
		sort($array);
		return $array;
	}
}