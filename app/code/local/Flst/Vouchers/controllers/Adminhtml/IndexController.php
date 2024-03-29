<?php

class Flst_Vouchers_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('vouchers/set_time')
                ->_addBreadcrumb('Vouchers Manager', 'Vouchers Manager');
        return $this;
    }
    
    public function editAction()
    {
        $storeId = $this->getRequest()->getParam('id');
        $storeModel = Mage::getModel('vouchers/vouchers')->load($storeId);
        
        if ($storeModel->getId() || $storeId == 0) {
            Mage::register('vouchers_data', $storeModel);
            $this->loadLayout();
            $this->_setActiveMenu('storelocator/set_time');
            $this->_addBreadcrumb('Vouchers Manager', 'Vouchers Manager');
            $this->_addBreadcrumb('Vouchers Description', 'Vouchers Description');
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('vouchers/adminhtml_vouchers_edit'))
                    ->_addLeft($this->getLayout()->createBlock('vouchers/adminhtml_vouchers_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')
                    ->addError('Store does not exist.');
            $this->redirect('*/*/');
        }
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function saveAction()
    {   
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        
        if ($this->getRequest()->getPost()) {
            try {
                $postData = $this->getRequest()->getPost();
                $storeModel = Mage::getModel('vouchers/vouchers');
                
                if ($this->getRequest()->getParam(('id')) <= 0) {
                    $storeModel->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
                } else {
                    $write->query("DELETE FROM storelocator_vouchers WHERE voucher_id = ".$this->getRequest()->getParam('id'));
                }
                $storeModel->addData($postData)
                    ->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
                    ->setId($this->getRequest()->getParam('id'))
                    ->save();
                                
                foreach ($this->getRequest()->getPost('stores') as $storeId) {
                    if ($storeId != 0) {
                        $write->query("INSERT INTO storelocator_vouchers(store_id, voucher_id) VALUES('".$storeId."', '".$storeModel->getId()."')");
                    }
                }
                                                
                Mage::getSingleton('adminhtml/session')
                        ->addSuccess('added');
                Mage::getSingleton('adminhtml/session')
                        ->setContactData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
    }
    
    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $storeModel = Mage::getModel('vouchers/vouchers');
                $storeModel->setId($this->getRequest()->getParam('id'))
                        ->delete();
                Mage::getSingleton('adminhtml/session')
                        ->addSuccess('successfully deleted');
                
                $write = Mage::getSingleton('core/resource')->getConnection('core_write');
                $write->query("DELETE FROM storelocator_vouchers WHERE voucher_id = ".$this->getRequest()->getParam('id'));
                
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                        ->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        } else {
            $this->_redirect('*/*/');
        }
    }
}