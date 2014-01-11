<?php

class Flst_Storelocator_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('storelocator/set_time')
                ->_addBreadcrumb('Store Locator Manager', 'Store Locator Manager');
        return $this;
    }
    
    public function editAction()
    {
        $storeId = $this->getRequest()->getParam('id');
        $storeModel = Mage::getModel('storelocator/storelocator')->load($storeId);
        
        if ($storeModel->getId() || $storeId == 0) {
            Mage::register('storelocator_data', $storeModel);
            $this->loadLayout();
            $this->_setActiveMenu('storelocator/set_time');
            $this->_addBreadcrumb('Store Locator Manager', 'Store Locator Manager');
            $this->_addBreadcrumb('Store Locator Description', 'Store Locator Description');
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('storelocator/adminhtml_storelocator_edit'))
                    ->_addLeft($this->getLayout()->createBlock('storelocator/adminhtml_storelocator_edit_tabs'));
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
        if ($this->getRequest()->getPost()) {
            try {
                $postData = $this->getRequest()->getPost();
                $storeModel = Mage::getModel('storelocator/storelocator');
                if ($this->getRequest()->getParam(('id')) <= 0) {
                    $storeModel->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
                }
                $storeModel->addData($postData)
                    ->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
                    ->setId($this->getRequest()->getParam('id'))
                    ->save();
                
                Mage::getSingleton('adminhtml/session')
                        ->addSuccess('added');
                Mage::getSingleton('adminhtml/session')
                        ->setContactData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                
            }
        }
    }
    
    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $storeModel = Mage::getModel('storelocator/storelocator');
                $storeModel->setId($this->getRequest()->getParam('id'))
                        ->delete();
                Mage::getSingleton('adminhtml/session')
                        ->addSuccess('successfully deleted');
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