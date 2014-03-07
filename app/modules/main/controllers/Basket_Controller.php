<?php
require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Basket.php';
require_once 'modules/main/models/Geo.php';

Class Basket_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Basket = new Basket;
			$this->inbasket=$this->Basket->totalProducts();
			if(!$this->Session->User['id'])
			$this->registry->get->redirect('/');
		}

        public function indexAction() {
        	if($_GET['id']>0){
				$this->Basket->addProduct($_GET['id']);
				$this->inbasket=$this->Basket->totalProducts();
			}
			$this->basketsum=$this->Basket->totalPrice();
            $this->styles=array('cart');
			$this->basketproducts=$this->Basket->getBasketProducts();
			$this->content =$this->view->AddView('basket', $this);
            $this->view->renderLayout('index', $this);
        }
		public function purchaseAction() {
			$this->styles=array('cart','cart-pushcase');
			$this->Geo = new Geo;
			$this->countries=$this->Geo->getCountries();
			$this->product=$this->Basket->productBuyInfo($_GET['id']);	
            if(!$this->product)
            $this->registry->get->redirect('/');
            $this->content =$this->view->AddView('purchase', $this);
            $this->view->renderLayout('index', $this);
		}
        public function makepurchaseAction() {
            $this->Basket = new Basket;
            $this->Basket->makePurchase($_POST);
        }
		public function removeAction(){
			$lang = $_GET[ 'lang' ];
			$id = $_GET[ 'id' ];
			$this->Basket->removeProduct($id);
			$this->inbasket=$this->Basket->totalProducts();
			if($this->inbasket>0)
			$json_data = '{
			    "header": "<span class=\"cart__header-count\">'.$this->inbasket.'</span> товаров – <span class=\"cart__header-price\">'.$this->Basket->totalPrice().'</span>",
			    "itemsCount": '.$this->inbasket.'
			}';
			else
			$json_data = '{
			    "header": "",
			    "itemsCount": ""
			}';
			$json_data = str_replace("\r\n",'',$json_data);
			$json_data = str_replace("\n",'',$json_data);
			
			echo $json_data;
			exit;
		}
		
}


?>