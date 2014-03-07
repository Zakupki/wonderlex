<?php
require_once 'modules/base/controllers/Base_Controller.php';

Class Seo_Controller Extends Base_Controller {
		public $registry;

        public function __construct($registry){
            parent::__construct($registry);
            $this->registry=$registry;
        }

        function indexAction() {
        }

		function robotsAction() {
		header("Content-type: text/html");
		echo 'User-agent: *
             Disallow: /';
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