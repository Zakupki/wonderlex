<?
require_once 'modules/base/controllers/Base_Controller.php';
Class Vkontakte_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
		}
        function indexAction() {
        	$file='http://cs417724.vk.me/v417724249/1a8a/c6wGsHiHA_Y.jpg';
			$siteid=39;
			$avatar=tools::GetImageFromUrl($file);
			
			tools::print_r($avatar);
								$tempfile="".$_SERVER['DOCUMENT_ROOT'].$avatar."";
																if(file_exists($tempfile)){
																	$image=pathinfo($avatar);
																	$newfile=md5(uniqid().microtime()).'.'.$image['extension'];
																	rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".$siteid."/img/".$newfile."");
																echo $_SERVER['DOCUMENT_ROOT']."/uploads/sites/".$siteid."/img/".$newfile;
																}
								
			
		}
		public function connectAction(){
			$this->Vk=new Vk;
			$returndata=$this->Vk->connect($_GET['url'],$_GET['sescode']);
			if($returndata>0)
			$this->registry->get->redirect('http://'.$_SESSION['ref'].'/admin/account/?sescode='.$_SESSION['scode'].'&authkey='.$returndata['key'].'');
		}
}
?>