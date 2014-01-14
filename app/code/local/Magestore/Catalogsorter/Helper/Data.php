<?php

class Magestore_Catalogsorter_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isActive()
	{
		return (bool) Mage::getStoreConfig('catalogsorter/general/active',Mage::app()->getStore()->getId());
	}
	
	public function sort($collection, $order, $direction)
	{
		// if(strtolower($direction) == 'asc'){
			// $direction = 'DESC';
		// } elseif(strtolower($direction) == 'desc'){
			// $direction = 'ASC';
		// }
		
		switch($order){
			case 'bestseller':
				$collection = $this->sortByBestseller($collection, $direction);
				break;
			case 'mostviewed':
				$collection = $this->sortByMostviewed($collection, $direction);
				break;			
			case 'recentlyadded':
				$collection = $this->sortByRecentlyadded($collection, $direction);
				break;
		}
		return $collection;
	}
	
	public function sortByBestseller($collection, $direction)
	{
        $storeId = Mage::app()->getStore()->getId();
        $product = Mage::getResourceSingleton('catalog/product');
		$productCollection = Mage::getResourceModel('catalogsorter/product_collection')
									->setStoreId($storeId)
									->addStoreFilter($storeId)
									->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes()) 
									->addMinimalPrice() 
									->addTaxPercents() 
									->addStoreFilter();			
	
        $qtyOrderedTableName = $productCollection->getTable('sales/order_item');
        $qtyOrderedFieldName = 'qty_ordered';
        $productIdFieldName = 'product_id';

        $compositeTypeIds = Mage::getSingleton('catalog/product_type')->getCompositeTypes();
        $productTypes = $productCollection->getConnection()->quoteInto(' AND (e.type_id NOT IN (?))', $compositeTypeIds);

        $productCollection->getSelect()->reset()->from(
            array('order_items' => $qtyOrderedTableName),
            array(
                'ordered_qty' => "SUM(order_items.{$qtyOrderedFieldName})",
                'order_items_name' => 'order_items.name'
            )
        );

         $_joinCondition = $productCollection->getConnection()->quoteInto(
                'order.entity_id = order_items.order_id AND order.state<>?', Mage_Sales_Model_Order::STATE_CANCELED
         );

         $productCollection->getSelect()->joinInner(
            array('order' => $productCollection->getTable('sales/order')),
            $_joinCondition,
            array()
         );
		
        $productCollection->getSelect()
            ->joinRight(array('e' => $product->getEntityTable()),
                "e.entity_id = order_items.{$productIdFieldName} "
				//." AND e.entity_type_id = {$product->getTypeId()}{$productTypes}"
				)
            ->group('e.entity_id')
            ->order('ordered_qty '.$direction)
			;
		//$productCollection->printlogquery(true);die();	
		return $productCollection;
	}
	
	public function sortByMostviewed($collection, $direction)
	{
        $storeId = Mage::app()->getStore()->getId();
        $product = Mage::getResourceSingleton('catalog/product');
		$productCollection = Mage::getResourceModel('catalogsorter/product_collection')
									->setStoreId($storeId)
									->addStoreFilter($storeId)
									->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes()) 
									->addMinimalPrice() 
									->addTaxPercents() 
									->addStoreFilter();			

        foreach (Mage::getModel('reports/event_type')->getCollection() as $eventType) {
            if ($eventType->getEventName() == 'catalog_product_view') {
                $productViewEvent = $eventType->getId();
                break;
            }
        }									
						
        $productCollection->getSelect()->reset()
            ->from(
                array('_table_views' => $productCollection->getTable('reports/event')),
                array('views' => 'COUNT(_table_views.event_id)'))
            ->joinRight(array('e' => $product->getEntityTable()),
                "e.entity_id = _table_views.object_id AND e.entity_type_id = {$product->getTypeId()}"
				." AND _table_views.event_type_id = '$productViewEvent'"
				)
            ->group('e.entity_id')
            ->order('views '.$direction)
            ;

		return $productCollection;
	}
	
	public function sortByRecentlyadded($collection, $direction)
	{
		return $collection->setOrder('created_at',$direction);
	}	
	
	public function getCurrentOrder()
	{
		$productToolbar = Mage::getBlockSingleton('catalog/product_list_toolbar');
        return $productToolbar->getCurrentOrder();
	}
	
	public function getCurrentDirection()
	{
		$productToolbar = Mage::getBlockSingleton('catalog/product_list_toolbar');
        return $productToolbar->getCurrentDirection();			
	}
	
	public function getAvailabeOrders()
	{
        $options = array(
            'position'  => Mage::helper('catalog')->__('Position')
        );
        foreach (Mage::getSingleton('catalog/config')->getAttributesUsedForSortBy() as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute_Abstract */
            $options[$attribute->getAttributeCode()] = $attribute->getStoreLabel();
        }
		foreach(Magestore_Catalogsorter_Model_Catalogsorter::$SORT_ORDERS as $code=>$label){
			$options[$code] = Mage::helper('catalogsorter')->__($label); 
		}	
		return $options;
	}
	
	public function getFilterredOrders()
	{
		$orderPriotities = array();
		$filterredOrders = array();
		$availabeOrders = $this->getAvailabeOrders();
		foreach($availabeOrders as $order=>$label){
			$orderPriotities[$order] = (int) Mage::getStoreConfig('catalogsorter/sortorders/'.$order);
			if(!$orderPriotities[$order]){
				unset($orderPriotities[$order]);
			}
		}
		
		if(count($orderPriotities)){
			asort($orderPriotities);
			foreach($orderPriotities as $order=>$priority){
				$filterredOrders[$order] = $availabeOrders[$order];
			}
		} else{
			$filterredOrders = $availabeOrders;
		}
		return $filterredOrders;
	}
	
}