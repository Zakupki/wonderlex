<?
class user {
	/*function __construct(){
		
	}*/
	function activateUser($code){
		$db=db::init();
		$res=$db->queryFetchRow(
		'SELECT id FROM z_user WHERE activationcode="'.mysql_escape_string($code).'" AND activation=0');
		if($res['id']>0)
		{
			$db->exec("UPDATE z_user SET activationcode='NULL', activation=1 WHERE id=".$res['id']."");
			
			$row=$db->queryFetchRow(
			'SELECT 
			  z_user.id,
			  z_usertype_user.usertypeid,
			  z_user.login,
			  z_user.countryid,
			  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
			  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
			  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
			  IF(
			    z_user.siteid > 0,
				z_site.NAME,
				IFNULL(z_user.displayname,z_user.login)
				) AS `displayname`,
			  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
			  COUNT(DISTINCT z_messages.id) AS messages,
			  z_user.email,
			  z_user.file_name
			FROM
			  z_user 
			  LEFT JOIN
			  z_site 
			  ON z_site.id = z_user.siteid
			  INNER JOIN
			  z_usertype_user 
			  ON z_usertype_user.userid = z_user.id 
			  LEFT JOIN
			  z_operation 
			  ON z_operation.userid = z_user.id AND z_operation.status=2
			  LEFT JOIN z_messages
			  ON z_messages.userid=z_user.id AND z_messages.NEW="Y"
			  LEFT JOIN z_country_currency
			  ON z_country_currency.countryid=z_user.countryid
			  LEFT JOIN z_currency
			  ON z_currency.id=z_country_currency.currencyid
			  LEFT JOIN z_currency z_currency_default
			  ON z_currency_default.default=1
			WHERE z_user.id='.$res['id'].'
			GROUP BY z_user.id 
			LIMIT 0,1
			');
			if($row['id']>0){
				if($remember){
					$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
					$db->exec('UPDATE z_user SET authkey="'.$key.'" WHERE z_user.id='.$row['id'].'');
					setcookie("react", $key, time()+60*60*24*15, '/');
				}
				$sites=$db->queryFetchAllAssoc('
				SELECT id FROM z_site WHERE z_site.userid='.$row['id'].'');
				if(count($sites)>0){
				$row['reccounts']=$sites;
				}
				$_SESSION['User']=$row;
				return true;
			}	
		}
		else
		return false;
	}
	function addUser($data){
		
		$data['activationcode']=md5(microtime(). $data['email'].MD5_KEY . rand());
        $password=$data['password'];
		$data['password']=md5($data['password'].MD5_KEY);
		
		$subject = "Подтверждение регистрации";
		$message = "Здравствуйте! Спасибо за регистрацию на сайте ".$_SERVER['HTTP_HOST']."\n\nВаш логин: ".$data['email']."\n\nВаш пароль: ".$password."\n\nДля того чтобы войти в свой аккуант его нужно активировать.\n\nЧтобы активировать ваш аккаунт, перейдите по ссылке:\n\nhttp://".$_SERVER['HTTP_HOST']."/activate/?act=".$data['activationcode']."\n\nС уважением, Администрация сайта ".$_SERVER['HTTP_HOST']."";
		
		$smtp=new smtp;
		 $smtp->Connect('ds210.mirohost.net');
                $smtp->Hello('ds210.mirohost.net');
                $smtp->Authenticate('informer@wonderlex.com', 'B4gAaOeW');
                $smtp->Mail('informer@wonderlex.com');
		$smtp->Recipient($data['email']);
		$smtp->Data($message, $subject);
		
		$db=db::init();
		$db->exec('INSERT INTO z_user (login, password, firstName, email, familyName, secondName, country, city, phone, question, answer, cash, activation, activationcode)
		 values ("'.$data['login'].'", "'.$data['password'].'", "'.$data['firstName'].'", "'.$data['email'].'", "'.$data['familyName'].'", "'.$data['secondName'].'", 
		 "'.$data['country'].'", "'.$data['city'].'", "'.$data['phone'].'", "'.$data['question'].'", "'.$data['answer'].'", "'.$data['cash'].'", 0, "'.$data['activationcode'].'")');
		$userid=$db->lastInsertId();
		$db->exec('INSERT INTO z_usertype_user (userid, usertypeid) VALUES ('.$userid.',2)');
		if($userid)
		return $userid;
        
	}
	function loginAdmin($email, $password, $remember=null){
		$password=md5($password.MD5_KEY);
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
			z_user.id,
			z_user.pro,
			z_usertype_user.usertypeid,
			z_user.login,
			z_user.firstName,
			IF(
			    z_user.siteid > 0,
				z_site.NAME,
				IFNULL(z_user.displayname,z_user.login)
				) AS `displayname`
		FROM z_user 
		INNER JOIN z_usertype_user 
			ON z_usertype_user.userid=z_user.id
		LEFT JOIN
			  z_site 
			  ON z_site.id = z_user.siteid
		WHERE z_user.email="'.mysql_escape_string($email).'" AND z_user.PASSWORD="'.$password.'"
		GROUP BY z_user.id 
		LIMIT 0,1'
		);
		if($row['id']>0)
		{
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('UPDATE z_user SET authkey="'.$key.'" WHERE z_user.id='.$row['id'].'');
				setcookie("reactlog", $key, time()+60*60*24*15);
			}
		return $row;
		}
	}
	function loginUser($email, $password, $remember){
		$password=md5($password.MD5_KEY);
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.countryid,
		  z_user.firstName,
		  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
		  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
		  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
		  COUNT(DISTINCT z_messages.id) AS messages,
		  z_user.email,
		  z_user.file_name
		FROM
		  z_user 
		  LEFT JOIN
		  z_site 
		  ON z_site.id = z_user.siteid
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id AND z_operation.status=2
		  LEFT JOIN z_messages
		  ON z_messages.userid=z_user.id AND z_messages.NEW="Y"
		  LEFT JOIN z_country_currency
		  ON z_country_currency.countryid=z_user.countryid
		  LEFT JOIN z_currency
		  ON z_currency.id=z_country_currency.currencyid
		  LEFT JOIN z_currency z_currency_default
		  ON z_currency_default.default=1
		WHERE z_user.email="'.mysql_escape_string($email).'" AND z_user.PASSWORD="'.$password.'"
		GROUP BY z_user.id 
		LIMIT 0,1
		');
		if($row['id']>0){
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}
			$sites=$db->queryFetchAllAssoc('
			SELECT z_site.id,
			concat("/uploads/sites/",z_site.id,"/19_",z_site.author_image) as author_image FROM 
			z_site 
			/*INNER JOIN
              z_timeorder 
              ON z_timeorder.siteid = z_site.id 
              AND z_timeorder.date_end > NOW()*/
			WHERE z_site.userid='.$row['id'].'');
			if(count($sites)>0){
			$row['reccounts']=$sites;
			}
		}
		else
		{
			setcookie("react", $key, time()-61*60*24*15, '/');	
		}
		
		if($row['id']>0){
			$_SESSION['User']=$row;
			return $row;
		}
	}
	
	function loginAsAdmin($password,$remember){
		$db=db::init();
		$password=md5($password.MD5_KEY);
		$rw=$db->queryFetchRowAssoc('
		SELECT 
		  z_user.id
		FROM
		  z_user
		WHERE z_user.email="admin@wonderlex.com" AND z_user.PASSWORD="'.$password.'" 
		LIMIT 0,1
		');
		if($rw['id']>0){
			$row=$db->queryFetchRowAssoc(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.firstName,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  SUM(z_operation.VALUE) AS money,
		  COUNT(DISTINCT z_messages.id) AS messages,
		  z_user.email
		FROM
		  z_site
		  INNER JOIN
		  z_user 
		  ON z_site.userid = z_user.id
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id
		  LEFT JOIN z_messages
		 ON z_messages.userid=z_user.id AND z_messages.NEW="Y"
		WHERE z_site.id='.tools::int($_SESSION['Site']['id']).'
		GROUP BY z_user.id 
		LIMIT 0,1'
		);
		if($row['id']>0){
			/*if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}*/
			$sites=$db->queryFetchAllAssoc('
			SELECT z_site.id FROM
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
		}
		if(count($sites)>0){
			$row['reccounts']=$sites;
		}
		if($row['id']>0)
		return $row;
		}
	}
	
	function loginReccountUser($email, $password, $remember){
		if($email=='admin@wonderlex.com'){
		return self::loginAsAdmin($password,$remember);
		}
		$password=md5($password.MD5_KEY);
		$db=db::init();
		$row=$db->queryFetchRowAssoc(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.firstName,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  SUM(z_operation.VALUE) AS money,
		  COUNT(DISTINCT z_messages.id) AS messages,
		  z_user.email
		FROM
		  z_user 
		  LEFT JOIN
		  z_site 
		  ON z_site.userid = z_user.id  AND z_site.id='.tools::int($_SESSION['Site']['id']).'
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id
		  LEFT JOIN z_messages
		 ON z_messages.userid=z_user.id AND z_messages.NEW="Y"
		WHERE z_user.email="'.mysql_escape_string($email).'" AND z_user.PASSWORD="'.$password.'" 
		GROUP BY z_user.id 
		LIMIT 0,1'
		);
		if($row['id']>0){
			if($remember){
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				$db->exec('INSERT INTO z_auth (authkey,siteid,userid) VALUES ("'.$key.'",'.tools::int($_SESSION['Site']['id']).','.$row['id'].')');
				setcookie("react", $key, time()+60*60*24*15, '/');
			}
			$sites=$db->queryFetchAllAssoc('
			SELECT z_site.id FROM
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
		}
		if(count($sites)>0){
			$row['reccounts']=$sites;
		}
		if($row['id']>0)
		return $row;
	}
	function loginByCookie($authkey){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  z_user.id,
		  z_usertype_user.usertypeid,
		  z_user.login,
		  z_user.countryid,
		  z_user.firstName,
		  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
		  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
		  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal,
		  IF(
		    z_user.siteid > 0,
			z_site.NAME,
			IFNULL(z_user.displayname,z_user.login)
			) AS `displayname`,
		  if(SUM(z_operation.VALUE)>0,SUM(z_operation.VALUE),0) AS money,
		  COUNT(DISTINCT z_messages.id) AS messages,
		  z_user.email,
		  z_user.file_name
		FROM
		  z_auth
		  INNER JOIN z_user
		  ON z_auth.userid=z_user.id
		  LEFT JOIN
		  z_site 
		  ON z_site.id = z_user.siteid
		  INNER JOIN
		  z_usertype_user 
		  ON z_usertype_user.userid = z_user.id 
		  LEFT JOIN
		  z_operation 
		  ON z_operation.userid = z_user.id AND z_operation.status=2
		  LEFT JOIN z_messages
		  ON z_messages.userid=z_user.id AND z_messages.NEW="Y"
		  LEFT JOIN z_country_currency
		  ON z_country_currency.countryid=z_user.countryid
		  LEFT JOIN z_currency
		  ON z_currency.id=z_country_currency.currencyid
		  LEFT JOIN z_currency z_currency_default
		  ON z_currency_default.default=1
		WHERE z_auth.authkey="'.mysql_escape_string($authkey).'" AND z_auth.siteid='.tools::int($_SESSION['Site']['id']).'
		GROUP BY z_user.id
		LIMIT 0,1'
		);
		if($row['id']>0)
		{
				$key=md5($_SESSION['Site']['id'].$email.$password.microtime());
				$db->exec('UPDATE z_auth SET authkey="'.$key.'" WHERE z_auth.userid='.$row['id'].' AND z_auth.siteid='.tools::int($_SESSION['Site']['id']).'');
				setcookie("react", $key, time()+60*60*24*15, '/');
				unset($row['password']);
			
			$sites=$db->queryFetchAllAssoc('
			SELECT z_site.id FROM
			z_site 
			INNER JOIN
			  z_timeorder 
			  ON z_timeorder.siteid = z_site.id 
			  AND z_timeorder.date_end > NOW()
			WHERE z_site.userid='.$row['id'].'');
			if(count($sites)>0){
				$row['reccounts']=$sites;
			}
		}
		else
		{
			setcookie("react", '', time()-61*60*24*15, '/');	
		}
		
		return $row;
	}
	function loginOut(){
		$db=db::init();
		setcookie("react", '', time()-42000);
		$db->exec('DELETE FROM z_auth WHERE userid='.$_SESSION['User']['id'].' AND siteid='.$_SESSION['Site']['id'].'');
		$_SESSION['User']=null;
	}
	function getMessages($id){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  COUNT(DISTINCT z_messages.id) AS messages
		FROM
		  z_messages
		WHERE z_messages.userid='.intval($id).' AND z_messages.new=1 LIMIT 0,1');
		if($row['messages']>0)
		return $row['messages'];
	}
	function getSiteOwnerEmail(){
		$db=db::init();
		$row=$db->queryFetchAllFirst('
		SELECT email
		FROM z_user WHERE id='.tools::int($_SESSION['Site']['userid']).'
		');
		if($row[0])
		return $row[0];
	}
	function changePassword($old, $new, $new_conf){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
		  password
		FROM
		  z_user
		WHERE z_user.id='.tools::int($_SESSION['User']['id']).' LIMIT 0,1');
		
		if($row['password'] && $row['password']==md5($old.MD5_KEY) && $new==$new_conf){
		$res=$db->exec('UPDATE z_user SET password="'.md5($new.MD5_KEY).'" WHERE z_user.id='.tools::int($_SESSION['User']['id']).'');
		}
		return $res;
	}
	function passwordretrieve($email){
		$this->Valid=new valid;
		if($this->Valid->isEmail($email)){
			$db=db::init();
			$row=$db->queryFetchRow('
			SELECT 
			  id
			FROM
			  z_user
			WHERE z_user.email="'.tools::str($email).'" LIMIT 0,1
			');
			if($row['id']>0 && $row['id']!==1){
				$key=md5(microtime(). $email.MD5_KEY . rand());
				$db->exec('DELETE FROM z_keys WHERE userid='.$row['id'].'');
				$db->exec('INSERT INTO z_keys
				(token,userid,siteid) VALUES ("'.$key.'",'.$row['id'].','.tools::int($_SESSION['Site']['id']).')');
				$subject = "Восстановление пароля!";
				$message = "Здравствуйте! На сайте ".$_SERVER['HTTP_HOST']." был выполнен запрос на восстановление пароля. Если это сделали Вы, то перейдите по ссылке в конце письма, после чего на Ваш email прийдет новый пароль для входа.\n\n Если Вы этого не делали, то просто проигнорируйте это письмо.\n\n Ссылка для восстановления пароля: http://".$_SERVER['HTTP_HOST']."/user/getnewpassword?key=".$key."\n\nС уважением, Администрация сайта Wonderlex.com";
				$smtp=new smtp;
				 $smtp->Connect('ds210.mirohost.net');
                $smtp->Hello('ds210.mirohost.net');
                $smtp->Authenticate('informer@wonderlex.com', 'B4gAaOeW');
                $smtp->Mail('informer@wonderlex.com');
				$smtp->Recipient($email);
				$smtp->Data($message, $subject);	
			}
		return true;
		}
	}
	function setnewpassword($key){
			$db=db::init();
			$row=$db->queryFetchRow('
			SELECT 
			  z_keys.id,
			  z_keys.userid,
			  z_user.email
			FROM
			  z_keys
			INNER JOIN z_user
			ON z_user.id=z_keys.userid
			WHERE z_keys.token="'.tools::str($key).'" AND DATE_ADD(z_keys.date_create, INTERVAL 5 HOUR) > NOW() LIMIT 0,1
			');
			if($row['id']>0){
				$db->exec('DELETE FROM z_keys WHERE userid='.$row['userid'].'');
				$newpassword=tools::generatePassword();
				$db->exec('UPDATE z_user SET password="'.tools::str(md5($newpassword.MD5_KEY)).'" WHERE id='.tools::int($row['userid']).'');
				$subject = "Новый пароль!";
				$message = "Здравствуйте! Ваш новый пароль для входа: ".$newpassword."\n\nВы можете сменить эго в любой момент в кабинете пользователя.\n\nС уважением, Администрация сайта Wonderlex.com";
				$smtp=new smtp;
				 $smtp->Connect('ds210.mirohost.net');
                $smtp->Hello('ds210.mirohost.net');
                $smtp->Authenticate('informer@wonderlex.com', 'B4gAaOeW');
                $smtp->Mail('informer@wonderlex.com');
				$smtp->Recipient($row['email']);
				$smtp->Data($message, $subject);
				return true;
			}
			else
			return false;
	}
    function loginByFacebookEmail($email, $referer, $siteid){
        $db=db::init();
        $row=$db->queryFetchRow(
            'SELECT
              z_user.id,
              z_user.email
            FROM
              z_user
              INNER JOIN
              z_usertype_user
              ON z_usertype_user.userid = z_user.id
            WHERE z_user.email="'.tools::str($email).'"
		');
        $data['userid']=$row['id'];
        $_SESSION['User']=$row;
       //if($row['id']>0){
           // $key=md5($siteid.$email.microtime());
           // $data['key']=$key;
           // $db->exec('DELETE FROM z_auth WHERE userid='.$row['id'].' AND siteid='.tools::int($siteid).'');
            //$db->exec('INSERT INTO z_auth (authkey,siteid,userid,ip,expires) VALUES ("'.$key.'",'.tools::int($siteid).','.$row['id'].',INET_ATON("'.$_SERVER['REMOTE_ADDR'].'"), UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL 30 SECOND)))');
       // }

        if($data['userid']>0){
            return $data;

        }
    }
    function linkFacebookUser($data, $params, $userid){
        $db=db::init();
        $res=$db->queryFetchAllAssoc('SELECT * from z_social_account where accountid='.$data->id.' AND socialid=255 AND userid='.tools::int($userid).'');
        //echo ('SELECT * from z_social_account where accountid='.$data->id.' AND socialid=255 AND userid='.tools::int($userid).'');
        //tools::print_r($res);
        if(!$res)
        $db->exec('INSERT INTO z_social_account (socialid, accountid,token,tokenexpires,userid)
		VALUES (255,'.$data->id.',"'.$params['access_token'].'",'.$params['expires'].','.tools::int($userid).')');
    }

}

?>