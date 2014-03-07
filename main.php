<?      if($_SERVER['REMOTE_ADDR']=='31.42.52.10')
        $expires = 60*60*24*14;
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;
		/*---------------------------------------------------------------------------------*/
		$ipArr=array('77.90.194.106','77.52.149.200','193.34.72.205','95.133.181.99','46.200.215.212','94.248.2.34');
		/*if(!in_array($_SERVER['REMOTE_ADDR'], $ipArr)){
			require_once 'atelier.html';
			die();
		}*/
		ini_set("memory_limit", "132M");
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		ini_set('display_errors', 1);
		//ini_set('display_errors', 1);

        if(!in_array($_SERVER['REMOTE_ADDR'], $ipArr)){
           // error_reporting(E_ALL);
        }
		define ('DIRSEP', DIRECTORY_SEPARATOR);
		$lib_paths = array();
		$lib_paths[] = "{$_SERVER['DOCUMENT_ROOT']}/app/";
		$lib_paths[] = "{$_SERVER['DOCUMENT_ROOT']}/_reactor/";
		$inc_path = implode(PATH_SEPARATOR, $lib_paths);
		set_include_path($inc_path);
		$site_path = $_SERVER['DOCUMENT_ROOT'].'/';
		define ('site_path', $site_path);
		define('MD5_KEY', 'osdgkadhgk');
		//define('MAIN_HOST', 'handy-friendy.com');
		define('MAIN_HOST2', 'wonderlex.com');
		define('MAIN_HOST3', 'handy.ua');
		//define('MAIN_HOST3', 'test.reparty.ru');
		define('MAIN_NAME', 'Wonderlex');
		define('MAIN_DB', 'reactor');
		define('DB_PREFIX', 'z_');
		define('MAIN_DEBUG', true);
		define('SMTP_HOST', 'ds139.mirohost.net');
		include_once "classes/loader.php";
		Loader::initialize();
		
		$registry = new Registry;
		
		$sitedomains[]=array(0=>'wonderlex.com',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.ru',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.ru',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.org',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.org',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.biz',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.biz',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.info',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.info',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.eu',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.eu',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.net',1=>'main',2=>1); 
		$sitedomains[]=array(0=>'wonderlex.net',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.com',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.in.ua',1=>'main',2=>1); 
		$sitedomains[]=array(0=>'wonderlex.in.ua',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.org.ua',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.org.ua',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.net.ua',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.net.ua',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonder-lex.com.ua',1=>'main',2=>1);
		$sitedomains[]=array(0=>'wonderlex.com.ua',1=>'main',2=>1);
				
		//$sitedomains[]=array(0=>'handy-friendy.com',1=>'main',2=>1);
		
		$registry->sitedomains=$sitedomains;
		
		$registry->langArr=array('1'=>'ru','2'=>'en');
		
		$registry->mainhost='http://'.$_SERVER['HTTP_HOST'];
		
		$registry->sitetitle='Reactor PRO';
		$registry->sitedesc='«Реактор» — профессиональное комьюнити саунд-продюсеров. Профайлами здесь служат персональные сайты, созданные на базе шаблонов (Reccount) и размещенные на личных доменах пользователей.';
		
		$router = new Router($registry);
		
		/*$router->addRewrite('newsinner',"^new\/(\d+)?$", array('main','news','newsinner'));
		$router->addRewrite('newspages',"^news\/(\d+)?$", array('main','news','index'));
		$router->addRewrite('newsservice',"^news\/service\/?$", array('main','news','index'));
		$router->addRewrite('newslatest',"^news\/latest\/?$", array('main','news','index'));*/
		
		$router->addRewrite('adminproduct',"^admin\/product\/(\d+)?$", array('shop','admin','product'));
		$router->addRewrite('admincategory',"^admin\/catalog\/(\d+)?$", array('shop','admin','catalog'));
		$router->addRewrite('adminservices',"^admin\/services\/(\d+)?$", array('shop','admin','service'));
		$router->addRewrite('adminservice',"^admin\/service\/(\d+)?$", array('shop','admin','service'));
		$router->addRewrite('adminevent',"^admin\/event\/(\d+)?$", array('shop','admin','event'));
		$router->addRewrite('adminblog',"^admin\/blog\/(\d+)?$", array('shop','admin','blog'));
		$router->addRewrite('adminauthors',"^admin\/authors\/(\d+)?$", array('shop','admin','author'));
		$router->addRewrite('adminauthor',"^admin\/author\/(\d+)?$", array('shop','admin','author'));
		
		$router->addRewrite('categorycatpage',"^catalog\/(\d+)\/(\d+)?", array('shop','catalog','index'));
		$router->addRewrite('categoryallpage',"^catalog\/all\/(\d+)?$", array('shop','catalog','index'));
		$router->addRewrite('categoryall',"^catalog\/all\/?$", array('shop','catalog','index'));
		
		$router->addRewrite('category',"^catalog\/(\w+)?$", array('shop','catalog','index'));
		$router->addRewrite('product',"^product\/(\d+)\/?", array('shop','catalog','product'));
		$router->addRewrite('servicepaging',"^services\/(\d+)?$", array('shop','services','index'));
		$router->addRewrite('service',"^service\/(\d+)?", array('shop','services','serviceinner'));
		$router->addRewrite('authorpage',"^authors\/(\d+)?$", array('shop','authors','index'));
		$router->addRewrite('author',"^author\/(\d+)?$", array('shop','authors','authorinner'));
		$router->addRewrite('eventpage',"^events\/(\d+)?$", array('shop','events','index'));
		$router->addRewrite('event',"^event\/(\d+)\/?", array('shop','events','eventinner'));
		$router->addRewrite('blogpage',"^blogs\/(\d+)?$", array('shop','blogs','index'));
		$router->addRewrite('blog',"^blog\/(\d+)?", array('shop','blogs','bloginner'));
		$router->addRewrite('favouritespage',"^favourites\/(\d+)?$", array('shop','favourites','index'));

		#wonderlex
		$router->addRewrite('w_collector',"^collector\/?", array('main','catalog','collector'));
        $router->addRewrite('w_product',"^product\/(\d+)?", array('main','catalog','product'));
        $router->addRewrite('w_author',"^author\/(\d+)?", array('main','authors','authorinner'));
        $router->addRewrite('w_editsite',"^user\/site\/(\d+)?", array('main','user','editsite'));
        

        #wonderlex admin
        $router->addRewrite('adminsite',"^admin\/site\/(\d+)?$", array('admin','sites','siteinner'));
		$router->addRewrite('adminsiteadd',"^admin\/site\/?$", array('admin','sites','siteinner'));
        $router->addRewrite('adminsitepageing',"^admin\/sites\/(\d+)?", array('admin','sites','index'));
        $router->addRewrite('adminapplication',"^admin\/application\/(\d+)?$", array('admin','sites','applicationinner'));
        $router->addRewrite('adminapplicationadd',"^admin\/application\/?$", array('admin','sites','applicationinner'));
		$router->addRewrite('adminmail',"^admin\/mail\/(\d+)?$", array('admin','mail','mailinner'));
		$router->addRewrite('adminmailnew',"^admin\/mail\/new?$", array('admin','mail','mailinner'));
		$router->addRewrite('admincitation',"^admin\/citation\/(\d+)?$", array('admin','citations','citationinner'));
		$router->addRewrite('admincitationinner',"^admin\/citation\/new?$", array('admin','citations','citationinner'));
		$router->addRewrite('adminarttype',"^admin\/arttype\/(\d+)?$", array('admin','arttype','arttypeinner'));
        $router->addRewrite('adminarttypeinner',"^admin\/arttype\/new?$", array('admin','arttype','arttypeinner'));
        $router->addRewrite('adminartstyle',"^admin\/arttype\/style\/(\d+)?$", array('admin','arttype','artstyleinner'));
        $router->addRewrite('adminartstyleinner',"^admin\/arttype\/style\/new?$", array('admin','arttype','artstyleinner'));
        $router->addRewrite('adminartgenre',"^admin\/arttype\/genre\/(\d+)?$", array('admin','arttype','artgenreinner'));
        $router->addRewrite('adminartgenreinner',"^admin\/arttype\/genre\/new?$", array('admin','arttype','artgenreinner'));
        $router->addRewrite('adminorder',"^admin\/order\/(\d+)?$", array('admin','orders','orderinner'));
        $router->addRewrite('adminuserpageing',"^admin\/users\/(\d+)?", array('admin','users','index'));

		$router->addRewrite('404',"404?$", array('shop','index','notfound'));
		//$router->addRewrite('index',"^$", array('main','releases','index'));
		
		
		
		//$registry->router->$router;
		
		$router->setPath (site_path .'app/modules');
		$router->delegate();
		
   /*---------------------------------------------------------------------------------*/	
   $mtime = microtime();
   $mtime = explode(" ",$mtime);
   $mtime = $mtime[1] + $mtime[0];
   $endtime = $mtime;
   $totaltime = ($endtime - $starttime);
   
   if($_SERVER['REMOTE_ADDR']=='31.42.52.10'){
    //print_r($_SESSION['Site']);
    //$valid = preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $string);    
   }       
      /*
          $link1 = mysql_connect("localhost","u_wonderle","t6cgepiP");
                                mysql_select_db("wonderle", $link1);
                                mysql_query("SET NAMES 'utf8'");
                                mysql_query('INSERT INTO _http_log (url,host,ip,time,agent) VALUES ("'.$_SERVER['REQUEST_URI'].'","'.$_SERVER['HTTP_HOST'].'","'.$_SERVER['REMOTE_ADDR'].'", '.round($totaltime,4).',"'.$_SERVER['HTTP_USER_AGENT'].'")');*/
      
              // echo    ('INSERT INTO _http_log (url,host,ip,time) VALUES ("'.$_SERVER['REQUEST_URI'].'","'.$_SERVER['HTTP_HOST'].'","'.$_SERVER['REMOTE_ADDR'].'", '.round($totaltime,4).')');
              
          //echo '<!--';
          //echo $_SERVER['REQUEST_URI'];
          
          // print_r($_SERVER);
          //echo '-->';
     // }
   
   
   //echo '<!--';
   //print_r($_SERVER);
   //echo '-->';
   //if(!tools::IsAjaxRequest() && $_SESSION['debug']=='123')
   //echo "<!--<br/>This page was created in ".round($totaltime,4)." seconds-->"; 
   
?>