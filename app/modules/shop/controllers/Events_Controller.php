<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/widgets/Widget.php';
require_once 'modules/shop/models/Event.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/models/Design.php';

Class Events_Controller Extends BaseShop_Controller {
		private $registry;
		private $take=12;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Account=new Account;
			$this->Fav=new Favourites;
			$this->favcount=$this->Fav->getFavCount();
		}

        function indexAction() {
        	$this->category=$this->Menu->getCategoryItems();
        	$this->mainmenu=$this->Menu->getMenuItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Widget=new Widget($this->registry);
			if($this->registry->wigetmenu['catalog'])
			$this->widgetlist.=$this->Widget->goods();
			$this->widgetlist.=$this->Widget->contacts();
			$this->Event=new Event;
			$this->count=$this->Event->getEventsCount();
			$this->Pageing = new Pageing('events', $this->take, $this->count, $this->registry->rewrites[1]);
			$this->eventlist=$this->Event->getEvents($this->Pageing->getStart(),$this->take);
			
                if(strlen($this->registry->currentseotitle)>0)
                $this->seotitle=$this->registry->currentseotitle;
                if(strlen($this->registry->currentseodescription)>0)
                $this->seodescription=$this->registry->currentseodescription;
                if(strlen($this->registry->currentseotext)>0)
                $this->seotext=$this->registry->currentseotext;
			
			$this->pager=$this->Pageing->GetHTML();
			$this->content =$this->view->AddView('events', $this);
			$this->view->renderLayout('layout', $this);	
				
        }
		function eventinnerAction() {
			$this->category=$this->Menu->getCategoryItems();
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Widget=new Widget($this->registry);
			//if($this->registry->wigetmenu['catalog'])
			$this->widgetlist=$this->Widget->goods();
			$this->widgetlist.=$this->Widget->smevents();
			$this->Event=new Event;
			$this->event=$this->Event->getEvent($this->registry->rewrites[1]);
            
                        if(strlen($this->event['name'])>0)
                        if(preg_match("/^event\/(\d+)\/?$/", $_GET['route'],$match) || preg_match("/^(\w+)\/event\/(\d+)\/?$/", $_GET['route'],$match)){
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: http://".$_SERVER['HTTP_HOST'].$this->registry->langurl."/event/".$this->registry->rewrites[1]."/".tools::encodestring($this->event['name'])."/");
                            exit();
                        }
            
			
			#SEO
			if(strlen($this->event['seotitle'])>0)
				$this->seotitle=$this->event['seotitle'];
			else
				$this->seotitle=$this->event['name'];
			if(strlen($this->event['seokeywords'])>0)
				$this->seokeywords=$this->event['seokeywords'];
			
			if(strlen($this->event['seodescription'])>0)
			$this->seodescription=$this->event['seodescription'];
			else
			$this->seodescription=$this->event['detail_text'];
			
			$this->prevevent=$this->Event->getPrevEvent($this->event['itemid']);
			$this->nextevent=$this->Event->getNextEvent($this->event['itemid']);
			$this->content =$this->view->AddView('eventinner', $this);
			$this->view->renderLayout('layout', $this);			
		}


}


?>