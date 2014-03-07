<?
require_once 'modules/base/models/Basemodel.php';

Class Comments Extends Basemodel {
	
	private $no_cache;
	
	public function __construct(){
		if(MAIN_DEBUG==true)
		$this->no_cache='SQL_NO_CACHE';
	}

	
	public function getComments($params){
		$db=db::init();
        if(!$params['start'])
        $params['start']=0;
        if(!$params['take'])
        $params['take']=3;
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_comments.id,
					  z_comments.userid,
					  z_comments.preview_text,
					  z_comments.date_create,
					  z_comments.deleted,
					  z_comments.attitude,
					  z_site.id as siteid,
					  CONCAT("/uploads/sites/",z_site.id,"/19_",z_site.author_image) as author_image,
					  DATE_FORMAT(
					    z_comments.date_create,
					    "%d.%m.%Y, %H:%i"
					  ) AS date_create,
					  if(z_user.id=2,z_comments.name,z_user.firstName) AS firstName
					FROM
					  z_comments 
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_comments.userid
					  INNER JOIN z_site
					  ON z_site.userid=z_user.id
					WHERE z_comments.itemid = '.tools::int($params['itemid']).'
					GROUP BY z_comments.id
					ORDER BY z_comments.date_create desc
					/*LIMIT '.tools::int($params['start']).','.tools::int($params['take']).'*/
					');
        if($result)
		return $result;
		
	}
public function getsiteComments($params){
        $db=db::init();
        if(!$params['start'])
        $params['start']=0;
        if(!$params['take'])
        $params['take']=3;
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                      z_comments_author.id,
                      z_comments_author.userid,
                      z_comments_author.preview_text,
                      z_comments_author.date_create,
                      z_comments_author.deleted,
                      z_comments_author.attitude,
                      z_site.id as siteid,
                      CONCAT("/uploads/sites/",z_site.id,"/19_",z_site.author_image) as author_image,
                      DATE_FORMAT(
                        z_comments_author.date_create,
                        "%d.%m.%Y, %H:%i"
                      ) AS date_create,
                      if(z_user.id=2,z_comments_author.name,z_user.firstName) AS firstName
                    FROM
                      z_comments_author 
                      INNER JOIN
                      z_user 
                      ON z_user.id = z_comments_author.userid
                      INNER JOIN z_site
                      ON z_site.userid=z_user.id
                    WHERE z_comments_author.siteid = '.tools::int($params['siteid']).'
                    GROUP BY z_comments_author.id
                    ORDER BY z_comments_author.date_create desc
                    /*LIMIT '.tools::int($params['start']).','.tools::int($params['take']).'*/
                    ');
        if($result)
        return $result;
        
    }
	
	
	public function addComment($data){
		/* header('Content-Type: application/json; charset=utf-8'); */
		$this->registry->token=new token;
		$db=db::init();
		$attitudes=array('positive'=>2, 'neutral'=>1, 'negative'=>0);
		if($_SESSION['User']['id']>0)
		{
			$userid=$_SESSION['User']['id'];
			$data['name']=$_SESSION['User']['firstName'];
		}else{
			$userid=2;
		}
		
		
			$data['message']=stripslashes($data['message']);
			$db->exec('
			INSERT INTO z_comments(
			  itemid,
			  userid,
			  siteid,
			  preview_text,
			  attitude,
			  name
			) 
			VALUES
			  (
			  '.tools::int($data['itemid']).', 
			  '.tools::int($userid).', 
			  '.tools::int($data['siteid']).', 
			  "'.tools::str($data['description']).'", 
			  '.tools::int($attitudes[$data['attitude']]).',
			  "'.tools::str($data['name']).'"
			  ) 
			');
			$newid=$db->lastInsertId();
		if($newid>0){		
		
			$attitude=array(2=>'authors-profile-comments__author-photo_positive', 1=>'authors-profile-comments__author-photo_neutral', 0=>'authors-profile-comments__author-photo_negative');
			
	        $result=$db->queryFetchAllAssoc('
					SELECT 
					  z_comments.id,
					  z_comments.userid,
					  z_comments.preview_text,
					  z_comments.attitude,
					  z_site.id as siteid,
					  CONCAT("/uploads/sites/",z_site.id,"/19_",z_site.author_image) as author_image,
					  DATE_FORMAT(
					    z_comments.date_create,
					    "%d.%m.%Y"
					  ) AS date_create,
					   DATE_FORMAT(
					    z_comments.date_create,
					    "%H:%i"
					  ) AS time_create,
					  if(z_user.id=2,z_comments.name,z_user.firstName) AS firstName
					FROM
					  z_comments 
					  INNER JOIN
					  z_user 
					  ON z_user.id = z_comments.userid
					  INNER JOIN z_site
					  ON z_site.userid=z_user.id
					WHERE z_comments.itemid = '.tools::int($data['itemid']).' AND z_comments.id>'.tools::int($data['lastcomment']).'
					GROUP BY z_comments.id
					ORDER BY z_comments.date_create DESC
					');
			foreach($result as $com){		
			$json_answer_arr[]='
	                {
	                    "href": "/author/'.$com['siteid'].'/",
	                    "imgPath": "'.$com['author_image'].'",
	                    "description": "' .$com['preview_text'] . '",
	                    "attitude": "' . $attitude[$com['attitude']] . '",
	                    "date": "'.$com['date_create'].'",
	                    "time": "'.$com['time_create'].'"
	                }';
	        }
 			$json_answer = '{
	            "statistic":
	            {
	                "positive": "' . rand(1, 100) . '",
	                "negative": "' . rand(1, 100) . '",
	                "neutral": "' .rand(1, 100) . '"
	            },
	            "array" :['.implode(',',$json_answer_arr).']
	        }';
	        echo $json_answer;
	    }
	    else {
	        header('HTTP/1.0 404');
	    }
		
	}
    public function addsiteComment($data){
        /* header('Content-Type: application/json; charset=utf-8'); */
        $this->registry->token=new token;
        $db=db::init();
        $attitudes=array('positive'=>2, 'neutral'=>1, 'negative'=>0);
        if($_SESSION['User']['id']>0)
        {
            $userid=$_SESSION['User']['id'];
            $data['name']=$_SESSION['User']['firstName'];
        }else{
            $userid=2;
        }
        
        
            $data['message']=stripslashes($data['message']);
            $db->exec('
            INSERT INTO z_comments_author(
              userid,
              siteid,
              preview_text,
              attitude,
              name
            ) 
            VALUES
              (
              '.tools::int($userid).', 
              '.tools::int($data['siteid']).', 
              "'.tools::str($data['description']).'", 
              '.tools::int($attitudes[$data['attitude']]).',
              "'.tools::str($data['name']).'"
              ) 
            ');
            $newid=$db->lastInsertId();
        if($newid>0){       
        
            $attitude=array(2=>'authors-profile-comments__author-photo_positive', 1=>'authors-profile-comments__author-photo_neutral', 0=>'authors-profile-comments__author-photo_negative');
            
            $result=$db->queryFetchAllAssoc('
                    SELECT 
                      z_comments_author.id,
                      z_comments_author.userid,
                      z_comments_author.preview_text,
                      z_comments_author.attitude,
                      z_site.id as siteid,
                      CONCAT("/uploads/sites/",z_site.id,"/19_",z_site.author_image) as author_image,
                      DATE_FORMAT(
                        z_comments_author.date_create,
                        "%d.%m.%Y"
                      ) AS date_create,
                       DATE_FORMAT(
                        z_comments_author.date_create,
                        "%H:%i"
                      ) AS time_create,
                      if(z_user.id=2,z_comments_author.name,z_user.firstName) AS firstName
                    FROM
                      z_comments_author 
                      INNER JOIN
                      z_user 
                      ON z_user.id = z_comments_author.userid
                      INNER JOIN z_site
                      ON z_site.userid=z_user.id
                    WHERE z_comments_author.siteid = '.tools::int($data['siteid']).' AND z_comments_author.id>'.tools::int($data['lastcomment']).'
                    GROUP BY z_comments_author.id
                    ORDER BY z_comments_author.date_create DESC
                    ');
            foreach($result as $com){       
            $json_answer_arr[]='
                    {
                        "href": "/author/'.$com['siteid'].'/",
                        "imgPath": "'.$com['author_image'].'",
                        "description": "' .$com['preview_text'] . '",
                        "attitude": "' . $attitude[$com['attitude']] . '",
                        "date": "'.$com['date_create'].'",
                        "time": "'.$com['time_create'].'"
                    }';
            }
            $json_answer = '{
                "statistic":
                {
                    "positive": "' . rand(1, 100) . '",
                    "negative": "' . rand(1, 100) . '",
                    "neutral": "' .rand(1, 100) . '"
                },
                "array" :['.implode(',',$json_answer_arr).']
            }';
            echo $json_answer;
        }
        else {
            header('HTTP/1.0 404');
        }
        
    }
	public function removeComment($data){
		/* header('Content-Type: application/json; charset=utf-8'); */
		$db=db::init();
		if($_SESSION['User']['id']>0){
			if($_SESSION['User']['id']==$_SESSION['Site']['userid']){
				$db->exec('
					DELETE z_comments.* FROM z_comments
					INNER JOIN z_site
					ON z_site.id=z_comments.siteid AND z_site.userid='.tools::int($_SESSION['User']['id']).'
					WHERE z_comments.id='.tools::int($data['id']).'
				');
				//echo 
			}
			/*
            elseif() {
                            $db->exec('
                                DELETE FROM z_comments
                                WHERE z_comments.id='.tools::int($_POST['id']).' 
                                AND z_releasetype.userid='.tools::int($_SESSION['User']['id']).'
                                AND z_comments.userid='.tools::int($_POST['userid']).'
                            ');
                        }*/
            
			
		
		$data = array(
	    'error' => false,
	    'status' => 'Комментарий удалён',
	    'content' => '<div class="text-removed text">Комментарий удалён</div>'
		);
		
		return $data;
		
		}
	}
	public function quoteComment(){
		if($_SESSION['User']['id']>0){
			$db=db::init();
			$stmt=$db->prepare("INSERT INTO z_quote (itemid,commentid,userid) VALUES (?,?,?)");
			$num=$stmt->execute(array(tools::int($_POST['itemid']),tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));
		}
		if($_SESSION['User']['id']>0 && $num>0){
			$data = array(
			    'error' => false,
			    'status' => 'Комментарий добавлен в список цитат'
			);
		}
		else{
			$data = array(
			    'error' => true,
		   		'status' => 'Произошла ошибка!'
			);
		}
		return $data;
	}
	public function unquoteComment(){
		if($_SESSION['User']['id']>0){
			$db=db::init();
			$stmt=$db->prepare("DELETE FROM z_quote WHERE itemid=? AND commentid=? AND userid=?");
			$num=$stmt->execute(array(tools::int($_POST['itemid']),tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));	
		}
		if($_SESSION['User']['id']>0 && $num>0){
			$data = array(
			    'error' => false,
			    'status' => 'Комментарий удален из списка цитат'
			);
		}
		else{
			$data = array(
			    'error' => true,
		   		'status' => 'Произошла ошибка!'
			);
		}
		return $data;
	}
	public function rateItem(){
		if($_SESSION['User']['id']>0){
			$db=db::init();
			if($_POST['current_rate']==0 && $_POST['rate']!=0){
				$stmt=$db->prepare("INSERT INTO z_rate (itemid,rate,userid) VALUES (?,?,?)");
				$num=$stmt->execute(array(tools::int($_POST['id']),tools::int($_POST['rate']),tools::int($_SESSION['User']['id'])));
			}
			else
			{
				if($_POST['rate']==0){
					$stmt=$db->prepare("DELETE FROM z_rate WHERE itemid=? AND userid=?");
					$num=$stmt->execute(array(tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));
				}
				else{
					$stmt=$db->prepare("UPDATE z_rate SET rate=? WHERE itemid=? AND userid=?");
					$num=$stmt->execute(array(tools::int($_POST['rate']),tools::int($_POST['id']),tools::int($_SESSION['User']['id'])));
				}
			}
		}
		
		if($_SESSION['User']['id']>0 && $num>0){
			$data = array(
			    'error' => false,
			    'status' => '',
			    'total_rate' => ($_POST['total_rate']-$_POST['current_rate'])+$_POST['rate']
			);
		}
		else{
			$data = array(
			    'error' => true,
		   		'status' => 'Произошла ошибка!'
			);
		}
		return $data;
	}
	
}
?>