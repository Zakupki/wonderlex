<?php

require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Geo.php';
require_once 'modules/shop/models/Stats.php';
require_once 'modules/shop/models/Arttype.php';

Class Ajax_Controller Extends BaseShop_Controller {
		public $registry;

        public function __construct($registry){
            parent::__construct($registry);
            $this->registry=$registry;
            /*if(!tools::IsAjaxRequest())
                $this->registry->get->redirect('/');*/
        }

        function indexAction() {
        }
		  function findcityAction() {
            $this->Geo=new Geo;
            $data=$this->Geo->findCity($_REQUEST['term'],$_REQUEST['country_id'],$_SESSION['langid']);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        function findcountryAction() {
            $this->Geo=new Geo;
            $data=$this->Geo->findCountry($_REQUEST['term'],$_SESSION['langid']);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        function getstatsAction(){
            $this->Stats=new Stats;
            header('Content-Type: application/json; charset=utf-8');
            $data = array(
                '*data*' => $this->Stats->getStats($_GET['id'], $_GET['type'])
            );
            echo str_replace('*','"',(str_replace('"', '', json_encode($data))));
        }
        function getarttypeAction(){
            //echo 213;
            $this->Arttype = new Arttype;
            //print_r($_REQUEST);
            echo tools::getOptions(array_merge(array(0=>''),$this->Arttype->getArtTypes(array('type'=>$_POST['type'],'id'=>$_POST['id']))));
        }


}


?>