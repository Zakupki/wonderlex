<?
require_once 'modules/base/models/Basemodel.php';

Class Reccount Extends Basemodel {
	
	
	public function getSitetypes($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_sitetype.id,
				  z_sitetype.name
				FROM
				  z_sitetype
				WHERE z_sitetype.parentid='.tools::int($id).'
				');
	if($result)
	return $result;
	}

    public function getSitesCount($params=array()){
        $db=db::init();
        if(strlen($params['get']['name'])>0)
            $whereSql.=' AND z_site_language.name LIKE "%'.$params['get']['name'].'%"';
        if(strlen($params['get']['domain'])>0){
            $whereSql.=' AND z_domain.name LIKE "%'.$params['get']['domain'].'%"';
            $joinSql=' INNER JOIN
				  z_domain
				  ON z_domain.siteid = z_site.id ';
        }
        $result=$db->queryFetchAllFirst('
                    SELECT
                      COUNT(z_site.id)
                    FROM
                      z_site
                    INNER JOIN z_site_language
				      ON z_site_language.siteid=z_site.id AND z_site_language.languageid=1
				    INNER JOIN z_user
                      ON z_user.id = z_site.userid
                    INNER JOIN z_sitetype
                      ON z_sitetype.id = z_site.sitetypeid
                    '.$joinSql.'
                    WHERE 1=1 '.$whereSql.'
                    ');
        if($result[0])
            return $result[0];
    }

	public function getSiteList($params=array()){
        $db=db::init();

        if($params['start']<1)
            $params['start']=0;
        if($params['take']<1)
            $params['take']=20;

        $sortTableArr=array(
            'id'=>'z_user.',
            'email'=>'z_user.',
            'date_create'=>'z_user.',
        );

        $domainjoinSql=' LEFT JOIN
				  z_domain
				  ON z_domain.siteid = z_site.id ';

        if(strlen($params['get']['name'])>0)
            $whereSql.=' AND z_site_language.name LIKE "%'.$params['get']['name'].'%"';
        if(strlen($params['get']['domain'])>0){
            $whereSql.=' AND z_domain.name LIKE "%'.$params['get']['domain'].'%"';
            $domainjoinSql=' INNER JOIN
				  z_domain
				  ON z_domain.siteid = z_site.id ';
        }

	/*if($sitetype){
	$sitetypeStr=' AND z_sitetype.parentid='.tools::int($sitetype);
	}*/
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_site.id,
				  z_site_language.name,
				  z_site.userid,
				  z_site.sort,
				  z_site.promo,
				  z_user.login,
				  z_user.email,
				  z_user.password,
				  z_sitetype.name AS sitetype,
				  z_domain.name AS domain
				FROM
				  z_site 
				  INNER JOIN
				  z_user 
				  ON z_user.id = z_site.userid 
				  INNER JOIN
				  z_sitetype 
				  ON z_sitetype.id = z_site.sitetypeid '.$sitetypeStr.' 
				  '.$domainjoinSql.'
				  INNER JOIN z_site_language
				  ON z_site_language.siteid=z_site.id AND z_site_language.languageid=1
				  WHERE 1=1 '.$whereSql.'
				  GROUP BY z_site.id
				  ORDER BY sort DESC, id DESC
				  LIMIT '.tools::int($params['start']).','.tools::int($params['take']).'
				');
	if($result)
	return $result;
}
	public function getCitationList($sitetype=null){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_citations.id,
				  z_site_language.name,
				  z_citations.detail_text
				FROM
				  z_citations
				  INNER JOIN z_site_language
				  ON z_site_language.siteid=z_citations.siteid AND z_site_language.languageid=1
				  GROUP BY z_citations.id
				');
	if($result)
	return $result;
}
	public function getSiteInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				z_site.id,
				z_site.name,
				z_site.userid,
			    z_site.promo,
			    z_site.countryid,
			    z_site.sitetypeid,
				z_site.preview_image as preview_name,
				z_site.detail_image as detail_name,
				z_site.sort,
				z_site.active,
				z_site.author_description,
				z_domain.id AS domain_id,
				CONCAT(
				"/uploads/sites/",z_site.id,"/",
				z_site.preview_image
				) AS preview,
				CONCAT(
				"/uploads/sites/",z_site.id,"/",
				z_site.detail_image
				) AS detail,
				CONCAT(
                "/uploads/sites/",z_site.id,"/",
                z_site.author_image
                ) AS author_image
				FROM z_site
				LEFT JOIN z_domain
				ON z_domain.siteid=z_site.id
				WHERE z_site.id='.tools::int($id).'
				');
	if($result)
	return $result;
	}
	public function getCitationInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				z_citations.id,
				z_citations.detail_text,
				z_citations.detail_text_en,
				z_citations.active,
				z_citations.siteid,
				z_citations.preview_image as preview_name,
				CONCAT(
				"/uploads/citations/",
				z_citations.preview_image
				) AS preview
				FROM z_citations
				WHERE z_citations.id='.tools::int($id).'
				');
	if($result)
	return $result;
	}
	
	public function updateSiteInner($data,$files){
        $db=db::init();
        if($files['small_image']['tmp_name']){
            $tempFile = $files['small_image']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.$data['id'].'/';
            $path_parts=pathinfo($files['small_image']['name']);
            $newfilename1=md5(uniqid().microtime()).".".$path_parts['extension'];
            $targetFile1 =  str_replace('//','/',$targetPath) . $newfilename1;
            if(move_uploaded_file($tempFile,$targetFile1)){
                if($data['preview'])
                tools::delImg($data['preview']);
                $Sql.=', preview_image="'.$newfilename1.'"';
            }
        }
        if($files['big_image']['tmp_name']){
            $tempFile = $files['big_image']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.$data['id'].'/';
            $path_parts=pathinfo($files['big_image']['name']);
            $newfilename2=md5(uniqid().microtime()).".".$path_parts['extension'];
            $targetFile2 =  str_replace('//','/',$targetPath) . $newfilename2;
            if(move_uploaded_file($tempFile,$targetFile2)){
                if($data['detail'])
                tools::delImg($data['detail']);
                $Sql.=', detail_image="'.$newfilename2.'"';
            }
        }
        if($files['author_image']['tmp_name']){
            $tempFile = $files['author_image']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/sites/'.$data['id'].'/';
            $path_parts=pathinfo($files['author_image']['name']);
            $newfilename2=md5(uniqid().microtime()).".".$path_parts['extension'];
            $targetFile2 =  str_replace('//','/',$targetPath) . $newfilename2;
            if(move_uploaded_file($tempFile,$targetFile2)){
                if($data['auth_im'])
                tools::delImg($data['auth_im']);
                $Sql.=', author_image="'.$newfilename2.'"';
            }
        }
        if($data['id']>0){
            $db->exec('UPDATE z_site SET active="'.tools::int($data['active']).'", author_description="'.tools::str($data['author_description']).'", sitetypeid='.tools::int($data['sitetypeid']).',sort='.tools::int($data['sort']).', promo='.tools::int($data['promo']).', countryid='.tools::int($data['countryid']).''.$Sql.'
 			WHERE z_site.id='.tools::int($data['id']).'');
        }else{
       
	   if($data['email']){
	   		$finduser=$db->queryFetchAllFirst('SELECT id FROM z_user WHERE email="'.tools::str($data['email']).'" LIMIT 0,1');
	   		
			if($finduser[0]>0){
				$userid=$finduser[0];
	   		}
			elseif($data['email']) {
				$db->exec('insert into z_user (login,password,firstName,email,activation) VALUES ("'.tools::str(strstr($data['email'], '@', true)).'","1cd803e2056d145af0e94dae20538b2e","'.tools::str(strstr($data['email'], '@', true)).'","'.tools::str($data['email']).'",1)');
				$userid=$db->lastInsertId();
				$db->exec('INSERT into z_usertype_user (userid,usertypeid) values ('.$userid.',2)');
			}	
			
			if($userid<1)
			die('no userid');
		 	$templateid=201;
		 	
			
			$result=$db->queryFetchRowAssoc('
			CALL addsite(3,'.$userid.')
			');
			$siteid=$result['siteid'];
			if($siteid<1)
			die('no id');
			//echo $siteid;
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
			eventscolor="'.$sitedata['eventscolor'].'",
			sort='.$sitedata['sort'].',
			active='.tools::int($sitedata['active']).'
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
			
			}			
			
        }

		
		return $siteid;
      
	}
	public function updateCitationInner($data,$files){
        if($files['small_image']['tmp_name']){
            $tempFile = $files['small_image']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/citations/';
            $path_parts=pathinfo($files['small_image']['name']);
            $newfilename1=md5(uniqid().microtime()).".".$path_parts['extension'];
            $targetFile1 =  str_replace('//','/',$targetPath) . $newfilename1;
            if(move_uploaded_file($tempFile,$targetFile1)){
                if($data['preview'])
                tools::delImg($data['preview']);
                $Sql.=', preview_image="'.$newfilename1.'"';
				$Sql2_col=', preview_image';
				$Sql2_val=', "'.$newfilename1.'"';
            }
        }
		$db=db::init();
        if($data['id']>0){
            $db->exec('UPDATE z_citations SET active='.tools::int($data['active']).', siteid='.tools::int($data['siteid']).',detail_text="'.tools::str($data['detail_text']).'", detail_text_en="'.tools::str($data['detail_text_en']).'"'.$Sql.'
 			WHERE z_citations.id='.tools::int($data['id']).'');
        }else{
        	$db->exec('INSERT INTO z_citations (detail_text,detail_text_en,active,siteid'.$Sql2_col.') VALUES ("'.tools::str($data['detail_text']).'", "'.tools::str($data['detail_text']).'",
			'.tools::int($data['active']).','.tools::int($data['siteid']).''.$Sql2_val.')');
		}

		
	}
    public function getAplications(){
         $db=db::init();
         $result=$db->queryFetchAllAssoc('
            SELECT 
              * 
            FROM
              z_aplication
            ORDER by active asc, date_create desc            
            ');
         if($result)
         return $result;
    }
    public function getAplicationInner($id){
         $db=db::init();
         $result=$db->queryFetchRowAssoc('
            SELECT 
              * 
            FROM
              z_aplication
            WHERE id='.tools::int($id).'
            ');
         if($result)
         return $result;
    }
    public function updateAplicationInner($data){
        $db=db::init();
        if($data['id']>0){
            $db->exec('UPDATE z_aplication SET active='.tools::int($data['active']).'
            WHERE z_aplication.id='.tools::int($data['id']).'');
        }
    }
}
?>