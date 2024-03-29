<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/
class Simtech_Searchanise_OptionsController extends Mage_Adminhtml_Controller_Action
{
    const PARAM_USE_NAVIGATION = 'snize_use_navigation';
    
    /*
     * options
     */
    public function indexAction()
    {
        $useNavigation = $this->getRequest()->getParam(self::PARAM_USE_NAVIGATION);
        Mage::helper('searchanise/ApiSe')->setUseNavigation($useNavigation == 'true' ? true : false);

        exit;
    }
}