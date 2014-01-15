<?php

class Flst_Vouchers_Block_Adminhtml_Vouchers_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() 
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('vouchers_form', array('legend' => 'Informations sur la promotion'));
        
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
        
        if (Mage::registry('vouchers_data')) {
            $form->setValues(Mage::registry('vouchers_data')->getData());
        }
        
        return parent::_prepareForm();
    }
}