<?
require_once 'modules/admin/controllers/BaseAdmin_Controller.php';
require_once 'modules/admin/models/Mail.php';

Class Mail_Controller Extends BaseAdmin_Controller {
		public $registry;
		public $error;
		
		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->view = new View($this->registry);
			$this->Mail=new Mail;
		}

        function indexAction() {
        	$this->mailist=$this->Mail->getMailList();
        	$this->content =$this->view->AddView('mail', $this);
			$this->view->renderLayout('admin', $this);
		}
		function mailinnerAction() {
        	$this->mailinner=$this->Mail->getMailInner($this->registry->rewrites[1]);
        	$this->content =$this->view->AddView('mailinner', $this);
			$this->view->renderLayout('admin', $this);
		}
		function updatemailinnerAction(){
			$this->Mail->updateMailInner($_POST);
			$this->registry->get->redirect('/admin/mail/');
		}
		function sendmailAction(){
		$db=db::init();
		
		switch ($_POST['send']) {
		    case 1:
		        $result=$db->queryFetchAllAssoc('
				SELECT email FROM z_user WHERE email IS NOT NULL
				');
				break;
		    case 2:
		        $result=$db->queryFetchAllAssoc('SELECT 
				  z_user.email,
				  z_site.sitetypeid 
				FROM
				  z_user 
				  INNER JOIN z_site 
				    ON z_site.userid = z_user.id 
				GROUP BY z_user.id ');
				break;
		   case 3:
		        $result=$db->queryFetchAllAssoc('SELECT 
				  z_user.email 
				FROM
				  z_user 
				  LEFT OUTER JOIN
				  z_site 
				  ON z_site.userid = z_user.id 
				WHERE z_site.userid IS NULL
				GROUP BY z_user.id');
		        break;
		}
		//tools::str($result);
		$cnt=0;
		//$result=array(0=>array('email'=>'dmitriy.bozhok@gmail.com'),1=>array('email'=>'julijapetrychenko@gmail.com'));
		if(is_array($result)){
			$subject = $_POST['subject'];
			$message = stripslashes($_POST['detail_text']);
			
			foreach($result as $user){
				$smtp=new smtp;
				$smtp->Connect(SMTP_HOST);
				$smtp->Hello(SMTP_HOST);
				$smtp->Authenticate('info@wonderlex.com', 'wI6VVSks');
				$smtp->Mail('info@wonderlex.com');
				//$smtp->Recipient('dmitriy.bozhok@gmail.com');
				$smtp->Recipient($user['email']);
				if($smtp->Data($message, $subject))
				$cnt++;
			}
		}
		//echo $cnt;
		$this->registry->get->redirect('/admin/mail/');
		}
	
}


?>