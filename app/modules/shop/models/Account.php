<?
require_once 'modules/base/models/Basemodel.php';

Class Account Extends Basemodel {

public function getSitecolor(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  color
				FROM
				  z_site
				WHERE z_site.id='.tools::int($_SESSION['Site']['id']).'
				LIMIT 0,1
				');
	if($result)
	return $result['color'];
}
public function updateAccount($data){
	$db=db::init();
	
	#Валюты
	if(count($data['currency'])>0)
	$delcursql=' AND currencyid NOT IN('.implode(',',$data['currency']).')';
	$db->exec('DELETE FROM z_currency_site WHERE siteid='.tools::int($_SESSION['Site']['id']).''.$delcursql.'');
	$result=$db->queryFetchAllAssoc('SELECT * FROM z_currency_site WHERE siteid='.tools::int($_SESSION['Site']['id']).'');
	foreach($result as $cur)
	$curArr[$cur['currencyid']]=$cur;
	
	foreach($data['currency'] as $val){
		if(!array_key_exists($val, $curArr))
		{
			if($val==$data['default_currency']){
			$defcur[$val]['col']=',major';
			$defcur[$val]['val']=',1';
			}
			$db->exec('INSERT z_currency_site (siteid,currencyid'.$defcur[$val]['col'].') VALUES ('.tools::int($_SESSION['Site']['id']).','.tools::int($val).''.$defcur[$val]['val'].')');
		}else{
			if($val==$data['default_currency'] && $curArr[$val]['major']!=1)
			$db->exec('UPDATE z_currency_site SET major=1 WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND currencyid='.tools::int($val).'');
			elseif($val!=$data['default_currency'] && $curArr[$val]['major']==1)
			$db->exec('UPDATE z_currency_site SET major=0 WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND currencyid='.tools::int($val).'');
		}
	}
	
	

	
	$db->exec('
	UPDATE z_site SET 
		messagenotice='.tools::int($data['notice']['messages']).', 
		newsnotice='.tools::int($data['notice']['news']).', 
		commentnotice='.tools::int($data['notice']['comments']).',
		facebook="'.tools::str($data['facebook']).'", 
		twitter="'.tools::str($data['twitter']).'", 
		vkontakte="'.tools::str($data['vkontakte']).'",
		instagram="'.tools::str($data['instagram']).'",
		phone="'.tools::str($data['phone']).'",
		email="'.tools::str($data['contact_email']).'",
		skype="'.tools::str($data['skype']).'",
		canorder='.tools::int($data['canorder']).',
		countryid='.tools::int($data['country']['id']).',
		cityid='.tools::int($data['city']['id']).',
		map='.tools::int($data['map']).'
		'.$data['map_url'].'
		WHERE
		id='.tools::int($_SESSION['Site']['id']).' 
		AND userid='.tools::int($_SESSION['User']['id']).'');
	$_SESSION['Site']['canorder']=tools::int($data['canorder']);
	#Languages
	$db->exec('UPDATE z_site_language SET active=0, major=0 WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'');
	foreach($data['language'] as $lkey=>$lang){
		if($lkey==$data['default_language'])
		$major[$lkey]=1;
		$db->exec('UPDATE z_site_language SET active='.$lang.', major='.tools::int($major[$lkey]).' WHERE z_site_language.id='.tools::int($lkey).' AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'');
	}
	
	foreach($data['title'] as $id=>$row){
		
		if($data['map_current'][$id] && $data['map_removed'][$id]>0){
		tools::delImg($data['map_current'][$id]);
		$map_update[$id]=',map_url=NULL';
		}
		if($data['map_new'][$id]){
				if($data['map_current'][$id])
				tools::delImg($data['map_current'][$id]);
				$data['map_new'][$id]=str_replace('7_', '', $data['map_new'][$id]);
				$tempfile1="".$_SERVER['DOCUMENT_ROOT'].$data['map_new'][$id]."";
				if(file_exists($tempfile1)){
					$data['map_new'][$id]=pathinfo($data['map_new'][$id]);
					$newfile1=md5(uniqid().microtime()).'.'.$data['map_new'][$id]['extension'];
					rename($tempfile1, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile1."");
					$map_update[$id]=',map_url="'.tools::str($newfile1).'"';
				}
		}
		
		
		$db->exec('UPDATE z_site_language 
		SET name="'.tools::str($row).'",
		address="'.tools::str($data['address'][$id]).'",
		keywords="'.tools::str($data['keywords'][$id]).'",
		description="'.tools::str($data['seo'][$id]).'"
		'.$map_update[$id].'
		WHERE z_site_language.id='.tools::int($id).' 
		AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' 
		AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'');
	}

	if(count($data['transmit'])>0){
		foreach($data['transmit'] as $sid=>$social)
		$db->exec('UPDATE z_social_account 
		SET works='.tools::int($social['works']).',
		news='.tools::int($social['news']).',
		blog='.tools::int($social['blog']).',
		events='.tools::int($social['events']).'
		WHERE id='.tools::int($sid).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
	}

	if($data['password'] && $data['new_password'] && $data['repeatnew_password']){
		$this->user=new user;
		$passch=$this->user->changePassword($data['password'],$data['new_password'],$data['repeatnew_password']);
		if($passch){
				$subject="Изменение пароля";
				$message="Здравствуйте!\r\nВы успешно изменили пароль для доступа к вашему аккаунту\r\nВаш логин для входа:".$_SESSION['User']['email']."\r\nНовый пароль:".$data['new_password']."";
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('info@wonderlex.com', 'wI6VVSks');
				$smtp->Mail('info@wonderlex.com');
				$smtp->Recipient($_SESSION['User']['email']);
				$smtp->Data($message, $subject);
			return 1;
		}
		else 
			return 2;
	}
	
}
public function getAccount(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site.messagenotice,
				  z_site.newsnotice,
				  z_site.commentnotice,
				  z_site.facebook,
				  z_site.twitter,
				  z_site.vkontakte,
				  z_site.instagram,
				  z_site.phone,
				  z_site.email,
				  z_site.skype,
				  z_site.canorder,
				  z_site.countryid,
				  z_site.cityid,
				  z_site.map,
				  if(1='.tools::int($_SESSION['langid']).',z_country.name_ru,z_country.name_en) AS countryname,
				  if(1='.tools::int($_SESSION['langid']).',z_city.city_name_ru,z_city.city_name_en) AS cityname
				FROM
				  z_site
				LEFT JOIN z_country
				ON z_country.id=z_site.countryid
				LEFT JOIN z_city
				ON z_city.id=z_site.cityid
				WHERE z_site.id='.tools::int($_SESSION['Site']['id']).' AND z_site.userid='.tools::int($_SESSION['User']['id']).'
				LIMIT 0,1
				');
				if($result){
					$result['socials']=$db->queryFetchAllAssoc('
						SELECT 
						  z_social.name AS socialname,
						  z_social.id AS socialid,
						  z_social_account.id,
						  z_social_account.accountid,
						  IF(NOW()>FROM_UNIXTIME(UNIX_TIMESTAMP(z_social_account.`date_update`)+z_social_account.`tokenexpires`),1,0) AS expired,
						  z_social_account.name,
						  z_social_account.works,
						  z_social_account.news,
						  z_social_account.blog,
						  z_social_account.events,
						  if(CHAR_LENGTH(z_social_account.file_name)>3,CONCAT("/uploads/sites/",z_social_account.siteid,"/img/11_",z_social_account.file_name),null) AS file_name
						FROM
						  z_social 
						  LEFT JOIN
						  z_social_account 
						  ON z_social_account.socialid = z_social.id 
						  AND z_social_account.siteid = '.tools::int($_SESSION['Site']['id']).'
						WHERE z_social.id IN(255,222) 
					');
				}
	if($result)
	return $result;
}
public function getAdminAbout(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_site_language.languageid,
				  z_site_language.about,
				  z_language.NAME AS languagename 
				FROM
				  z_site_language 
				  INNER JOIN
				  z_language 
				  ON z_language.id = z_site_language.languageid 
				WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
				');
	if($result)
	return $result;
}
public function updateAbout($data){
	$db=db::init();
	foreach($data['content'] as $key=>$val){
		$db->exec('
		UPDATE z_site_language SET about="'.tools::str($val).'"
		WHERE z_site_language.languageid='.tools::int($key).' AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).' 
		');
	}
}
public function getHowtobuy(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
	SELECT 
	  z_site_language.howtobuy
	FROM
	  z_site_language 
	WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
	AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
	');
	if($result[0])
	return $result[0];
}
public function getAdminHowtobuy(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_site_language.languageid,
				  z_site_language.howtobuy,
				  z_language.NAME AS languagename 
				FROM
				  z_site_language 
				  INNER JOIN
				  z_language 
				  ON z_language.id = z_site_language.languageid 
				WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
				');
	if($result)
	return $result;
}
public function updateHowtobuy($data){
	$db=db::init();
	foreach($data['content'] as $key=>$val){
		$db->exec('
		UPDATE z_site_language SET howtobuy="'.tools::str($val).'"
		WHERE z_site_language.languageid='.tools::int($key).' AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).' 
		');
	}
}
public function getAdminAgreement(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_site_language.languageid,
				  z_site_language.agreement,
				  z_language.NAME AS languagename 
				FROM
				  z_site_language 
				  INNER JOIN
				  z_language 
				  ON z_language.id = z_site_language.languageid 
				WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
				');
	if($result)
	return $result;
}
public function updateAgreement($data){
	$db=db::init();
	foreach($data['content'] as $key=>$val){
		$db->exec('
		UPDATE z_site_language SET agreement="'.tools::str($val).'"
		WHERE z_site_language.languageid='.tools::int($key).' AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.userid='.tools::int($_SESSION['User']['id']).' 
		');
	}
}
public function getAgreement(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site_language.agreement
				FROM
				  z_site_language 
				WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
				');
	if($result)
	return $result;
}
public function getAbout(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site_language.about
				FROM
				  z_site_language 
				WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
				');
	if($result)
	return $result;
}
public function getContacts(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site.phone,
				  z_site_language.address,
				  z_site.email,
				  z_site.skype,
				  z_site.map,
				  if(CHAR_LENGTH(z_site_language.map_url)>3,CONCAT("/uploads/sites/",z_site.id,"/img/7_",z_site_language.map_url),null) AS map_url
				FROM
				  z_site_language 
				INNER JOIN z_site
				ON z_site.id=z_site_language.siteid
				WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
				');
	if($result)
	return $result;
}
public function getSiteData(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_site_language.name,
				  z_site_language.description,
				  z_site.facebook,
				  z_site.vkontakte,
				  z_site.twitter
				FROM
				  z_site_language 
				INNER JOIN z_site
				ON z_site.id=z_site_language.siteid
				WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
				');
	if($result)
	return $result;
	
}
public function getSiteCurrency(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  DISTINCT(z_currency.id) AS id,
				  z_currency.code,
				  z_currency.id,
				  z_currency_site.currencyid,
				  z_currency_site.major
				FROM
				  z_currency 
				  LEFT JOIN
				  z_currency_site 
				  ON z_currency_site.currencyid = z_currency.id 
				  AND z_currency_site.siteid = '.tools::int($_SESSION['Site']['id']).' 
				WHERE z_currency.active = 1 
				');
	if($result)
	return $result;
	
}
public function getSeoAdmin(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_site_language.languageid,
	  z_language.NAME AS languagename,
	  z_site_language.seotitle AS sitename,
	  z_site_language.address AS address,
	  z_site_language.active,
	  z_site_language.description,
	  z_site_language.keywords,
	  z_site_language.mainseo,
	  z_site_language.secondseo,
	  z_site_language.postaladdress,
	  z_site_language.productalt1,
	  z_site_language.productalt2,
	  z_site_language.producttitle1,
	  z_site_language.producttitle2,
	  z_site_language.id,
	  z_site_language.major,
	  z_site.robots,
	  z_site.sitemap,
	  z_site.ror,
	  z_site.metrics
	FROM
	  z_site_language 
	  INNER JOIN
	  z_site
	  ON z_site.id=z_site_language.siteid
	  INNER JOIN
	  z_language 
	  ON z_site_language.languageid = z_language.id 
	WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
	');
	if($result)
	return $result;
}
public function getSeo(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT 
	  z_site_language.seotitle AS sitename,
	  z_site_language.description,
	  z_site_language.keywords,
	  z_site_language.mainseo,
	  z_site_language.secondseo,
	  z_site_language.postaladdress,
	  z_site_language.productalt1,
	  z_site_language.productalt2,
	  z_site_language.producttitle1,
	  z_site_language.producttitle2,
	  z_site.metrics
	FROM
	  z_site_language 
	  INNER JOIN z_site
	  ON z_site.id=z_site_language.siteid
	  INNER JOIN
	  z_language 
	  ON z_site_language.languageid = z_language.id 
	WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
	');
	if($result)
	return $result;
}
public function updateSeo($data){
	$db=db::init();
	$db->exec('UPDATE z_site 
		SET robots="'.tools::r_str($data['robots']).'",
		sitemap="'.tools::r_str($data['sitemap']).'",
		ror="'.tools::r_str($data['ror']).'",
		metrics="'.tools::r_str($data['metrics']).'"
		WHERE z_site.id='.tools::int($_SESSION['Site']['id']).'');
	foreach($data['title'] as $id=>$row){
		$db->exec('UPDATE z_site_language 
		SET seotitle="'.tools::str($row).'",
		keywords="'.tools::str($data['keywords'][$id]).'",
		description="'.tools::str($data['seo'][$id]).'",
		mainseo="'.tools::str($data['mainseo'][$id]).'",
		secondseo="'.tools::str($data['secondseo'][$id]).'",
		postaladdress="'.tools::str($data['postaladdress'][$id]).'",
		productalt1="'.tools::str($data['productalt1'][$id]).'",
		productalt2="'.tools::str($data['productalt2'][$id]).'",
		producttitle1="'.tools::str($data['producttitle1'][$id]).'",
		producttitle2="'.tools::str($data['producttitle2'][$id]).'"
		WHERE z_site_language.id='.tools::int($id).' 
		AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' 
		AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'');
	}
	
}
}
?>