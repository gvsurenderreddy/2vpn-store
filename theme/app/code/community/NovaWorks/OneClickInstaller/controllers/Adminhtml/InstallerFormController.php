<?php

class NovaWorks_OneClickInstaller_Adminhtml_InstallerFormController extends Mage_Adminhtml_Controller_Action
{
    protected $_storeId = null;

    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }
    
		protected function deleteBlock($id){
	        $block = Mage::getModel('cms/block')
	                ->setStoreId($this->_storeId)
	                ->load($id);
	
			$block->delete();
		}
    
    public function uninstallAction()
    {
		$post = $this->getRequest()->getPost();
		$message = "";
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
			$storeId = $post['design']['store_id'];		
			$this->_storeId = $storeId;	
			
			$this->deleteBlock('detail_product_right');
			$this->deleteBlock('block_top_left');
			$this->deleteBlock('block_top_center');
			$this->deleteBlock('block_custom_menu');
			$this->deleteBlock('block_custom_slidebar_2');
			$this->deleteBlock('block_custom_slidebar_3');
			$this->deleteBlock('block_info_top');
			$this->deleteBlock('block_detail_product_page_1');
			$this->deleteBlock('block_detail_product_page_2');
			$this->deleteBlock('aditional_footer_left');
			$this->deleteBlock('block_contact_top');
			$this->deleteBlock('block_contact_bottom');
			$this->deleteBlock('block_bottom_left');
			$this->deleteBlock('block_bottom_right');
			$this->deleteBlock('block_contact_box');
			$this->deleteBlock('block_container_info');
			$this->deleteBlock('block_empty_center');
			$this->deleteBlock('blog-content');
			$this->deleteBlock('home_3_banner_bottom');
			$this->deleteBlock('social_in_detail');
			if($storeId == 0) {
				$scope = 'default';
			}else{
				$scope = 'stores';
			}
			Mage::getConfig()->saveConfig('design/package/name','default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/template', 'default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/skin', 'default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/layout', 'default', $scope, $storeId);
			Mage::getConfig()->saveConfig('design/theme/default', 'default', $scope, $storeId);
			
			$message = $this->__('Medalion theme was uninstalled successfully. ');
			Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
		$this->_redirect('*/*');		
    }
    public function installAction()
    {
      $post = $this->getRequest()->getPost();
      $message = "";
      try {
      	if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
        }
				$storeId 			= $post['design']['store_id'];
				$InstallBlock 	= $post['design']['install_block'];
				$InstallSlideshow 	= $post['design']['install_slideshow'];
				$stores = array($storeId); 	//Used at all blocks
				$RootCategoryId = Mage::app()->getStore($storeId)->getRootCategoryId();			
				$novaworks_uploaded = false;
				$design = Mage::getModel('core/design_package')->getPackageList();
				foreach ($design as $package){
					if($package == "novaworks") {
						$novaworks_uploaded = true;
						break;
					}
				}
				if (!$novaworks_uploaded){
					Mage::throwException($this->__('Medalion Theme was not found. Please upload the theme first.'));				
				}					
				if($storeId == 0) {
					$scope = 'default';
				}else{
					$scope = 'stores';
				}
				//Configuration 
				//Design
				Mage::getConfig()->saveConfig('design/package/name', "novaworks", $scope, $storeId);
				Mage::getConfig()->saveConfig('design/theme/template', "medalion", $scope, $storeId);
				Mage::getConfig()->saveConfig('design/theme/skin', "medalion", $scope, $storeId);		
				Mage::getConfig()->saveConfig('design/theme/layout', "medalion", $scope, $storeId);
				Mage::getConfig()->saveConfig('design/theme/default', "medalion", $scope, $storeId);
				//Coppyright
				Mage::getConfig()->saveConfig('design/footer/copyright', "&copy; 2013 Medalion Theme. All Rights Reserved. Designed by <a href=\"http://novaworks.net/\" title=\"Novaworks\">Novaworks</a>",$scope, $storeId);
				//Header
				Mage::getConfig()->saveConfig('design/header/logo_src', "images/logo.png", $scope, $storeId);
				Mage::getConfig()->saveConfig('web/default/cms_home_page', "home_v1", $scope, $storeId);
				//Setup Static Block
				if($InstallBlock == 1) {
				//SETUP 404 NOT FOUND PAGE
				$html = '<div class="mail-center-404">
<div class="row-fluid">
<div class="span4">&nbsp;</div>
<div class="span3">
<div class="mail-center">
<h1>404</h1>
<h2>Oops!</h2>
<p>The page you are looking for does not exist.</p>
<p>Return to the <a href="{{config path="web/unsecure/base_url"}}">home page!</a></p>
</div>
</div>
<div class="span4">&nbsp;</div>
</div>
</div>';
				
				//load the current 404 page
				$page = Mage::getModel('cms/page');//->getCollection();
				$pageId = $page->checkIdentifier('no-route', $storeId);
				if ($pageId){
					//Update this one
					$page->load($pageId);
					$data = $page->getData();
					$data['is_active'] = 1;//Enable it
					$data['title'] = '404 Not Found'; //page title
					$data['root_template'] = 'one_column';
					$data['custom_theme'] = null;
					$data['content'] = $html;
					$page->setData($data);
				} else {
					//Create a new one
					$data = array();
					$data['form_key'] = '';
					$data['title'] = '404 Not Found'; //page title
					$data['identifier'] = 'no-route'; //URL
					$data['stores'][0] = $storeId; //stores array, store number
					$data['is_active'] = 1;
					$data['content'] = $html;
					$data['custom_theme'] = null;
					$data['custom_theme_from'] = '';
					$data['custom_theme_to'] = '';
					$data['root_template'] = 'one_column';
					$data['layout_update_xml'] = '';
					$data['meta_keywords'] = '';
					$data['meta_description'] = '';			
					 
					$page->setData($data);
				}
				
				// try to save it
				try {
					// save the data
					$page->save();
					$message .= $this->__(' 404 Not Found page saved.');
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_redirect('*/*');
					return;
				}
				//SETUP ABOUT US PAGE
				$html = '<div class="about-content">
<div class="row-fluid"><img src="{{media url="wysiwyg/img-welcome_1.jpg"}}" alt="" /></div>
<div class="row-fluid wel-come">
<h1>MEDALION STORE</h1>
<h3>FROM THE INTERNET</h3>
<h2>Good Evening.</h2>
<p>I&rsquo;m Jim, a designer from the UK. I work at Etch where we design and build apps for devices, big and small.</p>
<p>I have a hardwired desire to be better, an instinct for good design, a strong ambition to make a difference on the web, embarrassing hang-ups on semantics, and evangelistic tendencies.</p>
</div>
<div class="row-fluid content">
<div class="span8">
<p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidi-dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercita-tion ullamco laboris nisi ut aliquip ex ea commodo consequat.</span></p>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi archi-tecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidi-dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercita-tion ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi archi-tecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores.</p>
<p class="padding-top-bottom"><span>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</span></p>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi archi-tecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidi-dunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercita-tion ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi archi-tecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores.</p>
</div>
<div class="span4"><img src="{{media url="wysiwyg/view-project_1.png"}}" alt="" /></div>
</div>
<div class="row-fluid meat-your-team">
<div class="row-fluid">
<div class="span12">
<h2 class="title">Meat Your Team</h2>
</div>
</div>
<div class="row-fluid">
<div class="span3"><img src="{{media url="wysiwyg/view-project.jpg"}}" alt="" /></div>
<div class="span9 meat-right">
<div class="meat-position">
<p><span>I&rsquo;m Jim, a designer from the UK. I work at Etch where we design and build apps for devices, big and small.I have a hardwired desire to be better, an instinct for good design, a strong ambition to make a difference on the web, embarrassing hang-ups on semantics, and evan</span></p>
<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi archi-tecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
</div>
</div>
</div>
</div>
<div class="afew-container">
<div class="a-few-features">
<div class="row-fluid center-title">
<h2 class="title">A Few Features</h2>
</div>
<div class="row-fluid afew-top">
<div class="span6">
<div class="row-fluid">
<div class="span3">&nbsp;</div>
<div class="span9">
<div class="retina-ready">
<h3>Retina ready</h3>
<p>anny pack godard YOLO VHS Austin irony bespoke, you probably haven&rsquo;t heard of them fashion axe church-key wes anderson kale chips four loko. Gentrify stumptown chillwave, pop-up tofu DIY cardigan jean shorts blog wayfarers before they sold out authentic bushwick</p>
</div>
</div>
</div>
</div>
<div class="span6">
<div class="row-fluid">
<div class="span3">&nbsp;</div>
<div class="span9">
<div class="mobile-friendly">
<h3>Super Mobile-Friendly</h3>
<p>anny pack godard YOLO VHS Austin irony bespoke, you probably haven&rsquo;t heard of them fashion axe church-key wes anderson kale chips four loko. Gentrify stumptown chillwave, pop-up tofu DIY cardigan jean shorts blog wayfarers before they sold out authentic bushwick</p>
</div>
</div>
</div>
</div>
</div>
<div class="row-fluid afew-bottom">
<div class="span6">
<div class="row-fluid">
<div class="span3">&nbsp;</div>
<div class="span9">
<div class="wide-or">
<h3>Wide or Boxed Layout</h3>
<p>anny pack godard YOLO VHS Austin irony bespoke, you probably haven&rsquo;t heard of them fashion axe church-key wes anderson kale chips four loko. Gentrify stumptown chillwave, pop-up tofu DIY cardigan jean shorts blog wayfarers before they sold out authentic bushwick</p>
</div>
</div>
</div>
</div>
<div class="span6">
<div class="row-fluid">
<div class="span3">&nbsp;</div>
<div class="span9">
<div class="responsive-layout">
<h3>Responsive Layout</h3>
<p>anny pack godard YOLO VHS Austin irony bespoke, you probably haven&rsquo;t heard of them fashion axe church-key wes anderson kale chips four loko. Gentrify stumptown chillwave, pop-up tofu DIY cardigan jean shorts blog wayfarers before they sold out authentic bushwick</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>';
				
				$page = Mage::getModel('cms/page');//->getCollection();
				$pageId = $page->checkIdentifier('about-us', $storeId);
				if ($pageId){
					//Update this one
					$page->load($pageId);
					$data = $page->getData();
					$data['is_active'] = 1;//Enable it
					$data['title'] = 'About  Us'; //page title
					$data['root_template'] = 'one_column';
					$data['custom_theme'] = null;
					$data['content'] = $html;
					$page->setData($data);
				} else {
					//Create a new one
					$data = array();
					$data['form_key'] = '';
					$data['title'] = 'About  Us'; //page title
					$data['identifier'] = 'about-us'; //URL
					$data['stores'][0] = $storeId; //stores array, store number
					$data['is_active'] = 1;
					$data['content'] = $html;
					$data['custom_theme'] = null;
					$data['custom_theme_from'] = '';
					$data['custom_theme_to'] = '';
					$data['root_template'] = 'one_column';
					$data['layout_update_xml'] = '';
					$data['meta_keywords'] = '';
					$data['meta_description'] = '';			
					 
					$page->setData($data);
				}
				
				// try to save it
				try {
					// save the data
					$page->save();
					$message .= $this->__(' About Page page saved.');
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_redirect('*/*');
					return;
				}
				//SETUP FAQs PAGE
				$html = '<div class="faqs-content">
<div class="row-fluid">
<div id="accordion" class="accordion in">
<div class="accordion-group">
<h3>PRE-SALE QUESTIONS</h3>
<div class="row-fluid">
<div class="accordion-heading"><a class="accordion-toggle" href="#collapseOne" data-toggle="collapse" data-parent="#accordion"> Can I Preview the Documentation Before I Purchase the Theme? </a></div>
<div id="collapseOne" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
<div class="row-fluid">
<div class="accordion-group">
<div class="accordion-heading"><a class="accordion-toggle" href="#collapseTwo" data-parent="#accordion" data-toggle="collapse"> How Do I Get Support For My copy of the Theme, Beyond the Help of Documentation? </a></div>
<div id="collapseTwo" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
</div>
<div class="row-fluid">
<div class="accordion-group">
<div class="accordion-heading"><a class="accordion-toggle collapsed" href="#collapseThree" data-parent="#accordion" data-toggle="collapse"> Where Can I Find My Item Purchase Code? </a></div>
<div id="collapseThree" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
</div>
</div>
<div class="accordion-group">
<h3>A 2ND BLOCK OF FAQS</h3>
<div class="row-fluid">
<div class="accordion-heading"><a class="accordion-toggle" href="#collapsefour" data-toggle="collapse" data-parent="#accordion"> Can I Preview the Documentation Before I Purchase the Theme? </a></div>
<div id="collapsefour" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
<div class="row-fluid">
<div class="accordion-group">
<div class="accordion-heading"><a class="accordion-toggle" href="#collapsefive" data-parent="#accordion" data-toggle="collapse"> How Do I Get Support For My copy of the Theme, Beyond the Help of Documentation? </a></div>
<div id="collapsefive" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
</div>
<div class="row-fluid">
<div class="accordion-group">
<div class="accordion-heading"><a class="accordion-toggle collapsed" href="#collapsesix" data-parent="#accordion" data-toggle="collapse"> Where Can I Find My Item Purchase Code? </a></div>
<div id="collapsesix" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
</div>
</div>
<div class="accordion-group">
<h3>SHIPPING &amp; RETURNS</h3>
<div class="row-fluid">
<div class="accordion-heading"><a class="accordion-toggle" href="#collapseseven" data-toggle="collapse" data-parent="#accordion"> Can I Preview the Documentation Before I Purchase the Theme? </a></div>
<div id="collapseseven" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
<div class="row-fluid">
<div class="accordion-group">
<div class="accordion-heading"><a class="accordion-toggle" href="#collapseeight" data-parent="#accordion" data-toggle="collapse"> How Do I Get Support For My copy of the Theme, Beyond the Help of Documentation? </a></div>
<div id="collapseeight" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
</div>
<div class="row-fluid">
<div class="accordion-group">
<div class="accordion-heading"><a class="accordion-toggle collapsed" href="#collapsenine" data-parent="#accordion" data-toggle="collapse"> Where Can I Find My Item Purchase Code? </a></div>
<div id="collapsenine" class="accordion-body collapse">
<div class="accordion-inner">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo, quis pretium turpis neque eget nulla. Curabitur dictum consectetur metus nec dignissim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In congue, justo non cursus adipiscing, dui nibh scelerisque justo.</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>';
				
				$page = Mage::getModel('cms/page');//->getCollection();
				$pageId = $page->checkIdentifier('faq', $storeId);
				if ($pageId){
					//Update this one
					$page->load($pageId);
					$data = $page->getData();
					$data['is_active'] = 1;//Enable it
					$data['title'] = 'FAQs'; //page title
					$data['root_template'] = 'one_column';
					$data['custom_theme'] = null;
					$data['content'] = $html;
					$page->setData($data);
				} else {
					//Create a new one
					$data = array();
					$data['form_key'] = '';
					$data['title'] = 'FAQs'; //page title
					$data['identifier'] = 'faq'; //URL
					$data['stores'][0] = $storeId; //stores array, store number
					$data['is_active'] = 1;
					$data['content'] = $html;
					$data['custom_theme'] = null;
					$data['custom_theme_from'] = '';
					$data['custom_theme_to'] = '';
					$data['root_template'] = 'one_column';
					$data['layout_update_xml'] = '';
					$data['meta_keywords'] = '';
					$data['meta_description'] = '';			
					 
					$page->setData($data);
				}
				
				// try to save it
				try {
					// save the data
					$page->save();
					$message .= $this->__(' FAQ page saved.');
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_redirect('*/*');
					return;
				}
				//SETUP HOMEPAGE
				$html = '<p>{{block type="revslideshow/view"}}</p>
<p>[container]</p>
<p>[full_column]</p>
<p>[products_list type="cat" cat="35" count="12" output="product-slider" title="New products"]</p>
<p>[/full_column]</p>
<p>[/container]</p>
<p>[cool_box bg_color="#1f1d1b" v_space="25px"]</p>
<p>[products_list type="cat" cat="35" count="6" output="product-cool-list" title="Spring/Summer collection 2013" button_title="Read More" button_link="#"]</p>
<p>[/cool_box]</p>
<p>[cool_box bg_color="#FFFFFF" bg_image="{{media url="wysiwyg/bg-01.jpg"}}" v_space="0px"]</p>
<p>[container]</p>
<p>{{widget type="cms/widget_block" template="cms/widget/static_block/default.phtml" block_id="30"}}</p>
<p>[/container]</p>
<p>[/cool_box]</p>
<p>[container]</p>
<p>[full_column]</p>
<p>{{widget type="cms/widget_block" template="cms/widget/static_block/default.phtml" block_id="31"}}</p>
<p>[/full_column]</p>
<p>[/container]</p>';
				
				$page = Mage::getModel('cms/page');//->getCollection();
				$pageId = $page->checkIdentifier('home_v1', $storeId);
				if ($pageId){
					//Update this one
					$page->load($pageId);
					$data = $page->getData();
					$data['is_active'] = 1;//Enable it
					$data['title'] = 'Home Page'; //page title
					$data['root_template'] = 'medalion_custom_page';
					$data['custom_theme'] = null;
					$data['content'] = $html;
					$page->setData($data);
				} else {
					//Create a new one
					$data = array();
					$data['form_key'] = '';
					$data['title'] = 'Home page'; //page title
					$data['identifier'] = 'home_v1'; //URL
					$data['stores'][0] = $storeId; //stores array, store number
					$data['is_active'] = 1;
					$data['content'] = $html;
					$data['custom_theme'] = null;
					$data['custom_theme_from'] = '';
					$data['custom_theme_to'] = '';
					$data['root_template'] = 'medalion_custom_page';
					$data['layout_update_xml'] = '';
					$data['meta_keywords'] = '';
					$data['meta_description'] = '';			
					 
					$page->setData($data);
				}
				
				// try to save it
				try {
					// save the data
					$page->save();
					$message .= $this->__(' Home page saved.');
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_redirect('*/*');
					return;
				}
				//SETUP HOMEPAGE V2
				$html = '<p>{{block type="revslideshow/view"}}</p>
<p>[banner_simple title="FREESHIPPING ON ALL ODERS OVER $100" subtitle="FREE OVER $150 FOR INTERNATIONAL ODERS" button_title="BUY THEME" button_link="#"]</p>
<p>[products_list type="cat" cat="35" count="8" output="product-slider" title="New products"]</p>
<p>[collections title="Extra Collections"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-01.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-02.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-03.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-04.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-05.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[/collections]</p>
<p>[container class="products-list-3-col"]</p>
<p>[one_third]</p>
<p>[products_list type="cat" cat="36" count="2" output="product-3-columns" title="Best Seller"]</p>
<p>[/one_third]</p>
<p>[one_third]</p>
<p>[products_list type="toprated" count="2" output="product-3-columns" title="Top rated"]</p>
<p>[/one_third]</p>
<p>[one_third]</p>
<p>[products_list type="cat" cat="35 "count="2" output="product-3-columns" title="Featured"]</p>
<p>[/one_third]</p>
<p>[/container]</p>
<p>[container]</p>
<p>[one_third]<img src="{{media url="wysiwyg/Demo/sample_logo_1.jpg"}}" alt="" />[/one_third]</p>
<p>[one_third]<img src="{{media url="wysiwyg/Demo/sample_logo_1.jpg"}}" alt="" />[/one_third]</p>
<p>[one_third]<img src="{{media url="wysiwyg/Demo/sample_logo_1.jpg"}}" alt="" />[/one_third]</p>
<p>[/container]</p>';
				
				$page = Mage::getModel('cms/page');//->getCollection();
				$pageId = $page->checkIdentifier('home_v2', $storeId);
				if ($pageId){
					//Update this one
					$page->load($pageId);
					$data = $page->getData();
					$data['is_active'] = 1;//Enable it
					$data['title'] = 'Home Page V2'; //page title
					$data['root_template'] = 'one_column';
					$data['custom_theme'] = null;
					$data['content'] = $html;
					$page->setData($data);
				} else {
					//Create a new one
					$data = array();
					$data['form_key'] = '';
					$data['title'] = 'Home V2'; //page title
					$data['identifier'] = 'home_v2'; //URL
					$data['stores'][0] = $storeId; //stores array, store number
					$data['is_active'] = 1;
					$data['content'] = $html;
					$data['custom_theme'] = null;
					$data['custom_theme_from'] = '';
					$data['custom_theme_to'] = '';
					$data['root_template'] = 'one_column';
					$data['layout_update_xml'] = '';
					$data['meta_keywords'] = '';
					$data['meta_description'] = '';			
					 
					$page->setData($data);
				}
				
				// try to save it
				try {
					// save the data
					$page->save();
					$message .= $this->__(' Home V2 saved.');
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_redirect('*/*');
					return;
				}
				//SETUP HOMEPAGE V3
				$html = '<p>{{block type="revslideshow/view"}}</p>';
				
				$page = Mage::getModel('cms/page');//->getCollection();
				$pageId = $page->checkIdentifier('home_v3', $storeId);
				if ($pageId){
					//Update this one
					$page->load($pageId);
					$data = $page->getData();
					$data['is_active'] = 1;//Enable it
					$data['title'] = 'Home Page V3'; //page title
					$data['root_template'] = 'medalion_custom_page';
					$data['custom_theme'] = null;
					$data['content'] = $html;
					$page->setData($data);
				} else {
					//Create a new one
					$data = array();
					$data['form_key'] = '';
					$data['title'] = 'Home V3'; //page title
					$data['identifier'] = 'home_v3'; //URL
					$data['stores'][0] = $storeId; //stores array, store number
					$data['is_active'] = 1;
					$data['content'] = $html;
					$data['custom_theme'] = null;
					$data['custom_theme_from'] = '';
					$data['custom_theme_to'] = '';
					$data['root_template'] = 'medalion_custom_page';
					$data['layout_update_xml'] = '';
					$data['meta_keywords'] = '';
					$data['meta_description'] = '';			
					 
					$page->setData($data);
				}
				
				// try to save it
				try {
					// save the data
					$page->save();
					$message .= $this->__(' Home V3 saved.');
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_redirect('*/*');
					return;
				}
				//SETUP HOMEPAGE V4
				$html = '<p>{{block type="revslideshow/view"}}</p>
<p>[container]</p>
<p>[full_column]</p>
<p>[products_list type="catfilter" cat="35,36" cat_selected="36" count="4" output="product-filters" title="New products"]</p>
<p>[/full_column]</p>
<p>[/container]</p>
<p>[container]</p>
<p>[full_column]</p>
<p>[collections title="Extra Collections"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-01.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-02.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-03.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-04.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[collection_item title="SUMMNER COLLECTIONS 2013" image="{{media url="wysiwyg/Colletions/demo-05.jpg"}}" content="RIT Online builds programs around industry standards, employer demand, and the perspectives of our global network. We offer custom-de" link="#" text_link="Read more"]</p>
<p>[/collections]</p>
<p>[/full_column]</p>
<p>[/container]</p>
<p>[container]</p>
<p>[full_column]</p>
<p>[brands_list title="Brands List"]</p>
<p>[brand_item image="{{media url="wysiwyg/logo1.png"}}" link="#"]</p>
<p>[brand_item image="{{media url="wysiwyg/logo2.png"}}" link="#"]</p>
<p>[brand_item image="{{media url="wysiwyg/logo3.png"}}" link="#"]</p>
<p>[brand_item image="{{media url="wysiwyg/logo04.png"}}" link="#"]</p>
<p>[brand_item image="{{media url="wysiwyg/logo05.png"}}" link="#"]</p>
<p>[brand_item image="{{media url="wysiwyg/logo06.png"}}" link="#"]</p>
<p>[/brands_list]</p>
<p>[/full_column]</p>
<p>[/container]</p>';
				
				$page = Mage::getModel('cms/page');//->getCollection();
				$pageId = $page->checkIdentifier('home_v4', $storeId);
				if ($pageId){
					//Update this one
					$page->load($pageId);
					$data = $page->getData();
					$data['is_active'] = 1;//Enable it
					$data['title'] = 'Home Page V4'; //page title
					$data['root_template'] = 'medalion_custom_page';
					$data['custom_theme'] = null;
					$data['content'] = $html;
					$page->setData($data);
				} else {
					//Create a new one
					$data = array();
					$data['form_key'] = '';
					$data['title'] = 'Home V4'; //page title
					$data['identifier'] = 'home_v4'; //URL
					$data['stores'][0] = $storeId; //stores array, store number
					$data['is_active'] = 1;
					$data['content'] = $html;
					$data['custom_theme'] = null;
					$data['custom_theme_from'] = '';
					$data['custom_theme_to'] = '';
					$data['root_template'] = 'medalion_custom_page';
					$data['layout_update_xml'] = '';
					$data['meta_keywords'] = '';
					$data['meta_description'] = '';			
					 
					$page->setData($data);
				}
				
				// try to save it
				try {
					// save the data
					$page->save();
					$message .= $this->__(' Home V4 saved.');
				} catch (Mage_Core_Exception $e) {
					$this->_getSession()->addError($e->getMessage());
					$this->_redirect('*/*');
					return;
				}


					
					// Details product right
					$content = '<ul class="slides">
<li>
<p style="text-align: center;"><img src="{{media url="wysiwyg/detail-sample1_2.jpg"}}" alt="" /></p>
</li>
<li>
<p style="text-align: center;"><img src="{{media url="wysiwyg/detail-sample2_3.jpg"}}" alt="" /></p>
</li>
<li>
<p style="text-align: center;"><img src="{{media url="wysiwyg/detail-sample3.jpg"}}" alt="" /></p>
</li>
</ul>';
					$data = array("title" => "Details product right", 
								  "identifier" => "detail_product_right",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Details product right block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}	
					// Block Top Left
					$content = '<p>Call us free 24/7: (000) 589-516-5485</p>';
					$data = array("title" => "Block Top Left", 
								  "identifier" => "block_top_left",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block Top Left block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}						
					// Block Top Center
					$content = '<ul>
<li><a href="{{config path="web/unsecure/base_url"}}about-us">About Us</a></li>
<li><a href="{{config path="web/unsecure/base_url"}}faq">FAQs</a></li>
<li><a href="{{config path="web/unsecure/base_url"}}contacts">Contact</a></li>
<li class="last"><a href="#">Buy Theme!</a></li>
</ul>';
					$data = array("title" => "Block Top Center", 
								  "identifier" => "block_top_center",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block Top Center block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}	
					// Block Custom Menu
					$content = '<div class="col4-set">
<div class="col-1">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce suscipit bibendum risus, eget faucibus sapien cursus quis. Integer ultrices tempor sapien, quis mollis elit ornare at.</p>
</div>
<div class="col-2">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce suscipit bibendum risus, eget faucibus sapien cursus quis. Integer ultrices tempor sapien, quis mollis elit ornare at.</p>
</div>
<div class="col-3">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce suscipit bibendum risus, eget faucibus sapien cursus quis. Integer ultrices tempor sapien, quis mollis elit ornare at.</p>
</div>
<div class="col-4">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce suscipit bibendum risus, eget faucibus sapien cursus quis. Integer ultrices tempor sapien, quis mollis elit ornare at.</p>
</div>
</div>';
					$data = array("title" => "Block Custom", 
								  "identifier" => "block_custom_menu",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__('Custom Menu block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}				
					// Custom Slidebar 2
					$content = '<div class="block custom-html">
<div id="custom-html"><strong> <span>Custom HTML</span> </strong></div>
<div class="block-content">
<p>Lorem ipsum dolor sit amet, con-sectetuer adipiscing elit sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.d tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim vemodo consequat.</p>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat</p>
</div>
</div>';
					$data = array("title" => "Custom Slidebar 2", 
								  "identifier" => "block_custom_slidebar_2",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Custom Slidebar 2 block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}	
					// Custom Slidebar 3
					$content = '<div class="left-block-inner">
<ul class="slides">
<li>
<p style="text-align: center;"><img src="{{media url="wysiwyg/detail-sample2_2.jpg"}}" alt="" /></p>
</li>
<li>
<p style="text-align: center;"><img src="{{media url="wysiwyg/detail-sample2_2.jpg"}}" alt="" /></p>
</li>
<li>
<p style="text-align: center;"><img src="{{media url="wysiwyg/detail-sample2_2.jpg"}}" alt="" /></p>
</li>
</ul>
</div>';
					$data = array("title" => "Custom Right Slidebar", 
								  "identifier" => "block_custom_slidebar_3",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Custom Slidebar 2 block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}	
					// Block Info Top
					$content = '<div class="row-fluid">
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner01.jpg"}}" alt="" />
<h3>THOMAS MARINE, LEADER AU QU&Eacute;BEC</h3>
<div class="info-content">
<p>Avec ses cinq succursales, le Groupe Thomas Marine est le plus important concessionnaire du Qu&eacute;bec lorsqu&rsquo;il s&rsquo;agit de l&rsquo;achat d&rsquo;un bateau de p&ecirc;che ou d&rsquo;un bateau de plaisance. Premier d&eacute;taillant mondial pour le bateau de p&ecirc;che et le ponton d&rsquo;aluminium Princecraft et le bateau de plaisance Bayliner, nous sommes &eacute;galement distributeur exclusif du bateau de plaisance Crownline, du bateau de p&ecirc;che .</p>
</div>
<a href="#">Read More</a></div>
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner02.jpg"}}" alt="" />
<h3>LE BATEAU NEUF OU USAG&Eacute; DE VOS R&Ecirc;VES</h3>
<div class="info-content">
<p>Chez Thomas Marine, vous trouverez un vaste inventaire si vous cherchez un moteur hors-bord Mercury, un moteur &eacute;lectrique Minn Kota ou Motorguide, un sonar ou un GPS Hummingbird ou Lowrance, ainsi que tous les accessoires nautiques et pi&egrave;ces d&rsquo;&eacute;quipement essentiels &agrave; d&rsquo;agr&eacute;ables moments en bateau.</p>
</div>
<a href="#">Read More</a></div>
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner03.jpg"}}" alt="" />
<h3>VOUS NE TROUVEREZ PAS MEILLEUR SERVICE AILLEURS</h3>
<div class="info-content">
<p>Pour vos besoins d&rsquo;entretien de bateau ou de r&eacute;parations m&eacute;caniques sur votre hors-bord ou semi hors-bord confiez votre bateau de p&ecirc;che ou votre bateau de plaisance &agrave; nos techniciens certifi&eacute;s. Nos d&eacute;partements de service offre &eacute;galement l&rsquo;entreposage et l&rsquo;emballage de votre bateau d&rsquo;aluminium ou votre bateau de fibre de verre.</p>
</div>
<a href="#">Read More</a></div>
</div>';
					$data = array("title" => "Block info top", 
								  "identifier" => "block_info_top",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block Info Top block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}	
					// Block Detail product page 1
					$content = '<div style="background-color: #f5f5f5; padding: 10px; margin-bottom: 10px; margin-top: 10px;">This product <strong><span style="color: #ca3400; text-transform: uppercase;">Shiping Free</span></strong></div>';
					$data = array("title" => "Block Detail product page 1", 
								  "identifier" => "block_detail_product_page_1",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block Detail product page 1 created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}						
					// Block Detail product page 2
					$content = '<div style="border-top: #f5f5f5 solid 1px; border-bottom: #f5f5f5 solid 1px; padding: 10px; margin-bottom: 10px; margin-top: 10px;"><img style="float: left; padding-right: 10px; margin-top: -20px;" src="http://nunakidz.com/demo/bigstore/media/wysiwyg/sample-seal.png" alt="" /> We guarantee that We is authorized to sell this product and that every brand we sell is authentic.</div>';
					$data = array("title" => "Block Detail product page 2", 
								  "identifier" => "block_detail_product_page_2",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block Detail product page 2 created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}
					
																								
					//Bottom menu
					$content = '<div class="span4">
<h4>Our Offers</h4>
<ul class="bottom-menu">
<li><a href="#">New products</a></li>
<li><a href="#">Top sellers</a></li>
<li><a href="#">Specials</a></li>
<li><a href="#">Manufacturers</a></li>
<li><a href="#">Suppliers</a></li>
<li><a href="#">Specials</a></li>
<li><a href="#">Service</a></li>
</ul>
</div>
<div class="span4">
<h4>Shipping Info</h4>
<ul class="bottom-menu">
<li><a href="#">Returns</a></li>
<li><a href="#">Delivery</a></li>
<li><a href="#">Service</a></li>
<li><a href="#">Gift Cards</a></li>
<li><a href="#">Mobile</a></li>
<li><a href="#">Gift Cards</a></li>
<li><a href="#">Manufacturers</a></li>
</ul>
</div>
<div class="span4">
<h4>Our Account</h4>
<ul class="bottom-menu">
<li><a href="#">Your Account</a></li>
<li><a href="#">information</a></li>
<li><a href="#">Addresses</a></li>
<li><a href="#">Discount</a></li>
<li><a href="#">Orders history</a></li>
<li><a href="#">Addresses</a></li>
<li><a href="#">Search Terms</a></li>
</ul>
</div>';
					$data = array("title" => "Bottom menu", 
								  "identifier" => "aditional_footer_left",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Bottom menu block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}							
	// Block contact top
					$content = '<div class="col2-set">
<div class="col-1">
<h3>Address &amp; Directions:</h3>
We are moving to a new location and will update the contact information very soon.</div>
<div class="col-1">
<h3>Media Contact</h3>
<p>If you are interested in working with us and want to hold the beauty of our work in your own hands, simply request a FO Promo Box. We&rsquo;ll send you a copy of it, directly to your doorstep.</p>
</div>
</div>';
					$data = array("title" => "Block Contact Top", 
								  "identifier" => "block_contact_top",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block Contact Top created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}		
	// Block contact bottom
					$content = '<h3>Maps</h3>
<p><img src="{{media url="wysiwyg/map.jpg"}}" alt="" /></p>';
					$data = array("title" => "Block Contact Bottom", 
								  "identifier" => "block_contact_bottom",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block Contact Bottom created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}
	// Block left bottom
					$content = '<p><a href="#"><img src="{{media url="wysiwyg/connect-payment.png"}}" alt="" /></a></p>';
					$data = array("title" => "Block Bottom Left", 
								  "identifier" => "block_bottom_left",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}	
// Block bottom right
					$content = '<p><img src="{{media url="wysiwyg/connect-payment.png"}}" alt="" /></p>';
					$data = array("title" => "Block Bottom Right", 
								  "identifier" => "block_bottom_right",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block header right created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}		
		
	// Block Contact Box
					$content = '<div class="contact-us">
<h4>Contact us</h4>
<p class="address">[icon name="icon-location"] 49 Archdale, 2B Charles</p>
<p class="phone">[icon name="icon-phone"] +777 (100) 1234</p>
<p class="support">[icon name="icon-mail"]<span> sales@example.com</span></p>
</div>								
				';
					$data = array("title" => "Block Contact Box", 
								  "identifier" => "block_contact_box",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}	
	// Block Container info
					$content = '<div class="bottom-logo"><img src="{{media url="wysiwyg//Logo/bottom-logo.png"}}" alt="" /></div>
<p class="medalion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum justo ante, bibendum at bibendum iaculis, sodales id mauris. Nullam scelerisque ante eu tortor eleifend vel fringilla dui ullamcorper. Aenean diam diam, volutpat id commodo vitae, consequat in nisi. In elementum fringilla libero.</p>							
				';
					$data = array("title" => "Block Container info", 
								  "identifier" => "block_container_info",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}
	// Block 3 Banner Bottom
					$content = '<div class="row-fluid">
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner04.jpg"}}" alt="" /></div>
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner05.jpg"}}" alt="" /></div>
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner06.jpg"}}" alt="" /></div>
</div>							
				';
					$data = array("title" => "Block 3 Banner Bottom", 
								  "identifier" => "block_3_banner_bottom",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}
// Block Empty Center
					$content = '<p>* This is a static CMS block displayed if category is empty.</p>';
					$data = array("title" => "Block Empty Center", 
								  "identifier" => "block_empty_center",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}
// Block Blog content
					$content = '<div class="row-fluid content-blog">
<div class="span4">
<h3>THOMAS MARINE, LEADER AU QU&Eacute;BEC</h3>
<img src="{{media url="wysiwyg/footer-3-banner01.jpg"}}" alt="" />
<div class="info-content">
<p>Avec ses cinq succursales, le Groupe Thomas Marine est le plus important concessionnaire du Qu&eacute;bec lorsqu&rsquo;il s&rsquo;agit de l&rsquo;achat d&rsquo;un bateau de p&ecirc;che ou d&rsquo;un bateau de plaisance. Premier d&eacute;taillant mondial pour le bateau de p&ecirc;che et le ponton d&rsquo;aluminium Princecraft et le bateau de plaisance Bayliner, nous sommes &eacute;galement distributeur exclusif du bateau de plaisance Crownline, du bateau de p&ecirc;che Ranger Boats et Stratos, ainsi que du bateau de p&ecirc;che et du bateau de plaisance Striper ou Boston Whaler.</p>
</div>
<div class="clear">&nbsp;</div>
<a href="#">Read More</a></div>
<div class="span4">
<h3>LE BATEAU NEUF OU USAG&Eacute; DE VOS R&Ecirc;VES</h3>
<img src="{{media url="wysiwyg/footer-3-banner02.jpg"}}" alt="" />
<div class="info-content">
<p>Chez Thomas Marine, vous trouverez un vaste inventaire si vous cherchez un moteur hors-bord Mercury, un moteur &eacute;lectrique Minn Kota ou Motorguide, un sonar ou un GPS Hummingbird ou Lowrance, ainsi que tous les accessoires nautiques et pi&egrave;ces d&rsquo;&eacute;quipement essentiels &agrave; d&rsquo;agr&eacute;ables moments en bateau.</p>
<p>Si vous cherchez un bateau de p&ecirc;che d&rsquo;occasion, un ponton d&rsquo;occasion ou un bateau de plaisance d&rsquo;occasion, vous le trouverez chez-nous, certifi&eacute; et accompagn&eacute; d&rsquo;une garantie.</p>
</div>
<div class="clear">&nbsp;</div>
<a href="#">Read More</a></div>
<div class="span4">
<h3>VOUS NE TROUVEREZ PAS MEILLEUR SERVICE AILLEURS</h3>
<img src="{{media url="wysiwyg/footer-3-banner03.jpg"}}" alt="" />
<div class="info-content">
<p>Pour vos besoins d&rsquo;entretien de bateau ou de r&eacute;parations m&eacute;caniques sur votre hors-bord ou semi hors-bord confiez votre bateau de p&ecirc;che ou votre bateau de plaisance &agrave; nos techniciens certifi&eacute;s. Nos d&eacute;partements de service offre &eacute;galement l&rsquo;entreposage et l&rsquo;emballage de votre bateau d&rsquo;aluminium ou votre bateau de fibre de verre.</p>
<p>Visitez l&rsquo;une de nos succursales sans tarder. Laval, Varennes, Sorel-Tracy, Saint-Charles-sur-Richelieu et Saint-Paul-de-l&rsquo;&Icirc;le au-Noix.</p>
</div>
<div class="clear">&nbsp;</div>
<a href="#">Read More</a></div>
</div>';
					$data = array("title" => "Block Blog content", 
								  "identifier" => "blog-content",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}		
// Block 3 Banner Bottom 
					$content = '<div class="home-3-banner-bottom">
<div class="row-fluid">
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner04.jpg"}}" alt="" /></div>
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner05.jpg"}}" alt="" /></div>
<div class="span4"><img src="{{media url="wysiwyg/footer-3-banner06.jpg"}}" alt="" /></div>
</div>
</div>';
					$data = array("title" => "Block 3 Banner Bottom ", 
								  "identifier" => "home_3_banner_bottom",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}											
									
// Social in detail 
					$content = '<div class="row-fluid border-sidebar"> 
					<div class="sidebar-bottom">                    
						<a href="#">[icon name="icon-tumblr"]</a>
						<a href="#">[icon name="icon-vimeo"]</a>
						<a href="#">[icon name="icon-linkedin"]</a>
						<a href="#">[icon name="icon-picasa"]</a>
					</div>
				</div>';
					$data = array("title" => "Social in detail", 
								  "identifier" => "social_in_detail",
								  "stores" => $stores, 
								  "is_active" => 1, 
								  "content" => $content);
					$model = Mage::getModel('cms/block'); // loads cms/block model
					$model->setData($data); // add data to a model
		      try {
						$model->save();				      
						$message .= $this->__(' Block created.');
		      } catch (Exception $e){
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*');
						return;
					}											
																					
         //End Setup Static Block					
				}
				
							
				
				$model = Mage::getModel('core/store');
				$storeName = Mage::getModel('core/store')->load($storeId)->getName();
				$storeCode = Mage::getModel('core/store')->load($storeId)->getCode();
				$store = Mage::app()->getStore($storeId);
			
				$message = $this->__('medalion Theme was successfully installed on <i>'.$storeName.'</i>!');
        Mage::getSingleton('adminhtml/session')->addSuccess($message);
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
      }
      $this->_redirect('*/*');
		}    
}