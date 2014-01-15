<?php

class Flst_Storelocator_Block_Adminhtml_Storelocator_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() 
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('storelocator_form', array('legend' => 'Informations du store'));
        
        $fieldset->addField('name', 'text', array(
           'label' => 'Nom',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'name'
        ));
        
        $fieldset->addField('address', 'text', array(
           'label' => 'Adresse',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'address'
        ));
        
        $fieldset->addField('geo', 'text', array(
           'label' => 'Coordonées géo.',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'geo'
        ));
        
        $fieldset->addField('info', 'textarea', array(
           'label' => 'Informations générales',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'info'
        ));
        
        $fieldset->addField('presentation', 'textarea', array(
           'label' => 'Présentation',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'presentation'
        ));
        
        $fieldset->addField('contacts', 'text', array(
           'label' => 'Contacts',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'contacts'
        ));
        
        $fieldset->addField('horaires', 'text', array(
           'label' => 'Horaires',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'horaires'
        ));
        
        $fieldset->addField('horaires_exp', 'text', array(
           'label' => 'Horaires exceptionnels',
           'class' => 'required_entry',
           'required' => true,
           'name' => 'horaires_exp'
        ));
        
        if (Mage::registry('storelocator_data')) {
            $form->setValues(Mage::registry('storelocator_data')->getData());
        }
        
        return parent::_prepareForm();
    }
}