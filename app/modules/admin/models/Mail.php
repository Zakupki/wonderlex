<?
require_once 'modules/base/models/Basemodel.php';

Class Mail Extends Basemodel {
	
	
	public function getMailList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_mail.id,
					  z_mail.subject
					FROM
					  z_mail 
					');
		if($result)
		return $result;	
	}
	public function getMailInner($id){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
					SELECT 
					  z_mail.id,
					  z_mail.subject,
					  z_mail.detail_text
					FROM
					  z_mail 
					WHERE z_mail.id='.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function updateMailInner($data){
		$db=db::init();
		if($data['id']>0){
			$db->exec('UPDATE z_mail SET subject="'.tools::str($data['subject']).'",  detail_text="'.tools::r_str($data['detail_text']).'"
			WHERE z_mail.id='.tools::int($data['id']).'');
		}else{
			$db->exec('INSERT INTO z_mail (subject,detail_text) VALUES ("'.tools::str($data['subject']).'","'.tools::r_str($data['detail_text']).'")');
		}
	}	
}
?>