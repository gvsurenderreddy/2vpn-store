<?php

class Flst_Vouchers_Block_Adminhtml_Vouchers_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() 
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('vouchers_form', array('legend' => 'Informations sur la promotion'));
        
        $fieldset->addField('description', 'text', array(
           'label' => 'Description',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'description'
        ));
        
        $fieldset->addField('dateFrom', 'date', array(
           'label' => 'Date de départ',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'dateFrom',
           'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
           'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));
        
        $fieldset->addField('dateTo', 'date', array(
           'label' => 'Date de fin',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'dateTo',
           'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
           'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));
        
        $fieldset->addField('amount', 'text', array(
           'label' => 'Montant',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'amount'
        ));
        
        $stores = Mage::getModel('storelocator/storelocator')->getCollection();
        $storesArr[] = array('value' => 0, 'label' => 'Aucune boutique');
        foreach ($stores as $store) {
            $storesArr[] = array('value' => $store->store_id, 'label' => $store->name);
        }
        
        $fieldset->addField('stores', 'multiselect', array(
           'label' => 'Date de fin',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'stores[]',
           'values' => $storesArr
        ));
        
        if (Mage::registry('vouchers_data')) {
            $form->setValues(Mage::registry('vouchers_data')->getData());
        }
        
        return parent::_prepareForm();
    }
}