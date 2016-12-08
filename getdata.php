<?php

class GetData {

	public static function show($state,$str='',$data=array()){
		if(!is_numeric($state)){
			return '';
		}
		$type = isset($_POST['type']) ? $_POST['type'] : 'json';
		$result = array(
			"code" => $state,
			"message" => $str,
			"data" => $data
		);
		if($type == "xml"){
			self::xmlEncoding($state,$str,$data);
		}elseif ($type == "json") {
			self::json($state,$str,$data);
		}elseif ($type == "array") {
			echo $result;
		}else{
			#.........
		}
	}
	/*
	*$state:状态码
	*$str:状态信息
	*$data:返回数据中的data
	*/
	public static function json($state,$str='',$data=array()){
		if(!is_numeric($state)){
			return '';
		}
		$result = array(
			'code' => $state,
			'message' => $str,
			'data' => $data
		);

		echo json_encode($result);
		exit;
	}

	public static function xmlEncoding($state,$str='',$data=array()){
		// header('Content-Type: text/xml');

		if(!is_numeric($state)){
			return '';
		}
		$result = array(
			'code' => $state,
			'message' => $str,
			'data' => $data
		);

		$xml = "";
		
		$xml .= "<?xml version='1.0' encoding='UTF-8'?>\n";
		$xml .= "<root>\n";

		$xml .= self::dealXmlData($result);

		$xml .= "</root>\n";

		echo $xml;
	}

	public static function dealXmlData($data){
		$xml = "";
		$attr = "";
		foreach ($data as $key => $value) {
			if(is_numeric($key)){
				$attr = " id='{$key}'";
				$key = "item";
			}
			$xml .= "<{$key}{$attr}>";

			$xml .= is_array($value)? self::dealXmlData($value) : $value;

			$xml .= "</{$key}>\n";
		}
		return $xml;
	}
}
