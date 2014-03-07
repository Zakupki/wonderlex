<?php

require_once 'modules/base/controllers/Base_Controller.php';

Class Test_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
		}

        function indexAction() {
            header("Location: /");
        }
		function countryAction() {
			
			 $db=db::init(); 
			 /*
			
						$sitedata=$db->queryFetchAllAssoc('SELECT 
						 country_.`id`,
						 country_.`oid`,
						 country_.`country_name_ru`,
						 country_.`country_name_en`,
						 z_country2.`id` AS oldid,
						 z_country2.`name_ru`,
						 z_country2.`name_en`,
						 z_country2.`code`
						FROM country_
						INNER JOIN z_country2
						ON country_.`country_name_en`=z_country2.`name_en`
						');
						tools::print_r($sitedata);
						foreach($sitedata as $site){
						$db->exec('UPDATE z_country2 set newid='.$site['id'].' WHERE  `name_en`="'.$site['country_name_en'].'"');	
						}*/
			/*
			$sitedata=$db->queryFetchAllAssoc('
						SELECT 
						z_site.id,
						z_site.countryid,
						z_country2.newid
						FROM 
						z_site 
						INNER JOIN z_country2
						ON z_country2.id=z_site.countryid 
						WHERE z_site.countryid>0');
						foreach($sitedata as $site){
							$db->exec('UPDATE z_site SET countryid='.$site['newid'].' WHERE id='.$site['id'].'');
						}*/
			
		}
		
		 function addmenuAction() {
		 	die();
		 	$db=db::init();
        	$sitedata=$db->queryFetchAllAssoc('SELECT id,userid FROM z_site where id not in(1)');
			foreach($sitedata as $site){
				echo $site['id'];
				echo"<br>";
				echo $site['userid'];
				echo"<br>";
				echo"<br>";
				$itemid=null;
				$db->exec('INSERT INTO _items (siteid,userid,datatypeid) VALUES ('.$site['id'].','.$site['userid'].',1)');
				$itemid=$db->lastInsertId();
				$db->exec('INSERT INTO z_menu (itemid,name,active,languageid,menutypeid,sort,siteid,userid)
				VALUES
				('.$itemid.',"Авторы",1,1,7,8,'.$site['id'].','.$site['userid'].')');
				$db->exec('INSERT INTO z_menu (itemid,name,active,languageid,menutypeid,sort,siteid,userid)
				VALUES
				('.$itemid.',"Authors",1,2,7,8,'.$site['id'].','.$site['userid'].')');
			}
			//tools::print_r($sitedata);
        }
		 function createshopAction() {
		 	$db=db::init();
		 	if($_GET['password']=="123qwe" && $_GET['userid']>0 || $_GET['email'])
			echo 'pass ok';
			else
			die('no pass');
			
			if($_GET['userid']>0){
			$userid=$_GET['userid'];
			}
			elseif($_GET['email']) {
				$db->exec('insert into z_user (login,password,firstName,email,activation) VALUES ("'.tools::str(strstr($_GET['email'], '@', true)).'","1cd803e2056d145af0e94dae20538b2e","'.tools::str(strstr($_GET['email'], '@', true)).'","'.$_GET['email'].'",1)');
				$userid=$db->lastInsertId();
				$db->exec('INSERT into z_usertype_user (userid,usertypeid) values ('.$userid.',2)');
			}	
			
			if($userid<1)
			die('no userid');
		 	$templateid=109;
		 	
			
			$result=$db->queryFetchRowAssoc('
			CALL addsite(3,'.$userid.')
			');
			$siteid=$result['siteid'];
			if($siteid<1)
			die('no id');
			echo $siteid;
			mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/');
			mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/img/');
			
			#Настройки сайта
			$sitedata=$db->queryFetchRowAssoc('SELECT * FROM z_site WHERE z_site.id='.$templateid.'');
			$db->exec('
			UPDATE z_site 
			SET 
			maincolor="'.$sitedata['maincolor'].'", 
			linkcolor="'.$sitedata['linkcolor'].'", 
			bgcolor="'.$sitedata['bgcolor'].'",
			patterncolor='.$sitedata['patterncolor'].', 
			headercolor='.$sitedata['headercolor'].', 
			phone="'.$sitedata['phone'].'", 
			eventscolor="'.$sitedata['eventscolor'].'"
			WHERE z_site.id='.$siteid.'
			');
			#Копирование лого
			$sitelogo=$db->queryFetchRowAssoc('
				SELECT
				CONCAT(
				"/uploads/sites/",
				z_logo.siteid,
				"/img/",
				z_logo.url)
				AS logo 
				FROM z_logo
				WHERE z_logo.siteid='.$templateid.'');
			
			if($sitelogo['logo']){
						$sourcefile0=$_SERVER['DOCUMENT_ROOT'].$sitelogo['logo'];
						$sitelogo['logo']=pathinfo($sitelogo['logo']);
						$newfile0=md5(uniqid().microtime()).'.'.$sitelogo['logo']['extension'];
						copy($sourcefile0,$_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/img/'.$newfile0);
						
						$db->exec('
						INSERT INTO z_logo
						(siteid,userid,url,active) VALUES (
						'.$siteid.','.$userid.', "'.$newfile0.'",1)');
			}
			
			#Копирование баннера
			$sitebanner=$db->queryFetchRowAssoc('
				SELECT
				CONCAT(
				"/uploads/sites/",
				z_banner.siteid,
				"/img/",
				z_banner.file_name)
				AS banner,
				z_banner.color,
				z_banner.link
				FROM z_banner
				WHERE z_banner.siteid='.$templateid.'');
			
			if($sitebanner['banner']){
						$sourcefile0=$_SERVER['DOCUMENT_ROOT'].$sitebanner['banner'];
						$sitebanner['banner']=pathinfo($sitebanner['banner']);
						$newfile0=md5(uniqid().microtime()).'.'.$sitebanner['banner']['extension'];
						copy($sourcefile0,$_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/img/'.$newfile0);
						
						$db->exec('
						INSERT INTO z_banner
						(siteid,userid,file_name,active,color,link) VALUES (
						'.$siteid.','.$userid.', "'.$newfile0.'",1,"'.$sitebanner['color'].'","'.$sitebanner['link'].'")');
			}
			
			
			
			#Добавление категории
			$catdata=$db->queryFetchAllAssoc('
			SELECT 
			  z_category.id,
			  z_category.itemid,
			  z_category.languageid,
			  z_category.name,
			  z_category.sort,
			  z_category.code,
			  z_category.active,
			  _items.datatypeid,
			 z_product.id AS p_id,
			 z_product.itemid AS p_itemid,
			 z_product.languageid AS p_languageid,
			 z_product.name AS p_name,
			 z_product.detail_text AS p_detail_text,
			 z_product.price AS p_price,
			 z_product.active AS p_active,
			 z_product.sort AS p_sort,
			 z_product.techinfo AS p_techinfo,
			 z_product.favourite AS p_favourite,
			 z_product.file_name AS p_file_name,
			 z_product.categoryid AS p_categoryid,
			 z_product.file_name AS p_file_name,
			 CONCAT(
				"/uploads/sites/",
				z_product.siteid,
				"/img/",
				z_product.file_name)
				AS p_banner
			FROM
			  z_category 
			  LEFT JOIN
			  _items 
			  ON _items.id = z_category.itemid 
			  LEFT JOIN
			  z_product 
			  ON z_product.categoryid = z_category.itemid 
			WHERE z_category.siteid = '.$templateid.' 
			');
			foreach($catdata as $ckey=>$cat){
				$catArr[$cat['itemid']]['category'][$cat['id']]=$cat;
				$catArr[$cat['itemid']]['products'][$cat['p_itemid']][$cat['p_id']]=$cat;
			}
			foreach($catArr as $catk=>$catv){
				$db->exec('
				INSERT INTO _items
				(datatypeid,siteid,userid) VALUES 
				(1,'.$siteid.','.$userid.')
				');
				$newcatitem=$db->lastInsertId();
				foreach($catv['category'] as $catid=>$vcat){
					$db->exec('
					INSERT INTO z_category
					(name,code,languageid,itemid,siteid,userid,active,sort)
					VALUES
					("'.$vcat['name'].'","'.$vcat['code'].'",'.$vcat['languageid'].','.$newcatitem.','.$siteid.','.$userid.','.$vcat['active'].','.$vcat['sort'].')');	
				}
				foreach($catv['products'] AS $p_itemid){
					$db->exec('
					INSERT INTO _items
					(datatypeid,siteid,userid) VALUES 
					(11,'.$siteid.','.$userid.')
					');
					$newproditem=$db->lastInsertId();
					
					#Вставка в галерею
					$newfile2=md5(uniqid().microtime()).'.jpg';
					copy($_SERVER['DOCUMENT_ROOT'].'/img/shop/template/goodna.jpg',$_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/img/'.$newfile2);
					$db->exec('INSERT INTO z_gallery
					(file_name, active, siteid,userid,sort,itemid,major)
					VALUES (
					"'.$newfile2.'",1,'.$siteid.','.$userid.',1,'.$newproditem.',1)');
					
					$cnt=0;
					$newfile1=null;
					foreach($p_itemid as $prodid=>$prod){
					if($cnt<1 && $prod['p_file_name']){
						$sourcefile=$_SERVER['DOCUMENT_ROOT'].$prod['p_banner'];
						$prod['p_banner']=pathinfo($prod['p_banner']);
						$newfile1=md5(uniqid().microtime()).'.'.$prod['p_banner']['extension'];
						copy($sourcefile,$_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$siteid.'/img/'.$newfile1);
							
					}
					$db->exec('
					INSERT INTO z_product (preview,name,active,categoryid,price,detail_text,techinfo,favourite,itemid,siteid,userid,languageid,file_name)
					VALUES (
					1,
					"'.tools::str($prod['p_name']).'",
					'.$prod['p_active'].',
					'.$newcatitem.',
					'.$prod['p_price'].',
					"'.tools::str($prod['p_detail_text']).'",
					"'.tools::str($prod['p_techinfo']).'",
					'.$prod['p_favourite'].',
					'.$newproditem.',
					'.$siteid.',
					'.$userid.',
					'.$prod['p_languageid'].',
					"'.$newfile1.'")
					');
					$cnt++;
					}
				}
				
			}
			//tools::print_r($catArr);
			#Добавление событий
			$eventdata=$db->queryFetchAllAssoc('
			SELECT 
			  z_event.id,
			  z_event.name,
			  z_event.detail_text,
			  z_event.itemid,
			  z_event.languageid
			FROM
			  z_event 
			WHERE siteid = '.$templateid.' 
			');
			foreach($eventdata as $event){
				$eventArr[$event['itemid']][$event['id']]=$event;
			}
			foreach($eventArr as $event2){
				$db->exec('
				INSERT INTO _items
				(datatypeid,siteid,userid) VALUES 
				(9,'.$siteid.','.$userid.')
				');
				$neweventitem=$db->lastInsertId();
				foreach($event2 as $ev){
					$db->exec('
					INSERT INTO z_event
					(name,date_start,detail_text,active,userid,siteid,itemid,languageid)
					VALUES 
					("'.tools::str($ev['name']).'",
					NOW(),
					"'.tools::str($ev['detail_text']).'",
					1,'.tools::int($userid).',
					'.tools::int($siteid).',
					'.$neweventitem.',
					'.tools::int($ev['languageid']).')');
				}			
			}
			
			#Добавление блога
			$blogdata=$db->queryFetchAllAssoc('
			SELECT 
			  z_blog.id,
			  z_blog.name,
			  z_blog.detail_text,
			  z_blog.itemid,
			  z_blog.languageid
			FROM
			  z_blog 
			WHERE siteid = '.$templateid.' 
			');
			foreach($blogdata as $blog){
				$blogArr[$blog['itemid']][$blog['id']]=$blog;
			}
			foreach($blogArr as $blog2){
				$db->exec('
				INSERT INTO _items
				(datatypeid,siteid,userid) VALUES 
				(13,'.$siteid.','.$userid.')
				');
				$newblogitem=$db->lastInsertId();
				foreach($blog2 as $bl){
					$db->exec('
					INSERT INTO z_blog
					(name,date_start,detail_text,active,userid,siteid,itemid,languageid)
					VALUES 
					("'.tools::str($bl['name']).'",
					NOW(),
					"'.tools::str($bl['detail_text']).'",
					1,'.tools::int($userid).',
					'.tools::int($siteid).',
					'.$newblogitem.',
					'.tools::int($bl['languageid']).')');
				}			
			}
			//tools::print_r($blogArr);
		 }
		
}


?>