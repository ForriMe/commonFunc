<?php
require_once('../include.php');
$sql="select * from imooc_admin";
$totalRows = getResultNum($sql);

$pageSize = 2;
$totalPage = ceil($totalRows / $pageSize);
$page = $_REQUEST['page'];

if($page < 1 || $page == null ||!is_numeric($page)){
	$page = 1;
	} 

if($page > $totalPage) 
	$page = $totalPage;
$offset = ($page - 1) * $pageSize;


function showPage($page,$totalPage,$where=null){
	$where==null?null:"&".$where;
	$url=$_SERVER['PHP_SELF'];
	$index=($page==1)?"首页":"<a href='{$url}?page=1{$where}'>首页</a>";
	$last=($page==$totalPage)?"尾页":"<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
	$prev=($page==1)?"上一页":"<a href='{$url}?page=".($page-1)."{$where}'>上一页</a>";
	$next=($page==$totalPage)?"下一页":"<a href='{$url}?page=".($page+1)."{$where}'>下一页</a>";
	$str="总共{$totalPage}页/当前是第{$page}页";
	$p=null;
	
	for($i=1;$i<=$totalPage;$i++){
	
	if($page == $i){
		$p.="[{$i}]";
		} else {
			$p.="<a href='{$url}?page={$i}{$where}'>[{$i}]</a>";
			}
	}
	$pageStr = $str."<br/>" . $index . $prev .$p .$next .$last;
	return $pageStr;
}
?>