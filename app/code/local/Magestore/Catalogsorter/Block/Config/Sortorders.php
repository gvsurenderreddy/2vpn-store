<?php

class Magestore_Catalogsorter_Block_Config_Sortorders
	extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    protected $_dummyElement;
    protected $_fieldRenderer;
    protected $_values;

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getHeaderHtml($element);

        foreach (Mage::helper('catalogsorter')->getAvailabeOrders() as $order_code=>$order_label) {
            $html .= $this->_getFieldHtml($element, $order_code, $order_label);
        }
        $html .= $this->_getFooterHtml($element);
        return $html;
    }

    protected function _getDummyElement()
    {
        if (empty($this->_dummyElement)) {
            $this->_dummyElement = new Varien_Object(array('show_in_default'=>1, 'show_in_website'=>1));
        }
        return $this->_dummyElement;
    }

    protected function _getFieldRenderer()
    {
        if (empty($this->_fieldRenderer)) {
            $this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
        }
        return $this->_fieldRenderer;
    }

    protected function _getValues()
    {
        if (empty($this->_values)) {
            $this->_values = array(
                array('label'=>Mage::helper('adminhtml')->__('Enable'), 'value'=>0),
                array('label'=>Mage::helper('adminhtml')->__('Disable'), 'value'=>1),
            );
        }
        return $this->_values;
    }	
	

    protected function _getFieldHtml($fieldset, $order_code, $order_label)
    {
        $configData = $this->getConfigData();
        $path = 'catalogsorter/sortorders/'.$order_code;
        $data = isset($configData[$path]) ? $configData[$path] : '';
		
        $e = $this->_getDummyElement();

        $field = $fieldset->addField($order_code, 'text',
            array(
                'name'          => 'groups[sortorders][fields]['.$order_code.'][value]',
                'label'         => $order_label,
                'value'         => $data,
				'style'         => 'width:200px;',
                'inherit'       => isset($configData[$path]) ? false : true,
                'can_use_default_value' => $this->getForm()->canUseDefaultValue($e),
                'can_use_website_value' => $this->getForm()->canUseWebsiteValue($e),
				'comment'         => Mage::helper('catalogsorter')->__('Set priority for this order (0 as hidden)'),
            ))->setRenderer($this->_getFieldRenderer());

        return $field->toHtml();
    }
}