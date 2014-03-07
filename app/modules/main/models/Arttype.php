<?
require_once 'modules/base/models/Basemodel.php';

Class Arttype Extends Basemodel {
	
	
	public function getArttypeList(){
	   $db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					* 
					FROM z_arttype
					ORDER BY z_arttype.sort ASC,z_arttype.name
					');
		if($result)
		return $result;	
	}
	#Styles
    public function getArtstyleList($params){
        $db=db::init();
        if($params['arttype_id']>0)
        $sql.=' WHERE z_artstyles.arttype_id='.tools::int($params['arttype_id']).'';
        
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                    * 
                    FROM z_artstyles
                    '.$sql.'
                    ORDER BY z_artstyles.sort ASC,z_artstyles.name
                    ');
        if($result)
        return $result; 
    }
    public function getStylesToJson($params){
        if($params['arttype_id']>0){
        $styles=self::getArtstyleList($params);
            
            
            $json_data = '{
                "menu": {
                    "type":"style",
                    "name": "Стиль",
                    "items": [';
            $cnt=0;
            foreach($styles as $product){
            $jsondataData=null;        
            $jsondataData= '
                        {
                            "id": '.$product['id'].',
                            "name": "'.$product['name'].'"
                        }';
            $jsondataArr[]=$jsondataData;
            }
            $json_data .=implode(',',$jsondataArr);
    $json_data .= ']
    }
    }';
        }
    $json_data = str_replace("\r\n",'',$json_data);
    $json_data = str_replace("\n",'',$json_data);
    
    echo $json_data;
    exit;
    }
   
    #Genres
    public function getArtgenreList($params){
        $db=db::init();
        if($params['artstyle_id']>0)
        $sql.=' WHERE z_artgenres.artstyle_id='.tools::int($params['artstyle_id']).'';
        
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                    * 
                    FROM z_artgenres
                    '.$sql.'
                    ORDER BY z_artgenres.sort ASC,z_artgenres.name
                    ');
        if($result)
        return $result; 
    }
    public function getGenresToJson($params){
        if($params['artstyle_id']>0){
        $styles=self::getArtgenreList($params);
            $json_data = '{
                "menu": {
                    "type":"genre",
                    "name": "Жанр",
                    "items": [';
            $cnt=0;
            foreach($styles as $product){
            $jsondataData=null;        
            $jsondataData= '
                        {
                            "id": '.$product['id'].',
                            "name": "'.$product['name'].'"
                        }';
            $jsondataArr[]=$jsondataData;
            }
            $json_data .=implode(',',$jsondataArr);
    $json_data .= ']
    }
    }';
        }
    $json_data = str_replace("\r\n",'',$json_data);
    $json_data = str_replace("\n",'',$json_data);
    
    echo $json_data;
    exit;
    }
}
?>