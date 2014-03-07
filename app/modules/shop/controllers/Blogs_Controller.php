<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/models/Blog.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/widgets/Widget.php';

Class Blogs_Controller Extends BaseShop_Controller {
		private $registry;
		private $take=12;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Fav=new Favourites;
			$this->Account=new Account;
			$this->favcount=$this->Fav->getFavCount();
		}

        function indexAction() {
        	$this->category=$this->Menu->getCategoryItems();
        	$this->mainmenu=$this->Menu->getMenuItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Blog = new Blog;
			$this->count=$this->Blog->getBlogsCount();
			$this->Pageing = new Pageing('blogs', $this->take, $this->count, $this->registry->rewrites[1]);
			$this->blogs=$this->Blog->getBlogs($this->Pageing->getStart(),$this->take);
			$this->pager=$this->Pageing->GetHTML();
			$this->Widget=new Widget($this->registry);
			if($this->registry->wigetmenu['catalog'])
			$this->widgetlist=$this->Widget->goods();
			if($this->registry->wigetmenu['events'])
			$this->widgetlist.=$this->Widget->smevents();
			$this->content =$this->view->AddView('blog', $this);
			$this->view->renderLayout('layout', $this);	
				
        }
		function bloginnerAction() {
			$this->category=$this->Menu->getCategoryItems();
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Widget=new Widget($this->registry);
			if($this->registry->wigetmenu['catalog'])
			$this->widgetlist=$this->Widget->goods();
			if($this->registry->wigetmenu['events'])
			$this->widgetlist.=$this->Widget->smevents();
			$this->Blog = new Blog;
			$this->blog=$this->Blog->getBlogInner($this->registry->rewrites[1]);
			$this->seotitle=$this->blog['name'];
			$this->seodescription=$this->blog['detail_text'];
			$this->prevblog=$this->Blog->getPrevBlog($this->blog['itemid']);
			$this->nextblog=$this->Blog->getNextBlog($this->blog['itemid']);
			$this->content =$this->view->AddView('bloginner', $this);
			$this->view->renderLayout('layout', $this);			
		}


}


?>