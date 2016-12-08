<?php
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

//http://yaming.site/interface/index.php?controler=xxxx&api=xxxx;
require_once('getdata.php');
require_once('interface.php');

$Controler = isset($_GET['controler']) ? $_GET['controler'] : "DefaultControler";
$Api = isset($_GET['api']) ? $_GET['api'] : NULL;


if($Controler != NULL && $Api != NULL){
	if(class_exists($Controler)){
		if(method_exists($Controler, $Api)){
			$Controler->$Api();
			$Controler->test();
			exit;
		}else{
			GetData::show(202,'api name is not exist!');
			exit;
		}
	}else{
		GetData::show(201,'controler is not exist!');
		exit;
	}
}else{
	GetData::show(404,'parameters error!');
	exit;
}


class DefaultControler{
	public function login(){
		$name = $_POST['name'];
		$pwd = $_POST['pwd'];
		$remember_me = $_POST['remember_me']=='false' ? 0 : 1;

		$connect = Db::getInstance();
		$connect->connect();
		$sql = "select * form user where name = '".$name."'";
		$exist = $connect->getRow($sql);
		if(!$exist){
			$insert = "insert into user (姓名,密码,记住密码) values (".$name.",".$pwd.",".$remember_me.")";
			$connect->addRow($insert);
			$connect->close();
			header("location:http://yaming.site/index.html?newuser=true");
			exit;
		}else{
			GetData::show(203,"user name is existed!");
		}
	}	

	public function test()
     {
        echo "测试成功";
     }
}

?>


