<?php 
if(!defined('_HEROBOARD_'))exit;
class chTextType{

	private $theText;
	public function __construct($theText){
		$this->theText = $theText;
	}
	public function __destruct(){
		unset($this);
	}
	public function is_allCheck(){
		$result = array();
		array_push($result, $this->is_kr(), $this->is_num(), $this->is_enUpper(), $this->is_enLower(),$this->is_other());
		return $result;
	}

	public function is_kr(){
		return preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $this->theText);
	}
	public function is_num(){
		return preg_match("/[0-9]/", $this->theText);
	}
	public function is_enUpper(){
		return preg_match("/[a-z]/", $this->theText);
	}
	public function is_enLower(){
		return preg_match("/[A-Z]/", $this->theText);
	}
	public function is_other(){
		return preg_match("/[?=.*\[\]!@#$%^*&()\-_=+\\\|\[\]{};:\'\",.<>\/?]/", $this->theText);
	}

}

?>