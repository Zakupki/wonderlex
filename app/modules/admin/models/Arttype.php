<?
require_once 'modules/base/models/Basemodel.php';

Class Arttype Extends Basemodel {
	
	
	public function getArttypeList(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					* 
					FROM z_arttype
					ORDER BY id DESC
					');
		if($result)
		return $result;	
	}
	public function getArttypeInner($id){
		$db=db::init();
		if($id<1)
        return;
		$result=$db->queryFetchRowAssoc('
					SELECT 
					 *
					FROM
					  z_arttype
					WHERE id='.tools::int($id).'
					');
		if($result)
		return $result;
	}
	public function updateArttypeInner($data){
		$db=db::init();
		if($data['id']>0){
			$db->exec('UPDATE z_arttype SET name="'.tools::str($data['name']).'"
 			WHERE z_arttype.id='.tools::int($data['id']).'');
		}else{
		    $db->exec('INSERT INTO z_arttype (name) VALUES ("'.tools::str($data['name']).'")');
		}
	}
    public function deleteArttype($id){
        $db=db::init();
        if($id>0){
            $db->exec('DELETE FROM z_arttype WHERE z_arttype.id='.tools::int($id).'');
        }
    }
    #Styles
    public function getArtstyleList(){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                    * 
                    FROM z_artstyles
                    ORDER BY id DESC
                    ');
        if($result)
        return $result; 
    }
    public function getArtstyleOptions(){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                    z_artstyles.id,
                    z_artstyles.name,
                    z_arttype.name as arttypename
                    FROM z_artstyles
                    INNER JOIN z_arttype
                    ON z_arttype.id=z_artstyles.arttype_id
                    ORDER BY z_arttype.name ASC
                    ');
        if($result)
        return $result; 
    }
    public function getArtstyleInner($id){
        $db=db::init();
        if($id<1)
        return;
        $result=$db->queryFetchRowAssoc('
                    SELECT 
                     *
                    FROM
                      z_artstyles
                    WHERE id='.tools::int($id).'
                    ');
        if($result)
        return $result;
    }
    public function updateArtstyleInner($data){
        $db=db::init();
        if($data['id']>0){
            $db->exec('UPDATE z_artstyles SET name="'.tools::str($data['name']).'", arttype_id='.tools::int($data['arttype_id']).'
            WHERE z_artstyles.id='.tools::int($data['id']).'');
        }else{
            $db->exec('INSERT INTO z_artstyles (name,arttype_id) VALUES ("'.tools::str($data['name']).'", '.tools::int($data['arttype_id']).')');
        }
    }
    public function deleteArtstyle($id){
        $db=db::init();
        if($id>0){
            $db->exec('DELETE FROM z_artstyles WHERE z_artstyles.id='.tools::int($id).'');
        }
    }
    #Genres
    public function getArtgenreList(){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('
                    SELECT 
                    * 
                    FROM z_artgenres
                    ORDER BY id DESC
                    ');
        if($result)
        return $result; 
    }
    public function getArtgenreInner($id){
        $db=db::init();
        if($id<1)
        return;
        $result=$db->queryFetchRowAssoc('
                    SELECT 
                     *
                    FROM
                      z_artgenres
                    WHERE id='.tools::int($id).'
                    ');
        if($result)
        return $result;
    }
    public function updateArtgenreInner($data){
        $db=db::init();
        if($data['id']>0){
            $db->exec('UPDATE z_artgenres SET name="'.tools::str($data['name']).'", artstyle_id='.tools::int($data['artstyle_id']).'
            WHERE z_artgenres.id='.tools::int($data['id']).'');
        }else{
            $db->exec('INSERT INTO z_artgenres (name,artstyle_id) VALUES ("'.tools::str($data['name']).'", '.tools::int($data['artstyle_id']).')');
        }
    }
    public function deleteArtgenre($id){
        $db=db::init();
        if($id>0){
            $db->exec('DELETE FROM z_artgenres WHERE z_artgenres.id='.tools::int($id).'');
        }
    }
}
?>