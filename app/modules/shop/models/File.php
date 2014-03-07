<?
require_once 'modules/base/models/Basemodel.php';

Class File Extends Basemodel {

public function addUpload($filename){
	$db=db::init();
	$db->exec('INSERT INTO z_uploads
	(file_name,siteid,userid) VALUES ("'.tools::str($filename).'",'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
}
public function getUploads(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT
	z_uploads.id,
	CONCAT(
		"/uploads/sites/",
		z_uploads.siteid,
		"/img/",
		z_uploads.file_name
		) AS image,
	CONCAT(
		"/uploads/sites/",
		z_uploads.siteid,
		"/img/5_",
		z_uploads.file_name
		) AS thumb
	FROM z_uploads
	WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
	');
	if($result)
	return $result;
}
public function removeUpload($data){
	$db=db::init();
	if($db->exec('DELETE FROM z_uploads 
	WHERE siteid='.tools::int($_SESSION['Site']['id']).' 
	AND userid='.tools::int($_SESSION['User']['id']).' 
	AND id='.tools::int($data['id']).'')){
		tools::delImg($data['src']);
		
	}
}
}
?>