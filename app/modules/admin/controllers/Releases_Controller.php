<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Release.php';

Class Releases_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Release=new Release;
		}

        function indexAction() {
        	$this->releasetypelist=$this->Release->getReleaseTypeList();
			$this->content =$this->view->AddView('releasetypelist', $this);
			$this->view->renderLayout('admin', $this);
		}
		function releaseinnerAction(){
			$this->releasetypeinner=$this->Release->getReleaseTypeInner($this->registry->rewrites[1]);
			$this->content = $this->view->AddView('releasetypeinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatereleasetypeinnerAction(){
			$this->Release->updateReleaseTypeInner($_POST);
			$this->registry->get->redirect('/admin/releases/');
		}
}


?>