<?
require_once 'modules/base/models/Basemodel.php';

Class Order Extends Basemodel {
	
	
	public function getOrderList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
                      z_product_purchase.id,
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
                      ) AS url,
                      z_user.email
                    FROM
                      z_product 
                      INNER JOIN z_product_purchase
                      ON z_product_purchase.itemid=z_product.itemid
                      INNER JOIN z_user
                      ON z_user.id=z_product_purchase.userid
                      INNER JOIN z_site_language
                      ON z_site_language.siteid=z_product.siteid AND z_site_language.languageid=1
                      LEFT JOIN
                      z_gallery 
                      ON z_gallery.itemid = z_product.itemid AND z_gallery.major=1
                      LEFT JOIN z_currency
                      ON z_currency.id=1
                    WHERE z_product.languageid = 1
                    ORDER BY z_product_purchase.date_create DESC
					');
		if($result)
		return $result;	
	}
	public function getOrderInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
                      z_product_purchase.id,
                      z_product_purchase.postindex,
                      z_product_purchase.tel,
                      z_product_purchase.description,
                      z_country.name_ru as country,
                      z_city.city_name_ru as city,
                      z_product.itemid,
                      z_product.name,
                      z_site_language.name as sitename,
                      ROUND(z_product.price * z_currency.rate,2) AS price,
                      z_currency.localname AS curname,
                      DATE_FORMAT(z_product.date_create,"%d.%m.%Y") AS date_create,
                      z_product_purchase.active,
                      z_user.email
                    FROM
                      z_product 
                      INNER JOIN z_product_purchase
                      ON z_product_purchase.itemid=z_product.itemid
                      INNER JOIN z_user
                      ON z_user.id=z_product_purchase.userid
                      INNER JOIN z_site_language
                      ON z_site_language.siteid=z_product.siteid AND z_site_language.languageid=1
                      LEFT JOIN z_currency
                      ON z_currency.id=1
                      LEFT JOIN z_country
                      ON z_country.id=z_product_purchase.countryid
                      LEFT JOIN z_city
                      ON z_city.id=z_product_purchase.cityid
                    WHERE z_product_purchase.id = '.tools::int($id).' AND z_product.languageid = 1
					');
		if($result)
		return $result;
	}
	public function updateSocialInner($data,$files){
		$db=db::init();
		if($files['small_image']['tmp_name']){
			if($data['preview'] && $data['previewid']){
				$db->exec('DELETE FROM z_file WHERE id='.tools::int($data['previewid']).'');
				tools::delImg($data['preview']);
			}
			$tempFile = $files['small_image']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/social/';
			$path_parts=pathinfo($files['small_image']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			move_uploaded_file($tempFile,$targetFile);
			$db->exec('INSERT INTO z_file (subdir,file_name) VALUES ("social", "'.$newfilename.'")');
			$data['preview_image']=$db->lastInsertId();
		    $Sql.=', preview_image='.$data['preview_image'];
		}
		if($files['big_image']['tmp_name']){
			if($data['detail'] && $data['detailid']){
				$db->exec('DELETE FROM z_file WHERE id='.tools::int($data['detailid']).'');
				tools::delImg($data['detail']);
			}
			$tempFile = $files['big_image']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/social/';
			$path_parts=pathinfo($files['big_image']['name']);
			$newfilename=md5(uniqid().microtime()).".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			move_uploaded_file($tempFile,$targetFile);
			$db->exec('INSERT INTO z_file (subdir,file_name) VALUES ("social", "'.$newfilename.'")');
			$data['detail_image']=$db->lastInsertId();
			 $Sql.=', detail_image='.$data['detail_image'];
		}
		if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_social SET name="'.tools::str($data['name']).'", url="'.tools::str($data['url']).'"'.$Sql.'
 			WHERE z_social.id='.tools::int($data['id']).'');
		}
	}	
}
?>