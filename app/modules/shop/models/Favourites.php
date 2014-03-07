<?
require_once 'modules/base/models/Basemodel.php';

Class Favourites Extends Basemodel {

public function addToFavourites($data){
	$db=db::init();
	if($data['state']=='true'){
		$db->exec('INSERT INTO z_favourites 
		(siteid,userid,itemid) VALUES ('.tools::int($_SESSION['Site']['id']).','.tools::int($_SESSION['User']['id']).','.tools::int($data['itemid']).')');
		return $db->lastInsertId();
	}else{
		$db->exec('
		DELETE FROM z_favourites
		WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND userid='.tools::int($_SESSION['User']['id']).' AND itemid='.tools::int($data['itemid']).'
		');
		return true;
	}
	
}
public function getFavCount(){
	if(tools::int($_SESSION['User']['id'])>0 && tools::int($_SESSION['Site']['userid'])!=tools::int($_SESSION['User']['id'])){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT 
		  COUNT(DISTINCT itemid) 
		FROM
		  z_favourites 
		WHERE siteid = '.tools::int($_SESSION['Site']['id']).' 
		  AND userid = '.tools::int($_SESSION['User']['id']).' 
		');
		return $result[0];
	}
}
public function getUserFavouritesCount(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
				SELECT 
				  count(distinct z_product.itemid) AS COUNT
				FROM
				  z_product 
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'
				  INNER JOIN z_favourites
				  ON z_favourites.itemid=z_product.itemid
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
				');
	if($result[0])
	return $result[0];
}
public function getUserFavourites($start=0,$take=12,$catid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_product.id,
				  z_product.itemid,
				  z_product.name,
				  ROUND(z_product.price / z_currency.rate,2) AS price,
				  z_currency.localname AS curname,
				  z_product.detail_text,
				  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
				  z_product.active,
				  z_category.name AS categoryname,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/3_",
				    z_gallery.file_name
				  ) AS url,
				  z_favourites.id AS favourite
				FROM
				  z_product 
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				  INNER JOIN z_favourites
				  ON z_favourites.itemid=z_product.itemid
				  LEFT JOIN z_currency
				  ON z_currency.id='.tools::int($_SESSION['curid']).'
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.siteid='.tools::int($_SESSION['Site']['id']).'
				AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
				ORDER BY z_product.sort 
				LIMIT '.$start.','.$take.'
				');
				if(count($result)>0){
					foreach($result as $prod){
					$productIds[$prod['itemid']]=$prod['itemid'];
					}
					$favourites=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT itemid) AS count 
					FROM
					  z_favourites 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($favourites))
					foreach($favourites as $fav)
					$favArr[$fav['itemid']]=$fav['count'];
				}
	if($result)
	return array('products'=>$result,'favourites'=>$favArr);
}
public function getProductFavourites($itemid){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_user.firstName,
	  z_user.familyName,
	  z_user.id 
	FROM
	  z_favourites 
	  INNER JOIN
	  z_user 
	  ON z_user.id = z_favourites.userid 
	WHERE itemid = '.tools::int($itemid).'
	');
	if($result)
	return $result;
}
public function sendMessage($data){
	$db=db::init();
	$result=$db->queryFetchAllFirst
	('SELECT email FROM z_user WHERE id='.tools::int($data['userid']).'');
		
		$smtp=new smtp;
		$smtp->Connect(SMTP_HOST);
		$smtp->Hello(SMTP_HOST);
		$smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
		$smtp->Mail('reactor@reactor-pro.ru');
		$smtp->Recipient($result[0]);
		$smtp->Data(tools::str($data['message']), tools::str($data['message']));
	
}
public function getAdminFavourites(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
	SELECT 
	  z_user.firstName,
	  z_user.familyName,
	  z_user.id,
	  z_product.name
	FROM
	  z_favourites 
	  INNER JOIN
	  z_user 
	  ON z_user.id = z_favourites.userid 
	  INNER JOIN z_product
	  ON z_product.itemid=z_favourites.itemid AND z_product.languageid='.tools::int($_SESSION['langid']).'
	WHERE z_favourites.siteid='.tools::int($_SESSION['Site']['id']).'
	ORDER BY z_favourites.date_create DESC
	');
	if($result)
	return $result;
}

}
?>