<?
require_once 'modules/main/models/Basket.php';
require_once 'modules/main/models/Language.php';
require_once 'modules/main/models/Reccount.php';
Abstract Class Base_Controller Extends Controller{
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
                $this->Reccount=new Reccount;
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
				#Язык
                $this->langlist=$this->Language->getSiteLanguages($_SESSION['Site']['id']);
                
                
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
                    if(isset($_GET['lang'])){
                    $_SESSION['langid']=$_GET['lang'];
                    setcookie('langid',$_SESSION['langid'], time()+60*60);
                    }
                }
                if($_SESSION['langid']<1)
                    $_SESSION['langid']=1;
                
                #Валюта
                if(isset($_GET['curid'])){
                    $_SESSION['curid']=$_GET['curid'];
                    setcookie('curid',$_SESSION['curid'], time()+60*60);
                }
                
                if($_SESSION['curid']<1){
                    if($_COOKIE['curid'] && $this->Reccount->checkCurrency($_COOKIE['curid'])){
                        $_SESSION['curid']=$_COOKIE['curid'];
                    }else{
                        $_SESSION['curid']=$this->Reccount->getMainCurrency();
                        setcookie('curid',$_SESSION['curid'], time()+60*60);
                    }
                }
				$this->curlang=$_SESSION['langid'];
                $this->currency=$this->Reccount->getCurrency();
                $translate_array = parse_ini_file("config/maintrans.ini", true);
                $this->translate=$translate_array[$this->curlang];
                $this->registry->translate=$translate_array[$this->curlang];
                
				$this->sharetitle=$this->registry->sitetitle;
				$this->sharedesc=$this->registry->sitedesc;
				$this->sharehost=$this->registry->sitehost;
				$this->shareimage="http://".$_SERVER['HTTP_HOST']."/img/reactor/share.jpg";
				$this->banner='<div class="side-bn"><a target="_blank" href="http://www.hideoutfestival.com/"><img src="/img/reactor/banners/dlfng.jpg" alt="side-bn1" width="160" height="600"></a></div>';

        }
        abstract function indexAction();
}
?>