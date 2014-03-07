<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Catalog.php';
require_once 'modules/main/models/Arttype.php';
require_once 'modules/main/models/Comments.php';

Class Catalog_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
		    parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Catalog=new Catalog($this->registry);
            $this->Arttype=new Arttype;
		}

        function indexAction() {
        	$this->styles=array('catalog');
        	$this->products=$this->Catalog->getProducts(array('catalogType'=>'without-price'));
            $this->arttypes=$this->Arttype->getArttypeList();
            $this->catalogType='without-price';
            $this->content =$this->view->AddView('catalog', $this);
			$this->view->renderLayout('index', $this);
	    }
        function collectorAction() {
            $this->styles=array('catalog');
            $this->products=$this->Catalog->getProducts(array('catalogType'=>'with-price'));
            $this->arttypes=$this->Arttype->getArttypeList();
            $this->catalogType='with-price';
            $this->content =$this->view->AddView('catalog', $this);
            $this->view->renderLayout('index', $this);
        }
		function productAction() {
			//tools::print_r($_SESSION['User']);	
			$this->styles=array('item','authors-profile');
			$this->product=$this->Catalog->getProductInner($this->registry->rewrites[1]);
            $this->Comments=new Comments;
            $this->comments=$this->Comments->getComments(array('itemid'=>$this->registry->rewrites[1]));
			$this->otherproducts=$this->Catalog->getOtherProducts(array('category'=>$this->product['categoryid'],'itemid'=>$this->product['itemid']));
            $this->content =$this->view->AddView('product', $this);
			$this->view->renderLayout('index', $this);
		}
		function moreothersAction() {
			header('Content-Type: application/json');
			$this->Catalog->getOtherProductsToJson(array('start'=>$_GET['count'], 'take'=>$_GET['step'],'category'=>$_GET['categoryid'], 'itemid'=>$_GET['itemid']));
		}
		function moreworksAction() {
			header('Content-Type: application/json');
            $this->Catalog->getProductsToJson(array('viewId'=>$_GET['viewId'],'styleId'=>$_GET['styleId'],'genreId'=>$_GET['genreId'],'priceStart'=>$_GET['priceStart'], 'catalogType'=>$_GET['catalogType'], 'priceFinish'=>$_GET['priceFinish'], 'yearStart'=>$_GET['yearStart'], 'yearFinish'=>$_GET['yearFinish'], 'start'=>$_GET['count'], 'take'=>$_GET['step'], 'siteid'=>$_GET['siteid'], 'q'=>$_GET['q']));
		}
        function getartfilterAction() {
            header('Content-Type: application/json');
            
            $viewId = $_GET['viewId'];
            
            if(tools::int($_GET['viewId'])>0 && $_GET['styleId']=='none'){
                $this->Arttype->getStylesToJson(array('arttype_id'=>$_GET['viewId']));
            }elseif(tools::int($_GET['styleId'])>0 && $_GET['genreId']=='none'){
                $this->Arttype->getGenresToJson(array('artstyle_id'=>$_GET['styleId']));
            }
            //$this->Catalog->getProductsToJson(array('priceStart'=>$_GET['priceStart'], 'priceFinish'=>$_GET['priceFinish'], 'yearStart'=>$_GET['yearStart'], 'yearFinish'=>$_GET['yearFinish'], 'start'=>$_GET['count'], 'take'=>$_GET['step'], 'siteid'=>$_GET['siteid']));
        }
        function likeAction() {
        	$cnt=$this->Catalog->rateProduct($_GET['productId']);	
				
				
        	if ($cnt > 0) {
			    header('HTTP/1.0 200 OK');
			    $json = '{
			        "message": "OK",
			        "count": "' . $cnt . '"
			    }';
			}
			/*else {
			    header('HTTP/1.0 202 Not content');
			    $json = '{
			        "message": "Not content",
			        "count": "390"
			    }';
			}*/
			echo $json;
		}
}


?>