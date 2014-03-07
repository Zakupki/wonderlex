<?
require_once 'modules/base/models/Basemodel.php';

Class Seo Extends Basemodel {
	
	public function getRobots(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT 
		  robots
		FROM
		  z_site
		WHERE id='.tools::int($_SESSION['Site']['id']).'
		');
		if(strlen($result[0])>2)
		return $result[0];
        else 
        echo '';
        /*'User-agent: *
        Disallow: /';*/
	}
	public function getSitemap(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT 
		  sitemap
		FROM
		  z_site
		WHERE id='.tools::int($_SESSION['Site']['id']).'
		');
		if($result[0])
		return $result[0];
	}
	public function getRor(){
		$db=db::init();
		$result=$db->queryFetchAllFirst('
		SELECT 
		  ror
		FROM
		  z_site
		WHERE id='.tools::int($_SESSION['Site']['id']).'
		');
		if($result[0])
		return $result[0];
	}
    public function getSeoTemplate($id){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
        SELECT 
          value 
        FROM
          z_seotemplate
        WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND languageid='.tools::int($_SESSION['langid']).'
        AND templatetypeid='.tools::int($id).'
        ');
        if($result[0])
        return $result[0];
    }
}
?>