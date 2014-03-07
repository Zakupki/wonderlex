<?php
Class Router {
        public $registry;
        private $path;
        private $args = array();
		private $_urlDelimiter='/';
		private $routes;
		private $_requestUrl;
        function __construct($registry) {
        	
				
                $this->registry = $registry;
				$this->Session=session::init();
				$this->_requestUrl=trim($_SERVER['REQUEST_URI'],'/');
				preg_match("/^\/(\w+)\/?/", '/'.$this->_requestUrl.'/', $matches);
				if($matches[1] && in_array($matches[1],$registry->langArr)){
				//	tools::print_r($this->_requestUrl);
					$this->_requestUrl=str_replace($matches[1].'/', '', $this->_requestUrl);
				}
				
				
				
				$this->tools = new tools;
				$this->registry->get=new get($this->registry);
					$this->domaintype=$this->registry->get->handleDomain();
					$this->Client=new client();
					
					if($this->domaintype=='main'){
						$this->siteid=1;
						$requestUrl=explode('/', $this->_requestUrl);
						if($requestUrl[0]=='admin')
						$this->module='admin';
						else
						$this->module='main';
					}
					elseif($this->domaintype=='client'){
						if($_SESSION['Site']['id']>0)
						$siteid=$_SESSION['Site']['id'];
						else						
						$siteid=$this->Client->getSiteid(str_replace('www.','',$_SERVER['HTTP_HOST']));
						if($siteid>0){
							$this->siteid=$siteid;
							$this->module='client';
						}						
					}
					elseif($this->domaintype>1){
						if($_SESSION['Site']['id']>0){
							$siteid=$_SESSION['Site']['id'];
						}
						else
						$siteid=$this->Client->isServiceid($this->domaintype);
						if($siteid>0){
							$this->siteid=$siteid;
							$this->module='client';
						}
					}
					
					if(!$this->siteid){
					//echo $this->module;
					header("Location: http://wonderlex.com/");
                    die();
					}
					else{
						if($this->module=='client' && $this->siteid>0)
						$this->module=$this->Client->getClienttype($this->siteid);
						if($this->siteid>0){
							$_SESSION['Site']['id']=$this->siteid;
							$this->Session->module=$this->module;
						}
					}
                if($_SESSION['Site']['id'])
				$this->registry->siteid=$_SESSION['Site']['id'];
				$this->registry->module=$this->Session->module;
                
                /*
                if($_SERVER['REMOTE_ADDR']=='31.42.52.10'){
                                    echo $this->registry->module;
                                    echo $this->registry->siteid;
                                    die();
                                }*/
                $forstsites=array('main','admin');
                
                if($this->registry->siteid==1 && !in_array($this->registry->module,$forstsites)){
                //$this->registry->siteid=0;
                $_SESSION['Site']['id']=1;
                header("Location: http://wonderlex.com/");
                die();
                }
                //echo $this->registry->siteid;
                //die('123'); 
		}
		
		public function addRewrite($title, $rewrites, $controller){
			 	$this->routes[$title]['rewrite']=$rewrites;
				$this->routes[$title]['controller']=$controller;
		}
		
		public function findRewrite(){
			
			foreach($this->routes as $k=>$v){
				if(preg_match('/'.$v['rewrite'].'/', $this->_requestUrl, $this->rewritematched) && $v['controller'][0]==$this->registry->module){
					$this->registry->rewrites=$this->rewritematched;
					/*echo $this->registry->module;
					tools::print_r($v['controller']);*/
					return $k;
				}
			}		
		}
		
		function setPath($path) {
        
		$path=$path.'/'.$this->Session->module.'/controllers';
		if (is_dir($path) == false) {

                throw new Exception ('Invalid controller path: `/' . $path . '`');

        }


        $this->path = $path;
		$this->controller_path =$path;
		
		}
		
		private function getLanguage($route){
			if(!$this->registry->langkeyid){	
				preg_match("/^(\w+)\/?/", $route.'/', $matches);
				if($matches[1] && in_array($matches[1],$this->registry->langArr)){
				$route=str_replace($matches[1].'/', '', $route);
				$this->registry->langkeyid=array_search($matches[1], $this->registry->langArr);
				}
			}
			return $route;
		}
		
		private function getController(&$file, &$controller, &$action, &$args) {
			
		$route = (empty($_GET['route'])) ? '' : $_GET['route'];
		$route=self::getLanguage($route);
		
		if (empty($route)) { $route = 'Index'; }


        // Получаем раздельные части

        $route = trim($route, '/\\');

        $parts = explode('/', $route);
		//print_r($parts);

        // Находим правильный контроллер

        $this->cmd_path = $this->path.'/';
		/*echo "<pre>";
		print_r($parts);
		echo "</pre>";*/
		
        foreach ($parts as $part) {
        		if($this->Session->module==$part){
				array_shift($parts);
				continue;
				}
                
				$fullpath = $this->cmd_path . ucfirst($part);
				
				// Есть ли папка с таким путём?
				if (is_dir($fullpath)) {
					    $this->cmd_path .= $part . DIRSEP;

                        array_shift($parts);

                        continue;

                }
				
                // Находим файл
				if (is_file($fullpath . '_Controller.php')) {
                		$controller = ucfirst($part);
						
                        array_shift($parts);
						
						break;

                }
				
				

        }
		
		//echo $controller;


        if (empty($controller)) { $controller = 'Index';};

		// Получаем действие
		$action = array_shift($parts);
		//
		
        if (empty($action)) { $action = 'indexAction'; }
		else
		$action=$action.'Action';


        $file = $this->cmd_path . $controller . '_Controller.php';

        $args = $parts;
		
		
		}
		
		function delegate() {
			if($this->registry->routername=self::findRewrite()){
				//echo $this->registry->routername;
				
				/*preg_match("/^(\w+)\/?/", $route.'/', $matches);
		
				if($matches[1] && in_array($matches[1],$this->registry->langArr)){
					$route=str_replace($matches[1].'/', '', $route);
					$this->registry->langkeyid=array_search($matches[1], $this->registry->langArr);
				}*/
				$route = (empty($_GET['route'])) ? '' : $_GET['route'];
				self::getLanguage($route);
				/*
				echo $this->_requestUrl;
				echo $this->registry->routername;
				echo "<br/>";
				echo $this->routes[$this->registry->routername]['controller'][1];*/
				
				$file = $this->controller_path.'/'.ucfirst($this->routes[$this->registry->routername]['controller'][1]) . '_Controller.php';
				if (is_readable($file) == false) {
		                die ($file.'Controller Not Found');
		        }
		
		        // Подключаем файл
		        include ($file);
		
		        // Создаём экземпляр контроллера
		        $class = $this->routes[$this->registry->routername]['controller'][1].'_Controller';
		        $controller = new $class($this->registry);
				$action=$this->routes[$this->registry->routername]['controller'][2].'Action';
		        // Действие доступно?
				if (is_callable(array($controller, $action)) == false) {
					
					  if(in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){ 	
					  die ('Action Not Found');
					  }elseif($_SESSION['Site']['id']>1){
					  header("Status: 404 Not Found"); //FastCGI
                      $homepage = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/404/');
                      echo $homepage;
                      exit;
					  }    
		        }
				$this->registry->controller=$this->routes[$this->registry->routername]['controller'][1];
				$this->registry->action=$this->routes[$this->registry->routername]['controller'][2];
				// Выполняем действие
		        $controller->$action();
				
			
			}
			else {
					
				
				// Анализируем путь
				
				$this->getController($file, $controller, $action, $args);
		
		        // Файл доступен?
		        if (is_readable($file) == false) {
		        	  if(in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){ 	
					  die ($file.'Controller Not Found');
					  }elseif($_SESSION['Site']['id']>1){
					  header("Status: 404 Not Found"); //FastCGI
                      $homepage = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/404/');
                      echo $homepage;
                      exit;
					  }
				}
		
		        // Подключаем файл
		        include ($file);
				$this->registry->controller=strtolower($controller);
				$this->registry->action=str_replace('Action','',$action);
		        // Создаём экземпляр контроллера
		        $class = $controller.'_Controller';
		        $controller = new $class($this->registry);
				/*echo $action.'<br/>';*/
		        // Действие доступно?
				if (is_callable(array($controller, $action)) == false) {
					 
					  if(in_array($_SERVER['REMOTE_ADDR'],tools::allowed_ip())){
					  die ('<h2>Action '.$action.' of controller '.$class.' Not Found</h2>');
					  }elseif($_SESSION['Site']['id']>1){
					  header("Status: 404 Not Found"); //FastCGI
					  $homepage = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/404/');
					  echo $homepage;
					  exit;
					  }
		        }
				// Выполняем действие
		        $controller->$action();
			}

		}

}


?>