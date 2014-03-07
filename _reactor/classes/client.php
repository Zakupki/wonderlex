<?

final class client{
	function _construct($subdomain){
		
	}
	function isSubdomain($subdomain){
		$db=db::init();
		$db->query('select * from z_domain where z_domain.name='.$subdomain.'');
		
	}
	function getSiteid($subdomain){
		$db=db::init();
		$row=$db->queryFetchRow('SELECT 
		z_site.id,
		z_site.name,
		z_site.active,
		z_site.userid,
		z_site.maincolor,
		z_site.linkcolor,
		z_site.bgcolor,
		z_site.headercolor,
		z_site.eventscolor,
		z_site.headcolor,
		z_site.canorder,
		z_site.sitetypeid,
		z_site.edges,
		z_user.email,
		z_site.mainrows,
		UNIX_TIMESTAMP(z_site.date_update) as date_update,
		CONCAT("/uploads/sites/",z_logo.siteid,"/img/",z_logo.url) AS logo,
		CONCAT("/uploads/sites/",z_background.siteid,"/img/",z_background.file_name) AS hdpattern
		FROM
			z_domain 
		INNER JOIN z_site
		ON z_site.id=z_domain.siteid
		INNER JOIN z_user
		ON z_user.id=z_site.userid
		LEFT JOIN z_logo
		ON z_logo.siteid=z_site.id
		LEFT JOIN z_background
		ON z_background.siteid=z_site.id AND z_background.major=1 AND z_background.type=2
		WHERE z_site.active=1 AND z_domain.name = "'.mysql_escape_string($subdomain).'" AND z_domain.active=1
		LIMIT 0,1');
        if($row['id']>0){
    		$_SESSION['Site']=$row;
    		return $row['id'];
        }
	}
	function isServiceid($id){
		$db=db::init();
		$row=$db->queryFetchRow('SELECT
		z_site.id,
		z_site.name,
		z_site.active,
		z_site.userid,
		z_site.maincolor,
		z_site.linkcolor,
		z_site.bgcolor,
		z_site.headercolor,
		z_site.headcolor,
		z_site.eventscolor,
		z_site.canorder,
		z_site.edges,
		z_site.sitetypeid,
		z_site.mainrows,
		z_user.email,
		UNIX_TIMESTAMP(z_site.date_update) as date_update,
		CONCAT("/uploads/sites/",z_logo.siteid,"/img/",z_logo.url) AS logo,
		CONCAT("/uploads/sites/",z_background.siteid,"/img/",z_background.file_name) AS hdpattern
		FROM
			z_site
	    INNER JOIN z_user
        ON z_user.id=z_site.userid
		LEFT JOIN z_domain
		ON z_site.id=z_domain.siteid
		LEFT JOIN z_logo
		ON z_logo.siteid=z_site.id
		LEFT JOIN z_background
		ON z_background.siteid=z_site.id AND z_background.major=1 AND z_background.type=2
		WHERE z_site.active=1 AND z_site.id='.tools::int($id).'');
		if($row['id']>0){
            $_SESSION['Site']=$row;
    		return $row['id'];
        }
	}
	function getClienttype($id){
		$db=db::init();
		$row=$db->queryFetchRow('
		SELECT
		  IF(
		    z_sitetype.parentid,
		    z_sitetype.parentid,
		    z_site.sitetypeid
		  ) AS sitetypeid,
		  IF(
		    z_sitetype.parentid,
		    z_sitetype2.CODE,
		    z_sitetype.CODE
		  ) AS sitetypecode
		FROM
		  z_site 
		  LEFT JOIN
		  z_sitetype 
		  ON z_sitetype.id = z_site.sitetypeid
		  LEFT JOIN z_sitetype z_sitetype2
		  ON z_sitetype2.id=z_sitetype.parentid
		WHERE z_site.active=1 AND z_site.id = '.tools::int($id).'
		');
		if($row['sitetypeid']>0)
			return $row['sitetypecode'];
	}
	
}

?>