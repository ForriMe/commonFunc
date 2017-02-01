<?php
//这两个函数一般放在字符串操作函数库中string.func.php  然后在头上require一下
function getUniName(){
	return md5(uniqid(microtime(true),true));
	}
function getExt($filename){
	return strtolower(end(explode(".",$filename)));
	}
$filename="des_big.jpg";
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=false,$scale=0.5){
	list($src_w,$src_h,$imagetype) = getimagesize($filename);//得到原图像的宽高，类型
//	$scale = 0.5;
	if(is_null($dst_w)||is_null($dst_h)){ //判断是否指定了宽高，若没指定，则用默认的缩放比例
		$dst_w=ceil($src_w*$scale);
		$dst_h=ceil($src_h*$scale);
		}
	$mime=image_type_to_mime_type($imagetype);//mime = image/jpg
	$createFun=str_replace("/","createfrom",$mime); //获得图像资源函数
	$outFun = str_replace("/",null,$mime); //输入图像函数
	$src_image=$createFun($filename);//解决了不同后缀图片的显示问
	$dst_image=imagecreatetruecolor($dst_w,$dst_h);//创建一个新的画布
	imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);//重采样，拷贝原图到新画
	//image_50/fadsfafaefd.jpg
	if($destination&&!file_exists(dirname($destination))){//destination有值但是不存在这个目录
		mkdir(dirname($destination),0777,true);
		}
	$dstFilename= $destination ==null?getUniName().".".getExt($filename):$destination;//
	$outFun($dst_image,$dstFilename);
	imagedestroy($src_image);
	imagedestroy($dst_image);
//	$isReservedSource=false;
	if(!$isReservedSource){
		unlink($filename);
		}
		return $dstFilename;
	}

thumb($filename,"image_50/".$filename,50,50,true);
thumb($filename,"image_220/".$filename,220,220,true);
thumb($filename,"image_350/".$filename,350,350,true);
thumb($filename,"image_800/".$filename,800,800,true);
?>




