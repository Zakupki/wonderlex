<?
require_once 'modules/base/models/Basemodel.php';

Class Service Extends Basemodel {

public function getAdminServices($q=null){
	if($q)
	$Sql.=' AND z_services.name like "%'.tools::str($q).'%" ';
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_services.itemid,
				  z_services.name,
				  z_services.active, 
				  CONCAT(
				    "/uploads/sites/",
				    z_services.siteid,
				    "/img/2_",
				    z_services.file_name
				  ) AS url 
				FROM
				  z_services 
				WHERE z_services.languageid='.tools::int($_SESSION['langid']).'
				AND z_services.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_services.userid='.tools::int($_SESSION['User']['id']).'
				'.$Sql.'
				ORDER BY z_services.sort
				');
	if($result)
	return $result;
}
public function getServiceCount(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
				SELECT 
				  count(distinct z_services.itemid) AS count
				FROM
				  z_services 
				WHERE z_services.languageid='.tools::int($_SESSION['langid']).'
				AND z_services.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_services.active=1
				');
	if($result[0])
	return $result[0];
}
public function getServices($start=0,$take=12){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_services.itemid AS id,
				  z_services.name,
				  z_services.link,
				  z_services.preview_text,
				  if(char_length(z_services.file_name)>3,CONCAT(
				    "/uploads/sites/",
				    z_services.siteid,
				    "/img/6_",
				    z_services.file_name
				  ),null) AS url 
				FROM
				  z_services 
				WHERE z_services.languageid='.tools::int($_SESSION['langid']).'
				AND z_services.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_services.active=1
				ORDER BY z_services.sort
				LIMIT '.$start.','.$take.'
				');
	if($result)
	return $result;
}
public function updateServices($data){
	$db=db::init();
	$cnt=0;
	foreach($data['itemid'] as $key=>$itemid){
		
		if($data['remove'][$key][$itemid]){
			$result=$db->queryFetchRowAssoc('
			SELECT if(CHAR_LENGTH(z_services.file_name)>3,CONCAT(
				    "/uploads/sites/",
				    z_services.siteid,
				    "/img/1_",
				    z_services.file_name
				  ),"") AS url
			FROM z_services
			WHERE itemid='.tools::int($itemid).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
			if($result['url'])
			tools::delImg($result['url']);
			$dellidArr[$itemid]=$itemid;
		}
		
		$db->exec('UPDATE z_services SET 
		sort='.tools::int($cnt).',
		active='.tools::int($data['state'][$key][$itemid]).'
		WHERE itemid='.tools::int($itemid).'
		AND siteid='.tools::int($_SESSION['Site']['id']).'
		AND userid='.tools::int($_SESSION['User']['id']).' 
		');	
	$cnt++;
	}
	//tools::print_r($dellidArr);
	if(count($dellidArr)>0)
	$db->exec('DELETE FROM _items
	WHERE id in('.implode(",",$dellidArr).') 
	AND siteid='.tools::int($_SESSION['Site']['id']).'
	AND userid='.tools::int($_SESSION['User']['id']).'');
}

public function getAdminServiceInner($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_services.itemid,
				  z_services.name,
				  z_services.detail_text,
				  z_services.preview_text,
				  z_services.link,
				  z_services.seotitle,
				  z_services.seokeywords,
				  z_services.seodescription,
				  z_language.id AS languageid,
				  z_language.NAME AS languagename,
				  z_services.file_name,
				  if(CHAR_LENGTH(z_services.file_name)>3,CONCAT(
				    "/uploads/sites/",
				    z_services.siteid,
				    "/img/6_",
				    z_services.file_name),null
				  ) AS url
				FROM
				  z_site_language 
				  INNER JOIN
				  z_language 
				  ON z_language.id = z_site_language.languageid 
				  LEFT JOIN
				  z_services 
				  ON z_services.languageid = z_language.id AND z_services.itemid='.tools::int($id).'
				WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
				');
	return $result;
}
public function getServiceInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_services.name,
				  z_services.detail_text,
				  z_services.link,
				  z_services.seotitle,
				  z_services.seokeywords,
				  z_services.seodescription,
				  if(CHAR_LENGTH(z_services.file_name)>3,CONCAT(
				    "/uploads/sites/",
				    z_services.siteid,
				    "/img/7_",
				    z_services.file_name
				  ),null) AS url
				FROM
				  z_services 
				WHERE z_services.languageid = '.tools::int($_SESSION['langid']).' AND z_services.itemid = '.tools::int($id).'
				');				
	if($result)
	return $result;
}
public function updateServiceInner($data){
	$db=db::init();
				if($data['image_removed']){
					if($data['image_current'])
					tools::delImg(str_replace('6_', '', $data['image_current']));
					$updatefile='file_name=NULL,';
				}
				
				if($data['image_new']){
					if($data['image_current'])
					tools::delImg(str_replace('6_', '', $data['image_current']));
					$data['image_new']=str_replace('6_', '', $data['image_new']);
					$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['image_new']."";
					if(file_exists($tempfile)){
						$data['image_new']=pathinfo($data['image_new']);
						$newfile=md5(uniqid().microtime()).'.'.$data['image_new']['extension'];
						rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
						
					}
				}
				if($data['itemid']){
					if($newfile)
					$updatefile='file_name="'.tools::str($newfile).'",';
					foreach($data['title'] as $langid=>$title){
					$db->exec('
					UPDATE z_services SET
					name="'.tools::str($title).'",
					'.$updatefile.'
					link="'.tools::str($data['link']).'",
					detail_text="'.tools::str($data['content'][$langid]).'",
					preview_text="'.tools::str($data['preview_text'][$langid]).'",
					seotitle="'.tools::str($data['seotitle'][$langid]).'",
					seokeywords="'.tools::str($data['seokeywords'][$langid]).'",
					seodescription="'.tools::str($data['seodescription'][$langid]).'"
					WHERE itemid='.tools::int($data['itemid']).'
					AND languageid='.tools::int($langid).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					}
					
				}else{
					$db->exec('INSERT INTO _items (datatypeid,siteid,userid) VALUES (12,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
					$itemid=$db->lastInsertId();
					$data['itemid']=$itemid;
					foreach($data['title'] as $langid=>$val){
						$db->exec('INSERT INTO z_services (name,languageid,itemid,link,file_name,detail_text,preview_text,siteid,userid,active) VALUES (
						"'.tools::str($val).'",'.tools::int($langid).','.$itemid.',"'.tools::str($data['link']).'","'.$newfile.'","'.$data['content'][$langid].'","'.$data['preview_text'][$langid].'",
						'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).',1)
						');
					}
				}
		return 	$data['itemid'];
				
}
}
?>