<?
require_once 'modules/base/models/Basemodel.php';

Class Product Extends Basemodel {

public function getAdminCategory($catid,$q=null){
	$db=db::init();
	if($catid)
	$Sql=' AND z_category.itemid='.tools::int($catid).' ';
	if($q)
	$Sql.=' AND z_product.name like "%'.tools::str($q).'%" ';
	
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_product.id,
				  z_product.itemid,
				  z_product.name,
				  z_product.price,
				  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
				  z_product.active,
				  z_category.name AS categoryname,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/2_",
				    z_gallery.file_name
				  ) AS url 
				FROM
				  z_product 
				  LEFT JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'  AND z_category.siteid='.tools::int($_SESSION['Site']['id']).'
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_product.userid='.tools::int($_SESSION['User']['id']).'
				'.$Sql.'
				ORDER BY z_product.sort DESC, z_product.date_create DESC
				');
	if($result)
	return $result;
}
public function updateCategory($data){
	$db=db::init();
	$cnt=count($data['itemid']);
	foreach($data['itemid'] as $key=>$itemid){
		if($data['remove'][$key][$itemid]){
			$delitems[$itemid]=$itemid;
		}else{
			$db->exec('
			UPDATE z_product 
			SET active='.tools::int($data['state'][$key][$itemid]).', 
			sort='.tools::int($cnt).'
			WHERE itemid='.tools::int($itemid).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
			$cnt--;
		}
	}
	if(count($delitems)>0){
			$products=$db->queryFetchAllAssoc('
			SELECT
			CONCAT(
				    "/uploads/sites/",
				    z_product.siteid,
				    "/img/2_",
				    z_product.file_name
				  ) AS url
			FROM z_product
			WHERE z_product.itemid='.tools::int($itemid).'
			AND z_product.languageid = '.tools::int($_SESSION['langid']).' 
			AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
			AND z_product.userid='.tools::int($_SESSION['User']['id']).'
			');
			foreach($products as $data){
				tools::delImg($data['url']);
			}
			
			$result=$db->queryFetchAllAssoc('
			SELECT
			CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/2_",
				    z_gallery.file_name
				  ) AS url
			FROM z_gallery
			WHERE z_gallery.itemid='.tools::int($itemid).'
			AND z_gallery.siteid='.tools::int($_SESSION['Site']['id']).'
			AND z_gallery.userid='.tools::int($_SESSION['User']['id']).'
			');
			foreach($result as $data){
				tools::delImg($data['url']);
			}
			$db->exec('DELETE FROM _items WHERE 
			id in ('.implode(',',$delitems).')
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
	}
}
public function getAdminProduct($id){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_language.id AS languageid,
	  z_language.name AS languagename,
	  z_product.id,
	  z_product.itemid,
	  z_product.name,
	  z_product.price,
	  z_product.detail_text,
	  z_product.techinfo,
	  z_product.categoryid,
	  z_product.artgenreid as artgenre_id,
	  z_product.artstyleid AS artstyle_id,
	  z_product.arttypeid AS arttype_id,
	  z_product.favourite,
	  z_product.currencyid,
	  z_product.order,
	  z_product.seotitle,
	  z_product.seokeywords,
	  z_product.seodescription,
	  z_product.seotext,
	  CONCAT(
		"/uploads/sites/",
		z_product.siteid,
		"/img/1_",
		z_product.file_name)
		AS banner
	FROM
	  z_site_language 
	  INNER JOIN
	  z_language 
	  ON z_site_language.languageid = z_language.id 
	  LEFT JOIN
	  z_product 
	  ON z_product.languageid = z_language.id  AND z_product.itemid = '.tools::int($id).'
	  LEFT JOIN z_artgenres
	  ON z_artgenres.id=z_product.artgenreid
	  LEFT JOIN z_artstyles
	  ON z_artstyles.id=z_artgenres.artstyle_id
	  AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
	  AND z_product.userid='.tools::int($_SESSION['User']['id']).'
	WHERE z_site_language.active = 1 
	AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
	AND z_site_language.userid='.tools::int($_SESSION['User']['id']).'
	');
	$images=$db->queryFetchAllAssoc('
	SELECT 
	  z_gallery.id,
	  z_gallery.major,
	  CONCAT(
	    "/uploads/sites/",
	    z_gallery.siteid,
	    "/img/5_",
	    z_gallery.file_name
	  ) AS url,
	  CONCAT(
	    "/uploads/sites/",
	    z_gallery.siteid,
	    "/img/6_",
	    z_gallery.file_name
	  ) AS url2,
	  CONCAT(
	    "/uploads/sites/",
	    z_gallery.siteid,
	    "/img/",
	    z_gallery.file_name
	  ) AS url3  
	FROM
	  z_gallery 
	WHERE z_gallery.itemid = '.tools::int($id).'
	  AND z_gallery.siteid='.tools::int($_SESSION['Site']['id']).'
	  AND z_gallery.userid='.tools::int($_SESSION['User']['id']).'
	ORDER BY z_gallery.sort ASC, z_gallery.date_create DESC
	');
	
	return array('product'=>$result, 'images'=>$images);
}
public function getCategoryMeta($id=null){
	if($id<1)
	return;	
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_language.id AS languageid,
	  z_language.name AS languagename,
	  z_category.seotitle,
	  z_category.seodescription,
	  z_category.seotext
	FROM
	  z_category
	  INNER JOIN
	  z_language 
	  ON z_category.languageid = z_language.id 
	  INNER JOIN z_site_language
	  ON z_site_language.languageid=z_language.id
	WHERE z_site_language.active = 1 AND z_site_language.siteid='.tools::int($_SESSION['Site']['id']).'
	AND z_category.siteid='.tools::int($_SESSION['Site']['id']).'
	AND z_category.userid='.tools::int($_SESSION['User']['id']).'
	AND z_category.itemid='.tools::int($id).'
	');
	return $result;
}
public function updateProduct($data){
	$db=db::init();
	
		if($data['image_new']){
			if($data['image_current'])
			tools::delImg($data['image_current']);
			$data['image_new']=str_replace('1_', '', $data['image_new']);
			$tempfile1="".$_SERVER['DOCUMENT_ROOT'].$data['image_new']."";
			if(file_exists($tempfile1)){
				$data['image_new']=pathinfo($data['image_new']);
				$newfile1=md5(uniqid().microtime()).'.'.$data['image_new']['extension'];
				rename($tempfile1, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile1."");
				$data['file_name']=',file_name="'.tools::str($newfile1).'"';
				$file_nameCol=',file_name';
				$file_nameVal=',"'.tools::str($newfile1).'"';
			}
		}
	
	if($data['itemid']){
	    
        $this->cache=cache::init();
        $this->cache->set('w'.$_SESSION['Site']['id'].'_l'.$_SESSION['langid'].'_p'.$data['itemid'],true,false,-1);
		foreach($data['title'] as $id=>$val){
            if(!$data['arttype'])
                $data['arttype']="NULL";
            if(!$data['artstyle'])
                $data['artstyle']="NULL";
            if(!$data['artgenre'])
                $data['artgenre']="NULL";

            if(!$data['price'])
			$data['price']="NULL";
			$db->exec('
			UPDATE z_product 
			SET name="'.tools::str($val).'",
			preview=0,
			categoryid='.tools::int($data['category']).',
			artgenreid='.$data['artgenre'].',
			artstyleid='.$data['artstyle'].',
			arttypeid='.$data['arttype'].',
			price='.$data['price'].',
			detail_text="'.tools::str($data['content'][$id]).'",
			techinfo="'.tools::str($data['info'][$id]).'",
			favourite='.tools::int($data['featured']).',
			`order`='.tools::int($data['order']).',
			seotitle="'.tools::str($data['seotitle'][$id]).'",
			seokeywords="'.tools::str($data['seokeywords'][$id]).'",
			seodescription="'.tools::str($data['seodescription'][$id]).'",
			seotext="'.tools::str($data['seotext'][$id]).'",
			currencyid='.tools::int($data['currency']).'
			'.$data['file_name'].'
			WHERE languageid='.tools::int($id).'
			AND itemid='.tools::int($data['itemid']).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
		}
	}else{
		$db->exec('INSERT INTO _items (datatypeid,siteid,userid) VALUES (11,'.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).')');
		$data['itemid']=$db->lastInsertId();
		$newitemid=$data['itemid'];
		foreach($data['title'] as $id=>$val){

            if(!$data['arttype'])
                $data['arttype']="NULL";
            if(!$data['artstyle'])
                $data['artstyle']="NULL";
            if(!$data['artgenre'])
                $data['artgenre']="NULL";

			$db->exec('
			INSERT INTO z_product (name,active,categoryid,arttypeid,artstyleid,artgenreid,price,detail_text,techinfo,favourite,currencyid,itemid,siteid,userid,languageid,seotitle,seokeywords,seodescription,seotext'.$file_nameCol.')
			VALUES ("'.tools::str($val).'",1,'.tools::int($data['category']).','.$data['arttype'].','.$data['artstyle'].','.$data['artgenre'].','.tools::int($data['price']).',
			"'.tools::str($data['content'][$id]).'","'.tools::str($data['info'][$id]).'",'.tools::int($data['featured']).','.tools::int($data['currency']).',
			'.tools::int($data['itemid']).','.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).','.tools::int($id).', "'.tools::str($data['seotitle'][$id]).'", "'.tools::str($data['seokeywords'][$id]).'", "'.tools::str($data['seodescription'][$id]).'", "'.tools::str($data['seotext'][$id]).'" '.$file_nameVal.')
			');
		}
	}
	
		$db->exec('DELETE FROM z_product_author WHERE productid='.tools::int($data['itemid']).'');
		if(is_array($data['author']))
		foreach($data['author'] as $authid=>$state){
			if($authid>0 && tools::int($state)==1)
			$db->exec('INSERT INTO z_product_author (productid,authorid) VALUES ('.tools::int($data['itemid']).','.tools::int($authid).')');
		}
	
	
	$cnt=0;
	foreach($data['images_id'] as $key=>$val){
		
		if($data['images']==$key)
		$major=1;
		else
		$major=0;
		
		if($data['images_removed'][$key]){
			tools::delImg($data['images_src'][$key]);
			$db->exec('DELETE FROM z_gallery WHERE id='.$val.' AND siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).'');
		}else{
				if($val<1 && $data['images_src'][$key]){
					$data['images_src'][$key]=str_replace('5_', '', $data['images_src'][$key]);
					$tempfile="".$_SERVER['DOCUMENT_ROOT'].$data['images_src'][$key]."";
					if(file_exists($tempfile)){
						$data['images_src'][$key]=pathinfo($data['images_src'][$key]);
						$newfile=md5(uniqid().microtime()).'.'.$data['images_src'][$key]['extension'];
						
						
						rename($tempfile, "".$_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile."");
						$imagesize=null;
						$imagesize=getimagesize($_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/".$newfile);
						
						
						
						if($data['images_preview_new'][$key]){
							$this->Image=new Image;
							$this->Image->thumb($_SERVER['DOCUMENT_ROOT'].str_replace('6_', '', $data['images_preview_new'][$key]), $_SERVER['DOCUMENT_ROOT']."/uploads/sites/".tools::int($_SESSION['Site']['id'])."/img/6_".$newfile, 220, 170);
							unlink($_SERVER['DOCUMENT_ROOT'].str_replace('6_', '', $data['images_preview_new'][$key]));
						}
						$result=$db->exec('
						INSERT INTO z_gallery
						(file_name, siteid, active, userid, major, itemid, sort, height, width)
						VALUES
						("'.$newfile.'", '.tools::int($_SESSION['Site']['id']).', 1, '.tools::int($_SESSION['User']['id']).','.$major.', 
						'.tools::int($data['itemid']).', '.$cnt.', '.tools::int($imagesize[1]).', '.tools::int($imagesize[0]).')
						');
						$val['id']=$db->lastInsertId();
					}
				}
				else{
					if($val>0){
					if($data['images_preview_new'][$key])
					rename($_SERVER['DOCUMENT_ROOT'].$data['images_preview_new'][$key],$_SERVER['DOCUMENT_ROOT'].$data['images_preview'][$key]);
					
					$imagesize=null;
					$imagesize=getimagesize($_SERVER['DOCUMENT_ROOT'].$data['images_preview'][$key]);
					
					unlink($_SERVER['DOCUMENT_ROOT'].$data['images_preview_new'][$key]);
					unlink($_SERVER['DOCUMENT_ROOT'].str_replace('6_', '', $data['images_preview_new'][$key]));
					$db->exec('UPDATE z_gallery SET 
					major='.$major.', 
					sort='.$cnt.'/*,
					width='.tools::int($imagesize[0]).',
					height='.tools::int($imagesize[1]).'*/
					WHERE id='.$val.'');
					}
				}
		}
	$cnt++;	
	}
	if($data['itemid'])
	return $data['itemid'];	
}

public function updateCatalogMeta($data){
	
	if($data['categoryid']>0){
	$db=db::init();
		foreach($data['seotitle'] as $id=>$val){
			$db->exec('
			UPDATE z_category 
			SET 
			seotitle="'.tools::str($val).'",
			seodescription="'.tools::str($data['seodescription'][$id]).'",
			seotext="'.tools::str($data['seotext'][$id]).'"
			WHERE languageid='.tools::int($id).'
			AND itemid='.tools::int($data['categoryid']).'
			AND siteid='.tools::int($_SESSION['Site']['id']).'
			AND userid='.tools::int($_SESSION['User']['id']).'
			');
		}
	}
}
public function getCurrency(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  code,id 
	FROM
	  z_currency
	ORDER BY id');
	if($result)
	return $result;
}
public function getProductsCount($catid=false,$athorid=false){
	$db=db::init();
	if($catid)
	$Sql=' AND z_category.itemid='.tools::int($catid).'';
	if($athorid)
	$Join=' 
	INNER JOIN z_product_author
	ON z_product_author.productid=z_product.itemid
	AND z_product_author.authorid='.tools::int($athorid).'
	';
	
	$result=$db->queryFetchAllFirst('
				SELECT 
				  count(distinct z_product.itemid) AS COUNT
				FROM
				  z_product 
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'
				'.$Join.'
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
				'.$Sql.'
				');
	if($result[0])
	return $result[0];
}
/**
 * $start=0;
 * $take=12;
 * $catid;
 */
public function getProducts($start=0,$take=12,$catid=false,$athorid=false){
	
	$db=db::init();
	if($catid)
	$Sql=' AND z_category.itemid='.tools::int($catid).'';
	
	if($athorid)
	$Join=' 
	INNER JOIN z_product_author
	ON z_product_author.productid=z_product.itemid
	AND z_product_author.authorid='.tools::int($athorid).'
	';
	
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_product.id,
				  z_product.itemid,
				  z_product.name,
				  z_product.preview,
				  ROUND(z_product.price * z_currency.rate,2) AS price,
				  z_currency.localname AS curname,
				  z_product.detail_text,
				  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
				  z_product.active,
				  z_product.visits,
				  z_category.name AS categoryname,
				  z_category.id as cat_id,
				  z_category.seotitle,
				  z_category.seodescription,
				  z_category.seotext,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/6_",
				    z_gallery.file_name
				  ) AS url,
				  z_favourites.id AS favourite
				FROM
				  z_product 
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).' AND z_category.siteid='.tools::int($_SESSION['Site']['id']).'
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				  LEFT JOIN z_favourites
				  ON z_favourites.itemid=z_product.itemid AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
				  LEFT JOIN z_currency
				  ON z_currency.id='.tools::int($_SESSION['curid']).'
				  '.$Join.'
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
				'.$Sql.'
				ORDER BY z_product.sort DESC, z_product.date_create DESC
				LIMIT '.$start.','.$take.'
				');
				if(count($result)>0){
					foreach($result as $prod){
					$productIds[$prod['itemid']]=$prod['itemid'];
					}
					$favourites=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT id) AS count 
					FROM
					  z_favourites 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($favourites))
					foreach($favourites as $fav)
					$favArr[$fav['itemid']]=$fav['count'];
					
					$comments=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT id) AS count 
					FROM
					  z_comments 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($comments))
					foreach($comments as $com)
					$comArr[$com['itemid']]=$com['count'];
				}
	if($result)
	return array('products'=>$result,'favourites'=>$favArr,'comments'=>$comArr);
}
public function getOtherProducts($catid,$itemid){
	$db=db::init();
	if($catid)
	$Sql=' AND z_category.itemid='.tools::int($catid).'';
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_product.id,
				  z_product.itemid,
				  z_product.name,
				  z_product.preview,
				  ROUND(z_product.price / z_currency.rate,2) AS price,
				  z_currency.localname AS curname,
				  z_product.detail_text,
				  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
				  z_product.active,
				  z_product.visits,
				  z_category.name AS categoryname,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/6_",
				    z_gallery.file_name
				  ) AS url,
				  z_favourites.id AS favourite
				FROM
				  z_product 
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).' AND z_category.siteid='.tools::int($_SESSION['Site']['id']).'
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				  LEFT JOIN z_favourites
				  ON z_favourites.itemid=z_product.itemid AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
				  LEFT JOIN z_currency
				  ON z_currency.id='.tools::int($_SESSION['curid']).'
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
				'.$Sql.' AND z_product.itemid NOT IN('.tools::int($itemid).')
				ORDER BY RAND()
				LIMIT 0,4
				');
				if(count($result)>0){
					foreach($result as $prod){
					$productIds[$prod['itemid']]=$prod['itemid'];
					}
					$favourites=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT id) AS count 
					FROM
					  z_favourites 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($favourites))
					foreach($favourites as $fav)
					$favArr[$fav['itemid']]=$fav['count'];
					
					$comments=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT id) AS count 
					FROM
					  z_comments 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($comments))
					foreach($comments as $com)
					$comArr[$com['itemid']]=$com['count'];
				}
	if($result)
	return array('products'=>$result,'favourites'=>$favArr,'comments'=>$comArr);
}
public function getBannerProducts(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_product.id,
				  z_product.itemid,
				  z_product.name,
				  z_product.preview,
				  ROUND(z_product.price / z_currency.rate,2) AS price,
				  z_currency.localname AS curname,
				  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
				  z_product.active,
				  z_product.visits,
				  z_category.name AS categoryname,
				  CONCAT(
				  "/uploads/sites/",
				  z_product.siteid,
				  "/img/",
				  z_product.file_name)
				  AS banner,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/7_",
				    z_gallery.file_name
				  ) AS image,
				  z_favourites.id AS favourite
				FROM
				  z_product 
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).' AND z_category.siteid='.tools::int($_SESSION['Site']['id']).'
				  LEFT JOIN z_favourites
				  ON z_favourites.itemid=z_product.itemid AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
				  LEFT JOIN z_currency
				  ON z_currency.id='.tools::int($_SESSION['curid']).'
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_product.favourite=1
				GROUP BY z_product.id
				ORDER BY z_product.sort DESC, z_product.date_create DESC
				');
				if(count($result)>0){
					foreach($result as $prod){
					$productIds[$prod['itemid']]=$prod['itemid'];
					}
					$favourites=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT id) AS count 
					FROM
					  z_favourites 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($favourites))
					foreach($favourites as $fav)
					$favArr[$fav['itemid']]=$fav['count'];
					
					$comments=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT id) AS count 
					FROM
					  z_comments 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($comments))
					foreach($comments as $com)
					$comArr[$com['itemid']]=$com['count'];
				}
	if($result)
	return array('products'=>$result,'favourites'=>$favArr,'comments'=>$comArr);
}
public function getProductInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT 
	  z_product.id,
	  z_product.itemid,
	  z_product.name,
	  ROUND(z_product.price * z_currency.rate,2) AS price,
	  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
	  z_currency.localname AS curname,
	  z_product.detail_text,
	  z_product.techinfo,
	  z_product.categoryid,
	  z_category.name AS categoryname,
	  z_product.favourite,
	  z_product.currencyid,
	  z_product.visits,
	  z_product.order,
	  z_product.seotitle,
	  z_product.seokeywords,
	  z_product.seodescription,
	  z_product.seotext,
	  z_favourites.id AS favourite
	FROM
	  z_product 
	LEFT JOIN z_favourites
	ON z_favourites.itemid=z_product.itemid AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
	LEFT JOIN z_currency
	ON z_currency.id='.tools::int($_SESSION['curid']).'
	LEFT JOIN z_category 
	ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).' AND z_category.siteid='.tools::int($_SESSION['Site']['id']).'
	WHERE z_product.itemid = '.tools::int($id).'
	AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
	AND z_product.languageid='.tools::int($_SESSION['langid']).'
	AND z_product.active=1
	');
	$images=$db->queryFetchAllAssoc('
	SELECT 
	  z_gallery.id,
	  z_gallery.major,
	  CONCAT(
	    "/uploads/sites/",
	    z_gallery.siteid,
	    "/img/12_",
	    z_gallery.file_name
	  ) AS origimg,
	  CONCAT(
	    "/uploads/sites/",
	    z_gallery.siteid,
	    "/img/7_",
	    z_gallery.file_name
	  ) AS url,
	  CONCAT(
	    "/uploads/sites/",
	    z_gallery.siteid,
	    "/img/5_",
	    z_gallery.file_name
	  ) AS url2 
	FROM
	  z_gallery 
	WHERE z_gallery.itemid = '.tools::int($id).'
	  AND z_gallery.siteid='.tools::int($_SESSION['Site']['id']).'
	ORDER BY z_gallery.sort ASC, z_gallery.date_create DESC
	');
	$favourites=$db->queryFetchAllFirst('
					SELECT 
					COUNT(DISTINCT itemid) AS count 
					FROM
					  z_favourites 
					WHERE itemid = '.tools::int($id).'
					GROUP BY itemid');
	$comments=$db->queryFetchAllFirst('
					SELECT 
                      COUNT(id) AS COUNT
                    FROM
                      z_comments 
                    WHERE itemid = '.tools::int($id).'
                    GROUP BY itemid
					');
	
	return array('product'=>$result, 'images'=>$images, 'comments'=>$comments[0]);
}
 
 /**
 * $itemid
 * $categoryid
 **/
public function getPrevProduct($itemid,$categoryid){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT 
	  z_product.itemid,
	  z_product.name
	FROM
	  z_product 
	WHERE z_product.itemid < '.tools::int($itemid).'
	AND z_product.categoryid='.tools::int($categoryid).'
	AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
	AND z_product.languageid='.tools::int($_SESSION['langid']).'
	AND z_product.active=1
	ORDER BY z_product.itemid DESC LIMIT 1
	');
	if($result)
	return $result;
}
 
 /**
 * $itemid
 * $categoryid
 **/
public function getNextProduct($itemid,$categoryid){
    $db=db::init();
    $result=$db->queryFetchRowAssoc('
	SELECT
	  z_product.itemid,
      z_product.name
	FROM
	  z_product
	WHERE z_product.itemid > '.tools::int($itemid).'
	AND z_product.categoryid='.tools::int($categoryid).'
	AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
	AND z_product.languageid='.tools::int($_SESSION['langid']).'
	AND z_product.active=1
	ORDER BY z_product.itemid ASC LIMIT 1
	');
    if($result)
        return $result;
}
public function watchComments($itemid){
	$db=db::init();
	if($_SESSION['User']['id']==$_SESSION['Site']['userid']){
		$db->exec('DELETE FROM z_product_visit WHERE userid='.tools::int($_SESSION['User']['id']).' AND itemid='.tools::int($itemid));
		$db->exec('INSERT INTO z_product_visit (userid,itemid) VALUES ('.tools::int($_SESSION['User']['id']).','.tools::int($itemid).')');
	}
}
public function visitProduct($itemid){
	$db=db::init();
    $db->exec('
    UPDATE z_product SET visits=visits+1
    WHERE z_product.itemid ='.tools::int($itemid).'
	AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
	');
    }
}
?>