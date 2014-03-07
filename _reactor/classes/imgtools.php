<?
class Imgtools {
	
	function changecolor($uri,$template){
		if ($_GET['REQUEST_URI'])
			$uri = $_GET['REQUEST_URI'];
		else
			$uri = urldecode($_SERVER['REQUEST_URI']);
		$im = @imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$template.'/template.png');
    	imagealphablending($im, false); 
		imagesavealpha($im, true);
		
		$fileinfo=pathinfo($uri);
		$newcolor=self::hex2rgb($fileinfo['filename']);
		
		for ($x=imagesx($im); $x--; ) {
		    for ($y=imagesy($im); $y--; ) {
		        
				
				$colors = imagecolorat($im, $x, $y);
				$c = imagecolorsforindex($im, $colors);
		       // print_r($c);
				//echo '<br>';
				if ($c['red'] == 0 && $c['green'] == 0 && $c['blue'] == 0) {
		            // here we use the new color, but the original alpha channel
		            $colorB = imagecolorallocatealpha($im, $newcolor[0], $newcolor[1], $newcolor[2], $c['alpha']);
		            imagesetpixel($im, $x, $y, $colorB);
		        }
		    }
		}
		
	
		header("Content-type: image/png");
		imagepng($im);
		imagepng($im,$_SERVER['DOCUMENT_ROOT'].$uri);
		imagedestroy($im);
	}
	public static function hex2rgb($color)
	  {
	    $color = str_replace('#', '', $color);
	    $s = strlen($color) / 3;
	    $rgb[] = hexdec(str_repeat(substr($color, 0, $s), 2 / $s));
	    $rgb[] = hexdec(str_repeat(substr($color, $s, $s), 2 / $s));
	    $rgb[] = hexdec(str_repeat(substr($color, 2 * $s, $s), 2 / $s));
	
	    return $rgb;
	  }
	
	function changecolor2($uri){
		if ($_GET['REQUEST_URI'])
			$uri = $_GET['REQUEST_URI'];
		else
			$uri = urldecode($_SERVER['REQUEST_URI']);
			$fileinfo=pathinfo($uri);
			$img = new Imagick('template.png');
			
			//$img->paintFloodfillImage("#000000", 1,'#CCCCCC', 1, 1, false);
			
			//$img->colorizeImage('#'.$fileinfo['filename'], 1.0);
			//$img->paintOpaqueImage('#000000', '#'.$fileinfo['filename'], 0.00);
			//$img->writeImage($fileinfo['basename']);
			
			$clut = new Imagick();
			$clut->newImage(1, 1, new ImagickPixel('#'.$fileinfo['filename']));
			$img->clutImage($clut);
			//$img->writeImage('test.png');
			header('content-type: image/png');
			echo $img;		
	}
}
?>