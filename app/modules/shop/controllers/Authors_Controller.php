<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/models/Author.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/widgets/Widget.php';

Class Authors_Controller Extends BaseShop_Controller {
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
			$this->Author = new Author;
			$this->count=$this->Author->getAuthorCount();
			$this->Pageing = new Pageing('authors'.$latesturl, $this->take, $this->count, $this->registry->rewrites[1]);
			$this->authors=$this->Author->getAuthors($this->Pageing->getStart(),$this->take);
			$this->pager=$this->Pageing->GetHTML();
            $this->Widget=new Widget($this->registry);
            if($this->registry->wigetmenu['catalog'])
            $this->widgetlist.=$this->Widget->goods();
            $this->widgetlist.=$this->Widget->contacts();
			$this->content =$this->view->AddView('authors', $this);
			$this->view->renderLayout('layout', $this);	
				
        }
		function authorinnerAction() {
			$this->Author = new Author;
			$this->authorinner=$this->Author->getAuthorInner($this->registry->rewrites[1]);
			$this->category=$this->Menu->getCategoryItems();
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->currency=$this->Menu->getCurrency();
			$this->Widget=new Widget($this->registry);
			$this->widgetlist=$this->Widget->goods();
			$this->widgetlist.=$this->Widget->smevents();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->content =$this->view->AddView('authorinner', $this);
			$this->view->renderLayout('layout', $this);			
		}


}


?>