<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/models/Seo.php';
require_once 'modules/shop/models/Product.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/widgets/Widget.php';

Class Catalog_Controller Extends BaseShop_Controller {
		private $registry;
		private $take=12;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Product=new Product;
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
			$catid=null;
			if($this->registry->routername=='category' || $this->registry->routername=='categorycatpage'){
				$catid=$this->registry->rewrites[1];
				$this->page=$this->registry->rewrites[2];
				$latesturl='/'.$catid;
			}
			else{ 
				$this->page=$this->registry->rewrites[1];
				$latesturl='/all';
			}
			$this->productnum=$this->Product->getProductsCount($catid,$_GET['authorid']);
			$this->Pageing = new Pageing(trim($this->registry->langurl,'/').'/catalog'.$latesturl, $this->take, $this->productnum, $this->page);
			$productdata=$this->Product->getProducts($this->Pageing->getStart(),$this->take,$catid,$_GET['authorid']);
			$this->products=$productdata['products'];
			
            
			
			#SEO
			if($this->registry->routername=='categorycatpage' || $this->registry->routername=='category'){
			    if(strlen($this->products[0]['seotitle'])>0)
					$this->seotitle=$this->products[0]['seotitle'];
				if(strlen($this->products[0]['seodescription'])>0)
					$this->seodescription=$this->products[0]['seodescription'];
				if(strlen($this->products[0]['seotext'])>0)
					$this->seotext=$this->products[0]['seotext'];
				$this->currentcat=$this->products[0]['categoryname'];
            }else{
                if(strlen($this->registry->currentseotitle)>0)
			    $this->seotitle=$this->registry->currentseotitle;
                if(strlen($this->registry->currentseodescription)>0)
                $this->seodescription=$this->registry->currentseodescription;
                if(strlen($this->registry->currentseotext)>0)
                $this->seotext=$this->registry->currentseotext;
			}
               
               
                              if(strlen($this->currentcat)<1)  
                              $this->currentcat=$this->registry->currentpage;
                              if($this->currentcat)
                              if(preg_match("/^catalog\/(\d+)\/?$/", $_GET['route'],$match) || preg_match("/^(\w+)\/catalog\/(\d+)\/?$/", $_GET['route'],$match) ){
                                   header("HTTP/1.1 301 Moved Permanently");
                                   header("Location: http://".$_SERVER['HTTP_HOST'].$this->registry->langurl."/catalog/".$this->registry->rewrites[1]."/".tools::encodestring($this->currentcat)."/");
                                   exit(); 
                              }
               
            
			
			$this->favourites=$productdata['favourites'];
			$this->comments=$productdata['comments'];
			$this->pager=$this->Pageing->GetHTML();
			$this->content =$this->view->AddView('catalog', $this);
			$this->view->renderLayout('layout', $this);	
				
        }
		function productAction() {
           /*
            $this->cache=cache::init();
                      
                       if($data=$this->cache->get('w'.$_SESSION['Site']['id'].'_l'.$_SESSION['langid'].'_p'.$this->registry->rewrites[1])){
                           $this->view->renderLayout('layout', $data);
                       }else{*/
               
		    $this->category=$this->Menu->getCategoryItems();
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Product->visitProduct($this->registry->rewrites[1]);
			$this->Product->watchComments($this->registry->rewrites[1]);
            $productdata=$this->Product->getProductInner($this->registry->rewrites[1]);
			
            if(!$productdata['product'])
            echo tools::return404();
			
			$products=$this->Product->getOtherProducts($productdata['product']['categoryid'],$this->registry->rewrites[1]);
			$this->otherproducts=$products['products'];
			$this->otherfavourites=$products['favourites'];
			$this->othercomments=$products['comments'];
			$this->Widget=new Widget($this->registry);
			$this->widgetlist.=$this->Widget->contacts();
			if($this->registry->wigetmenu['events'])
			$this->widgetlist.=$this->Widget->smevents();
			$this->productinner=$productdata['product'];
            
            
                        if(strlen($this->productinner['name'])>0)
                        if(preg_match("/^product\/(\d+)\/?$/", $_GET['route'],$match) || preg_match("/^(\w+)\/product\/(\d+)\/?$/", $_GET['route'],$match) ){
                            header("HTTP/1.1 301 Moved Permanently");
                            header("Location: http://".$_SERVER['HTTP_HOST'].$this->registry->langurl."/product/".$this->registry->rewrites[1]."/".tools::encodestring($this->productinner['name'])."/");
                            exit();
                        }
			#SEO
			$this->Seo= new Seo;
			if(strlen($this->productinner['seotitle'])>0)
				$this->seotitle=$this->productinner['seotitle'];
			else{
				if($template=$this->Seo->getSeoTemplate(1))    
    				if($template)
                    $this->seotitle= str_replace('{name}', $this->productinner['name'], $template);
                    else
    				$this->seotitle=$this->productinner['name'];
                }
			if(strlen($this->productinner['seokeywords'])>0)
				$this->seokeywords=$this->productinner['seokeywords'];
			
			if(strlen($this->productinner['seodescription'])>0)
			$this->seodescription=$this->productinner['seodescription'];
			else{
                if($template=$this->Seo->getSeoTemplate(2))    
                    if($template)
                    $this->seodescription= str_replace('{name}', $this->productinner['detail_text'], $template);
                    else
                    $this->seodescription=$this->productinner['detail_text'];
                }
			
			$this->favouriteinner=$productdata['favourites'];
			$this->commentsinner=$productdata['comments'];
			$this->prevproduct=$this->Product->getPrevProduct($this->productinner['itemid'],$this->productinner['categoryid']);
			$this->nextproduct=$this->Product->getNextProduct($this->productinner['itemid'],$this->productinner['categoryid']);
			$this->images=$productdata['images'];
			
            
			
			$this->content =$this->view->AddView('product', $this);
			//$this->cache->set('w'.$_SESSION['Site']['id'].'_l'.$_SESSION['langid'].'_p'.$this->registry->rewrites[1], $this,false,60*60*24);
            $this->view->renderLayout('layout', $this);
            //}
            //die('error');
            
		}


}


?>