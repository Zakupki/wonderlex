<?php
require_once 'modules/base/controllers/BaseShop_Controller.php';
require_once 'modules/shop/models/Seo.php';

Class Seo_Controller Extends BaseShop_Controller {
		public $registry;

        public function __construct($registry){
            parent::__construct($registry);
            $this->registry=$registry;
        }

        function indexAction() {
        }

		function robotsAction() {
		header("Content-type: text/html");
		$this->Seo=new Seo;
		echo $this->Seo->getRobots();
		}
		
		function sitemapAction() {
		header("Content-type: text/xml");
		$this->Seo=new Seo;
		echo $this->Seo->getSitemap();
		}
		
		function rorAction() {
		header("Content-type: text/xml");
		$this->Seo=new Seo;
		echo $this->Seo->getRor();
		}
}
?>