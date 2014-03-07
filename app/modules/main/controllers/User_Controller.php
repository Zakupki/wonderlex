<?php

require_once 'modules/base/controllers/Base_Controller.php';
require_once 'modules/main/models/Users.php';
require_once 'modules/main/models/Geo.php';
require_once 'modules/main/models/Reccount.php';
require_once 'modules/main/models/Operation.php';
require_once 'modules/main/models/Basket.php';

Class User_Controller Extends Base_Controller {
    private $registry;
    public $error;
    public function __construct($registry){
        parent::__construct($registry);
        $this->registry=$registry;
        $this->view = new View($this->registry);
        $this->registry->token=new token;
        $this->Users=new Users;
    }

    function indexAction() {
        header("Location: /");
    }

    function profileAction() {
        $this->styles=array('cart','cart-pushcase');
        $this->profile=$this->Users->getUserFullProfile($_SESSION['User']['id']);
        $this->content =$this->view->AddView('userprofile', $this);
        $this->view->renderLayout('index', $this);
    }
    function historyAction() {
        if(!$_SESSION['User']['id'])
            $this->registry->get->redirect('/');
        $this->styles=array('cart','cart-pushcase','profile-history');
        $this->Basket=new Basket;
        $this->products=$this->Basket->getHistory();
        $this->content =$this->view->AddView('userhistory', $this);
        $this->view->renderLayout('index', $this);
    }
    function signupAction() {
        $this->styles=array('cart','cart-pushcase','profile-history');
        $this->Geo = new Geo;
        $this->countries=$this->Geo->getCountries();
        $this->content =$this->view->AddView('usersignup', $this);
        $this->view->renderLayout('index', $this);
    }
    function applyAction() {
        $this->Users->applySite();
    }
    function editsiteAction() {
        if(!$_SESSION['User']['id'])
            $this->registry->get->redirect('/');
        $this->styles=array('profile');
        $this->Reccount=new Reccount;
        $this->siteplans=$this->Reccount->getSitePlans();
        $this->sitedata=$this->Reccount->getUserSite($this->registry->rewrites[1]);
        $this->Operation= new Operation;
        $this->siteoperations=$this->Operation->getUserSiteOperations($this->registry->rewrites[1]);
        if(!$this->sitedata)
            $this->registry->get->redirect('/');
        $this->content =$this->view->AddView('editwsite', $this);
        $this->view->renderLayout('index', $this);
    }
    function payforsiteAction() {
        if(!$_SESSION['User']['id'])
            $this->registry->get->redirect('/');
        $this->Reccount=new Reccount;
        $payid=$this->Reccount->updatePlan($_GET);
        $this->registry->get->redirect('/user/purchasesite/?id='.$payid);
    }
    function purchasesiteAction(){
        if(!$_SESSION['User']['id'])
            $this->registry->get->redirect('/');
        $this->styles=array('cart','cart-pushcase');
        $this->Reccount=new Reccount;
        $this->plan=$this->Reccount->getPlanPrice($_GET);
        $this->Operation= new Operation;
        $oper_id=$this->Operation->popUpForSite($this->plan);
        $merchant_id='i7973552678';
        $signature="SkTs8f4HlzE6FUVrFKOnWY0GOwGisrTnyWdlRY1V41Mjt";
        $this->liqurl="https://www.liqpay.com/?do=clickNbuy";
        $method='card';
        $phone='+380931520242';

        $xml="<request>
				<version>1.2</version>
				<result_url>http://".$_SERVER['HTTP_HOST']."/popupend/</result_url>
				<server_url>http://".$_SERVER['HTTP_HOST']."/operation/operationresponse/</server_url>
				<merchant_id>$merchant_id</merchant_id>
				<order_id>$oper_id</order_id>
				<amount>".$this->plan['price']."</amount>
				<currency>UAH</currency>
				<description>Пополнение счета</description>
				<pay_way>$method</pay_way>
				</request>
				";

        $this->xml_encoded = base64_encode($xml);
        $this->lqsignature = base64_encode(sha1($signature.$xml.$signature,1));

        $this->content =$this->view->AddView('purchasesite', $this);
        $this->view->renderLayout('index', $this);

    }
    function loginAction() {
    $userData=$this->registry->user->loginUser(urldecode($_REQUEST['input_login']), trim(urldecode($_REQUEST['input_password'])), $this->Post->remember);
    header('Content-Type: text/html; charset=utf-8');
    if($userData) {
        header("HTTP/1.1 200 ".urlencode('Добро пожаловать')."");
        $json_data = '{
				        "userId": '.$userData['id'].'
				    }';
    } else {
        header("HTTP/1.1 401 ".urlencode('Логин/пароль неверный')."");

    }
    $json_data = str_replace("\r\n",'',$json_data);
    $json_data = str_replace("\n",'',$json_data);
    echo $json_data;
}

    function logoutAction() {
        $this->registry->user->loginOut();
        $this->registry->get->redirect('/');
    }
    function registerAction(){
        //GET
        $input_password = $_GET['input_password'];
        $input_password_repeat = $_GET['input_password_repeat'];
        $input_login = $_GET['input_login'];

        if($this->Valid->emailExists($input_login) && trim($input_password)==trim($input_password_repeat) ){
            $User=new user();
            $newuserid=$User->addUser(array('email'=>$input_login,'password'=>$input_password,'password2'=>$input_password_repeat));
        }
        if($newuserid){
            header("HTTP/1.1 200 ".urlencode('спасибо за регистрацию')."");
            $json_data = '{
                "userId": '.$newuserid.'
            }';
        }else{
            header("HTTP/1.1 401 ".urlencode('Такой email уже есть в базе.')."");
            /*$json_data = '{
                "userId": '.$newuserid.'
            }';*/
        }
        $json_data = str_replace("\r\n",'',$json_data);
        $json_data = str_replace("\n",'',$json_data);

        echo $json_data;
        exit;
    }

    function remindpassAction(){
        //GET
        $input_login = $_GET['input_login'];
        $this->user=new user;

        if($this->user->passwordretrieve($input_login)) {
            header("HTTP/1.1 200 ".urlencode('Пароль был отправлен на ваш e-mail.')."");
            $json_data = '{
        "userId": 0
    }';
        } else {
            header("HTTP/1.1 401 ".urlencode('E-mail не зарегистрирован .')."");
        }
        $json_data = str_replace("\r\n",'',$json_data);
        $json_data = str_replace("\n",'',$json_data);
    }
    function getnewpasswordAction(){
        $this->user=new user;
        $this->styles=array('about');
        if($this->user->setnewpassword($_GET['key'])){
            $this->head='Восстановление пароля.';
            $this->text='Новый пароль выслан на Ваш email';
        }
        else{
            $this->head='Восстановление пароля.';
            $this->text='Ссылка для восстановления пароля устарела';
        }
        $this->content =$this->view->AddView('message', $this);
        $this->view->renderLayout('index', $this);
    }
    function sendfeedbackAction(){
        $this->Support = new Support;
        if(strlen($_POST['message'])>0)
            $message=$this->Support->sendFeedback($_POST);
        if($message){
            $data = array(
                'error' => false,
                'status' => 'Форма отправлена'
            );
            echo json_encode($data);
        }
    }
    function updateprofileAction(){
        if($this->Users->updateUserProfile($_POST)){
            header("HTTP/1.0 200 ".urlencode('Данные успешно сохранены')."");
            $json = '{
		            "href": "/user/profile/",
		            "title": "Вернуться",
		            "message": "Данные успешно сохранены"
		        }';
            echo  $json;
        }
        else {
            header("HTTP/1.0 400 ".urlencode('Ошибка сохранения данных')."");
            $json = '{
		            "message": "Ошибка сохранения данные"
		        }';
            echo  $json;
        }
    }
    public function edithistoryAction(){
        $id = null;

        if (isset($_POST['ItemId'])) {
            $id = $_POST['ItemId'];
        }

        $flag = $_POST['flag'];

        if ($flag == 'remove') {

            $r = rand(0, 10);

            if ($r < 5) {
                header("HTTP/1.0 200 ".urleencode('OK')."");
            }
            else {
                header("HTTP/1.0 400 ".urleencode('Невозможно удалить запись')."");
            }

        }
        else if ($flag == 'load') {
            $r = rand(0, 5);
            $loadFlag = "more";
            if ($r < 2) {
                $loadFlag = "all";
            }
            $loadFlag = "all";
            $json_answer = '{
                    "flag": "' . $loadFlag . '",
                    "list": [
                    ]
                }';

            echo $json_answer;
        }
    }

}


?>