<?
require_once 'modules/base/models/Basemodel.php';

Class Author Extends Basemodel {

public function getAdminAuthors($q=null){
	if($q)
	$Sql.=' AND z_authors.name like "%'.tools::str($q).'%" ';
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_authors.itemid,
				  z_authors.name,
				  z_authors.active, 
				   if(char_length(z_authors.file_name)>4,CONCAT(
				    "/uploads/sites/",
				    z_authors.siteid,
				    "/img/2_",
				    z_authors.file_name
				  ),null) AS url 
				FROM
				  z_authors 
				WHERE z_authors.languageid='.tools::int($_SESSION['langid']).'
				AND z_authors.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_authors.userid='.tools::int($_SESSION['User']['id']).'
				'.$Sql.'
				ORDER BY z_authors.sort
				');
	if($result)
	return $result;
}
public function getAuthorCount(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
				SELECT 
				  count(distinct z_authors.itemid) AS count
				FROM
				  z_authors 
				WHERE z_authors.languageid='.tools::int($_SESSION['langid']).'
				AND z_authors.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_authors.active=1
				');
	if($result[0])
	return $result[0];
}
public function getAuthors($start=0,$take=12){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_authors.itemid AS id,
				  z_authors.name,
				  z_authors.link,
				  z_authors.detail_text,
				  if(char_length(z_authors.file_name)>4,CONCAT(
				    "/uploads/sites/",
				    z_authors.siteid,
				    "/img/6_",
				    z_authors.file_name
				  ),null) AS url 
				FROM
				  z_authors 
				WHERE z_authors.languageid='.tools::int($_SESSION['langid']).'
				AND z_authors.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_authors.active=1
				ORDER BY z_authors.sort
				LIMIT '.$start.','.$take.'
				');
	foreach($result as $auth)
	$authidarr[$auth['id']]=$auth['id'];
	if(count($authidarr)>0)
	$result2=$db->queryFetchAllAssoc('
		 SELECT 
		  COUNT(z_product_author.`productid`) AS products,
		  z_product_author.`authorid`
		 FROM z_product_author
		 WHERE z_product_author.`authorid` IN('.implode(',',$authidarr).')
		 GROUP BY z_product_author.`authorid`
	');
	foreach($result2 as $a){
		$works[$a['authorid']]=$a['products'];
	}
	
	if($result)
	return array('authors'=>$result, 'works'=>$works);
}
public function updateAuthors($data){
	$db=db::init();
	$cnt=0;
	foreach($data['itemid'] as $key=>$itemid){
		
		if($data['remove'][$key][$itemid]){
			$result=$db->queryFetchRowAssoc('
			SELECT if(CHAR_LENGTH(z_authors.file_name)>3,CONCAT(
				    "/uploads/sites/",
				    z_authors.siteid,
				    "/img/1_",
				    z_authors.file_name
				  ),"") AS url
			FROM z_authors
			WHERE itemid='.tools::int($itemid).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
			if($result['url'])
			tools::delImg($result['url']);
			$dellidArr[$itemid]=$itemid;
		}
		
		$db->exec('UPDATE z_authors SET 
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

public function getAdminAuthorInner($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_authors.itemid,
				  z_authors.name,
				  z_authors.detail_text,
				  z_authors.link,
				  z_authors.facebook,
				  z_authors.twitter,
				  z_authors.vkontakte,
				  z_authors.instagram,
				  z_language.id AS languageid,
				  z_language.NAME AS languagename,
				  z_authors.file_name,
				  if(CHAR_LENGTH(z_authors.file_name)>3,CONCAT(
				    "/uploads/sites/",
				    z_authors.siteid,
				    "/img/6_",
				    z_authors.file_name
				  ),null) AS url 
				FROM
				  z_site_language 
				  INNER JOIN
				  z_language 
				  ON z_language.id = z_site_language.languageid 
				  LEFT JOIN
				  z_authors 
				  ON z_authors.languageid = z_language.id AND z_authors.itemid='.tools::int($id).'
				WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
				');
	return $result;
}
public function getAuthorInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  COUNT(z_product_author.`productid`) AS products,
				  z_authors.name,
				  z_authors.itemid,
				  z_authors.detail_text,
				  z_authors.link,
				  if(CHAR_LENGTH(z_authors.file_name)>3,CONCAT(
				    "/uploads/sites/",
				    z_authors.siteid,
				    "/img/7_",
				    z_authors.file_name
				  ),"") AS url,
				  z_authors.facebook,
				  z_authors.twitter,
				  z_authors.vkontakte,
				  z_authors.instagram
				FROM
				  z_authors 
				LEFT JOIN z_product_author
				ON z_product_author.`authorid`=z_authors.`itemid`
				WHERE z_authors.languageid = '.tools::int($_SESSION['langid']).' AND z_authors.itemid = '.tools::int($id).'
				GROUP BY z_authors.`itemid`
				');				
	if($result)
	return $result;
}
public function updateAuthorInner($data){
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
					foreach($data['name'] as $langid=>$title){
					$db->exec('
					UPDATE z_authors SET
					name="'.tools::str($title).'",
					'.$updatefile.'
					link="'.tools::str($data['link']).'",
					detail_text="'.tools::str($data['content'][$langid]).'",
					facebook="'.tools::str($data['facebook']).'",
					twitter="'.tools::str($data['twitter']).'",
					vkontakte="'.tools::str($data['vkontakte']).'",
					instagram="'.tools::str($data['instagram']).'"
					WHERE itemid='.tools::int($data['itemid']).'
					AND languageid='.tools::int($langid).'
					AND siteid='.tools::int($_SESSION['Site']['id']).'
					AND userid='.tools::int($_SESSION['User']['id']).'
					');
					
					}
					
				}else{
					$db->exec('INSERT INTO _items (datatypeid,siteid,userid) VALUES (14,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
					$itemid=$db->lastInsertId();
					$data['itemid']=$itemid;
					foreach($data['name'] as $langid=>$val){
						$db->exec('INSERT INTO z_authors (name,languageid,itemid,link,file_name,detail_text,siteid,userid,active) VALUES (
						"'.tools::str($val).'",'.tools::int($langid).','.$itemid.',"'.tools::str($data['link']).'","'.$newfile.'","'.$data['content'][$langid].'",
						'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).',1)
						');
					}
				}
				
				return $data['itemid'];
				
				
}
	public function getProductAuthors($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_authors.itemid,
				  z_authors.name,
				  z_product_author.productid
				FROM
				  z_authors 
				LEFT JOIN z_product_author
				ON z_product_author.authorid=z_authors.itemid AND z_product_author.productid='.tools::int($id).'
				WHERE z_authors.languageid='.tools::int($_SESSION['langid']).'
				AND z_authors.siteid='.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_authors.sort
				');
		if($result)
		return $result;
	}
}
?>