<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Reccount.php';
require_once 'modules/admin/models/Geo.php';

Class Citation_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Reccount=new Reccount;

		}

        function indexAction() {
        	$this->sitelist=$this->Reccount->getSiteList();
        	$this->content =$this->view->AddView('citation', $this);
			$this->view->renderLayout('admin', $this);
		}
		function siteinnerAction() {
			$this->siteinner=$this->Reccount->getSiteInner($this->registry->rewrites[1]);
            $this->Geo=new Geo;
            $this->countries=$this->Geo->getCountries();
            $this->content =$this->view->AddView('siteinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatesiteinnerAction(){
			$this->Reccount->updateSiteInner($_POST,$_FILES);

			$this->registry->get->redirect('/admin/sites/');
		}
}


?>