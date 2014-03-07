<?
require_once 'modules/base/models/Basemodel.php';

Class Author Extends Basemodel {
    public $registry;
    public function __construct($registry){
        $this->registry=$registry;
    }
public function getAuthors($params=array('start'=>0,'take'=>12)){
	if(!$params['start'])
    $params['start']=0;
    if(!$params['take'])
    $params['take']=12;
    
    if(strlen($params['q'])>0)
    $Sql.=' AND z_site_language.name like "%'.tools::str($params['q']).'%"';
     
    $db=db::init();
    $result=$db->queryFetchAllAssoc('
                    SELECT
                      DISTINCT z_site.id,
                      IF(
					    z_domain.id > 0,
					    z_domain.NAME,
					    CONCAT("w",z_site_language.siteid, ".wonderlex.com")
					  ) AS domain,
                      IF(DATE_ADD(date_create, INTERVAL 1 MONTH)>NOW(),1,0) AS new,
                      z_site_language.name,
                      z_site.author_description,
                      z_site.facebook,
                      z_site.twitter,
                      z_site.vkontakte,
                      if(z_site_language.languageid=1,z_country.name_ru,z_country.name_en) AS country,
                      CONCAT(
                        "/uploads/sites/",
                        z_site.id,
                        "/17_",
                        z_site.author_image
                      ) AS author_image
                    FROM
                      z_site
                      LEFT JOIN
                      z_domain
                      ON z_domain.siteid = z_site.id
                      INNER JOIN
                      z_site_language
                      ON z_site_language.siteid = z_site.id
                      LEFT JOIN z_country
                      ON z_country.id=z_site.countryid
                    WHERE z_site.sitetypeid=3 AND z_site_language.languageid = '.tools::int($_SESSION['langid']).' AND z_site.promo=1
                    '.$Sql.'
                    group by z_site.id
                    ORDER BY z_site.sort desc, z_site.id desc
                    LIMIT '.$params['start'].','.$params['take'].'
                    ');
   /* echo "<pre>";
    print_r($result);
    echo "</pre>";*/
    if($result)
    return $result;
}
public function getAuthorsToJson($params){
    $data=self::getAuthors($params);
    $button = rand(0, 1);
    $json_data = '{
        "button": ' . $button . ',
        "arrays" : [
            ';
    $cnt=0;
    foreach($data as $item){
        
    if(strlen($item['author_description'])>150){
    $item['author_description'] = str_replace(array('\\', '/', '"', "'", "\r", "\n", "\b", "\f", "\t"), 
                             array('\\\\\\\\', '/', '\\"', "'", '\r', '\n', '\b', '\f', '\t'), $item['author_description']);    
        
    $item['author_description']=mb_substr(strip_tags(trim($item['author_description'])),0,150,'UTF-8');
    }
    //$item['author_description']=tools::toJson($item['author_description']);
    $jsondataArr[]= '
            {
                "href": "'.$this->registry->langurl.'/author/'.$item['id'].'/",
                "imgSrc": "'.$item['author_image'].'",
                "name": "'.$item['name'].'",
                "description": "'.$item['author_description'].'..."
            }';
    }
    $json_data .=implode(',',$jsondataArr);
    $json_data .= ']
    }';
    
    $json_data = str_replace("\r\n",'',$json_data);
    $json_data = str_replace("\n",'',$json_data);
    
    echo $json_data;
    exit;
    
}
public function getAuthorInner($id){
	    
    $db=db::init();
    $result=$db->queryFetchRowAssoc('
                    SELECT
                      DISTINCT z_site.id,
                      IF(
					    z_domain.id > 0,
					    z_domain.NAME,
					    CONCAT("w",z_site_language.siteid, ".wonderlex.com")
					  ) AS domain,
                      z_site_language.name,
                      z_site.author_description,
                      z_site.facebook,
                      z_site.twitter,
                      z_site.vkontakte,
                      if(z_site_language.languageid=1,z_country.name_ru,z_country.name_en) AS country,
                      CONCAT(
                        "/uploads/sites/",
                        z_site.id,
                        "/17_",
                        z_site.author_image
                      ) AS author_image,
                      z_country.name_ru as country,
                      z_city.city_name_ru as city
                    FROM
                      z_site
                      LEFT JOIN
                      z_domain
                      ON z_domain.siteid = z_site.id
                      INNER JOIN
                      z_site_language
                      ON z_site_language.siteid = z_site.id
                      LEFT JOIN
                      z_city
                      ON z_city.id = z_site.cityid
                      LEFT JOIN z_country
                      ON z_country.id=z_site.countryid
                    WHERE z_site.id='.tools::int($id).' AND z_site.sitetypeid=3 AND z_site_language.languageid = '.tools::int($_SESSION['langid']).'
                    ');
	if($result)
	$additional=$db->queryFetchRowAssoc('
                    SELECT SUM(z_rate.rate) as rate FROM z_rate
					INNER JOIN 
					_items 
					ON _items.id=z_rate.`itemid`
					WHERE _items.`siteid`=156

                    ');
	if($additional)
	$result['rate']=$additional['rate'];
    if($result)
    return $result;
}
}
?>