<?php
require_once 'modules/base/controllers/BaseShopAdmin_Controller.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/models/Partner.php';
require_once 'modules/shop/models/Product.php';
require_once 'modules/shop/models/Service.php';
require_once 'modules/shop/models/Author.php';
require_once 'modules/shop/models/Event.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/models/Blog.php';
require_once 'modules/shop/models/Arttype.php';

Class Admin_Controller Extends BaseShopAdmin_Controller {
		private $registry;
		
		public function __construct($registry){
			$this->registry=$registry;
			parent::__construct($registry);
			if(!$this->Session->User['id'] || $this->Session->User['id']!=$this->Session->Site['userid'])
			$this->registry->get->redirect('/');
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Account = new Account;
			$this->siteinfo=$this->Account->getSiteData();
		}

        function indexAction() {
        		$this->registry->get->redirect('/admin/account/');
		}
		function menuAction() {
				$this->mainmenu=$this->Menu->getMenuAllItems();
				$this->category=$this->Menu->getCategoryItems();			
				$this->menuitems=$this->Menu->getAdminMenuItems();
				$this->content =$this->view->AddView('/admin/menu', $this);
				$this->view->renderLayout('admin', $this);
		}
		function updatemenuAction() {
        		$this->Menu->updateMenu($_POST);
				$this->registry->get->redirect('/admin/menu/');
		}
		function categoryAction(){
				$this->mainmenu=$this->Menu->getMenuAllItems();
				$this->category=$this->Menu->getCategoryItems();	
				$this->categoryitems=$this->Menu->getAdminCategoryItems();
				//tools::print_r($this->categoryitems);
				$this->content =$this->view->AddView('/admin/category', $this);
				$this->view->renderLayout('admin', $this);
		}
		function updatecategoryAction(){
			$this->Menu->updateAdminCategoryItems($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/category/');
		}
		function accountAction(){
				$this->currencies=$this->Account->getSiteCurrency();
				$this->mainmenu=$this->Menu->getMenuAllItems();
				$this->category=$this->Menu->getCategoryItems();
				$this->sitelanguages=$this->Language->getSiteAdminLanguages();
				$this->sitedata=$this->Account->getAccount();
				$this->content =$this->view->AddView('/admin/account', $this);
				$this->view->renderLayout('admin', $this);
		}
		function updateaccountAction(){
			$resp=$this->Account->updateAccount($_POST);
			//tools::print_r($_POST);
			if($resp==1)
			$get='?newpass=1';
			elseif($resp==2)
			$get='?newpass=2';
			$this->registry->get->redirect('/admin/account/'.$get);
		}
		function designAction(){
			$this->Design = new Design;
			$this->sitedesign=$this->Design->getAdminSiteDesign();
			$this->sitecolor=$this->sitedesign[0];
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();	
			$this->content =$this->view->AddView('/admin/design', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatedesignAction(){
			$this->Design = new Design;
			$this->Design->updateSiteDesign($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/design/');
			
		}
		function partnersAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Partner=new Partner;	
			$this->partners=$this->Partner->getAdminPartners();
			$this->content =$this->view->AddView('/admin/partners', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatepartnersAction(){
			$this->Partner=new Partner;	
			$this->Partner->getUpdatePartners($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/partners/');			
		}
		function usersAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();	
			$this->content =$this->view->AddView('/admin/users', $this);
			$this->view->renderLayout('admin', $this);
		}
		function aboutAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			
			$this->about=$this->Account->getAdminAbout();
			$this->content =$this->view->AddView('/admin/about', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateaboutAction(){
			
			$this->Account->updateAbout($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/about/');			
		}
		function servicesAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Service = new Service;
			$this->services=$this->Service->getAdminServices($_GET['q']);
			$this->content =$this->view->AddView('/admin/services', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateservicesAction(){
			$this->Service = new Service;
			$this->Service->updateServices($_POST);
			$this->registry->get->redirect('/admin/services/');
		}
		function serviceAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Service = new Service;
			$this->servicedata=$this->Service->getAdminServiceInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('/admin/service', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateserviceinnerAction(){
			$this->Service = new Service;
			$itemid=$this->Service->updateServiceInner($_POST);
			if($_POST['apply'])
			$this->registry->get->redirect('/admin/service/'.$itemid.'/');
			else
			$this->registry->get->redirect('/admin/services/');
		}
		function authorsAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Author = new Author;
			$this->authors=$this->Author->getAdminAuthors($_GET['q']);
			$this->content =$this->view->AddView('/admin/authors', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateauthorsAction(){
			$this->Author = new Author;
			$this->Author->updateAuthors($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/authors/');
		}
		function authorAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Author = new Author;
			$this->authordata=$this->Author->getAdminAuthorInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('/admin/authorinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateauthorinnerAction(){
			$this->Author = new Author;
			$itemid=$this->Author->updateAuthorInner($_POST);
			if($_POST['apply'])
			$this->registry->get->redirect('/admin/author/'.$itemid.'/');
			else
			$this->registry->get->redirect('/admin/authors/');
		}
		function blogsAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Blog = new Blog;
			$this->blogs=$this->Blog->getAdminBlogs($_GET['q']);
			$this->content =$this->view->AddView('/admin/blog', $this);
			$this->view->renderLayout('admin', $this);
		}
		function blogAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Blog = new Blog;
			$this->bloginner=$this->Blog->getAdminBlogInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('/admin/bloginner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatebloginnerAction(){
			$this->Blog = new Blog;
			$itemid=$this->Blog->updateBlogInner($_POST);
			if($_POST['apply'])
			$this->registry->get->redirect('/admin/blog/'.$itemid.'/');
			else
			$this->registry->get->redirect('/admin/blogs/');
		}
		function updateblogsAction(){
			$this->Blog = new Blog;
			$this->Blog->updateBlogs($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/blogs/');
		}
		function eventsAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Event = new Event;
			$this->events=$this->Event->getAdminEvents($_GET['q']);
			$this->content =$this->view->AddView('/admin/events', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateeventsAction(){
			$this->Event = new Event;
			$this->Event->updateEvents($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/events/');			
		}
		function eventAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Event = new Event;
			$this->eventdata=$this->Event->getAdminEventInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('/admin/eventinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateeventAction(){
			$this->Event = new Event;
			$itemid=$this->Event->updateEvent($_POST);
			if($_POST['apply'])
			$this->registry->get->redirect('/admin/event/'.$itemid.'/');
			else
			$this->registry->get->redirect('/admin/events/');			
		}
		function catalogAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Product=new Product;
			$this->products=$this->Product->getAdminCategory($this->registry->rewrites[1],$_GET['q']);	
			#META
			if($this->registry->rewrites[1]>0){
			$this->categorymenta=$this->Product->getCategoryMeta($this->registry->rewrites[1]);
			$this->categoryid=$this->registry->rewrites[1];
			}
			$this->content =$this->view->AddView('/admin/catalog', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatecatalogAction(){
			$this->Product = new Product;
			$this->Product->updateCategory($_POST);
			//tools::print_r($_POST);
			$this->registry->get->redirect('/admin/catalog/');			
		}
		function updatecatalogmetaAction(){
			$this->Product = new Product;
			$this->Product->updateCatalogMeta($_POST);
			$this->registry->get->redirect('/admin/catalog/'.$_POST['categoryid'].'/');			
		}
		function productAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Menu=new Menu;
			$this->categories=$this->Menu->getCategoryAllItems();
			$this->Product = new Product;
			$this->currency=$this->Product->getCurrency();
			$this->Author=new Author;
			$productdata=$this->Product->getAdminProduct($this->registry->rewrites[1]);
			$this->authorslist=$this->Author->getProductAuthors($this->registry->rewrites[1]);
			$this->productinner=$productdata['product'];
			$this->images=$productdata['images'];
            $this->Arttype = new Arttype;
            $this->arttype=$this->Arttype->getArtTypes(array('type'=>'arttype'));
            $this->artstyles=$this->Arttype->getArtTypes(array('type'=>'artstyles','id'=>$this->productinner[0]['arttype_id']));
            $this->artgenres=$this->Arttype->getArtTypes(array('type'=>'artgenres','id'=>$this->productinner[0]['artstyle_id']));
			//tools::print_r($this->arttype);
			$this->content =$this->view->AddView('/admin/productinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateproductAction(){
			$this->Product = new Product;
			$itemid=$this->Product->updateProduct($_POST);
			if($_POST['apply'])
			$this->registry->get->redirect('/admin/product/'.$itemid.'/');
			else
			$this->registry->get->redirect('/admin/catalog/');
		}
		function favouritesAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Favourites=new Favourites;
			$this->favouriteslist=$this->Favourites->getAdminFavourites();
			$this->content =$this->view->AddView('/admin/favourites', $this);
			$this->view->renderLayout('admin', $this);
		}
		function bannerAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->Design = new Design;
			$this->bannerdata=$this->Design->getAdminBanner();
			$this->content =$this->view->AddView('/admin/banner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatebannerAction(){
			$this->Design = new Design;
			$this->Design->updateBanner($_POST);
			$this->registry->get->redirect('/admin/banner/');
		}
		function howtobuyAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			
			$this->howtobuy=$this->Account->getAdminHowtobuy();
			$this->content =$this->view->AddView('/admin/howtobuy', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatehowtobuyAction(){
			
			$this->Account->updateHowtobuy($_POST);
			$this->registry->get->redirect('/admin/howtobuy/');			
		}
		function agreementAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			
			$this->agreement=$this->Account->getAdminAgreement();
			$this->content =$this->view->AddView('/admin/agreement', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateagreementAction(){
			$this->Account->updateAgreement($_POST);
			$this->registry->get->redirect('/admin/agreement/');			
		}
		function seoAction(){
			$this->mainmenu=$this->Menu->getMenuAllItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->sitelanguages=$this->Account->getSeoAdmin();
			
			$this->content =$this->view->AddView('/admin/seo', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateseoAction(){
			$this->Account->updateSeo($_POST);
			$this->registry->get->redirect('/admin/seo/');			
		}
        function analyticsAction(){
            $this->content =$this->view->AddView('/admin/analytics', $this);
            $this->view->renderLayout('admin', $this);
        }
}


?>