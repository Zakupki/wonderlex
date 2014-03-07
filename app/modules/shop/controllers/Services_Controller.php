<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/models/Service.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/widgets/Widget.php';

Class Services_Controller Extends BaseShop_Controller {
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
			$this->Service = new Service;
			$this->count=$this->Service->getServiceCount();
			$this->Pageing = new Pageing(trim($this->registry->langurl,'/').'/services'.$latesturl, $this->take, $this->count, $this->registry->rewrites[1]);
			$this->services=$this->Service->getServices($this->Pageing->getStart(),$this->take);
			$this->pager=$this->Pageing->GetHTML();
            $this->Widget=new Widget($this->registry);
            
                if(strlen($this->registry->currentseotitle)>0)
                $this->seotitle=$this->registry->currentseotitle;
                if(strlen($this->registry->currentseodescription)>0)
                $this->seodescription=$this->registry->currentseodescription;
                if(strlen($this->registry->currentseotext)>0)
                $this->seotext=$this->registry->currentseotext;
            
            if($this->registry->wigetmenu['catalog'])
               $this->widgetlist.=$this->Widget->goods();
            $this->widgetlist.=$this->Widget->contacts();
			$this->content =$this->view->AddView('services', $this);
			$this->view->renderLayout('layout', $this);	
				
        }
		function serviceinnerAction() {
			$this->Service = new Service;
			$this->serviceinner=$this->Service->getServiceInner($this->registry->rewrites[1]);
			
            /*
            if(strlen($this->serviceinner['name'])>0)
                        if(preg_match("/^service\/(\d+)\/?$/", $_GET['route'],$match) || preg_match("/^(\w+)\/service\/(\d+)\/?$/", $_GET['route'],$match)){
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: http://".$_SERVER['HTTP_HOST'].$this->registry->langurl."/service/".$this->registry->rewrites[1]."/".tools::encodestring($this->serviceinner['name'])."/");
                            exit();
                        }*/
            
            
			#SEO
			if(strlen($this->serviceinner['seotitle'])>0)
				$this->seotitle=$this->serviceinner['seotitle'];
			else
				$this->seotitle=$this->serviceinner['name'];
			if(strlen($this->serviceinner['seokeywords'])>0)
				$this->seokeywords=$this->serviceinner['seokeywords'];
			
			if(strlen($this->serviceinner['seodescription'])>0)
			$this->seodescription=$this->serviceinner['seodescription'];
			else
			$this->seodescription=$this->serviceinner['detail_text'];


			$this->category=$this->Menu->getCategoryItems();
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->currency=$this->Menu->getCurrency();
			$this->Widget=new Widget($this->registry);
            if($this->registry->wigetmenu['catalog'])
                $this->widgetlist.=$this->Widget->goods();
            $this->widgetlist.=$this->Widget->contacts();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->content =$this->view->AddView('serviceinner', $this);
			$this->view->renderLayout('layout', $this);			
		}


}


?>