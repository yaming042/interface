<?php
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

 class Db
{

 //保存类实例的静态成员变量
     private static $_instance;
     private $_dbConfig = array(
            'host' => 'localhost',
            'user' => 'zjwdb_6062112',
            'password' => '123QWEasd',
            'database' => 'zjwdb_6062112',
        );
     private $_dbSource;
     private $result;
 
    //private标记的构造方法
     private function __construct(){}
 
    //创建__clone方法防止对象被复制克隆
     public function __clone()
     {
         trigger_error('Clone is not allow!', E_USER_ERROR);
     }
 
    //单例方法,用于访问实例的公共的静态方法
     public static function getInstance()
     {
         if (!(self::$_instance instanceof self)) {
             self::$_instance = new self;
         }
         return self::$_instance;
     }
 
    /*连接数据库*/
     public function connect(){
        if(!$this->_dbSource){
            $this->_dbSource = mysql_connect($this->_dbConfig['host'],$this->_dbConfig['user'],$this->_dbConfig['password']);
            if(!$this->_dbSource){
                echo "连接数据库失败";
            }else{
                echo "链接数据库成功";
            }
            mysql_select_db($this->_dbConfig['database'],$this->_dbSource);
            mysql_query("set names UTF8",$this->_dbSource);
        }

        return $this->_dbSource;
     }

     public function close(){
        return mysql_close($this->_dbSource);
     }

     /*查询表*/
     public function query($sql){ 
        // $this->_dbSource = self::connect(); 
        $this->result = mysql_query($sql,$this->_dbSource);
        return $this->result;
     }

     /*查询表记录条数*/
     public function getRow(){
        $sql = "select * from test";
        $source = self::query($sql);
        return mysql_num_rows($source);
     }

     /*插入一条记录*/
     public function addRow($sql){
        return self::query($sql);
     }

     public function test()
     {
        echo "测试成功";
     }
 
 }
 
 /*用new实例化private标记构造函数的类会报错
 $danli = new Danli();
 
 复制(克隆)对象将导致一个E_USER_ERROR
 $danli_clone = clone $danli;
 */
 
 
 //正确方法,用双冒号::操作符访问静态方法获取实例
 $connect = Db::getInstance();
 $connect->connect();
 $sql = "INSERT INTO test ".
       "(姓名) ".
       "VALUES ".
       "('二逼')";
 $connect->addRow($sql);
 $aaa = $connect->getRow();
 var_dump($aaa);
 $connect->close();
 ?>