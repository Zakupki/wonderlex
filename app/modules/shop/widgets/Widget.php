<?
require_once 'modules/shop/models/Product.php';
require_once 'modules/shop/models/Menu.php';
require_once 'modules/shop/models/Event.php';
require_once 'modules/shop/models/Blog.php';
require_once 'modules/shop/models/Partner.php';
require_once 'modules/shop/models/Account.php';
Class Widget {
	function __construct($registry){
		$this->registry=$registry;
		$this->view = new View($this->registry);
	}
	public function goods(){
		$this->Product=new Product;
		$productdata=$this->Product->getProducts(0,5);
		$this->products=$productdata['products'];
		$this->favourites=$productdata['favourites'];
		return $this->view->AddView('widgets/goods', $this);
	}
	public function contacts(){
		$this->Account=new Account;
		$this->contactdata=$this->Account->getContacts();
		return $this->view->AddView('widgets/contacts', $this);
	}
	public function howtobuy(){
		return $this->view->AddView('widgets/howtobuy', $this);
	}
	public function blog(){
		$this->Menu=new Menu;
		$this->pagename=$this->Menu->getPageName(5);
		$this->Blog=new Blog;
		$this->bloglist=$this->Blog->getBlogs(0,15);
		return $this->view->AddView('widgets/blog', $this);
	}
	public function events(){
		$this->Menu=new Menu;
		$this->pagename=$this->Menu->getPageName(6);
		$this->Event=new Event;
		$this->eventlist=$this->Event->getEvents(0,15);
		return $this->view->AddView('widgets/events', $this);
	}
	public function smevents(){
		$this->Menu=new Menu;
		$this->pagename=$this->Menu->getPageName(6);
		$this->Event=new Event;
		$this->eventlist=$this->Event->getEvents(0,5);
		if(is_array($this->eventlist))
		return $this->view->AddView('widgets/smevents', $this);
	}
	public function partners(){
		$this->Partner=new Partner;
		$this->partnerlist=$this->Partner->getPartners(0,5);
		return $this->view->AddView('widgets/partners', $this);
	}
}
?>