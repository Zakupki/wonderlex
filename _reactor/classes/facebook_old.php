<?
require_once 'modules/main/models/Social.php';
Class Facebook {
	
	public function __construct(){
		$this->app_id="305286906257619";
		$this->app_secret = "e39ff21c9871822d99d015764e0b4002";
		$this->canvas_page="http://wonderlex.com/facebook/connect/";
		$this->my_url="http://wonderlex.com/facebook/connect/";
	}
	
	
	public function connect2($url,$sescode){
		
		   session_start();
		   $code = $_REQUEST["code"];
		  
		   if(empty($code)) {
		     $urlArr=parse_url($_SERVER['HTTP_REFERER']);
			 
			 if($url && $sescode){
				 $_SESSION['ref']=$url;
				 $_SESSION['scode']=$sescode;
			 }
			 $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
		     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
		       . $this->app_id . "&redirect_uri=" . urlencode($this->my_url) . "&state="
		       . $_SESSION['state']."&scope=email,user_about_me,publish_stream";
		
		     echo("<script> top.location.href='" . $dialog_url . "'</script>");
		   }
			
		   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
		   		
				
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
		     $token_url = "https://graph.facebook.com/oauth/access_token?"
		       . "client_id=" . $this->app_id . "&redirect_uri=" . urlencode($this->my_url)
		       . "&client_secret=" . $this->app_secret . "&code=" . $code;
		
		     $response = file_get_contents($token_url);
		     $params = null;
		     parse_str($response, $params);
			 print_r($params);
			 
			 echo "<br>";
			 echo date("Y-m-d H:i:s", $params['expires']);
			 echo "<br>";
			 
			 $graph_url = "https://graph.facebook.com/me?access_token=" 
		       . $params['access_token'];
		
		     $user = json_decode(file_get_contents($graph_url));
			 
			 print_r($user);
			 echo "<br>";
			 echo date("Y-m-d H:i:s", strtotime($user->updated_time));
			 echo "<br>";
			 echo strtotime($user->updated_time);
			 echo "<br>";
			 echo "<br>";
			 echo strtotime($user->updated_time)+$params['expires'];
			 echo "<br>";
			 echo date("Y-m-d H:i:s", strtotime($user->updated_time)+$params['expires']);
			 echo "<br>";
			 die();
			 
			 
			 if($user->id>0 && $user->email){
			 	$this->User=new User;
				
				
				/*
				$newuserdata=$this->User->loginByFacebookEmail($user->email,$_SESSION['ref'],$this->siteid);
								if($newuserdata['userid']>0){
										$this->User->linkFacebookUser($user,$params,$newuserdata['userid']);
										return $newuserdata;
								}else{*/
				
					
					if(self::addAccount($user,$params,$siteid)){
						//$newuserdata=$this->User->loginByFacebookEmail($user->email,$_SESSION['ref'],$this->siteid);
						
						/*
						$this->Social=new Social;
												$sdata=$this->Social->findSocial($user->link);
												$db=db::init();
												$db->exec('
												INSERT INTO z_user_social
													(socialid, url, active, userid, sort)
												VALUES 
													  ('.tools::int($sdata['id']).', "'.tools::str($user->link).'", 1, '.tools::int($newuserdata['userid']).', 0 )');
												*/
						
						return true;
					}
				/*}*/
			 	;
			 }
		   }
		   else {
		     
		   }
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
		     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
		       . $this->app_id . "&redirect_uri=" . urlencode($this->my_url) . "&state="
		       . $_SESSION['state']."&scope=email,user_about_me,publish_stream";
		
		     echo("<script> top.location.href='" . $dialog_url . "'</script>");
		   }
		   echo $_SESSION['state'];
		   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
		   			
				
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
		     $token_url = "https://graph.facebook.com/oauth/access_token?"
		       . "client_id=" . $this->app_id . "&redirect_uri=" . urlencode($this->my_url)
		       . "&client_secret=" . $this->app_secret . "&code=" . $code;
		
		     $response = file_get_contents($token_url);
		     $params = null;
		     parse_str($response, $params);
			 $graph_url = "https://graph.facebook.com/me?access_token=" 
		       . $params['access_token'];
		
		     $user = json_decode(file_get_contents($graph_url));
			 if($user->id>0 && $user->email){
			 	$this->User=new User;
				
				
				/*
				$newuserdata=$this->User->loginByFacebookEmail($user->email,$_SESSION['ref'],$this->siteid);
								if($newuserdata['userid']>0){
										$this->User->linkFacebookUser($user,$params,$newuserdata['userid']);
										return $newuserdata;
								}else{*/
				
					
					if(self::addAccount($user,$params,$siteid)){
						//$newuserdata=$this->User->loginByFacebookEmail($user->email,$_SESSION['ref'],$this->siteid);
						
						/*
						$this->Social=new Social;
												$sdata=$this->Social->findSocial($user->link);
												$db=db::init();
												$db->exec('
												INSERT INTO z_user_social
													(socialid, url, active, userid, sort)
												VALUES 
													  ('.tools::int($sdata['id']).', "'.tools::str($user->link).'", 1, '.tools::int($newuserdata['userid']).', 0 )');
												*/
						
						return true;
					}
				/*}*/
			 	;
			 }
		   }
		   else {
		     
		   }
	}
	public function disconnect($id){
		$db=db::init();
		$db->exec('delete from z_social_account where id='.tools::int($id).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
	}
	function addAccount($data, $params,$siteid){
		$db=db::init();
		
		$avatar=tools::GetFacebookImageFromUrl('http://graph.facebook.com/'.$data->id.'/picture?type=large');
						$tempfile="".$_SERVER['DOCUMENT_ROOT'].$avatar."";
						if(file_exists($tempfile)){
							$image=pathinfo($avatar);
							$newfile=md5(uniqid().microtime()).'.'.$image['extension'];
							rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".$siteid."/img/".$newfile."");
						}
				
				
				if(!$newfile)
				$newfile='NULL';
				
				/*
				$db->exec('INSERT INTO z_user (login, email, preview_text, file_name, activation)
								 values ("'.$data->name.'", "'.$data->email.'", "'.$data->bio.'", "'.$newfile.'", 1)');
								$newuserid=$db->lastInsertId();*/
				
		
		
		$apprequest_url = "https://graph.facebook.com/me/feed";
		$parameters = "?access_token=" . $params['access_token'] . "&link=http://".$_SESSION['ref']."/";
		$myurl = $apprequest_url . $parameters;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_URL,$myurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result=curl_exec($ch);
		
		$db->exec('INSERT INTO z_social_account (socialid, accountid,token,tokenexpires,siteid,name,email,file_name) 
		VALUES (255,'.$data->id.',"'.$params['access_token'].'",'.$params['expires'].','.$siteid.',"'.$data->name.'", "'.$data->email.'","'.$newfile.'")');
		
		$newuserid=$db->lastInsertId();
		//$db->exec('INSERT INTO z_usertype_user (userid, usertypeid) VALUES ('.$newuserid.',2)');
		if($newuserid>0)
		return $newuserid;
	}
	
}
?>