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
        echo  $_SESSION['facebookid'];
        }
		public function connectAction(){
				
			//require_once("facebook.php");

				
			$this->Facebook=new Facebook;
			//if($_SERVER['REMOTE_ADDR']=='31.42.52.10')
			//$returndata=$this->Facebook->connect2($_GET['url'],$_GET['sescode']);
			//else
			if($_REQUEST['id']>0)
			$this->Facebook->disconnect($_REQUEST['id']);
			
			
			$returndata=$this->Facebook->connect($_GET['url'],$_GET['sescode']);
			if($returndata>0)
			$this->registry->get->redirect('http://'.$_SESSION['ref'].'/admin/account/?sescode='.$_SESSION['scode'].'&authkey='.$returndata['key'].'');
			
			
		}
}
?>