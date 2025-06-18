<?php 
if(!defined('_HEROBOARD_'))exit;

	class chAndInputPwClass{
		private $pastPw, $newPw, $tf, $chPastPw, $chNewPw;
		
		public function __construct($pastPw=false,$newPw=false){
			$this->pastPw = $pastPw;
			$this->newPw = $newPw;
			$this->tf = 1;
		}
		public function __destruct(){
			unset($this);
		}
		
		public function progressChPw(){
			
			$this->getMemberInfo();
			if($this->tf!=1){
				return $this->tf;
				$this->__destruct();
				exit;
			}
			
			$this->comparePwRight();
			if($this->tf!=1){
				return $this->tf;
				$this->__destruct();
				exit;
			}
			
			$this->comparePastPwAndNewPw();
			if($this->tf!=1){
				return $this->tf;
				$this->__destruct();
				exit;
			}
			
			$this->compareRealPastPwAndNewPw();
			if($this->tf!=1){
				return $this->tf;
				$this->__destruct();
				exit;
			}
			
			//return $this->tf;exit;
			$this->compareWholePastPwWithNewPw();
			if($this->tf!=1){
				return $this->tf;
				$this->__destruct();
				exit;
			}
			
			$this->updateRealPw();
			if($this->tf!=1){
				return $this->tf;
				$this->__destruct();
				exit;
			}
			
			$this->insertPwtoLog();
			if($this->tf!=1){
				return $this->tf;
				$this->__destruct();
				exit;
			}
			
			return $this->tf;
			
		}
		
		protected function getMemberInfo(){
			$error = "CHPWCLASS_01";
			
			$hero_id = $_SESSION['temp_id'];
			
			$hero_pw_past = $this->pastPw;
			$pw_md5_past = md5($hero_pw_past);
			$temp_past = $pw_md5_past.$hero_id;
			$pw_sha3_256_past = sha3_hash('sha3-256', $temp_past);
			
			$hero_pw_new = $this->newPw;
			$pw_md5_new = md5($hero_pw_new);
			$temp_new = $pw_md5_new.$hero_id;
			$pw_sha3_256_new = sha3_hash('sha3-256', $temp_new);
			
			$member_sql = "select * from (select count(*) from member where hero_code='".$_SESSION['temp_code']."' and hero_pw='".$pw_sha3_256_past."') as A, ";
			$member_sql .= "(select count(*) from member where hero_code='".$_SESSION['temp_code']."' and hero_pw='".$pw_sha3_256_new."') as B";
			$member_res = new_sql($member_sql,$error,"on");
			if((string)$member_res==$error){
				$this->tf = $error;
				return false;
			}
			$this->chPastPw = mysql_result($member_res,0,0);
			$this->chNewPw = mysql_result($member_res,0,1);
		}
		
		protected function comparePwRight(){
			if($this->chPastPw<1){
				$this->tf = "message:비밀번호가 일치하지 않습니다. 비밀번호를 확인해주세요.";
				return false;
			}
		}
		
		protected function comparePastPwAndNewPw(){
			if($this->pastPw && $this->newPw){
				if($this->pastPw==$this->newPw){
					$this->tf = "message:변경하려는 비밀번호가 기존 비밀번호와 같습니다.";
				}
			}
		}
		
		protected function compareRealPastPwAndNewPw(){
			if($this->chNewPw>0){
				$this->tf = "message:새로운 비밀번호가 기존 비밀번호와 같습니다.";
				return false;
			}
		}
		
		protected function compareWholePastPwWithNewPw(){
			$error = "CHPWCLASS_03";
			
			$hero_id = $_SESSION['temp_id'];
			$hero_pw_new = $this->newPw;
			$pw_md5_new = md5($hero_pw_new);
			$temp_new = $pw_md5_new.$hero_id;
			$pw_sha3_256_new = sha3_hash('sha3-256', $temp_new);
			
			$loggingPw_sql = "select count(*) from logging_pw where hero_code='".$_SESSION['temp_code']."' and hero_pw='".$pw_sha3_256_new."'";
			
			$loggingPw_res = new_sql($loggingPw_sql,$error);
			if((string)$loggingPw_res==$error){
				$this->tf = $error;
				return false;
			}
			
			$count_wholePwWithNewPw = mysql_result($loggingPw_res,0,0);
			if($count_wholePwWithNewPw>0){
				$this->tf = "message:이전에 사용한 비밀번호는 사용하실 수 없습니다.";
				return false;
			}
		}
		
		protected function updateRealPw(){
			$error = "CHPWCLASS_04";
			
			$hero_id = $_SESSION['temp_id'];
			$hero_pw_new = $this->newPw;
			$pw_md5_new = md5($hero_pw_new);
			$temp_new = $pw_md5_new.$hero_id;
			$pw_sha3_256_new = sha3_hash('sha3-256', $temp_new);
			
			$updatePwMemeber_sql = "update member set hero_pw='".$pw_sha3_256_new."' where hero_code='".$_SESSION['temp_code']."'";
			$updatePwMemeber_res = new_sql($updatePwMemeber_sql,$error);
			if((string)$updatePwMemeber_res==$error){
				$this->tf=$error;
				return false;
			}
		}
		
		protected function insertPwtoLog(){
			$error = "CHPWCLASS_05";

			$hero_id = $_SESSION['temp_id'];
			$hero_pw_past = $this->pastPw;
			$pw_md5_past = md5($hero_pw_past);
			$temp_past = $pw_md5_past.$hero_id;
			$pw_sha3_256_past = sha3_hash('sha3-256', $temp_past);

			$insertPwLogging_sql = "insert into logging_pw (hero_code, hero_pw, hero_oldday) values ('".$_SESSION['temp_code']."', '".$pw_sha3_256_past."', '".date("Y-m-d")."')";
			$insertPwLogging_res = new_sql($insertPwLogging_sql,$error);
			if((string)$insertPwLogging_res==$error){
				$this->tf=$error;
				return false;
			}
		}
		
		public function insertChNextTimetoLog($delay){

			if(!$delay || ($delay!='oneDay' && $delay!='twoWeeks')){
				$this->tf="message:시스템 에러입니다. 다시 시도해주세요.";
				return false;
			}
			
			switch ($delay){
				case "oneDay" : $theDaytoChPw = date("Y-m-d",strtotime("+1 day"));break;
				case "twoWeeks" : $theDaytoChPw = date("Y-m-d",strtotime("+2 week"));break;
			}
			
			$error = "CHPWCLASS_06";
			$loggingPw_sql = "select count(*) from logging_pw where hero_code='".$_SESSION['temp_code']."'";
			$loggingPw_res = new_sql($loggingPw_sql,$error);
			if((string)$loggingPw_res==$error){
				$this->tf=$error;
				return false;
			}
			$count_loggingPw = mysql_result($loggingPw_res,0,0);
			
			if($count_loggingPw>0){
				$error="CHPWCLASS_07";
				$updatePwLogging_sql = "update logging_pw set hero_today= '".$theDaytoChPw."' where hero_code='".$_SESSION['temp_code']."'";
				$updatePwLogging_res = new_sql($updatePwLogging_sql,$error);
				if((string)$updatePwLogging_res==$error){
					$this->tf=$error;
					return false;
				}
			}else{
				$error="CHPWCLASS_08";
				$insertPwLogging_sql = "insert into logging_pw (hero_code, hero_today) values ('".$_SESSION['temp_code']."', '".$theDaytoChPw."')";
				$insertPwLogging_res = new_sql($insertPwLogging_sql,$error);
				if((string)$insertPwLogging_res==$error){
					$this->tf=$error;
					return false;
				}
			}
			return true;
			
		}
		
	}

?>