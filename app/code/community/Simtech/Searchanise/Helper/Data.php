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

class Simtech_Searchanise_Helper_Data extends Mage_Core_Helper_Abstract
{
    const DISABLE_VAR_NAME = 'disabled_module_searchanise';
    const DISABLE_KEY      = 'Y';

    const DEBUG_VAR_NAME = 'debug_module_searchanise';
    const DEBUG_KEY      = 'Y';
    
    const TEXT_FIND          = 'TEXT_FIND';
    const TEXT_ADVANCED_FIND = 'TEXT_ADVANCED_FIND';
    const VIEW_CATEGORY      = 'VIEW_CATEGORY';
    const VIEW_TAG           = 'VIEW_TAG';
    
    protected $_disableText = null;
    protected $_debugText   = null;
    
    protected static $_searchaniseTypes = array(
        self::TEXT_FIND,
        self::TEXT_ADVANCED_FIND,
        self::VIEW_CATEGORY,
        self::VIEW_TAG,
    );
    
    /**
     * Searchanise request
     *
     * @var Simtech_Searchanise_Model_Request
     */
    protected $_searchaniseRequest = null;

    protected $_searchaniseCurentType = null;
    
    public function initSearchaniseRequest()
    {
        $this->_searchaniseRequest = Mage::getModel('searchanise/request');
        
        return $this;
    }

    public function checkSearchaniseResult()
    {
        return Mage::helper('searchanise/ApiSe')->checkSearchaniseResult($this->_searchaniseRequest);
    }
    
    public function setSearchaniseRequest($request)
    {
        $this->_searchaniseRequest = $request;
    }
    
    public function getSearchaniseRequest()
    {
        return $this->_searchaniseRequest;
    }

    public function setSearchaniseCurentType($type = null)
    {
        $this->_searchaniseCurentType = $type;
    }

    public function getSearchaniseCurentType()
    {
        return $this->_searchaniseCurentType;
    }
    
    public function getDisableText()
    {
        if (is_null($this->_disableText)) {
            $this->_disableText = $this->_getRequest()->getParam(self::DISABLE_VAR_NAME);
        }
        
        return $this->_disableText;
    }
    
    public function checkEnabled()
    {
        return ($this->getDisableText() != self::DISABLE_KEY) ? true : false;
    }

    public function getDebugText()
    {
        if (is_null($this->_debugText)) {
            $this->_debugText = $this->_getRequest()->getParam(self::DEBUG_VAR_NAME);
        }
        
        return $this->_debugText;
    }
    
    public function checkDebug()
    {
        return ($this->getDebugText() == self::DEBUG_KEY) ? true : false;
    }
    
    protected function setDefaultSort(&$params, $type)
    {
        if (empty($params)) {
            $params = array();
        }

        if (in_array($type, self::$_searchaniseTypes)) {
            if ($type == self::TEXT_FIND) {
                $params['sortBy']    = 'relevance';
                $params['sortOrder'] = 'desc';

            } elseif ($type == self::TEXT_ADVANCED_FIND) {
                $params['sortBy']    = 'title';
                $params['sortOrder'] = 'asc';

            } elseif ($type == self::VIEW_CATEGORY) {
                $params['sortBy']    = 'title';
                $params['sortOrder'] = 'asc';

            } elseif ($type == self::VIEW_TAG) {
                $params['sortBy']    = 'title';
                $params['sortOrder'] = 'asc';
            }

            if (empty($params['restrictBy'])) {
                $params['restrictBy'] = array();
            }
            if (empty($params['queryBy'])) {
                $params['queryBy'] = array();
            }
            if (empty($params['union'])) {
                $params['union'] = array();
            }
        }

        return $this;
    }
    
    protected function getUrlSuggestion($suggestion)
    {
        $query = array(
            'q' => $suggestion,
            Mage::getBlockSingleton('page/html_pager')->getPageVarName() => null // exclude current page from urls
        );
        
        return Mage::getUrl('*/*/*', array('_current'=>true, '_use_rewrite'=>true, '_query'=>$query));
    }

    /**
     * Check for replace default functional (example getAvailableLimit in Simtech_Searchanise_Block_Product_List_Toolbar)
     *
     * @return boolean
     */
    public function checkSearchaniseIsRunning()
    {
        $check = false;

        $type = $this->getSearchaniseCurentType();
        
        if ($type) {
            if (Mage::helper('searchanise/ApiSe')->getUseNavigation()) {
                $check = true;
            } else {
                if (($type == self::TEXT_FIND) || ($type == self::TEXT_ADVANCED_FIND)) {
                    $check = true;
                }
            }
        }

        return $check;
    }
    
    public function execute($type = null, $controller = null, $blockToolbar = null, $data = null)
    {
        $this->setSearchaniseCurentType(); // init value
        if ((!$this->checkEnabled()) || (!Mage::helper('searchanise/ApiSe')->getEnabledSearchaniseSearch())) {
            return;
        }
        
        if (!Mage::helper('searchanise/ApiSe')->getUseNavigation()) {
            if (($type != self::TEXT_FIND) && ($type != self::TEXT_ADVANCED_FIND)) {
                return;
            }
        }
        $this->setSearchaniseCurentType($type);
        if (empty($params)) {
            $params = array();
        }

        // Set default value.
        $this->setDefaultSort($params, $type);

        $params['restrictBy']['status'] = '1';
        $params['union']['price']['min'] = Mage::helper('searchanise/ApiSe')->getCurLabelForPricesUsergroup();
        $params['startIndex'] = 0; // tmp
        $showOutOfStock = Mage::getStoreConfigFlag(Mage_CatalogInventory_Helper_Data::XML_PATH_SHOW_OUT_OF_STOCK);
        if ($showOutOfStock) {
            // nothing
        } else {
            $params['restrictBy']['is_in_stock'] = '1';
        }
        
        if (in_array($type, self::$_searchaniseTypes)) {
            if ($type == self::TEXT_FIND) {
                $params['q'] = Mage::helper('catalogsearch')->getQueryText();
                if ($params['q'] != '') {
                    $params['q'] = strtolower(trim($params['q']));
                }

                $params['facets']                = 'true';
                $params['suggestions']           = 'true';
                $params['query_correction']      = 'false';
                $params['suggestionsMaxResults'] = Mage::helper('searchanise/ApiSe')->getSuggestionsMaxResults();
                
                $params['restrictBy']['visibility'] = '3|4';
                $minQuantityDecimals = Mage::helper('searchanise/ApiSe')->getMinQuantityDecimals();
                if (!empty($minQuantityDecimals)) {
                    $params['restrictBy']['quantity_decimals'] = $minQuantityDecimals . ',';
                }

            } elseif ($type == self::TEXT_ADVANCED_FIND) {
                $params['facets']           = 'false';
                $params['suggestions']      = 'false';
                $params['query_correction'] = 'false';
                
                $params['restrictBy']['visibility'] = '3|4';
                $minQuantityDecimals = Mage::helper('searchanise/ApiSe')->getMinQuantityDecimals();
                if (!empty($minQuantityDecimals)) {
                    $params['restrictBy']['quantity_decimals'] = $minQuantityDecimals . ',';
                }
                
            } elseif ($type == self::VIEW_CATEGORY) {
                // fixme in the future
                // need to add check to display block "Layered Navigation"
                if (true) {
                    $params['facets'] = 'true';
                    
                } else {
                    $params['facets'] = 'false';
                }
                
                $params['suggestions'] = 'false';
                $params['restrictBy']['visibility'] = '2|4';

            } elseif ($type == self::VIEW_TAG) {
                $params['facets']      = 'false';
                $params['suggestions'] = 'false';
                
                $params['restrictBy']['visibility'] = '3|2|4';
            }
        }

        if ((!empty($controller)) && (!empty($blockToolbar))) {
            if ($availableOrders = $blockToolbar->getAvailableOrders()) {
                if (in_array($type, self::$_searchaniseTypes)) {
                    $fl_change_orders = false;
                    // Fixme in the feature:
                    // products could have different position in different categories, sort by "position" disabled.
                    if (isset($availableOrders['position'])) {
                        $fl_change_orders = true;
                        unset($availableOrders['position']);
                    }
                    // end

                    if ($type == self::TEXT_FIND) {
                        if (!isset($availableOrders['relevance'])) {
                            $fl_change_orders = true;
                            $availableOrders = array_merge(
                                array('relevance' => $controller->__('Relevance')),
                                $availableOrders
                            );
                        }
                    } elseif ($type == self::TEXT_ADVANCED_FIND) {
                        // Nothing.
                    } elseif ($type == self::VIEW_CATEGORY) {
                        // Nothing.
                    } elseif ($type == self::VIEW_TAG) {
                        // Nothing.
                    }
                    if ($fl_change_orders) {
                        $blockToolbar->setAvailableOrders($availableOrders);
                        // If it changed orders then necessary set new default order and default direction.
                        $blockToolbar->setDefaultOrder($params['sortBy']);
                        $blockToolbar->setDefaultDirection($params['sortOrder']);
                    }
                }
            }

            $sortBy = $blockToolbar->getCurrentOrder();
            $sortOrder = $blockToolbar->getCurrentDirection();

            $maxResults = (int) $blockToolbar->getLimit();
            $startIndex = 0;
            $curPage = (int) $blockToolbar->getCurrentPage();
            $startIndex = $curPage > 1 ? ($curPage - 1) * $maxResults : 0;
            
            if ($maxResults) {
                $params['maxResults'] = $maxResults;
            }
            if ($startIndex) {
                $params['startIndex'] = $startIndex;
            }
            
            if ($sortBy) {
                if ($sortBy == 'name') {
                    $params['sortBy'] = 'title';
                } else {
                    $params['sortBy'] = $sortBy;
                }
            }
            
            if ($sortOrder) {
                $params['sortOrder'] = $sortOrder;
            }
        }
        // Fixme in the future
        // Need add check the 'sort By' parameter on the existence of Server.
        // $params['sortBy']
                
        //ADD FACETS
        $arrAttributes = array();
        $arrInputType  = array(); // need for save type $arrAttributes
        if (!empty($controller)) {
            // CATEGORIES
            {
                $arrCat = null;
                
                if ((in_array($type, self::$_searchaniseTypes)) && ($type != self::VIEW_TAG)) {
                    $cat_id = (int) $controller->getRequest()->getParam('cat');
                    if (!empty($cat_id)) {
                        $arrCat = array();
                        $arrCat[] = $cat_id; // need if not exist children categories
                        
                        $categories = Mage::getModel('catalog/category')
                            ->getCollection()
                            ->setStoreId(Mage::app()->getStore()->getId())
                            ->addFieldToFilter('entity_id', $cat_id)
                            ->load()
                            ;
                            
                        if (!empty($categories)) {
                            foreach ($categories as $cat) {
                                if (!empty($cat)) {
                                    $arrCat = $cat->getAllChildren(true);
                                }
                            }
                        }
                    } elseif (($type == self::VIEW_CATEGORY) && (!empty($data))) {
                        // data = category
                        $arrCat = $data->getAllChildren(true);
                    }
                }
                
                if (!empty($arrCat)) {
                    if (is_array($arrCat)) {
                        $params['restrictBy']['categories'] = implode('|', $arrCat);
                    } else {
                        $params['restrictBy']['categories'] = $arrCat;
                    }
                }
            }
            // ATTRIBUTES
            {
                $attributes = Mage::getResourceModel('catalog/product_attribute_collection');
                $attributes
                    ->setItemObjectClass('catalog/resource_eav_attribute')
                    ->load();
                    
                if (!empty($attributes)) {
                    foreach ($attributes as $id => $attr) {
                        $arrAttributes[$id] = $attr->getName();
                        $arrInputType[$id] = $attr->getData('frontend_input');
                    }
                    
                    if (!empty($arrAttributes)) {
                        $requestParams = $controller->getRequest()->getParams();
                        
                        if (!empty($requestParams)) {
                            foreach ($requestParams as $name => $val) {
                                $id = array_search($name, $arrAttributes);
                                if (($name) && ($id)) {
                                    $labelAttribute = 'attribute_' . $id;

                                    if ($name == 'price') {
                                        $valPrice = Mage::helper('searchanise/ApiSe')->getPriceValueFromRequest($val);
                                        if ($valPrice != '') {
                                            $params['restrictBy']['price'] = $valPrice;
                                        }

                                    } elseif ($arrInputType[$id] == 'price') {
                                        $params['union'][$labelAttribute]['min'] = Mage::helper('searchanise/ApiSe')->getCurLabelForPricesUsergroup();
                                        $valPrice = Mage::helper('searchanise/ApiSe')->getPriceValueFromRequest($val);
                                        
                                        if ($valPrice != '') {
                                            $params['restrictBy'][$labelAttribute] = $valPrice;
                                        }
                                        
                                    } elseif (($arrInputType[$id] == 'text') || ($arrInputType[$id] == 'textarea')) {
                                        if ($val != '') {
                                            $val = Mage::helper('searchanise/ApiSe')->escapingCharacters($val);

                                            if ($val != '') {
                                                $params['queryBy'][$labelAttribute] = $val;
                                            }
                                        }

                                    } elseif (($arrInputType[$id] == 'select') ||
                                              ($arrInputType[$id] == 'multiselect') ||
                                              ($arrInputType[$id] == 'boolean')) {
                                        if ($val) {
                                            if (is_array($val)) {
                                                $params['restrictBy'][$labelAttribute] = implode('|', $val);
                                            } else {
                                                $params['restrictBy'][$labelAttribute] = $val;
                                            }
                                        }

                                    } else {
                                        // nothing
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // TAGS
            if ((in_array($type, self::$_searchaniseTypes)) && ($type == self::VIEW_TAG)) {
                if ($data) {
                    // data = tag
                    $params['restrictBy']['tag_ids'] = $data->getId();
                }
            }
        }

        if (!Mage::helper('searchanise/ApiSe')->getUseNavigation()) {
            if (empty($params['queryBy']) && (!isset($params['q']) || $params['q'] == '')) {
                return;
            }
        }
        
        Mage::helper('searchanise')
            ->initSearchaniseRequest()
            ->getSearchaniseRequest()
            ->setStore(Mage::app()->getStore())
            ->setSearchParams($params)
            ->sendSearchRequest()
            ->getSearchResult();
        
        //add suggestions
        $suggestionsMaxResults = Mage::helper('searchanise/ApiSe')->getSuggestionsMaxResults();
        if ((!empty($suggestionsMaxResults)) && (in_array($type, self::$_searchaniseTypes)) && ($type == self::TEXT_FIND)) {
            $res = Mage::helper('searchanise')->getSearchaniseRequest();
            
            if ($res->getTotalProduct() == 0) {
                $sugs = Mage::helper('searchanise')->getSearchaniseRequest()->getSuggestions();
                
                if ((!empty($sugs)) && (count($sugs) > 0)) {
                    $message = Mage::helper('searchanise')->__('Did you mean: ');
                    $link = '';
                    $textFind = Mage::helper('catalogsearch')->getQueryText();
                    $count_sug = 0;

                    foreach ($sugs as $k => $sug) {
                        if ((!empty($sug)) && ($sug != $textFind)) {    
                            $link .= '<a href="' . self::getUrlSuggestion($sug). '">' . $sug .'</a>';
                            
                            if (end($sugs) == $sug) { 
                                $link .= '?'; 
                            } else { 
                                $link .= ', '; 
                            }
                            $count_sug++;
                        }
                        if ($count_sug >= $suggestionsMaxResults) {
                            break;
                        }
                    }
                    
                    if ($link != '') {
                        Mage::helper('catalogsearch')->addNoteMessage($message . $link);
                    }
                }
            }
        }
    }
    
    /**
     * Get specified products limit display per page
     *
     * @return string
     */
    public function getLimit()
    {
        //~ $limit = $this->_getData('_current_limit');
        //~ if ($limit) {
            //~ return $limit;
        //~ }
        
        $limits = $this->getAvailableLimit();
        $defaultLimit = $this->getDefaultPerPageValue();
        if (!$defaultLimit || !isset($limits[$defaultLimit])) {
            $keys = array_keys($limits);
            $defaultLimit = $keys[0];
        }
        
        $limit = $this->getRequest()->getParam($this->getLimitVarName());
        if ($limit && isset($limits[$limit])) {
            if ($limit == $defaultLimit) {
                Mage::getSingleton('catalog/session')->unsLimitPage();
            } else {
                $this->_memorizeParam('limit_page', $limit);
            }
        } else {
            $limit = Mage::getSingleton('catalog/session')->getLimitPage();
        }
        if (!$limit || !isset($limits[$limit])) {
            $limit = $defaultLimit;
        }

        $this->setData('_current_limit', $limit);
        return $limit;
    }
    
    /**
     * Retrieve available limits for current view mode
     *
     * @return array
     */
    public function getAvailableLimit()
    {
        $currentMode = $this->getCurrentMode();
        if (in_array($currentMode, array('list', 'grid'))) {
            return $this->_getAvailableLimit($currentMode);
        } else {
            return $this->_defaultAvailableLimit;
        }
    }
}