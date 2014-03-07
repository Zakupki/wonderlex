<?
require_once 'modules/base/models/Basemodel.php';

Class Stats Extends Basemodel {

	private $registry;
	public function __construct($registry){
		$this->registry=$registry;
	}

	public function getStats($siteid,$statstypeid){
		$db=db::init();
        if($statstypeid==1){

            if(date('n')==12){
                $month='01';
                $year=date("Y")-1;
            }
            else{
                $month=date('m')-1;
                $year=date("Y");
            }

            $result=$db->queryFetchAll('
            SELECT
              UNIX_TIMESTAMP(date_add(`date_start`, INTERVAL 2 HOUR))*1000 AS `date`,
              visits AS `value`,
              visitors AS `visitors`
            FROM
              z_analytics_day
            WHERE siteid='.tools::int($siteid).' AND date_start BETWEEN "'.$year.'-'.$month.'-'.date('d').' 00:00:00" AND "'.date('Y').'-'.date('m').'-'.date('d').' 00:00:00"
            ORDER BY z_analytics_day.date_start ASC
            ');
        } elseif($statstypeid==2) {
            $result=$db->queryFetchAll('
            SELECT
              UNIX_TIMESTAMP(date_add(`date_start`, INTERVAL 3 HOUR))*1000 AS `date`,
              visits AS `value`,
              visitors AS `visitors`
            FROM
              z_analytics_month
            WHERE siteid='.tools::int($siteid).' AND date_start BETWEEN "'.(date('Y')-1).'-'.date('m').'-01 00:00:00" AND "'.date('Y').'-'.date('m').'-01 00:00:00"
            ORDER BY z_analytics_month.date_start ASC
            ');
        }
		if($result)
		return $result;
	}
	public function getStatsTypesData($siteid){
		$db=db::init();
		$result=$db->queryFetchAllAssoc('
		SELECT 
		  z_social_stats.`date`,
		  z_social_stats.`value`,
		  z_social_statstype.code,
		  z_social_statstype.color,
		  z_social_statstype.name,
		  z_social_statstype.id
		FROM
		  z_social_stats 
		  INNER JOIN
		  z_social_statstype 
		  ON z_social_statstype.id = z_social_stats.statstypeid 
		WHERE z_social_stats.siteid = '.tools::int($siteid).' AND z_social_stats.value>0
		AND z_social_stats.DATE = 
		  (SELECT 
		    MAX(z_social_stats.DATE) 
		  FROM
		    z_social_stats)
		GROUP BY z_social_stats.statstypeid 
		ORDER BY z_social_statstype.id ASC
		');
		
		$ga=$db->queryFetchRowAssoc('
		SELECT 
		 z_analytics_day.`id`,
		 z_analytics_day.visits
		FROM
		  z_analytics_day 
		WHERE siteid = '.tools::int($siteid).' 
		ORDER BY date_start DESC
		LIMIT 0,1');
		if($ga['id']>0)		
        $result[]=array('id'=>7,'name'=>'Google Analytics', 'code'=>'ga','value'=>$ga['visits']);
		if($result)
		return $result;
	}
}
?>