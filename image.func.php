<?php
	require_once("string.func.php");
		//通过gd库做验证码
		//创建画布
	function verifyImage($type = 1,$length = 4,$sess_name = "verify"){
	$width = 80;
	$height = 30;
	
	$image = @imagecreatetruecolor($width,$height)or die('Cannot Initialize new GD image stream');
	
	$white = imagecolorallocate($image,255,255,255);
	$black = imagecolorallocate($image,0,0,0);
	//用填充矩阵填充画布
	imagefilledrectangle($image,1,1,$width-2,$height-2,$white);
	//随机产生4个数字
	//$type = 1;
	//$length = 4;
	$chars = buildRandomString($type,$length);
	$sess_name="verify";
	$_SESSION['verify']=$chars;
	$fontfile="SIMYOU.TTF";
	for($i=0;$i<$length;$i++){
		$size=mt_rand(14,18);
		$angle=mt_rand(-15,15);
		$x=5+$i*$size;
		$y=mt_rand(20,26);
		$color=imagecolorallocate($image,mt_rand(50,90),mt_rand(80,200),mt_rand(90,180));
		$fontfile="../fonts/".$fontfile;
		$text=substr($chars,$i,1);//取随机产生的第一，第二，第三，第四个数字
		imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);
	}
	
	for($i=0;$i<50;$i++){
		imagesetpixel($image,mt_rand(0,$width-1),mt_rand(0,$height-1),$black);
		}
	
	for($i=0;$i<5;$i++){
		imageline($image,mt_rand(0,$width-1),mt_rand(0,$height-1),mt_rand(0,$width-1),mt_rand(0,$height-1),$black);
		}
		
	ob_clean();
	header ('Content-Type: image/gif');
	imagegif($image);
	imagedestroy($image);
		}
	verifyImage(2,5);
?>


