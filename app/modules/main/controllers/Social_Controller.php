<?php
require_once 'modules/main/models/Social.php';
require_once 'modules/base/controllers/Base_Controller.php';

Class Social_Controller Extends Base_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
            //if(!isset($this->Social))
            $this->Social=new Social;
		}
        function indexAction(){

        }
        function disconnectAction(){
            $this->Social->disconnect($_GET['id']);
        }
        function vkconnectAction() {
            $userid=$_SESSION['User']['id'];
            $this->Vk=new Vk;
            $returndata=$this->Vk->connect(array('code'=>$_GET['code']));
            if($userid){
                $this->registry->get->redirect('/');
            }
            else{
                $this->registry->get->redirect('/');
            }
		}
        function fbconnectAction() {
            $userid=$_SESSION['User']['id'];
            $this->Facebook=new Facebook;
            $returndata=$this->Facebook->connect2(array('code'=>$_GET['code']));

            //print_r($returndata);
            /*if($returndata>0)
                $this->registry->get->redirect('http://'.$_SESSION['ref'].'/admin/account/?sescode='.$_SESSION['scode'].'&authkey='.$returndata['key'].'');*/
            if($userid)
                $this->registry->get->redirect('/');
            else
                $this->registry->get->redirect('/');
        }

}?>