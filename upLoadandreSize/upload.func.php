<?php
header("content-type:text/html/charset=utf-8");


function getExt($filename){
	return strtolower(end(explode(".",$filename)));
	}
function getUniName(){
	return md5(uniqid(microtime(true),true));
	}
function uploadFile($fileInfo,
					$allowExt=array("gif","jpeg","png","wbmp"),
					$maxSize="2097152",
					$imgFlag=true,
					$path="uploads"){
	
	//$allowExt=array("gif","jpeg","png","wbmp");
	$ext = getExt($fileInfo['name']);//获取后缀
	$fileInfo['name'] = getUniName().".".$ext;//生成唯一文件名
	//$imgFlag=true;
	$destination = $path."/".$fileInfo['name'];//上传路径
	//$path="uploads";
	//若不存在这个文件夹则创建之
	if(!file_exists($path)){
		mkdir($path,0777,true);
		}
//	$maxSize = 1024*1024;//2M
	if($fileInfo['error']==0){
		//判断文件是否是通过httpPOST上传上来的
		//is_uploaded_file($tmp_name)
		
		if(!in_array($ext,$allowExt)){
			exit("非法文件类型");
			} 
		if($fileInfo['size']>$maxSize){
			exit("文件大小超过限制");
			}
		if($imgFlag){
			//验证文件是真正的文件
			//getimagesize($filename)
			$info = getimagesize($fileInfo['tmp_name']);
			if(!$info){
				exit("不是真正的文件类型");
				}
			}
		
		if(is_uploaded_file($fileInfo['tmp_name'])){
			
			if(move_uploaded_file($fileInfo['tmp_name'],$destination)){
				$mes = "文件上传成功";
				} else {
					$mes = "文件移动失败";
					}
			
			} else {
				$mes = "文件不是通过HTTP POST方式上传的";
				}
			
		} else {
			switch($fileInfo['error']){
				case 1:
					$mes = "超过了配置文件上传的大小";//UPLOAD_ERR_INI+SIZE
					break;
				case 2:
					$mes = "超过了表单设置上传文件的大小";//UPLOAD_ERR__FORM_SIZE
					break;
				case 3:
					$mes = "文件部分被上传";//UPLOAD_ERR_PARTIAL
					break;
				case 4:
					$mes = "没有文件被上传";//UPLOAD_ERR_NO_FILE
					break;
				case 6:
					$mes = "没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
					break;
				case 7:
					$mes = "文件不可写";//UPLOAD_CANT_WRITE
					break;
				case 8:
					$mes = "由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
					break;
				}
			}
			return $mes;
}

$fileInfo=$_FILES['myfile'];
$info = uploadFile($fileInfo);
echo $info;
?>