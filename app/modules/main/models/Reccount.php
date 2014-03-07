<?
require_once 'modules/base/models/Basemodel.php';

Class Reccount Extends Basemodel {
	
	private $no_cache;
	
	public function __construct(){
		if(MAIN_DEBUG==true)
		$this->no_cache='SQL_NO_CACHE';
	}
	
	public function getSiteStr($langid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT
                      DISTINCT z_site.id,
                      z_domain.NAME AS domain,
                      z_site_language.name,
                      if(z_site_language.languageid=1,z_country.name_ru,z_country.name_en) AS country,
                      CONCAT(
                        "/img/main2/flag/",
                        z_country.code,".png"
                      ) AS flag,
                      CONCAT(
                        "/uploads/sites/",
                        z_site.id,
                        "/",
                        z_site.preview_image
                      ) AS preview,
                      CONCAT(
                        "/uploads/sites/",
                        z_site.id,
                        "/",
                        z_site.detail_image
                      ) AS detail
                    FROM
                      z_site
                      INNER JOIN
                      z_domain
                      ON z_domain.siteid = z_site.id AND z_domain.active=1
                      INNER JOIN
                      z_site_language
                      ON z_site_language.siteid = z_site.id
                      LEFT JOIN z_country
                      ON z_country.id=z_site.countryid
                    WHERE z_site.sitetypeid=3 AND z_site_language.languageid = '.tools::int($langid).' AND z_site.promo=1
                    group by z_site.id
                    order by z_site.sort desc, z_site.id desc
                    
                    ');
		if($result)
		return $result;
	}
	public function getCitationStr($langid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
					SELECT 
					  z_site_language.`name`,
					  z_domain.NAME AS domain,
					  IF(
					    z_site_language.`languageid` = '.tools::int($langid).',
					    z_citations.`detail_text`,
					    z_citations.`detail_text_en`
					  ) AS citation,
					  CONCAT(
					    "/uploads/citations/",
					    z_citations.preview_image
					  ) AS preview,
					  CONCAT(
					    "/img/main2/flag/",
					    z_country.code,
					    ".png"
					  ) AS flag,
					  z_country.name_ru as country,
					  z_city.city_name_ru as city
					FROM
					  z_citations 
					  INNER JOIN z_site_language 
					    ON z_site_language.`siteid` = z_citations.`siteid` 
					    AND z_site_language.`languageid` = '.tools::int($langid).' 
					  INNER JOIN z_site 
					    ON z_site.id = z_citations.`siteid` 
					  LEFT JOIN z_country 
					    ON z_country.id = z_site.countryid 
					  LEFT JOIN z_city 
                        ON z_city.id = z_site.cityid 
					  INNER JOIN
                      z_domain
                      ON z_domain.siteid = z_site.id
					WHERE z_citations.`active` = 1 
					ORDER BY z_citations.date_create DESC
					');
		if($result)
		return $result;
	}
	public function getGreeting($emailid){
		$db=db::init();
		$result=$db->queryFetchRowAssoc('
			SELECT 
			  `subject`,
			  detail_text 
			FROM
			  z_mail 
			WHERE id='.tools::int($emailid).'
		');
		return $result;
	}
	public function getUserSite($id){
	   $db=db::init();
        $result=$db->queryFetchRowAssoc('
                    SELECT 
                      z_site.id,
                      IF(
                        z_domain.id > 0,
                        z_domain.name,
                        CONCAT("w", z_site.id, ".wonderlex.com")
                      ) AS domain,
                      z_site_language.name,
                      z_siteplantype.title AS planname,
                      z_site_siteplan.siteplantypeid AS planid,
                      DATEDIFF(z_site_siteplan.`date_end`,NOW()) AS date_end
                    FROM
                      z_site 
                      LEFT JOIN z_domain 
                        ON z_domain.siteid = z_site.id 
                      INNER JOIN z_site_language 
                        ON z_site_language.siteid = z_site.id 
                      LEFT JOIN z_site_siteplan 
                        ON z_site_siteplan.siteid = z_site.id AND z_site_siteplan.`active`=1
                      LEFT JOIN z_siteplantype 
                        ON z_siteplantype.id = z_site_siteplan.siteplantypeid 
                    WHERE z_site.id = '.tools::int($id).' 
                      AND z_site.userid = '.tools::int($_SESSION['User']['id']).' 
                      AND z_site_language.languageid = '.tools::int($_SESSION['langid']).' 
                    ORDER BY z_site_siteplan.`siteplantypeid` DESC
                    LIMIT 0,1
                    
                    ');
        if($result)
        return $result;
	}
    public function getSitePlans($id){
       $db=db::init();
        $result=$db->queryFetchAllAssoc('
                    SELECT
                    z_siteplantype.id,
                    z_siteplantype.title,
                    z_siteplantype.description,
                    ROUND(z_siteplantype.price * z_currency.rate,2) AS price,
                    z_currency.localname AS curname
                    FROM
                     z_siteplantype
                    LEFT JOIN z_currency
                    ON z_currency.id='.tools::int($_SESSION['curid']).'
                    ');
        if($result)
        return $result;
    }
	public function updatePlan($data){
			$db=db::init();
		   	$oldplan=$db->queryFetchRowAssoc('
	       	SELECT 
			  max(z_site_siteplan.date_end) as date_end
			FROM
			  z_site_siteplan 
			WHERE z_site_siteplan.`date_end`>NOW()
			AND z_site_siteplan.`siteplantypeid`='.tools::int($data['plan']).'
			AND z_site_siteplan.`siteid`='.tools::int($data['siteid']).'
			AND z_site_siteplan.active=1
	       ');
		
			if($oldplan['date_end'])
				$date_start='"'.$oldplan['date_end'].'"';
			else
				$date_start='NOW()';
			$db->exec('
			INSERT INTO z_site_siteplan 
			(siteid,siteplantypeid,date_start,date_end)
			VALUES 
			('.tools::int($data['siteid']).', '.tools::int($data['plan']).', '.$date_start.', DATE_ADD('.$date_start.',INTERVAL 1 YEAR))');
			$payid=$db->lastInsertId();
			if($payid>0)
			return $payid;			
	}
	public function getPlanPrice($data){
		if(!$data['id'])
		return;
		$db=db::init();
		$plan=$db->queryFetchRowAssoc('SELECT 
		  ROUND(z_siteplantype.price * z_currency.rate,2) AS price,
		  z_siteplantype.title,
		  z_site_siteplan.id
		FROM
		  `z_site_siteplan` 
		INNER JOIN `z_siteplantype`
		ON `z_siteplantype`.`id`=z_site_siteplan.`siteplantypeid`
		LEFT JOIN z_currency
		ON z_currency.id=1
		WHERE z_site_siteplan.id = '.tools::int($data['id']).' 
		AND z_site_siteplan.active=0');
		if($plan)
		return $plan;
	}
    public function getCurrency(){
        $db=db::init();
        $result=$db->queryFetchAllAssoc('
        SELECT 
        z_currency.id,
        z_currency.code 
        from 
        z_currency 
        INNER JOIN z_currency_site
        ON z_currency_site.currencyid=z_currency.id AND z_currency_site.siteid='.tools::int($_SESSION['Site']['id']).'
        where z_currency.active=1');
        foreach($result as $cur)
        $curIdArr[$cur['id']]=$cur['id'];
        //echo $_SESSION['curid'];
        //tools::print_r($curIdArr);
        if(!in_array($_SESSION['curid'],$curIdArr)){
        
        $_SESSION['curid']=self::getMainCurrency();
        setcookie('curid',$_SESSION['curid'], time()+60*60);
    }
    
    if($result)
    return $result;
    }
    public function getMainCurrency(){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
        SELECT currencyid FROM z_currency_site WHERE z_currency_site.`siteid`='.tools::int($_SESSION['Site']['id']).' AND z_currency_site.`major`=1');
        if($result[0])
        return $result[0];
    }
    public function checkCurrency($curid){
        $db=db::init();
        $result=$db->queryFetchAllFirst('
        SELECT currencyid FROM z_currency_site WHERE siteid='.tools::int($_SESSION['Site']['id']).' AND currencyid='.tools::int($curid).'');
        if($result[0])
        return $result[0];
    }

}
?>