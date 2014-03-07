<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/models/Favourites.php';

Class Favourites_Controller Extends BaseShop_Controller {
		private $registry;
		private $take=12;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Account=new Account;
		}

        function indexAction() {
        	$this->sitedata=$this->Account->getSiteData();
			$this->currency=$this->Menu->getCurrency();
        	$this->Favourites=new Favourites;
			$this->favcount=$this->Favourites->getFavCount();
        	$this->category=$this->Menu->getCategoryItems();
        	$this->mainmenu=$this->Menu->getMenuItems();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$page=$this->registry->rewrites[1];
			$this->productnum=$this->Favourites->getUserFavouritesCount();
			$this->Pageing = new Pageing('favourites', $this->take, $this->productnum, $page);
			$productdata=$this->Favourites->getUserFavourites($this->Pageing->getStart(),$this->take,$catid);
			$this->products=$productdata['products'];
			$this->favourites=$productdata['favourites'];
			$this->pager=$this->Pageing->GetHTML();
			$this->content =$this->view->AddView('favourites', $this);
			$this->view->renderLayout('layout', $this);	
				
        }
		function addAction() {
        	$this->Favourites=new Favourites;
			$data = array(
					'error' => true,
				    'status' => ''
				);
			if($this->Favourites->addToFavourites($_POST)){
				$data = array(
				    'error' => false,
				    'status' => ''
				);
			}
			echo json_encode($data);
		}
		function allAction(){
			$this->Favourites=new Favourites;
			$data = array(
					'error' => false,
				    'status' => ''
			);
			$this->users=$this->Favourites->getProductFavourites($_POST['itemid']);
		
				$data = array(
				    'error' => false,
				    'status' => ''
				);
				
				
				
				$data['content'] = '
				<div class="favers">
				  <h2>Добавили в избранное</h2>
				  <div class="list">';
				foreach($this->users as $user){
				$data['content'] .= '
					<div class="li">
			      <input name="userid['.$user['id'].']" value="'.$user['id'].'" type="hidden" />
			      <div class="user"><a href="#">'.$user['firstName'].' '.$user['familyName'].'<i class="i"></i></a></div>
			      <div class="button"><div class="bg"><div class="r"><div class="l"><div class="el">Написать письмо<i class="i"></i></div></div></div></div></div>
			    </div>';
				}
					
				$data['content'] .= '    
					<!--<div class="last li">
				      <input name="userid[2]" value="3" type="hidden" />
				      <div class="user"><a href="#">Ольга Вишневская<i class="i"></i></a></div>
				      <div class="button"><div class="bg"><div class="r"><div class="l"><div class="el">Написать письмо<i class="i"></i></div></div></div></div></div>
				    </div>-->
					
				  </div>
				</div>
				';
			echo json_encode($data);
		}
		function mailAction(){
			$this->Favourites=new Favourites;
			$this->Favourites->sendMessage($_POST);
			$data = array(
			    'error' => false,
			    'status' => ''
			);
			
			$data['status'] = 'Ваше письмо отправлено.';
			
			echo json_encode($data);
		}
}


?>