<?
require_once 'modules/base/models/Basemodel.php';

Class Event Extends Basemodel {

public function getAdminEventInner($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_event.itemid,
				  z_event.name,
				  z_event.detail_text,
				  z_event.seotitle,
				  z_event.seokeywords,
				  z_event.seodescription,
				  DATE_FORMAT(z_event.date_start,"%d.%m.%Y") AS date_start,
				  z_language.id AS languageid,
				  z_language.NAME AS languagename
				FROM
				  z_site_language 
				  INNER JOIN
				  z_language 
				  ON z_language.id = z_site_language.languageid 
				  LEFT JOIN
				  z_event 
				  ON z_event.languageid = z_language.id AND z_event.itemid='.tools::int($id).'
				WHERE z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
				');
	if($result)
	return $result;
}
public function updateEvent($data){
	$db=db::init();
	if($data['date']){
		$data['date']=explode('.', $data['date']);
		$dateCol=',date_start';
		$dateVal='"'.tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]).'",';
		$dateUpd=tools::getSqlDate($data['date'][2],$data['date'][1],$data['date'][0]);
		}
	else
		$dateUpd="NULL";
	if(!$data['itemid']){
		$db->exec('INSERT INTO _items (datatypeid,siteid,userid) VALUES (9,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
		$itemid=$db->lastInsertId();
	}
	
	foreach($data['title'] as $langid=>$title){
		if($data['itemid']>0){
			$db->exec('
			UPDATE z_event
			SET name="'.tools::str($title).'",
			detail_text="'.tools::str($data['content'][$langid]).'",
			seotitle="'.tools::str($data['seotitle'][$langid]).'",
			seokeywords="'.tools::str($data['seokeywords'][$langid]).'",
			seodescription="'.tools::str($data['seodescription'][$langid]).'",
			date_start="'.$dateUpd.'"
			WHERE itemid='.tools::int($data['itemid']).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			AND languageid='.tools::int($langid).'
			');
		}else{
			$db->exec('
			INSERT INTO z_event
			(name'.$dateCol.',detail_text,active,userid,siteid,itemid,languageid,seotitle,seokeywords,seodescription)
			VALUES 
			("'.tools::str($title).'",
			'.$dateVal.'
			"'.tools::str($data['content'][$langid]).'",
			1,'.tools::int($_SESSION['User']['id']).',
			'.tools::int($_SESSION['Site']['id']).',
			'.tools::int($itemid).',
			'.tools::int($langid).',
			"'.tools::str($data['seotitle'][$langid]).'",
			"'.tools::str($data['seokeywords'][$langid]).'",
			"'.tools::str($data['seodescription'][$langid]).'")');
		}
	}
	if($data['itemid'])
	return $data['itemid'];
	else 
	return $itemid;
}
public function getAdminEvents($q=null){
	if($q)
	$Sql.=' AND z_event.name like "%'.tools::str($q).'%" ';
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_event.name,
	  z_event.active,
	  z_event.itemid,
	  z_event.seotitle,
	  z_event.seokeywords,
	  z_event.seodescription,
	  DATE_FORMAT(z_event.date_start,"%d.%m.%Y") AS date_start
	FROM
	  z_event 
	WHERE z_event.languageid = '.tools::int($_SESSION['langid']).' 
	  AND z_event.siteid = '.tools::int($_SESSION['Site']['id']).' 
	  AND z_event.userid = '.tools::int($_SESSION['User']['id']).' 
	  '.$Sql.'
	  ORDER BY z_event.sort DESC, z_event.date_start DESC
	');
	if($result)
	return $result;
}
public function updateEvents($data){
	$db=db::init();
	$cnt=count($data['itemid']);
	foreach($data['itemid'] as $key=>$itemid){
		if($data['remove'][$key][$itemid]){
			$db->exec('
			DELETE FROM _items
			WHERE id='.tools::int($itemid).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'');
		}else{
			$db->exec('
			UPDATE z_event SET
			active='.tools::int($data['state'][$key][$itemid]).',
			sort='.$cnt.'
			WHERE itemid='.tools::int($itemid).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
			$cnt--;
		}
	}
	
}
public function getEvent($itemid){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT 
	  z_event.name,
	  z_event.active,
	  z_event.itemid,
	  z_event.detail_text,
	  z_event.seotitle,
	  z_event.seokeywords,
	  z_event.seodescription,
	  DAYOFMONTH(z_event.date_start) AS dayinmonth,
	  MONTH(z_event.date_start) AS month,
	  DATE_FORMAT(z_event.date_start,"%d.%m.%Y") AS date_start
	FROM
	  z_event 
	WHERE z_event.itemid='.tools::int($itemid).'
	  AND z_event.languageid = '.tools::int($_SESSION['langid']).' 
	  AND z_event.siteid = '.tools::int($_SESSION['Site']['id']).' 
	');
	if($result)
	return $result;
}
public function getEvents($start=0,$end=15){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_event.name,
	  z_event.active,
	  z_event.itemid,
	  z_event.detail_text,
	  DAYOFMONTH(z_event.date_start) AS dayinmonth,
	  MONTH(z_event.date_start) AS month,
	  DATE_FORMAT(z_event.date_start,"%d.%m.%Y") AS date_start
	FROM
	  z_event 
	WHERE z_event.languageid = '.tools::int($_SESSION['langid']).' 
	  AND z_event.siteid = '.tools::int($_SESSION['Site']['id']).' 
	  ORDER BY z_event.sort DESC, z_event.date_start DESC
	  LIMIT '.$start.','.$end.'
	');
	if($result)
	return $result;
}
public function getEventsCount(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
	SELECT 
	  count(distinct z_event.itemid) AS count
	FROM
	  z_event 
	WHERE z_event.languageid = '.tools::int($_SESSION['langid']).' 
	  AND z_event.siteid = '.tools::int($_SESSION['Site']['id']).'
	');
	if($result[0])
	return $result[0];
}
public function getPrevEvent($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_event.itemid,
		  z_event.name
		FROM
		  z_event 
		WHERE z_event.itemid < '.tools::int($itemid).'
		AND z_event.siteid='.tools::int($_SESSION['Site']['id']).'
		AND z_event.languageid='.tools::int($_SESSION['langid']).'
		AND z_event.active=1
		ORDER BY z_event.itemid DESC LIMIT 1
		');
		if($result)
		return $result;
	}
	public function getNextEvent($itemid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
		SELECT 
		  z_event.itemid,
          z_event.name
		FROM
		  z_event 
		WHERE z_event.itemid > '.tools::int($itemid).'
		AND z_event.siteid='.tools::int($_SESSION['Site']['id']).'
		AND z_event.languageid='.tools::int($_SESSION['langid']).'
		AND z_event.active=1
		ORDER BY z_event.itemid ASC LIMIT 1
		');
		if($result)
		return $result;
	}
}
?>