<?

final class get
{
	public $http_host;
	protected $registry;
	
	function __construct($registry){
		$this->http_host=$_SERVER['HTTP_HOST'];
		$this->registry = $registry;
	}
	public function handleDomain($checkhost=null){
		if($checkhost)
		$this->http_host=$checkhost;
		$this->http_host=str_replace('www.','',$this->http_host);
		foreach($this->registry->sitedomains as $dom){
			
			if(preg_match("'w([\d]+?).".$dom[0]."$'",$this->http_host,$domain)){
				return $domain['1'];
			}
			if($this->http_host==$dom[0]){
				//$_SESSION['langid']=$dom[2];
				/*$this->registry->langid=$dom[2];
				$translate_array = parse_ini_file("config/lang/".$dom[2].".ini");
				$this->registry->trans=$translate_array;*/
				define('MAIN_HOST',$dom[0]);
				return $dom[1];
			}
		}
		return 'client';
	}
	public function redirect($url){
		header("Location: ".$url."");
	//return;
	}
}

?>