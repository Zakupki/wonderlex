<?
require_once 'modules/base/models/Basemodel.php';

Class Basket Extends Basemodel {
    

public function addProduct($itemid){
	$db=db::init();
	if($_SESSION['User']['id']>0){
		$result=$db->queryFetchAllFirst('
					SELECT 
					id
					FROM
					  z_basket 
					WHERE userid = '.tools::int($_SESSION['User']['id']).' AND itemid='.tools::int($itemid).'
					');
		if($result[0]<1)
		$db->exec('INSERT INTO z_basket (userid,itemid) VALUES ('.tools::int($_SESSION['User']['id']).','.tools::int($itemid).')');
	}   		
}
public function removeProduct($itemid){
	$db=db::init();
	if($_SESSION['User']['id']>0 && $itemid>0){
		$db->exec('DELETE FROM z_basket WHERE userid='.tools::int($_SESSION['User']['id']).' AND itemid='.tools::int($itemid).'');
	}   		
}
public function totalProducts(){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
					SELECT 
					COUNT(DISTINCT itemid) AS count 
					FROM
					  z_basket 
					WHERE userid = '.tools::int($_SESSION['User']['id']).'
					GROUP BY userid');
	if(isset($result[0]))
    return $result[0];
}
public function totalPrice($itemid){
	$db=db::init();
	$result=$db->queryFetchAllFirst('
					SELECT 
					concat(SUM(ROUND(z_product.price * z_currency.rate,2))," ", z_currency.localname) AS price
					FROM
					  z_basket 
					INNER JOIN z_product
					ON z_product.itemid=z_basket.itemid AND z_product.languageid='.tools::int($_SESSION['langid']).'
					LEFT JOIN z_currency
				  	ON z_currency.id='.tools::int($_SESSION['curid']).'
					WHERE z_basket.userid = '.tools::int($_SESSION['User']['id']).'');
	return $result[0];
}
public function productBuyInfo($itemid){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
					SELECT 
					ROUND(z_product.price * z_currency.rate,2) AS price,
					z_product.name,
					z_product.itemid
					FROM
					  z_product
					INNER JOIN z_basket
					ON z_product.itemid=z_basket.itemid
					LEFT JOIN z_currency
				  	ON z_currency.id='.tools::int($_SESSION['curid']).'
					WHERE z_product.itemid='.tools::int($itemid).' AND z_basket.userid = '.tools::int($_SESSION['User']['id']).' AND z_product.languageid='.tools::int($_SESSION['langid']).''); 
	return $result;
}
public function getBasketProducts(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_product.id,
				  z_product.itemid,
				  z_product.name,
				  z_site_language.name as sitename,
				  ROUND(z_product.price * z_currency.rate,2) AS price,
				  z_currency.localname AS curname,
				  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
				  z_product.active,
				  z_gallery.width,
				  floor(z_gallery.height/(z_gallery.width/430)) as height,
				  CONCAT(
				    "/uploads/sites/",
				    z_gallery.siteid,
				    "/img/20_",
				    z_gallery.file_name
				  ) AS url
				FROM
				  z_product 
				  INNER JOIN z_basket
				  ON z_basket.itemid=z_product.itemid
				  INNER JOIN z_site_language
				  ON z_site_language.siteid=z_product.siteid AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
				  LEFT JOIN
				  z_gallery 
				  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
				  LEFT JOIN z_currency
				  ON z_currency.id='.tools::int($_SESSION['curid']).'
				WHERE z_basket.userid='.tools::int($_SESSION['User']['id']).' AND z_product.languageid = '.tools::int($_SESSION['langid']).' 
				ORDER BY z_basket.date_create DESC
				');
	if($result)
	return $result;
}
public function makePurchase($data){
    $db=db::init();
    $stmt=$db->prepare("INSERT INTO z_product_purchase (itemid,userid,price,countryid,cityid,address,postindex,tel,description) VALUES (?,?,?,?,?,?,?,?,?)");
    $res=$stmt->execute(array(
    $data['itemid'],
    $_SESSION['User']['id'],
    $data['price'],
    $data['country'],
    $data['city'],
    $data['address'],
    $data['index'],
    $data['tel'],
    $data['description']
    ));
    if($res){
        $stmt=$db->prepare("DELETE FROM z_basket WHERE itemid=? AND userid=?");
        $stmt->execute(array(
        $data['itemid'],
        $_SESSION['User']['id']
        ));
        $subject = "Новый заказ";
        $message = "Поступил новый заказ от пользователя ".$_SESSION['User']['email']."\n\n";
        $smtp=new smtp;
        $smtp->Connect(SMTP_HOST);
        $smtp->Hello(SMTP_HOST);
        $smtp->Authenticate('reactor@reactor-pro.ru', '123qwe123');
        $smtp->Mail('reactor@reactor-pro.ru');
        $smtp->Recipient('dmitriy.bozhok@gmail.com');
        $smtp->Data($message, $subject);
        return true;
    }
}
public function getHistory(){
    $db=db::init();
    $result=$db->queryFetchAllAssoc('
                SELECT 
                  z_product.id,
                  z_product.itemid,
                  z_product.name,
                  z_site_language.name as sitename,
                  ROUND(z_product.price * z_currency.rate,2) AS price,
                  z_currency.localname AS curname,
                  DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
                  z_product.active,
                  CONCAT(
                    "/uploads/sites/",
                    z_gallery.siteid,
                    "/img/21_",
                    z_gallery.file_name
                  ) AS url
                FROM
                  z_product 
                  INNER JOIN z_product_purchase
                  ON z_product_purchase.itemid=z_product.itemid
                  INNER JOIN z_site_language
                  ON z_site_language.siteid=z_product.siteid AND z_site_language.languageid='.tools::int($_SESSION['langid']).'
                  LEFT JOIN
                  z_gallery 
                  ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
                  LEFT JOIN z_currency
                  ON z_currency.id='.tools::int($_SESSION['curid']).'
                WHERE z_product_purchase.userid='.tools::int($_SESSION['User']['id']).' AND z_product.languageid = '.tools::int($_SESSION['langid']).' 
                ORDER BY z_product_purchase.date_create DESC
                ');
    if($result)
    return $result;
}
}
?>