<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Order.php';

Class Orders_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Order=new Order;

		}

        function indexAction() {
        	$this->orderlist=$this->Order->getOrderList();
        	$this->content =$this->view->AddView('order', $this);
			$this->view->renderLayout('admin', $this);
		}
		function orderinnerAction() {
			$this->order=$this->Order->getOrderInner($this->registry->rewrites[1]);
            $this->content =$this->view->AddView('orderinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updateorderinnerAction(){
		    $this->Order->updateOrderInner($_POST,$_FILES);
			$this->registry->get->redirect('/admin/orders/');
		}
}


?>