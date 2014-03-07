<?
require_once 'modules/base/models/Basemodel.php';

Class Partner Extends Basemodel {

public function getAdminPartners(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_partners.id,
				  z_partners.link,
				  z_partners.active, 
				  CONCAT(
				    "/uploads/sites/",
				    z_partners.siteid,
				    "/img/",
				    z_partners.file_name
				  ) AS url 
				FROM
				  z_partners
				WHERE z_partners.siteid='.tools::int($_SESSION['Site']['id']).'
				ORDER BY z_partners.sort ASC
				');
	if($result)
	return $result;
}
public function getPartners(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_partners.id,
				  z_partners.link,
				  z_partners.active, 
				  CONCAT(
				    "/uploads/sites/",
				    z_partners.siteid,
				    "/img/",
				    z_partners.file_name
				  ) AS url 
				FROM
				  z_partners
				WHERE z_partners.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_partners.active=1
				ORDER BY z_partners.sort ASC
				');
	if($result)
	return $result;
}
public function getUpdatePartners($data){
	unset($data['itemid'][count($data['itemid'])]);
	unset($data['itemid'][count($data['itemid'])]);
	//tools::print_r($data);
	$cnt=0;
	foreach($data['itemid'] as $key=>$val){
		$db=db::init();
		if($data['image_new'][$key][$val]){
					if($data['image_current'][$key][$val])
					tools::delImg($data['image_current'][$key][$val]);
					$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['image_new'][$key][$val]."";
					if(file_exists($tempfile)){
						$data['image_new'][$key][$val]=pathinfo($data['image_new'][$key][$val]);
						$newfile=md5(uniqid().microtime()).'.'.$data['image_new'][$key][$val]['extension'];
						rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
						
					}
		}
		if($data['remove'][$key][$val]){
			$db->exec('
			DELETE FROM z_partners
			WHERE id='.tools::int($val).' 
			AND siteid='.tools::int($_SESSION['Site']['id']).' 
			AND userid='.tools::int($_SESSION['User']['id']).'');	
		}else{
			if($val>0){
				if($newfile)
				$newfile='file_name="'.tools::str($newfile).'",';
				$db->exec('UPDATE z_partners 
				SET 
				link="'.tools::str($data['url'][$key][$val]).'",
				sort='.$cnt.',
				'.$newfile.'
				active='.$data['state'][$key][$val].'
				WHERE id='.tools::int($val).' AND siteid='.tools::int($_SESSION['Site']['id']).' 
				AND userid='.tools::int($_SESSION['User']['id']).'');
			}else{
				$db->exec('INSERT INTO z_partners (link,sort,active,siteid,userid,file_name) 
				VALUE ("'.tools::str($data['url'][$key][$val]).'",'.$cnt.','.$data['state'][$key][$val].','.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).',"'.$newfile.'"
				)');
			}
			$cnt++;
		}
	}
}
}
?>