<?php
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PWD","root");
define("DB_DBNAME","shopImooc");
define("DB_CHARSET","utf8");
function connect(){
	$link = mysql_connect(DB_HOST,DB_USER,DB_PWD) or die("数据库连接失败Error".mysql_errno().".".mysql_error());
	mysql_set_charset(DB_CHARSET);
	mysql_select_db(DB_DBNAME);
	return $link;
	}
	//完成插入操作
function insert($table,$array){
	$keys = join(",",array_keys($array));
	$vals = "'".join("','",array_values($array))."'";
	$sql = "insert{$table}($keys) values({$vals})";
	mysql_query($sql);
	return mysql_insert_id();
}
//更新数据 update imooc_admin set username='king' where id = 1
function update($table,$array,$where = null){
	foreach($array as $key=>$val){
		if($str == null){
			$sep="";
			} else {
				$sep=",";
				}
		$str.=$sep.$key."='".$val."'";
		}
	$sql="update{$table}set{$str}".($where==null?null:"where".$where);
	mysql_query($sql);
	return mysql_affected_rows();	
	}
//删除数据
function delete($table,$where=null){
	$where=($where==null?null:"where ".$where);
	$sql="delete from{$table}{$where}";
	mysql_query($sql);
	return mysql_affected_rows();
	}
	
//得到指定的一条记录
function fetchOne($sql,$result_type=MYSQL_ASSOC){
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result,$result_type);
	return $row;
}
	
//得到所有记录
function fetchAll($sql,$result_type=MYSQL_ASSOC){
	$result = mysql_query($sql);
	while(@$row=mysql_fetch_array($result,$result_type)){
		$rows[]=$row;
		}
		return $rows;
	}
//得到结果的记录条数
function getResultNum($sql){
	$result=mysql_query($sql);
	return mysql_num_rows($result);
	}
	/*connect();
	$sql= "select * from imooc_admin where username='king'";
	$result=mysql_query($sql);
    $row = mysql_fetch_array($result,MYSQL_ASSOC);    	 
	var_dump($row);*/

?>
	
	