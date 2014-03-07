<?php

require_once 'modules/base/controllers/BaseShopAdmin_Controller.php';
require_once 'modules/shop/models/File.php';

Class File_Controller Extends BaseShopAdmin_Controller {
		private $registry;

		public function __construct($registry){
			parent::__construct($registry);
			$this->registry=$registry;
			$this->registry->token=new token;
		}
        function indexAction() {
		}
		function open_image ($file) {
	    $extension = strrchr($file, '.');
	    $extension = strtolower($extension);

	    switch($extension) {
	        case '.jpg':
	        case '.jpeg':
	            $im = @imagecreatefromjpeg($file);
	            break;

	        case '.gif':
	            $im = @imagecreatefromgif($file);
	            break;

	        case '.png':
	            $im = @imagecreatefrompng($file);
	            break;

	        default:
	            $im = false;
	            break;
	    }
	    return $im;
		}
	function imageresizecrop($outfile_name, $infile, $left, $top, $width, $height, $quality) {
		$outfile = imagecreatetruecolor($width, $height);
        imagecolorallocate($outfile, 0, 0, 0);
        imagecopyresampled(
	        $outfile, $infile,
	        0, 0, $left, $top,
	        $width, $height, $width, $height);
		if(imagejpeg($outfile, $outfile_name, $quality)){
		imagedestroy($outfile);
		return $outfile_name;
		}
	}
		
		function cropAction(){
				
			    ///$data = json_decode(stripcslashes($_POST),true);
				//tools::print_r($_POST);
				//return;
				
				$data = array(
		        'post' => $_POST,
		        'files' => $_FILES,
		        'src' => '',
		        'status' => '',
		        'error' => false
		   		);
				
				$file=$_POST;
				if($file['size']>0)
				$file['size']=$file['size']."_";
				else $file['size']='';
				
				$path_parts=pathinfo($file['file']);
				$newbase=md5(uniqid().microtime());
				$newfile=$path_parts['dirname']."/".$newbase.".".$path_parts['extension'];
				$newreturnfile=$path_parts['dirname']."/".$file['size'].$newbase.".".$path_parts['extension'];
				
				$im = self::open_image($_SERVER['DOCUMENT_ROOT'].$file['file']);
				
				
				$new_croped_file=self::imageresizecrop($_SERVER['DOCUMENT_ROOT'].$newfile, $im, $file['x'], $file['y'], $file['width'], $file['height'], 100);
				if(!$file['edit'])
				unlink($_SERVER['DOCUMENT_ROOT'].$file['file']);
				if($new_croped_file){
					$data['file'] = $newreturnfile;
			    } else {
			        $data['status'] = 'Произошла ошибка при загрузке изображения.';
			        $data['error'] = true;
			    }
				echo json_encode($data);
		}
		
		function uploadimageAction(){
			if($_POST['size'])
			$_POST['size']=$_POST['size'].'_';
			else {
			$_POST['size']=null;	
			}
			if($_POST['preview_size'])
			$_POST['preview_size']=$_POST['preview_size'].'_';
			else {
			$_POST['preview_size']=null;	
			}
			
			$data = array(
		        'src' => '',
		        'status' => '',
		        'error' => false
		    );
			
			if (!empty($_FILES)) {
				$imagetmpsize=getimagesize($_FILES['Filedata']['tmp_name']);
				if($imagetmpsize[0]<$_POST['min_w'] || $imagetmpsize[1]<$_POST['min_h']){
					$data['status'] = $_FILES['Filedata']['name'].': изображение должно быть больше чем '.$_POST['min_w'].'x'.$_POST['min_h'].' px.';
					$data['error'] = true;
					echo json_encode($data);
					return;
				}
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilebase=md5(uniqid().microtime());
			$newfilename=$newfilebase.".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			$returnTargetFile  = str_replace('//','/',$targetPath) . $_POST['size'] .$newfilebase.".".$path_parts['extension'];
			$returnTargetFilePreview  = str_replace('//','/',$targetPath) . $_POST['preview_size'] .$newfilebase.".".$path_parts['extension'];
			$returnTargetFileSrc  = str_replace('//','/',$targetPath) .$newfilebase.".".$path_parts['extension'];
			
			if(move_uploaded_file($tempFile,$targetFile)){
				$imagesize=getimagesize($targetFile);
			    $data['file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
				$data['src_file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFileSrc);
				$data['preview_file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFilePreview);
				$data['extension']=strtolower($path_parts['extension']);
				$data['width']=$imagesize[0];
				$data['height']=$imagesize[1];
	        } else {
	            $data['status'] = 'Произошла ошибка при загрузке изображения.';
	            $data['error'] = true;
	        }
			echo json_encode($data);
			}
		}
		function uploadbannerAction(){
			if($_POST['size'])
			$_POST['size']=$_POST['size'].'_';
			$_POST['size']='';
			$data = array(
		        'post' => $_POST,
		        'files' => $_FILES,
		        'src' => '',
		        'status' => '',
		        'error' => false
		    );
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilebase=md5(uniqid().microtime());
			$newfilename=$newfilebase.".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			$returnTargetFile  = str_replace('//','/',$targetPath) . $_POST['size'] .$newfilebase.".".$path_parts['extension'];
			if(move_uploaded_file($tempFile,$targetFile)){
			    $data['file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
	        } else {
	            $data['status'] = 'Произошла ошибка при загрузке изображения.';
	            $data['error'] = true;
	        }
			echo json_encode($data);
			}
		}
		function usercssAction(){
header("Content-type: text/css");
echo "
a,
a:hover {color: #".$_SESSION['Site']['linkcolor'].";}

body {background: #".$_SESSION['Site']['bgcolor'].";}

/* .jcheck-input .i {background-image: url(/uploads/checkbox/".$_SESSION['Site']['maincolor'].".png);} */

.button .bg {background: #".$_SESSION['Site']['maincolor'].";}

.layout-header {background-color: #".$_SESSION['Site']['maincolor'].";}
.error404 {background-color: #".$_SESSION['Site']['maincolor'].";}

.layout-header-bot {background-image: url(/uploads/waves/".$_SESSION['Site']['bgcolor'].".png);}

.lang a,
.lang a:hover {color: #".$_SESSION['Site']['headcolor'].";}

.currency,
.currency .label,
.currency .jdrop {color: #".$_SESSION['Site']['headcolor'].";}
.currency .jdrop-arrow {background-image: url(/uploads/droparrow/".$_SESSION['Site']['headcolor'].".png);}

.search .query,
.search .submit-button {color: #000000;}
.search .query {border-color: #000000;}

.m1 .jdrop-open .jdrop-caption a,
.m1 .jdrop-open .jdrop-caption a:hover {color: #".$_SESSION['Site']['linkcolor'].";}
.m1 .title a,
.m1 .title a:hover,
.m1 .jdrop-caption a,
.m1 .jdrop-caption a:hover {color: #".$_SESSION['Site']['headcolor'].";}
.m1 .jdrop-arrow {background-image: url(/uploads/droparrow/".$_SESSION['Site']['headcolor'].".png);}
.m1 .jdrop-title,
.m1 .jdrop-open .jdrop-arrow {background-image: url(/uploads/droparrow/".$_SESSION['Site']['linkcolor'].".png);}

.auth-link .i {background-image: url(/uploads/user/".$_SESSION['Site']['headcolor'].".png);}

.member .profile-link .i {background-image: url(/uploads/user/".$_SESSION['Site']['headcolor'].".png);}
.member .admin-link .i {background-image: url(/uploads/settings/".$_SESSION['Site']['headcolor'].".png);}
.member .logout-link .i {background-image: url(/uploads/logout/".$_SESSION['Site']['headcolor'].".png);}

.pager a,
.pager a:hover {color: #".$_SESSION['Site']['maincolor'].";}
.pager .prev .i {background-image: url(/uploads/prev/".$_SESSION['Site']['maincolor'].".png);}
.pager .next .i {background-image: url(/uploads/next/".$_SESSION['Site']['maincolor'].".png);}

.auth .tabs li {color: #".$_SESSION['Site']['maincolor'].";}
.auth .network-links ul span {color: #".$_SESSION['Site']['maincolor'].";}

.filter .jdrop-caption {color: #".$_SESSION['Site']['linkcolor'].";}
.filter .jdrop-arrow {background-image: url(/uploads/droparrow/".$_SESSION['Site']['linkcolor'].".png)}

.catalog .buy span {color: #".$_SESSION['Site']['linkcolor'].";}
/*.catalog .buy .i {background-image: url(/uploads/basket/".$_SESSION['Site']['linkcolor'].".png);}*/

.catalog-widget .buy span {color: #".$_SESSION['Site']['linkcolor'].";}
/*.catalog-widget .buy .i {background-image: url(/uploads/basket/".$_SESSION['Site']['linkcolor'].".png);}*/

.product-links .buy span {color: #".$_SESSION['Site']['linkcolor'].";}
/*.product-links .buy .i {background-image: url(/uploads/basket/".$_SESSION['Site']['linkcolor'].".png);}*/

.product-links .favorites span {color: #".$_SESSION['Site']['linkcolor'].";}
.product-links .favorites .i {background-image: url(/uploads/favorites/".$_SESSION['Site']['linkcolor'].".png);}

.news .jswap-prev {background-image: url(/uploads/prev/".$_SESSION['Site']['maincolor'].".png);}
.news .jswap-next {background-image: url(/uploads/next/".$_SESSION['Site']['maincolor'].".png);}

.events-block .bg-top,
.events-block .bg-bot {background-image: url(/uploads/eventbg/".$_SESSION['Site']['eventscolor'].".png);}
.no-edges .events-block .content {background: #".$_SESSION['Site']['eventscolor'].";}

.services .more-link a,
.services .more-link a:hover {color: #".$_SESSION['Site']['maincolor'].";}
.services .more-link .i {background-image: url(/uploads/morelink/".$_SESSION['Site']['maincolor'].".png);}

.author .button .i,
.service .button .i,
.services .button .i {background-image: url(/uploads/works/ffffff.png);}

.authors .works-link .i {background-image: url(/uploads/works/ee3654.png);}

.blog .more a,
.blog .more a:hover {color: #".$_SESSION['Site']['maincolor'].";}

/* .comments-form .user .i {background-image: url(/uploads/user/".$_SESSION['Site']['linkcolor'].".png);} */
/* .comments-list .remove {background-image: url(/uploads/remove/".$_SESSION['Site']['maincolor'].".png);} */

.favers .user a,
.favers .user a:hover {color: #".$_SESSION['Site']['maincolor'].";}

.auth .recover-link {color: #".$_SESSION['Site']['linkcolor'].";}
";

if ($_SESSION['Site']['hdpattern'] && !$_SESSION['Site']['headercolor']) {
echo "
.layout-header {background-image: url(".$_SESSION['Site']['hdpattern'].");}
.error404 {background-image: url(".$_SESSION['Site']['hdpattern'].");}
";
}		
}
		function uploadlogoAction(){
			$data = array(
				'src_file' => '',
		        'status' => '',
		        'error' => false
		    );
			if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
			$path_parts=pathinfo($_FILES['Filedata']['name']);
			$newfilebase=md5(uniqid().microtime());
			$newfilename=$newfilebase.".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			$returnTargetFile  = str_replace('//','/',$targetPath) . $newfilebase.".".$path_parts['extension'];
			
			$this->Image=new Image;
						
			if($this->Image->thumb($tempFile, $targetFile, $_POST['max_w'], $_POST['max_h'])){
			    $data['src_file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
				$data['file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
	        } elseif(move_uploaded_file($tempFile,$targetFile)) {
	        	$data['src_file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
				$data['file'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
	        }
			if(!file_exists($returnTargetFile)){
				$data['status'] = 'Произошла ошибка при загрузке изображения.';
	            $data['error'] = true;
			}
			echo json_encode($data);
			}
		}
		function getuploadsAction(){
			$this->File=new File;
			echo json_encode($this->File->getUploads());
		}
		
		function adduploadAction(){
			
			/*echo $_SESSION['Site']['id'];
			$folder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/';
			$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
			if (
			    $_FILES['file']['type'] == 'image/png' ||
			    $_FILES['file']['type'] == 'image/jpg' ||
			    $_FILES['file']['type'] == 'image/gif' ||
			    $_FILES['file']['type'] == 'image/jpeg' ||
			    $_FILES['file']['type'] == 'image/pjpeg'
			) {	
			    $file = time() . '-' . $_FILES['file']['name'];
			    move_uploaded_file($_FILES['file']['tmp_name'], $folder . $file);
			    $data = array(
			        'filelink' => '/projects/handy-admin/uploads/images/' . $file
			    );
			    echo json_encode($data);
			}*/
			
			
			$data = array(
		        'status' => '',
		        'error' => false
		    );
			
			if (!empty($_FILES)) {
			$this->File=new File;
			$tempFile = $_FILES['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/sites/'.$_SESSION['Site']['id'].'/img/';
			$path_parts=pathinfo($_FILES['file']['name']);
			$newfilebase=md5(uniqid().microtime());
			$newfilename=$newfilebase.".".$path_parts['extension'];
			$targetFile =  str_replace('//','/',$targetPath) . $newfilename;
			$returnTargetFile  = str_replace('//','/',$targetPath) . $newfilebase.".".$path_parts['extension'];
			if(move_uploaded_file($tempFile,$targetFile)){
				$this->File->addUpload($newfilename);
				$imagesize=getimagesize($targetFile);
			    $data['filelink'] = str_replace($_SERVER['DOCUMENT_ROOT'],'',$returnTargetFile);
				$data['extension']=strtolower($path_parts['extension']);
				$data['width']=$imagesize[0];
				$data['height']=$imagesize[1];
	        } else {
	            $data['status'] = 'Произошла ошибка при загрузке изображения.';
	            $data['error'] = true;
	        }
			echo json_encode($data);
			}
		}
		function removeAction(){
			$data = array(
			    'error' => false,
			    'status' => ''
			);
			$this->File=new File;
			$this->File->removeUpload($_POST);
			echo json_encode($data);
		}
}


?>