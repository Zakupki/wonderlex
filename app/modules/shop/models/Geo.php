<?
require_once 'modules/base/models/Basemodel.php';

Class Geo Extends Basemodel {
	
	
	public function findCountry($country,$langid){
	$db=db::init();
	if($langid==1)
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_country.id AS value,
				  z_country.name_ru AS label
				FROM
				  z_country 
				WHERE z_country.name_ru LIKE "%'.$country.'%"
				  ');
    else
        $result=$db->queryFetchAllAssoc('
				SELECT
				  z_country.id AS value,
				  z_country.name_en AS label
				FROM
				  z_country
				WHERE z_country.name_en LIKE "%'.$country.'%"
				  ');
	if($result)
	return $result;
    }
	
	public function findCity($city,$countryid,$langid){
	$db=db::init();
	if($langid==1)
	$result=$db->queryFetchAllAssoc('
				SELECT 
				  z_city.id AS value,
				  z_city.city_name_ru AS label
				FROM
				  z_city 
				WHERE z_city.id_country='.$countryid.' AND z_city.city_name_ru LIKE "%'.$city.'%"
				  ');
    else
        $result=$db->queryFetchAllAssoc('
				SELECT
				  z_city.id AS value,
				  z_city.city_name_en AS label
				FROM
				  z_city
				WHERE z_city.id_country='.$countryid.' AND z_city.city_name_en LIKE "%'.$city.'%"
				  ');
	if($result)
	return $result;
    }
}
?>