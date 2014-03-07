<?
require_once 'modules/base/models/Basemodel.php';

Class Comments Extends Basemodel {
	
	private $no_cache;
	
	public function __construct(){
		if(MAIN_DEBUG==true)
		$this->no_cache='SQL_NO_CACHE';
	}

	
	public function getComments($itemid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_comments.id,
					  z_comments.userid,
					  z_comments.preview_text,
					  z_comments.date_create,
					  z_comments.deleted,
					  
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
					WHERE z_comments.itemid = '.tools::int($itemid).'
					GROUP BY z_comments.id
					ORDER BY z_comments.date_create ASC
					');
		if($result)
		return $result;
		
	}
	
	
	public function addComment($data){
		/* header('Content-Type: application/json; charset=utf-8'); */
		$this->registry->token=new token;
		$db=db::init();
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
			  name
			) 
			VALUES
			  ('.tools::int($data['itemid']).', '.tools::int($userid).', '.tools::int($data['siteid']).', "'.tools::str($data['message']).'", "'.tools::str($data['name']).'") 
			');
			$newid=$db->lastInsertId();
			
			
			
			
			
			
			$data['status'] = 'Ваше сообщение отправлено';
			
			$data['total'] = $_POST['total'] + 1;
			
			$data['content'] = '
			  <div class="last li">
			    <input name="id" value="'.$newid.'" type="hidden" />
			    <div class="info">
			      <div class="user"><a>'.$data['name'].'<i class="i"></i></a></div>
			      <div class="date">'.date('d.m.Y, H:i').'<i class="i"></i></div>
			      <div class="remove"></div>
			    </div>
			    <div class="text">' . $_POST['message'] . '</div>
			  </div>
			';
			
			
		return $data;
		
	}
	public function removeComment(){
		/* header('Content-Type: application/json; charset=utf-8'); */
		$db=db::init();
		if($_SESSION['User']['id']>0){
			if($_SESSION['User']['id']==$_SESSION['Site']['userid']){
                $db->exec('
                    DELETE z_comments.* FROM z_comments
                    INNER JOIN z_site
                    ON z_site.id=z_comments.siteid AND z_site.userid='.tools::int($_SESSION['User']['id']).'
                    WHERE z_comments.id='.tools::int($_POST['id']).'
                ');
            }
			/*else {
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