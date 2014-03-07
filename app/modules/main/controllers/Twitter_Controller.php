<?
require_once 'modules/base/controllers/Base_Controller.php';
Class Twitter_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			define('CONSUMER_KEY', '3V2XLROnHt7ZylJFJuh0hg');
			define('CONSUMER_SECRET', 'Zjs7xWOBZLQp7bGMwHQ8yBNo2YwTMBYAhFxih5qa3As');
			define('OAUTH_CALLBACK', 'http://wonderlex.com/twitter/callback/?url='.$_GET['url'].'');	
		}
        function indexAction() {		
		echo  $_SESSION['facebookid'];
        }
	
		
		
		public function connectAction(){
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	 		/* Get temporary credentials. */
			$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
			/* Save temporary credentials to session. */
			
			
			$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
			$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
			
			
			/* If last connection failed don't display authorization link. */
			switch ($connection->http_code) {
			  case 200:
			    /* Build authorize URL and redirect user to Twitter. */
			    $url = $connection->getAuthorizeURL($token);
			    header('Location: ' . $url); 
			    break;
			  default:
			    /* Show notification if something went wrong. */
			    echo 'Could not connect to Twitter. Refresh the page or try again later.';
			}
		}
		public function callbackAction(){
			$db=db::init();
			/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
			
			/* Request access tokens from twitter */
			$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
			
			/* Save the access tokens. Normally these would be saved in a database for future use. */
			$_SESSION['access_token'] = $access_token;
			
			//tools::print_r($_SESSION['access_token']);
			
			/* Remove no longer needed request tokens */
			unset($_SESSION['oauth_token']);
			unset($_SESSION['oauth_token_secret']);
			
			
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

			/* If method is set change API call made. Test is called by default. */
			$data = $connection->get('account/verify_credentials');
			
				$registry = new Registry;
				$sitedomains[]=array(0=>'wonderlex.com',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.ru',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.ru',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.org',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.org',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.biz',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.biz',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.info',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.info',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.eu',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.eu',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.net',1=>'main',2=>1); 
				$sitedomains[]=array(0=>'wonderlex.net',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.com',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.in.ua',1=>'main',2=>1); 
				$sitedomains[]=array(0=>'wonderlex.in.ua',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.org.ua',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.org.ua',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.net.ua',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.net.ua',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonder-lex.com.ua',1=>'main',2=>1);
				$sitedomains[]=array(0=>'wonderlex.com.ua',1=>'main',2=>1);
						
				$sitedomains[]=array(0=>'handy-friendy.com',1=>'main',2=>1);
				
				$registry->sitedomains=$sitedomains;
				
		   		$this->get=new get($registry);
				//echo $_SESSION['ref'];
				$this->domaintype=$this->get->handleDomain($_REQUEST['url']);
				//echo $this->domaintype;
				$this->Client=new client();
				
					
					if($this->domaintype=='main'){
						$this->siteid=1;
						$requestUrl=explode('/', $this->_requestUrl);
						if($requestUrl[0]=='admin')
						$this->module='admin';
						else
						$this->module='main';
					}
					elseif($this->domaintype=='client'){
						echo $_SESSION['ref'];
						$siteid=$this->Client->getSiteid(str_replace('www.','',$_REQUEST['url']));
						if($siteid>0){
							$this->siteid=$siteid;
							$this->module='client';
						}						
					}
					elseif($this->domaintype>1){
						$siteid=$this->Client->isServiceid($this->domaintype);
						if($siteid>0){
							$this->siteid=$siteid;
							$this->module='client';
						}
					}
					$avatar=tools::GetImageFromUrl($data->profile_image_url);
												$tempfile="".$_SERVER['DOCUMENT_ROOT'].$avatar."";
												if(file_exists($tempfile)){
												$image=pathinfo($avatar);
												$newfile=md5(uniqid().microtime()).'.'.$image['extension'];
												rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".$siteid."/img/".$newfile."");
					}
			if(!$newfile)
			$newfile='NULL';
		
			$db->exec('INSERT INTO z_social_account (socialid, accountid,token,token_secret,siteid,name,file_name) 
						VALUES (222,'.$data->id.',"'.$access_token['oauth_token'].'","'.$access_token['oauth_token_secret'].'",'.$siteid.',"'.$data->name.'", "'.$newfile.'")');
			if($db->lastInsertId())
			$this->registry->get->redirect('http://'.$_REQUEST['url'].'/admin/account/');
		}
		
		public function unlinkAction(){
			/*
			if(!$_POST['password'] && $_POST['new_password']==$_POST['new_password_confirm']){
						$this->User = new User;
						$this->User->addPassword($_POST['new_password'],$_POST['new_password_confirm']);
						}*/
			$this->Facebook = new Facebook;
			$this->Facebook->disconnect($_REQUEST['id']);
			//$_SESSION['User']['haspasword']=1;
			$data=array('error'=>false,'status'=>'');
			echo json_encode($data);
		}
		
}
?>