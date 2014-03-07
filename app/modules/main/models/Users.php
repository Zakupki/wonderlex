<?
require_once 'modules/base/models/Basemodel.php';
//require_once 'modules/artist/models/Social.php';
//require_once 'modules/main/models/Reccount.php';

Class Users Extends Basemodel {
	
	private $Reccount;
	
	public function getUserProfile($login){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_user.id/*
					  ,
											z_user.website,
											IF(
											  z_user.siteid > 0,
											  z_site.name,
											  IFNULL(z_user.displayname,z_user.login)
											) AS `displayname`,
											IF(
												z_user.siteid > 0,
											  z_site.about,
											  z_user.preview_text
											) AS preview_text,
											z_user.login,
											if(z_site2.id,1,0) AS pro,
											z_user.siteid,
											CONCAT(
											  "/uploads/users/4_",
											  z_user.file_name
											) AS url */
					  
					FROM
					  z_user 
					  LEFT JOIN
					  z_site 
					  ON z_site.id = z_user.siteid
					  LEFT JOIN z_site z_site2
					  ON z_site2.userid=z_user.id
					  WHERE z_user.login="'.mysql_escape_string(trim($login)).'"
					  GROUP BY z_user.id
					');
		/*
		if($result['siteid']>0){
					$this->Social=new Social;
					$result['socilalist']=$this->Social->getUserSocial($result['siteid']);
				}
				else {
					$result['socilalist']=self::getUserProfileSocial($result['id']);
				}			*/
			
		return $result;
	}
	
	public function getUserProfileSocial($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_social.id AS socialid,
				  CONCAT(
				    "/uploads/",
				    z_file.subdir,
				    "/",
				    z_file.file_name
				  ) AS img,
				  z_user_social.url,
				  z_user_social.active 
				FROM
				  z_user_social 
				  INNER JOIN
				  z_social 
				  ON z_social.id = z_user_social.socialid 
				  LEFT JOIN
				  z_file 
				  ON z_social.preview_image = z_file.id 
				WHERE z_user_social.userid = '.tools::int($id).' 
				ORDER BY z_user_social.sort ');
	if($result)
	return $result;
}
	
	public function getUserReccounts(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_site.id,
					  z_site.name 
					FROM
					  z_site 
					WHERE z_site.userid = '.$_SESSION['User']['id'].' 
					  AND z_site.active = 1 
					');
		return $result;
	}
	
	
	public function getUserFullProfile($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_user.id,
					  z_user.login,
					  z_user.displayname,
					  z_user.preview_text,
					  z_user.pro,
					  z_user.firstName,
					  z_user.email,
					  z_user.siteid,
					  z_user.website,
					  z_user.facebook,
					  z_user.vkontakte,
					  z_user.twitter,
					  if(z_domain.id>0,z_domain.name,concat("w",z_site.id,".wonderlex.com")) AS domain
					  FROM
					  z_user
					  LEFT JOIN z_site
					  ON z_site.userid=z_user.id
					  LEFT JOIN
                      z_domain
                      ON z_domain.siteid = z_site.id
					  WHERE z_user.id='.tools::int($id).'
					  LIMIT 0,1
					');
		$linkresult=$db->queryFetchAllAssoc('
					SELECT
					  id, 
					  url,
					  active 
					FROM
					  z_user_social
					 WHERE userid='.tools::int($id).'
					');
		if($linkresult)
		$result['links']=$linkresult;
		return $result;
	}
	
	public function updateUserProfile($data){
		$db=db::init();
		if($_SESSION['User']['id']==$data['userid'] && $_SESSION['User']['id']>0 ){
			$result=$db->exec('UPDATE z_user SET 
			firstName="'.tools::str($data['name']).'",
			facebook="'.tools::str(str_replace(array('http://','https://'), '', $data['facebook'])).'",
			twitter="'.tools::str(str_replace(array('http://','https://'), '', $data['twitter'])).'",
			vkontakte="'.tools::str(str_replace(array('http://','https://'), '', $data['vkontakte'])).'"
			WHERE id='.tools::int($data['userid']).'');
		}
		
		return $result;
	}
	public function updateRegisterInfo($data){
		$db=db::init();
		$this->user=new user;
		//$db->exec('UPDATE z_user SET countryid='.tools::int($data['country']).' WHERE id='.tools::int($_SESSION['User']['id']).'');
		
		
		//$userData=self::getUserCurrencyInfo(tools::int($_SESSION['User']['id']));
		
		//$_SESSION['User']['countryid']=tools::int($data['country']);
		//$_SESSION['User']['currencyid']=$userData['currencyid'];
		//$_SESSION['User']['currency']=$userData['currency'];
		//$_SESSION['User']['currencylocal']=$userData['currencylocal'];
		
		
		$this->user->changePassword($data['password_old'],$data['password'],$data['password_check']);
		return true;
	}
	public function getUserMinInfo($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
			SELECT
			  id,
			  countryid,
			  login,
			  email
			FROM
			  z_user
			WHERE id='.tools::int($id).'
			');
		if($result)
		return $result;
	}
	public function getUserCurrencyInfo($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
			SELECT
			  if(z_currency.id,z_currency.id,z_currency_default.id) as currencyid,
			  if(z_currency.id,z_currency.code, z_currency_default.code) as currency,
			  if(z_currency.id,z_currency.localname, z_currency_default.localname) as currencylocal
			FROM
			  z_user
			 LEFT JOIN z_country_currency
			 ON z_country_currency.countryid=z_user.countryid
			 LEFT JOIN z_currency
			 ON z_currency.id=z_country_currency.currencyid
			 LEFT JOIN z_currency z_currency_default
			 ON z_currency_default.default=1
			WHERE z_user.id='.tools::int($id).'
			');
		if($result)
		return $result;
	}
	function checkLoginMail($login,$email){
		$db=db::init();
		$row=$db->queryFetchRow(
		'SELECT 
			id
		FROM z_user 
		WHERE z_user.login="'.tools::str($login).'" AND z_user.email="'.tools::str($email).'" LIMIT 0,1'
		);
		if($row['id']>0)
		return $row['id'];
	}
	function getBalance(){
		$db=db::init();
		$result=$db->queryFetchRow('
			SELECT 
			  SUM(z_operation.VALUE) AS total
			FROM
			  z_operation 
			WHERE z_operation.userid = '.tools::int($_SESSION['User']['id']).' 
			  AND z_operation.status = 2 
			');	
		if($result['total']>0)
		return $result['total'];
	}
    public function applySite(){
                        $subject = "Новая заявка Wonderlex";
                        $message = "Имя: ".$_POST['name']."\n\nE-mail: ".$_POST['email']."\n\nНомер телефона: ".$_POST['tel']."\n\nСтрана: ".$_POST['country']."\n\nДата рождения: ".$_POST['day'].".".$_POST['month'].".".$_POST['year']."\n\nСсылка на работы: ".$_POST['reference']."\n\nFacebook: ".$_POST['facebook']."\n\nСообщения: ".$_POST['description']."\n\n";
                        $smtp=new smtp;
                        $smtp->Connect(SMTP_HOST);
                        $smtp->Hello(SMTP_HOST);
                        $smtp->Authenticate('informer@wonderlex.com', 'B4gAaOeW');
                        $smtp->Mail('informer@wonderlex.com');
                        //$smtp->Recipient('dmitriy.bozhok@gmail.com');
                        $smtp->Recipient('larisa@atelier.ua');
                        $smtp->Recipient('oksana@atelier.ua');
                       //$smtp->Recipient('fox@atelier.ua');
                        $status=$smtp->Data($message, $subject);
                        
                        
                        $subject = "Ваша заявка прината!";
                        $message = "Благодарим за инерес к нашей системе. В ближайшее время с Вами свяжется менеджер для дальнейшего сотрудничетсва.\n\n";
                        $smtp=new smtp;
                        $smtp->Connect(SMTP_HOST);
                        $smtp->Hello(SMTP_HOST);
                        $smtp->Authenticate('informer@wonderlex.com', 'B4gAaOeW');
                        $smtp->Mail('informer@wonderlex.com');
                        $smtp->Recipient($_POST['email']);
                        $status=$smtp->Data($message, $subject);
                        
                        
        $db=db::init();
        $db->exec('INSERT INTO z_aplication
                        (name, phone, email, date_birth,url,description,userid,active)
                        VALUES (
                        "'.tools::str($_POST['name']).'",
                        "'.tools::str($_POST['phone']).'",
                        "'.tools::str($_POST['email']).'",
                        "'.tools::getSqlDate($_POST['year'],$_POST['month'],$_POST['day']).'",
                        "'.str_replace('http://','',$_POST['reference']).'",
                        "'.tools::str($_POST['description']).'",
                        '.tools::int($_SESSION['User']['id']).',
                        1)
                        ');
        
        
        if ($status) {
        header('HTTP/1.0 200 Спасибо! Ваша заявка принята');
        $json_answer = '{
            "href": "/",
            "title": "Вернуться на главную"
            }';
        }
        else {
            header('HTTP/1.0 400 Ошибка обработки заявки');
            $json_answer = '{}';
        }
    
        echo $json_answer;
    }
	
}
?>