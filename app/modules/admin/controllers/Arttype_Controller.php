<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Arttype.php';

Class Arttype_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Arttype=new Arttype;
		}

        function indexAction() {
            $this->arttypes=$this->Arttype->getArttypeList();
            $this->content =$this->view->AddView('arttypes', $this);
            $this->view->renderLayout('admin', $this);
        }
        function arttypeinnerAction() {
            $this->arttype=$this->Arttype->getArttypeInner($this->registry->rewrites[1]);
            $this->content =$this->view->AddView('arttypeinner', $this);
            $this->view->renderLayout('admin', $this);
        }
        function updatearttypeinnerAction(){
            $this->Arttype->updateArttypeInner($_POST);
            $this->registry->get->redirect('/admin/arttype/');
        }
        function deletearttypeAction(){
            $this->Arttype->deleteArttype($_GET['id']);
            $this->registry->get->redirect('/admin/arttype/');
        }
        #styles
        function stylesAction() {
            $this->artstyles=$this->Arttype->getArtstyleList();
            $this->content =$this->view->AddView('artstyles', $this);
            $this->view->renderLayout('admin', $this);
        }
         function artstyleinnerAction() {
            $this->artstyle=$this->Arttype->getArtstyleInner($this->registry->rewrites[1]);
            $this->arttypes=$this->Arttype->getArttypeList();
            $this->content =$this->view->AddView('artstyleinner', $this);
            $this->view->renderLayout('admin', $this);
        }
        function updateartstyleinnerAction(){
            $this->Arttype->updateArtstyleInner($_POST);
            $this->registry->get->redirect('/admin/arttype/styles/');
        }
        function deleteartstyleAction(){
            $this->Arttype->deleteArtstyle($_GET['id']);
            $this->registry->get->redirect('/admin/arttype/style/');
        }
        #genres
        function genresAction() {
            $this->artgenres=$this->Arttype->getArtgenreList();
            $this->content =$this->view->AddView('artgenres', $this);
            $this->view->renderLayout('admin', $this);
        }
         function artgenreinnerAction() {
            $this->artgenre=$this->Arttype->getArtgenreInner($this->registry->rewrites[1]);
            $this->artstyles=$this->Arttype->getArtstyleOptions();
            $this->content =$this->view->AddView('artgenreinner', $this);
            $this->view->renderLayout('admin', $this);
        }
        function updateartgenreinnerAction(){
            $this->Arttype->updateArtgenreInner($_POST);
            $this->registry->get->redirect('/admin/arttype/genres/');
        }
        function deleteartgenreAction(){
            $this->Arttype->deleteArtgenre($_GET['id']);
            $this->registry->get->redirect('/admin/arttype/genres/');
        }
}


?>