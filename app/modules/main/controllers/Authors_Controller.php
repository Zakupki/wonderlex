<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Author.php';
require_once 'modules/main/models/Catalog.php';
require_once 'modules/main/models/Arttype.php';
require_once 'modules/main/models/Comments.php';

Class Authors_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
            $this->Author=new Author($this->registry);
			$this->Catalog=new Catalog($this->registry);
			$this->Arttype=new Arttype;
		}

        function indexAction() {
        	$this->styles=array('authors-list');
            $this->authors=$this->Author->getAuthors();
			$this->arttypes=$this->Arttype->getArttypeList();
            $this->content =$this->view->AddView('authors', $this);
			$this->view->renderLayout('index', $this);
	    }
		function authorinnerAction() {
			$this->styles=array('authors-profile');
			$this->productscount=$this->Catalog->getProductsCount(array('siteid'=>$this->registry->rewrites[1]));
			$this->products=$this->Catalog->getProducts(array('start'=>0,'take'=>12,'siteid'=>$this->registry->rewrites[1]));
            $this->Comments=new Comments;
            $this->comments=$this->Comments->getsiteComments(array('siteid'=>$this->registry->rewrites[1]));
			$this->authorinner=$this->Author->getAuthorInner($this->registry->rewrites[1]);
			$this->content =$this->view->AddView('authorinner', $this);
			$this->view->renderLayout('index', $this);
		}
		function moreauthorsAction() {
			header('Content-Type: application/json');
			$this->Author->getAuthorsToJson(array('start'=>$_GET['count'],'take'=>$_GET['step'],'q'=>$_GET['q']));
		}

		
}


?>