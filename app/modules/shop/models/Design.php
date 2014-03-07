<?
require_once 'modules/base/models/Basemodel.php';

Class Design Extends Basemodel {
public function getAdminSiteDesign(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	z_site.maincolor,
	z_site.linkcolor,
	z_site.bgcolor,
	z_site.patterncolor,
	z_site.headcolor,
	z_site.eventscolor,
	z_site.edges,
	z_site.mainrows,
	z_background.major,
	z_background.type AS bgtype,
	z_background.id AS backgroundid,
	z_logo.id AS logoid,
	CONCAT("/uploads/sites/",z_logo.siteid,"/img/",z_logo.url) AS logo,
	z_watermark.id AS watermarkid,
	CONCAT("/uploads/sites/",z_watermark.siteid,"/img/",z_watermark.file_name) AS watermark,
	CONCAT("/uploads/sites/",z_background.siteid,"/img/1_",z_background.file_name) AS url1,
	CONCAT("/uploads/sites/",z_background.siteid,"/img/",z_background.file_name) AS url
	FROM z_site
	LEFT JOIN z_background
	ON z_background.siteid=z_site.id
	LEFT JOIN z_logo
	ON z_logo.siteid=z_site.id
	LEFT JOIN z_watermark
	ON z_watermark.siteid=z_site.id
	WHERE z_site.id='.tools::int($_SESSION['Site']['id']).' AND  z_site.userid='.tools::int($_SESSION['User']['id']).'');
	return $result;
}
function updateSiteDesign($data){
	$db=db::init();
	
	if(!$data['logo_id'] || $data['logo_new']!=$data['logo_current']){
		if(strlen($data['logo_new'])>0){
			if($data['logo_id']>0){
			$db->exec('DELETE FROM z_logo WHERE id='.tools::int($data['logo_id']).' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
			tools::delImg($data['logo_current']);
			}
			$templogo="".$_SERVER['DOCUMENT_ROOT'].$data['logo_new']."";
				if(file_exists($templogo)){
					$data['logo_new']=pathinfo($data['logo_new']);
					$newfile=md5(uniqid().microtime()).'.'.$data['logo_new']['extension'];
					rename($templogo, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$result=$db->exec('
					INSERT INTO z_logo
					(url, siteid, active, userid)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).')
					');
					$_SESSION['Site']['logo']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile;
				}
		}
		
	}
	if(!$data['watermark_id'] || $data['watermark_new']!=$data['watermark_current']){
			if(strlen($data['watermark_new'])>0){
				if($data['watermark_id']>0){
				$db->exec('DELETE FROM z_watermark WHERE id='.tools::int($data['watermark_id']).' AND siteid='.tools::int($_SESSION['Site']['id']).'');
				tools::delImg($data['watermark_current']);
				}
				$tempwatermark="".$_SERVER['DOCUMENT_ROOT'].$data['watermark_new']."";
					if(file_exists($tempwatermark)){
						$data['watermark_new']=pathinfo($data['watermark_new']);
						$newfile=md5(uniqid().microtime()).'.'.$data['watermark_new']['extension'];
						rename($tempwatermark, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
						$result=$db->exec('
						INSERT INTO z_watermark
						(file_name, siteid)
						VALUES
						("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).')
						');
						$_SESSION['Site']['watermark']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile;
					}
			}
			
		}
	/*$_SESSION['Site']['bgpattern']=null;
	foreach($data['bg_pattern_id'] as $key=>$val){
		if($key==0)
		continue;
		$major=0;
		if($data['bg_pattern']==$key)
		$major=1;
		
		
		
		if($data['bg_pattern_removed'][$key]){
			tools::delImg($data['bg_pattern_src'][$key]);
			$db->exec('DELETE FROM z_background WHERE id='.$val.' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
		}else{
			if($val<1){
				$data['bg_pattern_src'][$key]=str_replace('1_', '', $data['bg_pattern_src'][$key]);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['bg_pattern_src'][$key]."";
				if(file_exists($tempfile)){
					$data['bg_pattern_src'][$key]=pathinfo($data['bg_pattern_src'][$key]);
					$newfile=md5(uniqid().microtime()).'.'.$data['bg_pattern_src'][$key]['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					
					$result=$db->exec('
					INSERT INTO z_background 
					(file_name, siteid, active, userid, major, type)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).','.$major.', 1)
					');
					if($major)
					$_SESSION['Site']['bgpattern']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile;
					$val['id']=$db->lastInsertId();
				}
				
			}
			else{
				if($major)
				$_SESSION['Site']['bgpattern']=str_replace('1_', '', $data['bg_pattern_src'][$key]);
				$result=$db->exec('UPDATE z_background SET major='.$major.' WHERE id='.$val.'');
			}
		}
		
	}*/
	foreach($data['header_id'] as $key=>$val){
		
		if(tools::int($val)<1 && !$data['header_src'][$key])
		continue;
		
		if($key==0)
		continue;
		
		$major=0;
		if($data['header']==$key)
		$major=1;
		
		if($data['header_removed'][$key]){
			tools::delImg($data['header_src'][$key]);
			if($val>0)
			$db->exec('DELETE FROM z_background WHERE id='.$val.' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
		}else{
			if($val<1){
				$data['header_src'][$key]=str_replace('1_', '', $data['header_src'][$key]);
				$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['header_src'][$key]."";
				if(file_exists($tempfile)){
					$data['header_src'][$key]=pathinfo($data['header_src'][$key]);
					$newfile=md5(uniqid().microtime()).'.'.$data['header_src'][$key]['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					
					$result=$db->exec('
					INSERT INTO z_background 
					(file_name, siteid, active, userid, major, type)
					VALUES
					("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).','.$major.', 2)
					');
					if($major)
					$_SESSION['Site']['hdpattern']="/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile;
					$val['id']=$db->lastInsertId();
				}
				
			}
			else{
				if($data['header_preview_new'][$key]){
					tools::delImg($data['header_src'][$key]);
					$data['header_preview_new'][$key]=str_replace('1_', '', $data['header_preview_new'][$key]);
					$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['header_preview_new'][$key]."";
					$data['header_preview_new'][$key]=pathinfo($data['header_preview_new'][$key]);
					$newfile=md5(uniqid().microtime()).'.'.$data['header_preview_new'][$key]['extension'];
					rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
					$updatefile=', file_name="'.$newfile.'"';
					if($major)
					$_SESSION['Site']['hdpattern']=$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile;
				}else{
				if($major)
				$_SESSION['Site']['hdpattern']=str_replace('1_', '', $data['header_src'][$key]);
				}
				$result=$db->exec('UPDATE z_background SET major='.$major.''.$updatefile.' WHERE id='.$val.'');
			}
		}
	}
	if(!$data['bg_pattern'])
	$sqlStr.=" ,patterncolor=1";
	else
	$sqlStr.=" ,patterncolor=0";
	if(!$data['header']){
	$sqlStr.=" ,headercolor=1";
	$_SESSION['Site']['headercolor']=1;
	}
	else{
	$sqlStr.=" ,headercolor=0";
	$_SESSION['Site']['headercolor']=0;
	}
	
	$_SESSION['Site']['maincolor']=str_replace("#","",$data['main_color']);
	$_SESSION['Site']['linkcolor']=str_replace("#","",$data['link_color']);
	$_SESSION['Site']['bgcolor']=str_replace("#","",$data['bg_color']);
	$_SESSION['Site']['eventscolor']=str_replace("#","",$data['eventscolor']);
	$_SESSION['Site']['headcolor']=str_replace("#","",$data['headcolor']);
	$_SESSION['Site']['edges']=tools::int($data['edges']);
	$_SESSION['Site']['mainrows']=tools::int($data['mainrows']);
	$db->exec('
	UPDATE z_site SET 
	maincolor="'.tools::str(str_replace("#","",$data['main_color'])).'",
	linkcolor="'.tools::str(str_replace("#","",$data['link_color'])).'",
	bgcolor="'.tools::str(str_replace("#","",$data['bg_color'])).'",
	eventscolor="'.tools::str(str_replace("#","",$data['eventscolor'])).'",
	headcolor="'.tools::str(str_replace("#","",$data['headcolor'])).'",
	edges='.tools::int($data['edges']).',
	mainrows='.tools::int($data['mainrows']).',
	date_update=NOW()
	'.$sqlStr.'
	WHERE z_site.id='.tools::int($_SESSION['Site']['id']).' AND  z_site.userid='.tools::int($_SESSION['User']['id']).'
	');
}
public function getBanner(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT id,link,color,CONCAT("/uploads/sites/",z_banner.siteid,"/img/",z_banner.file_name) AS url,active
	FROM z_banner
	WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND active=1
	');
	if($result)
	return $result;
}
public function getAdminBanner(){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT id,link,color,CONCAT("/uploads/sites/",z_banner.siteid,"/img/",z_banner.file_name) AS url,active
	FROM z_banner
	WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'
	');
	if($result)
	return $result;
}
public function updateBanner($data){
	//tools::print_r($data);
	$db=db::init();
	if($data['image_new']){
		if($data['image_current'])
		tools::delImg($data['image_current']);
		$templogo="".$_SERVER['DOCUMENT_ROOT'].$data['image_new']."";
		$data['image_new']=pathinfo($data['image_new']);
		$newfile=md5(uniqid().microtime()).'.'.$data['image_new']['extension'];
		rename($templogo, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
		$updateFile='file_name="'.$newfile.'", ';
		$col='file_name, ';
		$val='"'.$newfile.'", ';
		
	}
	if($data['image_id']){
		$db->exec('UPDATE z_banner SET '.$updateFile.'link="'.tools::str($data['url']).'", color="'.str_replace("#","",$data['color']).'", active='.tools::int($data['active']).' WHERE id='.tools::int($data['image_id']).'');	
	}else{
		$result=$db->exec('
		INSERT INTO z_banner
		(file_name, link, color, siteid, active, userid)
		VALUES
		('.$val.'"'.tools::str($data['url']).'", "'.str_replace("#","",$data['color']).'", '.tools::int($_SESSION['Site']['id']).', '.tools::int($data['active']).', '.tools::int($_SESSION['User']['id']).')
		');
	}
}
}
?>