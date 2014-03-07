<?
require_once 'modules/main/models/Basket.php';
require_once 'modules/main/models/Language.php';
Abstract Class Base_AdminController Extends Controller{
        private $registry;
		public $Session;
		function __construct($registry) {
				parent::__construct($registry);
        		$this->registry=$registry;
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				$this->Basket=new Basket;
                $this->Language=new Language;
                $this->inbasket=$this->Basket->totalProducts();
				if(!$_SESSION['sescode'])
				$_SESSION['sescode']=md5(MD5_KEY.microtime());
				
				if(isset($_COOKIE['react']) && $this->Session->User['id']<1){
					$userData=$this->registry->user->loginByCookie($_COOKIE['react']);
						if($userData){
							$_SESSION['User']=$userData;
							$this->User=$_SESSION['User'];		
						}
						else
						setcookie("react", '', time()-62*60*24*15, '/');					
				}
				
		}
        abstract function indexAction();
}
?>