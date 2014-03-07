<?
require_once 'modules/base/models/Basemodel.php';

Class Blog Extends Basemodel {
	public function getAdminBlogs($q=null){
	if($q)
	$Sql.=' AND z_blog.name like "%'.tools::str($q).'%" ';
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_blog.name,
		  z_blog.itemid,
		  z_blog.active,
		  DATE_FORMAT(z_blog.date_start,"%d.%m.%Y") AS date_start 
		FROM
		  z_blog 
		WHERE z_blog.languageid = '.tools::int($_SESSION['langid']).' 
		AND z_blog.siteid='.tools::int($_SESSION['Site']['id']).'
		AND z_blog.userid='.tools::int($_SESSION['User']['id']).'
		'.$Sql.'
		ORDER BY z_blog.date_start desc
		');
		if($result)
		return $result;
	}
	public function getAdminBlogInner($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_blog.itemid,
					  z_blog.name,
					  z_blog.detail_text,
					  DATE_FORMAT(z_blog.date_start,"%d.%m.%Y") AS date_start,
					  z_language.id AS languageid,
					  z_language.NAME AS languagename
					FROM
					  z_site_language 
					  INNER JOIN
					  z_language 
					  ON z_language.id = z_site_language.languageid 
					  LEFT JOIN
					  z_blog 
					  ON z_blog.languageid = z_language.id AND z_blog.itemid='.tools::int($id).'
					WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
					AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
					');
		if($result)
		return $result;
	}
	public function updateBlogInner($data){
		$db=db::init();
		if($data['date']){
		$data['date']=explode('.', $data['date']);
		$dateCol=',date_start';
		$dateVal='"'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'",';
		$dateUpd=tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]);
		}
		else{
		$dateUpd="NOW()";
		$dateCol=',date_start';
		$dateVal='NOW(),';
		}
		if(!$data['itemid']){
			$db->exec('INSERT INTO _items (datatypeid,siteid,userid) VALUES (13,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
			$itemid=$db->lastInsertId();
	}
	
	foreach($data['title'] as $langid=>$title){
			if($data['itemid']>0){
				$db->exec('
				UPDATE z_blog
				SET name="'.tools::str($title).'",
				detail_text="'.tools::str($data['content'][$langid]).'",
				date_start="'.$dateUpd.'"
				WHERE itemid='.tools::int($data['itemid']).'
				AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'
				AND languageid='.tools::int($langid).'
				');
			}else{
				$db->exec('
				INSERT INTO z_blog
				(name'.$dateCol.',detail_text,active,userid,siteid,itemid,languageid)
				VALUES 
				("'.tools::str($title).'",
				'.$dateVal.'
				"'.tools::str($data['content'][$langid]).'",
				1,'.tools::int($_SESSION['User']['id']).',
				'.tools::int($_SESSION['Site']['id']).',
				'.tools::int($itemid).',
				'.tools::int($langid).')');
			}
		}
	if($data['itemid'])
	return $data['itemid'];
	else return $itemid;
	}
	public function updateBlogs($data){
		$db=db::init();
		$cnt=0;
		foreach($data['itemid'] as $key=>$itemid){
			if($data['remove'][$key][$itemid]){
				$db->exec('
				DELETE FROM _items
				WHERE id='.tools::int($itemid).'
				AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'');
			}else{
				$db->exec('
				UPDATE z_blog SET
				active='.tools::int($data['state'][$key][$itemid]).',
				sort='.$cnt.'
				WHERE itemid='.tools::int($itemid).'
				AND siteid='.tools::int($_SESSION['Site']['id']).'
				AND userid='.tools::int($_SESSION['User']['id']).'
				');
				$cnt++;
			}
		}
		
	}

	public function getBlogs($start=0,$take=10){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_blog.name,
		  z_blog.detail_text,
		  z_blog.itemid,
		  z_blog.active,
		  DATE_FORMAT(z_blog.date_start,"%d.%m.%Y") AS date_start 
		FROM
		  z_blog 
		WHERE z_blog.languageid = '.tools::int($_SESSION['langid']).' 
		AND z_blog.siteid='.tools::int($_SESSION['Site']['id']).'
		ORDER BY z_blog.date_start desc
		LIMIT '.tools::int($start).','.tools::int($take).'
		');
		if($result)
		return $result;
	}
	public function getBlogsCount(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT 
		  count(distinct z_blog.itemid) AS count
		  FROM
		  z_blog 
		WHERE z_blog.languageid = '.tools::int($_SESSION['langid']).' 
		AND z_blog.siteid='.tools::int($_SESSION['Site']['id']).'
		');
		if($result[0])
		return $result[0];
	}

	public function getBlogInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				  z_blog.itemid,
				  z_blog.name,
				  z_blog.detail_text,
				  DATE_FORMAT(z_blog.date_start,"%d.%m.%Y") AS date_start
				FROM
				  z_blog 
				WHERE z_blog.itemid='.tools::int($id).'
				AND z_blog.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_blog.languageid='.tools::int($_SESSION['langid']).'
				');
	if($result)
	return $result;
	}
	public function getPrevBlog($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_blog.itemid
		FROM
		  z_blog 
		WHERE z_blog.itemid < '.tools::int($itemid).'
		AND z_blog.siteid='.tools::int($_SESSION['Site']['id']).'
		AND z_blog.languageid='.tools::int($_SESSION['langid']).'
		AND z_blog.active=1
		ORDER BY z_blog.itemid DESC LIMIT 1
		');
		if($result)
		return $result;
	}
	public function getNextBlog($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_blog.itemid
		FROM
		  z_blog 
		WHERE z_blog.itemid > '.tools::int($itemid).'
		AND z_blog.siteid='.tools::int($_SESSION['Site']['id']).'
		AND z_blog.languageid='.tools::int($_SESSION['langid']).'
		AND z_blog.active=1
		ORDER BY z_blog.itemid ASC LIMIT 1
		');
		if($result)
		return $result;
	}
}
?>