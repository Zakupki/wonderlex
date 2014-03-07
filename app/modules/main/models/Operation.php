<?
require_once 'modules/base/models/Basemodel.php';

Class Operation Extends Basemodel {
	
	public function popUp($sum){
		$db=db::init();
		$stmt=$db->prepare("INSERT INTO z_operation (operationtypeid,value,userid,status) VALUES (?,?,?,?)");
		$res=$stmt->execute(array(1,$sum,$_SESSION['User']['id'],1));
		if($res)
		$oper_id=$db->lastInsertId();
		return $oper_id;
	}
	public function popUpForSite($data){
		$db=db::init();
		$stmt=$db->prepare("INSERT INTO z_operation (operationtypeid,value,userid,status,operationtypeforid,targetid) VALUES (?,?,?,?,?,?)");
		$res=$stmt->execute(array(1,$data['price'],$_SESSION['User']['id'],1,2,$data['id']));
		if($res)
		$oper_id=$db->lastInsertId();
		return $oper_id;
	}
	public function updateOperation($data){
		$db=db::init();
		
		$xmlStr=base64_decode($data['operation_xml']);
		$rec_sign=base64_decode($data['signature']);
		$xml = simplexml_load_string($xmlStr);
		
		$id=trim($xml->order_id);
		$status=trim($xml->status);
		$transactionid=trim($xml->transaction_id);
		
		
		$statusArr=array('new'=>1, 'success'=>2, 'wait_secure'=>3, 'failure'=>4);
		
		$stmt=$db->prepare("UPDATE z_operation SET status=?, transactionid=?, date_update=NOW(), xml=? WHERE id=?");
		$res=$stmt->execute(array(tools::int($statusArr[''.$status.'']), tools::int($transactionid), $xmlStr, tools::int($id)));
		
		
		if(tools::int($statusArr[''.$status.''])==2){
			$operation=$db->queryFetchRowAssoc('SELECT * FROM z_operation WHERE id='.tools::int($id).' AND status=2');
			
			if($operation['operationtypeforid']==2 && $operation['targetid']){
			    
                
				$stmt=$db->prepare("UPDATE z_site_siteplan SET active=? WHERE id=?");
				$res=$stmt->execute(array(1, tools::int($operation['targetid'])));
			}
		}
		
		
		//$stmt=$db->prepare("UPDATE z_operation SET status=?, date_update=NOW(), xml=? WHERE id=? AND userid=?");
		//$res=$stmt->execute(array(tools::int($statusArr[''.$status.'']), $xmlStr, tools::int($id)));
		//echo tools::int($statusArr[''.$status.'']).'--'.tools::int($id);
		if($res)
		return $oper_id;
	}
    public function getUserSiteOperations($siteid){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('SELECT 
          z_operation.`value`,
          DATE_FORMAT(z_operation.`date_create`, "%d.%m.%Y") AS date,
          z_siteplantype.`title` AS siteplan
        FROM
          z_operation 
        INNER JOIN z_site_siteplan
        ON z_site_siteplan.`id`=z_operation.`targetid`
        INNER JOIN z_siteplantype
        ON z_siteplantype.`id`=z_site_siteplan.`siteplantypeid`
        WHERE z_operation.userid = '.tools::int($_SESSION['User']['id']).' 
          AND z_operation.`operationtypeforid` = 2 
          AND z_operation.`status`=2
          AND z_site_siteplan.siteid='.tools::int($siteid));
        if($result)
        return $result;
    }
}
?>