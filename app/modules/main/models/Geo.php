<?
require_once 'modules/base/models/Basemodel.php';

Class Geo Extends Basemodel {
	
	public function getCountries(){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  id,
		  name_ru,
		  name_en,
		  if('.tools::int($_SESSION['langid']).'=1,name_ru,name_en) as name,
		  code 
		FROM
		  z_country
		ORDER BY name_ru');
		if($result)
		return $result;
	}
	public function getCities($id){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  id,
		  if('.tools::int($_SESSION['langid']).'=1,city_name_ru,city_name_en) as name
		FROM
		  z_city
		WHERE id_country='.tools::int($id).'
		ORDER BY city_name_ru');
			 $json_answer = '{
		            "list": [
		            ';
					foreach($result as $city)
		             $cities[]='
					    {
		                    "name": "'.$city['name'].'",
		                    "value": "'.$city['id'].'"
		                }';
			 $json_answer .=implode(',',$cities);
		     $json_answer .='
		     ]
		        }';
		     echo $json_answer;
	}
}
?>