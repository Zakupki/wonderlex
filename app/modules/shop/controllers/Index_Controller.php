<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Product.php';
require_once 'modules/shop/models/Account.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/widgets/Widget.php';

Class Index_Controller Extends BaseShop_Controller {
		public $registry;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->Account=new Account;
		}

        function indexAction() {
        	$this->mainmenu=$this->Menu->getMenuItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Fav=new Favourites;
			$this->favcount=$this->Fav->getFavCount();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Product=new Product;
			$this->banners=$this->Product->getBannerProducts();
			$productdata=$this->Product->getProducts(0,$_SESSION['Site']['mainrows']*4);
			$this->products=$productdata['products'];
			$this->favourites=$productdata['favourites'];
			$this->comments=$productdata['comments'];
            $this->Widget=new Widget($this->registry);
			if($this->registry->wigetmenu['events'])
			$this->widgetlist.=$this->Widget->events();
			if($this->registry->wigetmenu['blogs'])
			$this->widgetlist.=$this->Widget->blog();
			$this->partners=$this->Widget->partners();
			$this->teaser =$this->view->AddView('widgets/teaser', $this);
			$this->content =$this->view->AddView('index', $this);
			$this->view->renderLayout('layout', $this);	
				
        }
		function aboutAction() {
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Fav=new Favourites;
			$this->favcount=$this->Fav->getFavCount();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Widget=new Widget($this->registry);
			$this->widgetlist.=$this->Widget->contacts();
			if($this->registry->wigetmenu['events'])
			$this->widgetlist.=$this->Widget->smevents();
			    
			    if(strlen($this->registry->currentseotitle)>0)
                $this->seotitle=$this->registry->currentseotitle;
                if(strlen($this->registry->currentseodescription)>0)
                $this->seodescription=$this->registry->currentseodescription;
                if(strlen($this->registry->currentseotext)>0)
                $this->seotext=$this->registry->currentseotext;
                
			$this->aboutdata=$this->Account->getAbout();
			$this->content =$this->view->AddView('about', $this);
			$this->view->renderLayout('layout', $this);			
		}
		function contactsAction() {
			$str=uniqid();
      		$_SESSION['ADR_CAPTCHA']=substr($str, strlen($str)-4, strlen($str));
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Fav=new Favourites;
			$this->favcount=$this->Fav->getFavCount();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Account=new Account;
			$this->contactdata=$this->Account->getContacts();
            if($this->contactdata['address']){
                $graph_url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($this->contactdata['address'])."&sensor=false";
                $user = json_decode(file_get_contents($graph_url));
                $this->location=$user->results[0]->geometry->location;
            }
            
                if(strlen($this->registry->currentseotitle)>0)
                $this->seotitle=$this->registry->currentseotitle;
                if(strlen($this->registry->currentseodescription)>0)
                $this->seodescription=$this->registry->currentseodescription;
                if(strlen($this->registry->currentseotext)>0)
                $this->seotext=$this->registry->currentseotext;
            
            $this->Widget=new Widget($this->registry);
			if($this->registry->wigetmenu['catalog'])
			$this->widgetlist=$this->Widget->goods();
			if($this->registry->wigetmenu['events'])
			$this->widgetlist.=$this->Widget->smevents();
			$this->content =$this->view->AddView('contacts', $this);
			$this->view->renderLayout('layout', $this);			
		}
		function notfoundAction() {
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->sitedata=$this->Account->getSiteData();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->content =$this->view->AddView('404', $this);
			$this->view->renderLayout('blank', $this);			
		}
		function howtobuyAction(){
			header('Content-Type: application/json; charset=utf-8');	
			$this->Account=new Account;
			$data = array(
			    'error' => false,
			    'status' => ''
			);

			$data['content'] = '
			<div class="buy-help">
			  <h2>'.$this->registry->translate['howtobuy'].'</h2>
			  <div class="text">
			    <p>'.$this->Account->getHowtobuy().'</p>
			  </div>
			</div>
			';

			echo json_encode($data);
			
		}
		function howtoorderAction(){
			header('Content-Type: application/json; charset=utf-8');	
			$data = array(
			    'get' => $_GET,
			    'post' => $_POST,
			    'files' => $_FILES,
			    'error' => false,
			    'status' => ''
			);
			
			$data['content'] = '
			<div class="buy-form">
			  <h2>Заказать</h2>
				<div class="content">
			    <form action="/buysubmit/" method="post">
			    <input name="itemid" type="hidden" value="'.$_POST['itemid'].'"/>
			      <div class="field">
			        <div class="label"><label for="buy-name">Имя и фамилия</label></div>
			        <div class="input-text"><input name="name" id="buy-name" type="text" class="required" /></div>
			      </div>
			      <div class="field">
			        <div class="label"><label for="buy-email">E-mail</label></div>
			        <div class="input-text"><input name="email" id="buy-email" type="text" class="email required" /></div>
			      </div>
			      <div class="field">
			        <div class="label"><label for="buy-phone">Телефон</label></div>
			        <div class="input-text"><input name="phone" id="buy-phone" type="text" class="required" /></div>
			      </div>
			      <div class="field">
			        <div class="label"><label for="buy-address">Адрес</label></div>
			        <div class="input-text"><input name="address" id="buy-address" type="text" class="required" /></div>
			      </div>
			      <div class="field">
			        <div class="label"><label for="buy-message">Сообщение</label></div>
			        <div class="textarea"><textarea name="message" id="buy-message" cols="" rows=""></textarea></div>
			      </div>
			      <div class="submit">
			        <div class="button"><div class="bg"><div class="r"><div class="l"><button class="el" type="submit">Заказать</button></div></div></div></div>
			      </div>
			    </form>
			  </div>
			</div>
			';
			
			echo json_encode($data);
		}
		function testmailAction(){
		            
		        $subject = "Необходимо обновление подключения к Facebook!";
                $message = "Здравствуйте! \n\nВаше подключение на сайте ".$user['domain']." устарело! \n\nОбновите его на странице настройки аккаунта для дальнейше публикации ваших материалов. \n\nС уважением, Администрация сайта Wonderlex.com";
                echo mail('dmitriy.bozhok@gmail.com',$subject,$message);
                die();
                $smtp=new smtp;
                $smtp->Connect(SMTP_HOST);
                $smtp->Hello(SMTP_HOST);
                $smtp->Authenticate('info@wonderlex.com', 'a123qweqwe');
                $smtp->Mail('info@wonderlex.com');
                $smtp->Recipient('dmitriy.bozhok@gmail.com');
                echo $smtp->Data($message, $subject);   
                print_r($smtp->error);
		}
		function buysubmitAction(){
		    //tools::print_r($_SESSION['Site']);
			header('Content-Type: application/json; charset=utf-8');	
			$data = array(
			    'get' => $_GET,
			    'post' => $_POST,
			    'files' => $_FILES,
			    'error' => false,
			    'status' => ''
			);
                $subject = "Заказ товара";
                $message = "E-mail: ".$_POST['email']."\n\nИмя: ".$_POST['name']."\n\nТелефон: ".$_POST['phone']."\n\nАдрес: ".$_POST['address']."\n\nСообщение: ".$_POST['message']."\n\nТовар: http://".$_SERVER['HTTP_HOST']."/product/".$_POST['itemid']."\n\n";
                $smtp=new smtp;
                $smtp->Connect('ds210.mirohost.net');
                $smtp->Hello('ds210.mirohost.net');
                $smtp->Authenticate('informer@wonderlex.com', 'B4gAaOeW');
                $smtp->Mail('informer@wonderlex.com');
                $smtp->Recipient($_SESSION['Site']['email']);
                
                
            if($smtp->Data($message, $subject))                
			$data['content'] = '
			<div class="buy-help">
			  <h2>Ваш заказ принят</h2>
			  <div class="text">
			    <p>В ближайшее время с Вами свяжется наш менеджер для уточнения деталей.</p>
			  </div>
			</div>
			';
            else{
           $data['content'] = '
            <div class="buy-help">
              <h2>Ошибка!</h2>
              <div class="text">
                <p>Ваше сообщение не отправлено. </p>
              </div>
            </div>
            ';
            }
			echo json_encode($data);
		}

		function activateAction(){
			$User=new user;
			if($User->activateUser($_GET['act']))
			$this->registry->get->redirect('/');
			else
			$this->registry->get->redirect('/error/?error=1');
			
		}
		function agreementAction(){
			$this->mainmenu=$this->Menu->getMenuItems();
			$this->category=$this->Menu->getCategoryItems();
			$this->currency=$this->Menu->getCurrency();
			$this->sitedata=$this->Account->getSiteData();
			$this->Fav=new Favourites;
			$this->favcount=$this->Fav->getFavCount();
			$this->Design=new Design;
			$this->bannerdata=$this->Design->getBanner();
			$this->Widget=new Widget($this->registry);
			$this->widgetlist.=$this->Widget->contacts();
			$this->widgetlist.=$this->Widget->smevents();
			
			$this->agreement=$this->Account->getAgreement();
			$this->content =$this->view->AddView('agreement', $this);
			$this->view->renderLayout('layout', $this);			
		}


}


?>