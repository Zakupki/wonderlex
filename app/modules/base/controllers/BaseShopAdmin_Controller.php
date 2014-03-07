<?php
require_once 'modules/shop/models/Menu.php';
require_once 'modules/shop/models/Language.php';

Abstract Class BaseShopAdmin_Controller Extends Controller{

        private $registry;
		private $Session;
		function __construct($registry) {
				parent::__construct($registry);
        		$this->registry=$registry;
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				$this->Menu = new Menu($this->registry);
				$this->Language = new Language;
				
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
				#Язык
				if($_SESSION['langid']<1){
					if($_COOKIE['langid'])
					$_SESSION['langid']=$_COOKIE['langid'];
					else{
					$_SESSION['langid']=$this->Language->getMainLang();
					setcookie('langid',$_SESSION['langid'], time()+60*60);
					}
				}
				if($_GET['lang']){
				$_SESSION['langid']=$_GET['lang'];
				setcookie('langid',$_SESSION['langid'], time()+60*60);
				}
				$this->curlang=$_SESSION['langid'];
				$translate_array = parse_ini_file("config/translations.ini", true);
				$this->translate=$translate_array[$this->curlang];
				$this->langlist=$this->Language->getSiteLanguages($_SESSION['siteid']);
				$this->sitename=$_SESSION['Site']['name'];				
		}
		abstract function indexAction();

}


?>