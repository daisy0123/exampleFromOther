<?php
class Core_Security_Verify 
{
	const LENGTH = 4;
	/**
	* 功能：生成验证码
	* 返回：验证码字符串
	*/
	static function getVerify () {
		$strings = Array('3','4','5','6','7','a','b','c','d','e','f','h','i','j','k','m','n','p','r','s','t','u','v','w','x','y');
		$chrNum = "";
		$count = count($strings);
		for ($i = 1; $i <= self::LENGTH; $i++) {
			$chrNum .= $strings[rand(0,$count-1)];
		}
		return $chrNum;
	}
	/**
	* 功能：生成验证码图片
	*/
	static public function GetImage ($strNum) {
		if ($strNum == '')							//判断是否有验证码
			throw new Exception("No parameter passed in ");
		$fontSize = 15;
		$width = 70;
		$height = 24;
		$pointNum = 0;
		$im = imagecreate($width, $height);
		$backgroundcolor = imagecolorallocate ($im, 255, 255, 255);
		$frameColor = ImageColorAllocate($im, 150, 150, 150);
		$stringColor = ImageColorAllocate($im, 30, 30, 30);
		$font = realpath(FONT_PATH."arial.ttf");
		for($i = 0; $i < self::LENGTH; $i++) {				//循环写字
			$charY = ($height+9)/2 + rand(-1,1);
			$charX = $i*15+8;
			$text_color = imagecolorallocate($im, mt_rand(50, 200), mt_rand(50, 128), mt_rand(50, 200));
			$angle = rand(-20,20);
			ImageTTFText($im, $fontSize, $angle, $charX,  $charY, $text_color, $font, $strNum[$i]);
		}
		for($i=0; $i <= 5; $i++) {						//循环画背景线
			$linecolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			$linex = mt_rand(1, $width-1);
			$liney = mt_rand(1, $height-1);
			imageline($im, $linex, $liney, $linex + mt_rand(0, 4) - 2, $liney + mt_rand(0, 4) - 2, $linecolor);
		}
		for($i=0; $i <= 32; $i++) {						//循环画背景点
			$pointcolor = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagesetpixel($im, mt_rand(1, $width-1), mt_rand(1, $height-1), $pointcolor);
		}
		imagerectangle($im, 0, 0, $width-1 , $height-1 , $frameColor);
		ob_clean();
		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
		exit;
	}
}
?>
