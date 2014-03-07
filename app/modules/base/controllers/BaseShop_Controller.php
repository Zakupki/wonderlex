<?php
require_once 'modules/shop/models/Menu.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/models/Language.php';
require_once 'modules/shop/models/Account.php';

Abstract Class BaseShop_Controller Extends Controller{

        private $registry;
		public $Session;
		public $seotitle;
		public $seokeywords;
		public $seodescription;
		function __construct($registry) {
			    //die('Сайт временно не доступен!');
				parent::__construct($registry);
        		$this->registry=$registry;
				if(!is_object($this->registry->get))
				$this->registry->get=new get;
				$this->registry->user=new user;
				$this->Menu = new Menu($this->registry);
				$this->Design = new Design;
				$this->Language = new Language;
				$this->Account = new Account;
				
				if(!$_SESSION['sescode'])
				$_SESSION['sescode']=md5(MD5_KEY.microtime());
				
				#Логин
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
				$this->langlist=$this->Language->getSiteLanguages($_SESSION['siteid']);
				foreach($this->langlist as $l){
					if($l['active']){
						$activelangArr[]=$l['id'];
					}
					if($l['major']==1)
					$this->registry->majorlangid=$l['id'];
					
					if(!$l['major'] && $this->registry->langkeyid==$l['id'])
					$this->registry->langurl='/'.$l['code'];
				}
				if(count($activelangArr)==1){
					$_SESSION['langid']=$activelangArr[0];
					setcookie('langid',$_SESSION['langid'], time()+60*60);
				}else{
					
					if(!$this->registry->langkeyid)
					$_SESSION['langid']=$this->registry->majorlangid;
					else	
					$_SESSION['langid']=$this->registry->langkeyid;
					
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
				}
				
				#Валюта
				if($_GET['curid']){
					$_SESSION['curid']=$_GET['curid'];
					setcookie('curid',$_SESSION['curid'], time()+60*60);
				}
				
				if($_SESSION['curid']<1){
					if($_COOKIE['curid'] && $this->Menu->checkCurrency($_COOKIE['curid'])){
						$_SESSION['curid']=$_COOKIE['curid'];
					}else{
						$_SESSION['curid']=$this->Menu->getMainCurrency();
						setcookie('curid',$_SESSION['curid'], time()+60*60);
					}
				}
					
				
				
				$this->curlang=$_SESSION['langid'];
				$translate_array = parse_ini_file("config/translations.ini", true);
				$this->translate=$translate_array[$this->curlang];
				$this->registry->translate=$translate_array[$this->curlang];
				//$this->langlist=$this->Language->getSiteLanguages($_SESSION['siteid']);
				
				$this->sitename=$_SESSION['Site']['name'];
				$this->sitedesc=$_SESSION['Site']['about'];
				
				
				#Seo
				$seo=$this->Account->getSeo();
				
				$this->seotitle=$seo['sitename'];
				$this->seokeywords=$seo['keywords'];
				$this->seodescription=$seo['description'];
				$this->mainseo=$seo['mainseo'];
				$this->secondseo=$seo['secondseo'];
				$this->metrics=$seo['metrics'];
				$this->postaladdress=$seo['postaladdress'];
				$this->productalt1=$seo['productalt1'];
				$this->productalt2=$seo['productalt2'];
				$this->producttitle1=$seo['producttitle1'];
				$this->producttitle2=$seo['producttitle2'];
				
				if(strlen($this->sitedesc)>2)
				$this->sitedesc=strip_tags(str_replace('&nbsp;',' ',$this->sitedesc));
				else
				$this->sitedesc=$this->registry->sitedesc;
				
				
				if(!$_SESSION['Site']['active'] && !$_SESSION['User']['id'] ){
				$this->registry->token=new token;
				$this->token=$this->registry->token->getToken(5);
				$this->pagebg=$this->Design->getPagebg($this->registry->controller);
				$this->view = new View($this->registry);
				$this->content =$this->view->AddView('unactive', $this);
				$this->view->renderLayout('unactive', $this);
				die();
				}
				
		}
		abstract function indexAction();

}


?>