<?
require_once 'modules/base/models/Basemodel.php';
Class Arttype Extends Basemodel {

    public $tables=array('arttype','artstyles','artgenres');

    public function getArtTypes($params){
        $db=db::init();
        if(!in_array($params['type'],$this->tables))
        return;

        if($params['type']=='artstyles')
            $sql.=' WHERE z_artstyles.arttype_id='.tools::int($params['id']).'';
        elseif($params['type']=='artgenres')
            $sql.=' WHERE z_artgenres.artstyle_id='.tools::int($params['id']).'';
        
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                    * 
                    FROM z_'.tools::str($params['type']).'
                    '.$sql.'
                    ORDER BY sort ASC, name ASC
                    ');
        if($result)
        return $result; 
    }
}
?>