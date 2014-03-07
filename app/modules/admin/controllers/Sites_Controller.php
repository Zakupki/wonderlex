<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Reccount.php';
require_once 'modules/admin/models/Geo.php';

Class Sites_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
        public $take=20;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Reccount=new Reccount;
		}

        function indexAction() {
            $this->count=$this->Reccount->getSitesCount(array('get'=>$_GET));
            if(tools::int($this->registry->rewrites[1])>0)
                $this->page=tools::int($this->registry->rewrites[1]);
            $this->Pageing = new Pageing('/admin/sites', $this->take, $this->count, $this->page);
            $this->pager=$this->Pageing->GetAdminHTML();
            if(!$_GET['sorttype'])
                $_GET['sorttype']='id';
            if(!$_GET['sort'])
                $_GET['sort']='asc';

            $this->sitelist=$this->Reccount->getSiteList(array('get'=>$_GET,'start'=>$this->Pageing->getStart(),'take'=>$this->take, 'sorttype'=>$_GET['sorttype'],'sort'=>$_GET['sort']));
        	$this->content =$this->view->AddView('sites', $this);
			$this->view->renderLayout('admin', $this);
		}
		function siteinnerAction() {
			$this->siteinner=$this->Reccount->getSiteInner($this->registry->rewrites[1]);
            $this->Geo=new Geo;
            $this->sitetypes=$this->Reccount->getSitetypes(1);
            $this->countries=$this->Geo->getCountries();
			$this->content =$this->view->AddView('siteinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatesiteinnerAction(){
		    $this->cache=cache::init();
		    $this->cache->set('ru_main_sites',true,false,-1);
            $siteid=$this->Reccount->updateSiteInner($_POST,$_FILES);
			if($siteid>0)
			$this->registry->get->redirect('/admin/sites/?new='.$siteid.'');
			else
			$this->registry->get->redirect('/admin/sites/');
		}
         function aplicationsAction() {
            $this->aplications=$this->Reccount->getAplications();
            $this->content =$this->view->AddView('aplications', $this);
            $this->view->renderLayout('admin', $this);
        }
        function applicationinnerAction() {
            $this->aplication=$this->Reccount->getAplicationInner($this->registry->rewrites[1]);
            $this->content =$this->view->AddView('aplicationinner', $this);
            $this->view->renderLayout('admin', $this);
        }
        function updateaplicationinnerAction(){
            $this->Reccount->updateAplicationInner($_POST);
            $this->registry->get->redirect('/admin/sites/aplications');
        }
}


?>