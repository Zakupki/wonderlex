<?
require_once 'modules/main/models/Social.php';
Class Vk {
	
	public function __construct(){
		$this->ApplicationId = '3290196';
    	$this->Key ='ufvINXFeLW2OOwBJmoDi';
		$this->redirect_uri='http://wonderlex.com/vkontakte/connect/';
	}
	
	
	
	public function connect($url,$sescode){
		
		   session_start();
		   $code = $_REQUEST["code"];
		  
		   if(empty($code)) {
		     $urlArr=parse_url($_SERVER['HTTP_REFERER']);
			 
			 if($url && $sescode){
				 $_SESSION['ref']=$url;
				 $_SESSION['scode']=$sescode;
			 }
			 $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
		     
		     
		    $dialog_url='https://oauth.vk.com/authorize?client_id='.$this->ApplicationId.'&scope=offline,wall&redirect_uri='.$this->redirect_uri.'&response_type=code';
		    echo("<script> top.location.href='" . $dialog_url . "'</script>");
		   }else{
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
				$this->domaintype=$this->get->handleDomain($_SESSION['ref']);
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
						$siteid=$this->Client->getSiteid(str_replace('www.','',$_SESSION['ref']));
						//echo $siteid;
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
		     
		     
		     $token_url = 'https://oauth.vk.com/oauth/access_token?client_id='.$this->ApplicationId.'&client_secret='.$this->Key.'&code='.$code.'&redirect_uri='.$this->redirect_uri.'';
		     $user = json_decode(file_get_contents($token_url));
			 
			 $user_url = 'https://api.vk.com/method/getProfiles?uid='.$user->user_id.'&access_token='.$user->access_token.'&fields=photo_50';
			 $params = json_decode(file_get_contents($user_url));
			 
			 if($user->user_id>0){
			 	$this->User=new User;
					if(self::addAccount($user,$params->response[0],$siteid))
						return true;
			 }
		   }
		  
	}
	public function disconnect($id){
		$db=db::init();
		$db->exec('delete from z_social_account where id='.tools::int($id).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
	}
	function addAccount($data,$params=null,$siteid){
				$db=db::init();
				$avatar=tools::GetImageFromUrl($params->photo_50);
								$tempfile="".$_SERVER['DOCUMENT_ROOT'].$avatar."";
								if(file_exists($tempfile)){
									$image=pathinfo($avatar);
									$newfile=md5(uniqid().microtime()).'.'.$image['extension'];
									rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".$siteid."/img/".$newfile."");
				}
				
				
								
				if(!$newfile)
				$newfile='NULL';
				
				/*
				$apprequest_url = "https://graph.facebook.com/me/feed";
								$parameters = "?access_token=" . $params['access_token'] . "&link=http://".$_SESSION['ref']."/";
								$myurl = $apprequest_url . $parameters;
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch,CURLOPT_URL,$myurl);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$result=curl_exec($ch);*/
				
		
		if(!$siteid)
            $siteid=1;
		$db->exec('INSERT INTO z_social_account (socialid, accountid,token,tokenexpires,siteid,name,file_name,userid)
		VALUES (226,'.$data->user_id.',"'.$data->access_token.'",'.$data->expires_in.','.$siteid.',"'.$params->first_name.' '.$params->last_name.'", "'.$newfile.'", '.tools::int($_SESSION['User']['id']).')');
		
		$newuserid=$db->lastInsertId();
		//$db->exec('INSERT INTO z_usertype_user (userid, usertypeid) VALUES ('.$newuserid.',2)');
		if($newuserid>0)
		return $newuserid;
	}
	
}
?>