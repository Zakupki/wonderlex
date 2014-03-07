<?
require_once 'modules/base/controllers/Base_Controller.php';
Class Facebook_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
		}
        function indexAction() {		
		}
		public function unlinkAction(){
			$this->Facebook = new Facebook;
			$this->Facebook->disconnect($_REQUEST['id']);
			$this->registry->get->redirect('/admin/account/');
		}
		
}
?>