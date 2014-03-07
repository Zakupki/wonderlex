<?
require_once 'modules/base/models/Basemodel.php';

Class Catalog Extends Basemodel {

    public $list;
    public $registry;
    private $no_cache;
    
    public function __construct($registry){
        $this->registry=$registry;
    }
public function getProductsCount($params=array()){
	$db=db::init();
	if($params['siteid'])
	$Sql=' AND z_product.siteid='.tools::int($params['siteid']).'';
	$result=$db->queryFetchAllFirst('
				SELECT 
				  count(distinct z_product.itemid) AS COUNT
				FROM
				  z_product 
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'
				  INNER JOIN z_site
				  ON z_site.id=z_product.siteid AND z_site.promo=1
				'.$Join.'
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).'
				'.$Sql.'
				');
	if($result[0])
	return $result[0];
}

public function getProductGallery(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				id,
				CONCAT(
				   "/uploads/sites/",
				   z_gallery.siteid,
				   "/img/",
				   z_gallery.file_name
				) AS url
				FROM z_gallery
				');
				
	if($result)
	return $result;
}
/**
 * $start=0;
 * $take=12;
 * $catid;
 */
public function getProducts($params=array('start'=>0,'take'=>12, 'q'=>null)){
	$db=db::init();
	
    if(!$params['start'])
    $params['start']=0;
    if(!$params['take'])
    $params['take']=12;
    
    if(strlen($params['q'])>0)
    $Sql.=' AND z_product.name like "%'.tools::str($params['q']).'%"';
    
    if($params['yearStart']>0 && $params['yearFinish']>0){
    $Sql.=' AND DATE_FORMAT(z_product.date_create,"%Y") >='.$params['yearStart'].' AND DATE_FORMAT(z_product.date_create,"%Y") <='.$params['yearFinish'].'';    
    }
    if($params['priceStart']>0 && $params['priceFinish']>0){
    $Sql.=' AND z_product.price >='.$params['priceStart'].' AND z_product.price <='.$params['priceFinish'].'';    
    }

    if($params['viewId']>0 || $params['styleId'] || $params['genreId']){
        $Join.='
        LEFT JOIN z_artgenres
          ON z_artgenres.id=z_product.artgenreid
        LEFT JOIN z_artstyles
          ON z_artstyles.id=z_artgenres.artstyle_id
        ';
        if($params['genreId']>0){
            $Sql.=' AND z_product.artgenreid ='.$params['genreId'].' ';
        }
        if($params['styleId']>0){
            $Sql.=' AND z_product.artstyleid ='.$params['styleId'].' ';
        }
        if($params['viewId']>0){
            $Sql.=' AND z_product.arttypeid ='.$params['viewId'].' ';
        }
    }
    
	if($params['siteid'])
	$Sql.=' AND z_product.siteid='.tools::int($params['siteid']).'';
	if($params['categoryid'])
	$Sql.=' AND z_category.itemid='.tools::int($params['categoryid']).'';
	
    if($params['catalogType']=='with-price'){
    $Sql.=' AND z_product.price > 0';     
    }
    if($params['catalogType']=='without-price'){
    $Sql.=' AND z_product.price < 1';     
    }
   
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_product.id,
				  z_product.itemid,
				  z_product.name,
				  z_product.preview,
				  z_site_language.name as sitename,
				  ROUND(z_product.price * z_currency.rate,2) AS price,
				  z_currency.localname AS curname,
				  z_product.detail_text,
				  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
				  z_product.active,
				  z_product.visits,
				  z_category.name AS categoryname,
				  z_gallery.width,
				  floor(z_gallery.height/(z_gallery.width/430)) as height,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/13_",
				    z_gallery.file_name
				  ) AS url,
				  z_favourites.id AS favourite
				FROM
				  z_product 
				  INNER JOIN z_site_language
				  ON z_site_language.siteid=z_product.siteid AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
				  INNER JOIN z_site
                  ON z_site.id=z_product.siteid AND z_site.promo=1
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				  LEFT JOIN z_favourites
				  ON z_favourites.itemid=z_product.itemid AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
				  LEFT JOIN z_currency
				  ON z_currency.id='.tools::int($_SESSION['curid']).'
				  '.$Join.'
				WHERE z_site.active=1 AND z_product.languageid = '.tools::int($_SESSION['langid']).'
				'.$Sql.'
				ORDER BY z_product.sort DESC, z_product.date_create DESC
				LIMIT '.$params['start'].','.$params['take'].'
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
					
					$comments=$db->queryFetchAllAssoc('
					SELECT 
					  itemid,
					  COUNT(DISTINCT itemid) AS count 
					FROM
					  z_comments 
					WHERE itemid IN('.implode(',',$productIds).')
					GROUP BY itemid');
					if(is_array($comments))
					foreach($comments as $com)
					$comArr[$com['itemid']]=$com['count'];
					
				}
	if($result)
	$this->list=$result;	
	return array('products'=>$result,'favourites'=>$favArr,'comments'=>$comArr);
}

public function getProductsToJson($params=array()){
    
    
    $oldtake=$params['take'];
    if($params['start']>0)
    $params['take']++; 
    $products=self::getProducts($params);
	 if(count($products['products'])==$params['take'] && count($products['products'])>$oldtake){
        $mode='more';
        array_pop($products['products']);
    }else
        $mode='finish';
    //echo count($products);
	$json_data = '{
        "mode": "'.$mode.'",
        "items" : [
            ';
	$cnt=0;
	foreach($products['products'] as $product){
   $jsondataData=null;	    
   
   $jsondataData.='{
            "painter": 
            {
                "name": '.tools::toJSONInternal($product['sitename']).',
                "href": "'.$this->registry->langurl.'/product/'.$product['itemid'].'/"
            },
            "image": {
                "id": "'.$product['id'].'",
                "url": "'.$product['url'].'",
                "href": "'.$this->registry->langurl.'/product/'.$product['itemid'].'/",
                "pictureName": '.tools::toJSONInternal($product['name']).'';
   if($product['price']>0)
   $jsondataData.=',
                "price": "'.$product['price'].' '.$product['curname'].'"';
   elseif($product['price']<1 || $_SESSION['User']['id']<1)
   $jsondataData.= ',
                       "withoutCart": "1"';
   $jsondataData.= ',
                       "withoutAuction": "1"
                   },
            "auction_href": "#",
            "cart_href": "'.$this->registry->langurl.'/basket/?id='.$product['id'].'"
        }';


    
    $jsondataArr[]=$jsondataData;
	}
	$json_data .=implode(',',$jsondataArr);
	$json_data .= ']
    }';
	
	//$json_data = str_replace("\r\n",'',$json_data);
    //$json_data = str_replace("\n",'',$json_data);
    //$json_data = preg_replace('/\s+/', ' ',$json_data);
	//$json_data=tools::toJson($json_data);
    
	echo $json_data;
	exit;
	
}
public function getOtherProductsToJson($params){
	$oldtake=$params['take'];
    if($params['start']>0)
    $params['take']++; 
	$products=self::getOtherProducts($params);
	if(count($products)==$params['take'] && count($products)>$oldtake){
        $mode='more';
        array_pop($products);
    }else
        $mode='finish';
	$json_data = '{
        "mode": "'.$mode.'",
        "items" : [
            ';
	$cnt=0;
	foreach($products as $product){
	$jsondataData=null;        
    $jsondataData.= '
    		{
                "painter": {
                    "name": "'.$product['sitename'].'",
                    "href": "/product/'.$product['itemid'].'/"
                },
                "image": {
                    "id": "'.$product['id'].'",
                    "url": "'.$product['url'].'",
                    "href":"/product/'.$product['itemid'].'/",
                    "pictureName": "'.$product['sitename'].'"';
	if($product['price']>0)
	$jsondataData.= ',
                    "price": "'.$product['price'].' '.$product['curname'].'"';
	elseif($product['price']<1 || $_SESSION['User']['id']<1)
	$jsondataData.= ',
                    "withoutCart": "1"';
	$jsondataData.= ',
					"withoutAuction": "1"
                },
				"auction_href": "#",
				"cart_href": "/basket/?id='.$product['id'].'"
            }';
        
    $jsondataArr[]=$jsondataData;
	}
	$json_data .=implode(',',$jsondataArr);
	$json_data .= ']
    }';
	
	$json_data = str_replace("\r\n",'',$json_data);
	$json_data = str_replace("\n",'',$json_data);
    
	echo $json_data;
	exit;
	
}
public function getOtherProducts($params=array('start'=>0,'take'=>12)){
    $db=db::init();
    if(!$params['start'])
    $params['start']=0;
    if(!$params['take'])
    $params['take']=12;
	
	if($params['categoryid'])
    $Sql=' AND z_category.itemid='.tools::int($params['categoryid']).'';
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
				  z_gallery.width,
				  floor(z_gallery.height/(z_gallery.width/200)) as height,
				  z_category.name AS categoryname,
				   IF(
			    z_domain.id > 0,
			    z_domain.NAME,
			    CONCAT("w",z_site_language.siteid, ".wonderlex.com")
			  ) AS domain,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/16_",
				    z_gallery.file_name
				  ) AS url,
				  z_favourites.id AS favourite,
				  z_site_language.name as sitename
				FROM
				  z_product 
				  INNER JOIN z_site_language
				  ON z_site_language.siteid=z_product.siteid AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
				  INNER JOIN
				  z_category 
				  ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'
				  LEFT JOIN
    			  z_domain
    			  ON z_domain.siteid = z_site_language.siteid
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				  LEFT JOIN z_favourites
				  ON z_favourites.itemid=z_product.itemid AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
				  LEFT JOIN z_currency
				  ON z_currency.id='.tools::int($_SESSION['curid']).'
				WHERE z_product.languageid = '.tools::int($_SESSION['langid']).' 
				AND z_product.itemid NOT IN('.tools::int($itemid).')
				'.$Sql.'
				ORDER BY RAND()
				LIMIT '.tools::int($params['start']).','.tools::int($params['take']).'
				');
				
			
	if($result)
	return $result;
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
					  COUNT(DISTINCT itemid) AS count 
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
					  COUNT(DISTINCT itemid) AS count 
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
    if($_SESSION['User']['id']>0){
    $join.='
            LEFT JOIN z_rate
            ON z_rate.itemid=z_product.itemid AND z_rate.userid='.tools::int($_SESSION['User']['id']).'';
    $select.=',
      z_rate.rate as rate';
    }
	$result=$db->queryFetchRowAssoc('
	SELECT 
	  z_product.id,
	  z_product.itemid,
	  z_product.name,
	  z_site_language.name AS sitename,
	  z_site_language.siteid,
	  CONCAT(
      	"/uploads/sites/",
        z_site.id,
        "/19_",
        z_site.author_image
      ) AS author_image,
      IF(
		    z_domain.id > 0,
		    z_domain.NAME,
		    CONCAT("w",z_site_language.siteid, ".wonderlex.com")
		  ) AS domain,
	  ROUND(z_product.price * z_currency.rate,2) AS price,
	  DATE_FORMAT(z_product.date_create,"%Y") AS date_create,
	  z_currency.localname AS curname,
	  z_product.detail_text,
	  z_product.techinfo,
	  z_product.categoryid,
	  z_category.name AS categoryname,
	  z_product.favourite,
	  z_product.currencyid,
	  z_product.visits,
	  z_product.order,
	  z_favourites.id AS favourite
      '.$select.'
	FROM
	  z_product 
	INNER JOIN z_site_language
	ON z_site_language.siteid=z_product.siteid AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
	INNER JOIN z_site
	ON z_site.id=z_product.siteid	
	LEFT JOIN
    z_domain
    ON z_domain.siteid = z_site_language.siteid
	LEFT JOIN z_favourites
	ON z_favourites.itemid=z_product.itemid AND z_favourites.userid='.tools::int($_SESSION['User']['id']).'
	'.$join.'
	LEFT JOIN z_currency
	ON z_currency.id='.tools::int($_SESSION['curid']).'
	LEFT JOIN z_category 
	ON z_category.itemid = z_product.categoryid AND z_category.languageid='.tools::int($_SESSION['langid']).'
	WHERE z_site.active=1 AND z_product.itemid = '.tools::int($id).'
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
	    "/img/15_",
	    z_gallery.file_name
	  ) AS origimg,
	  CONCAT(
	    "/uploads/sites/",
	    z_gallery.siteid,
	    "/img/14_",
	    z_gallery.file_name
	  ) AS url
	FROM
	  z_gallery 
	WHERE z_gallery.itemid = '.tools::int($id).'
	ORDER BY z_gallery.sort ASC, z_gallery.date_create DESC
	');
	$likes=$db->queryFetchAllFirst('
					SELECT 
					COUNT(DISTINCT itemid) AS count 
					FROM
					  z_rate 
					WHERE itemid = '.tools::int($id).'
					GROUP BY itemid');
	$comments=$db->queryFetchAllFirst('
					SELECT 
					COUNT(DISTINCT id) AS count 
					FROM
					  z_comments 
					WHERE itemid = '.tools::int($id).'
					GROUP BY itemid');
	
	return array('product'=>$result, 'images'=>$images, 'comments'=>$comments[0], 'likes'=>$likes[0]);
}
 
 /**
 * $itemid
 * $categoryid
 **/
public function getPrevProduct($itemid,$categoryid){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
	SELECT 
	  z_product.itemid
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
	  z_product.itemid
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
public function rateProduct($id){
	$db=db::init();
	if($_SESSION['User']['id']>0){
	    $data=$db->exec('
	    INSERT INTO z_rate (itemid,userid,rate) VALUES ('.tools::int($id).','.$_SESSION['User']['id'].',1)');
		if($data)
			$data=$db->queryFetchRowAssoc('SELECT COUNT(itemid) AS cnt from z_rate where itemid='.tools::int($id).' AND userid='.$_SESSION['User']['id'].' group by itemid');
			if($data['cnt']>0)
			return $data['cnt'];
	}
}
}
?>