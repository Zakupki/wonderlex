<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Reccount.php';

Class Citations_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Reccount=new Reccount;

		}

        function indexAction() {
        	$this->sitelist=$this->Reccount->getCitationList();
        	$this->content =$this->view->AddView('citation', $this);
			$this->view->renderLayout('admin', $this);
		}
		function citationinnerAction() {
			$this->citationinner=$this->Reccount->getCitationInner($this->registry->rewrites[1]);
            $this->sites=$this->Reccount->getSiteList();
            $this->content =$this->view->AddView('citationinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatecitationinnerAction(){
		    $this->cache->set('ru_main_sites',true,false,-1);
			$this->Reccount->updateCitationInner($_POST,$_FILES);
			$this->registry->get->redirect('/admin/citations/');
		}
}


?>