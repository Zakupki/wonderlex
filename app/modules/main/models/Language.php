<?
require_once 'modules/base/models/Basemodel.php';

Class Language Extends Basemodel {

public function getMainLang(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
	SELECT 
	z_site_language.languageid
	FROM z_site_language
	WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).' AND z_site_language.major=1
	');	
	if($result[0])
	return $result[0];
	else 
	return 1;
}
public function getSiteLanguages(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	z_language.id,
	z_language.name,
	z_language.description,
	z_language.code,
	z_site_language.active,
	z_site_language.major
	FROM z_language
	INNER JOIN z_site_language
	ON z_site_language.languageid=z_language.id AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
	');
	if($result)
	return $result;
}
public function getSiteAdminLanguages(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_site_language.languageid,
	  z_language.NAME AS languagename,
	  z_site_language.NAME AS sitename,
	  z_site_language.address AS address,
	  z_site_language.active,
	  z_site_language.description,
	  z_site_language.keywords,
	  z_site_language.id,
	  z_site_language.major,
	  if(CHAR_LENGTH(z_site_language.map_url)>3,concat("/uploads/sites/",z_site_language.siteid,"/img/7_",z_site_language.map_url),null) AS map_url
	FROM
	  z_site_language 
	  INNER JOIN
	  z_language 
	  ON z_site_language.languageid = z_language.id 
	WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
	');
	if($result)
	return $result;
}
}
?>