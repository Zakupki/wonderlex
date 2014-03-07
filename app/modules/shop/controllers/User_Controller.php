<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/shop/models/Design.php';
require_once 'modules/shop/models/Favourites.php';
require_once 'modules/shop/models/Menu.php';
require_once 'modules/shop/widgets/Widget.php';
require_once 'modules/shop/models/Account.php';

Class User_Controller Extends Base_Controller {
		private $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->registry->token=new token;
			$this->messageum=$this->registry->user->getMessages($this->Session->User['id']);
			$this->Menu=new Menu($this->registry);
			$this->Account=new Account;
		}
		
		function indexAction(){
			
		}
		
		function recoverAction(){
			$out=array(
			'error'=>false,
			'status'=>'Инструкция для восстановления пароля отправлена.'
			);
			$this->user=new user;
			$this->user->passwordretrieve($_POST['email']);
			echo json_encode($out);
		}
		
        function loginAction() {
				if($this->Session->User['id'])
				$this->registry->get->redirect('/');
				
				$logindata=$_POST;
					if (true) {
						$userData=$this->registry->user->loginReccountUser($logindata['email'], $logindata['password'], $logindata['remember']);
						if($userData){
							$this->Session->User=$userData;
							$data=array(
								'error'=>false,
								'status'=>''
							);
							echo json_encode($data);
						}
						else{
							$data=array(
								'error'=>true,
								'status'=>'Комбинация логин-пароль не верна.',
								'token'=>$this->registry->token->getToken(5)
							);
							echo json_encode($data);
						}
					}
					else{
						$data=array(
						'error'=>true,
						'status'=>'Сессия устарела',
						'token'=>$this->registry->token->getToken(5)
						);
						echo json_encode($data);
					}			
        }
		
		
		function logoutAction() {
				$this->user=new user;
				$this->user->loginOut();
            	$this->registry->get->redirect('/');
        }
		function readmessageAction() {
			header('Content-Type: application/json; charset=utf-8');
			
			$db=db::init();
			$db->query('UPDATE z_messages SET z_messages.new='.intval($_GET['new']).' WHERE z_messages.id='.intval($_GET['id']).' AND z_messages.userid='.$this->Session->User['id'].'');
			$data = array(
			    'counter' => intval($this->registry->user->getMessages($this->Session->User['id'])),
			    'success' => true
			);
			
			echo json_encode($data);
			die();
        }
		function registerAction() {
				if($this->Session->User['id'])
				$this->registry->get->redirect('/');
				$this->token=$this->registry->token->getToken();
				/*if($this->Post->check || $this->Post->makeregister){*/
						
						/*#Проверка Логина
						if(strlen($this->Post->login)>0){
							if(!$this->Valid->isLogin($this->Post->login))
							$this->error['login']='Введите правильный логин.';
							else{
								if($this->Valid->loginExists($this->Post->login)==false)
								$this->error['login']='Такой логин уже зарегистрирован.';
							}
						}
						elseif(strlen($this->Post->login)<1 && !$this->Post->check) 
						$this->error['login']='Введите логин.';*/
						
						#Проверка Email
						if(strlen($this->Post->email)>0){
							if(!$this->Valid->isEmail($this->Post->email))
							$this->error['email']='Введите правильный email.';
							else{
								if($this->Valid->emailExists($this->Post->email)==false)
								$this->error['email']='Такой email уже зарегистрирован.';
							}
						}
						elseif(strlen($this->Post->email)<1 && !$this->Post->check) 
						$this->error['email']='Введите email.';
						
						if(strlen($this->Post->password)>0){
							if(strlen($this->Post->passwordcheck)>0){
								if($this->Post->password!=$this->Post->passwordcheck){
								$this->error['password']='&nbsp;';
								$this->error['password2']='Пароли не совпадают.';
								}
								
							}
							elseif(strlen($this->Post->password2)<1 && !$this->Post->check) 
							$this->error['password2']='Введите подтверждение пароля.';
							
						}
						elseif(strlen($this->Post->password)<1 && !$this->Post->check) 
						$this->error['password']='Введите пароль.';
						
						
					
					if(!is_array($this->error) && !$this->Post->check)
					{
						$User=new user();
						$User->addUser($this->Post->asIterator());
						//$this->registry->get->redirect('/');
						echo json_encode(array(
						'error'=>false, 
						'status'=>'Вы успешно зарегистрированы! На ваш email отправлено письмо с активацией вашего аккаунта.',
						'redirect'=>'/'
						));
						die();
					}
					if(!$this->Post->check){
						//tools::print_r($this->error);
					}
					if(is_array($this->error) || $this->Post->check) {
						foreach($this->Post->asIterator() as $k=>$v){
							if(!$this->error[$k] && $k!='check'){
							echo json_encode(true);
							die();
							}
						}
						echo json_encode(implode(',',$this->error));
						die();
					}
					
				/*}*/
				
				
				
				/*$this->content=$this->view->AddView('register_form', $this);
				$this->view->renderLayout('layout', $this);*/
		}
		function getnewpasswordAction(){
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
			
			//$this->aboutdata=$this->Account->getAbout();
			
				
			$this->user=new user;
			if($this->user->setnewpassword($_GET['key']))
			$this->text='Новый пароль выслан на Ваш email';
			else
			$this->text='Ссылка для восстановления пароля устарела';
			$this->content =$this->view->AddView('text', $this);	
			$this->view->renderLayout('layout', $this);	
		}
		function sendfeedbackAction(){
			
			if(strlen($_POST['email'])>0 && strlen($_POST['name'])>0 && strlen($_POST['message'])>0 && $_SESSION['ADR_CAPTCHA']==$_POST['user_capcha']){
				$this->user=new user;
				$subject = "Обратная связь";
				$message = "E-mail: ".$_POST['email']."\n\nИмя: ".$_POST['name']."\n\nСообщение: ".$_POST['message']."\n\n";
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('info@wonderlex.com', 'wI6VVSks');
				$smtp->Mail('info@wonderlex.com');
				$smtp->Recipient($this->user->getSiteOwnerEmail());
				if($smtp->Data($message, $subject)){
					$data['status'] = 'Ваше сообщение отправлено';
					echo json_encode($data);
				}
			}else {
					if($_SESSION['ADR_CAPTCHA']!=$_POST['user_capcha'])
					$data['status'] = 'Ведите правильный код спам фильтра';
					else
					$data['status'] = 'Ваше сообщение не было отправлено';
					echo json_encode($data);
			}
		}
}
?>