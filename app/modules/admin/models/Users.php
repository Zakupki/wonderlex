<?
require_once 'modules/base/models/Basemodel.php';

Class Users Extends Basemodel {


    public function getUserCount(){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
                    SELECT
                      COUNT(z_user.id)
                    FROM
                      z_user
                    ');
        if($result[0])
            return $result[0];
    }

    public function getUserList($params=array()){
        if($params['start']<1)
            $params['start']=0;
        if($params['take']<1)
            $params['take']=20;

        if(strlen($params['get']['email'])>0)
            $whereSql.=' AND z_user.email LIKE "%'.$params['get']['email'].'%"';

        $sortTableArr=array(
            'id'=>'z_user.',
            'email'=>'z_user.',
            'date_create'=>'z_user.',
        );

        $db=db::init();
        $result=$db->queryFetchAllAssoc('
				SELECT
				z_user.id,
				z_user.login,
				z_user.email,
				z_user.firstName,
				z_user.familyName,
				z_user.secondName,
				z_user.active,
				(SELECT IF(id,1,0) FROM `z_site` WHERE `z_site`.id=z_user.id LIMIT 0,1) AS hassite,
				DATE_FORMAT(z_user.date_create,"%d.%m.%Y") AS date_create
				FROM z_user
				WHERE 1=1 '.$whereSql.'
				Order by '.$sortTableArr[$params['sorttype']].''.$params['sorttype'].' '.$params['sort'].'
				LIMIT '.tools::int($params['start']).','.tools::int($params['take']).'
				');
       if($result)
            return $result;
    }
	public function getUserDiscounts(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT 
				z_user.id,
				z_user.login,
				z_user.email,
				z_user.firstName,
				z_user.familyName,
				z_user.secondName,
				z_discount.value,
				z_discount.code,
				CONCAT(
					"/uploads/users/3_",
					z_user.file_name
					) AS url
				FROM z_user
				INNER JOIN z_discount
				ON z_discount.userid=z_user.id
				Order by z_user.id
				');
	if($result)
	return $result;
}
	public function getUsersBalance(){
	$db=db::init();
	$result=$db->queryFetchAllAssoc('
				SELECT
				z_operation.id,
				z_operationstatustype.name AS status,
				z_operation.value,
				DATE_FORMAT(z_operation.date_create,"%d.%m.%Y") AS date_create,
				z_operationtype.name AS operationtype,
				z_user.login
				FROM z_operation
				INNER JOIN z_operationtype
				ON z_operationtype.id=z_operation.operationtypeid
				INNER JOIN z_user
				ON z_user.id=z_operation.userid
				INNER JOIN z_operationstatustype
				ON z_operationstatustype.id=z_operation.status
				WHERE z_operation.status>1 AND z_operation.xml IS NOT NULL
				ORDER BY z_operation.date_create desc
				');
	if($result)
	return $result;
}
	public function getUserInner($id){
	$db=db::init();
	$result=$db->queryFetchRowAssoc('
				SELECT 
				z_user.id,
				z_user.login,
				z_user.recommend
				FROM z_user
				WHERE id='.tools::int($id).'
				');
	if($result)
	return $result;
}
	public function updateUserInner($data){
	if($data['id']>0){
			$db=db::init();
			$db->exec('UPDATE z_user SET recommend='.tools::int($data['recommend']).'
			WHERE z_user.id='.tools::int($data['id']).'');
		}
	}
}
?>