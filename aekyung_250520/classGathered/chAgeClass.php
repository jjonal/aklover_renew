<?php 
if(!defined('_HEROBOARD_'))exit;

	class chAgeClass{
		private $year, $month, $date, $thisYear, $thisMonth, $thisDate;
		
		public function __construct($year, $month=false, $date=false){
			$this->year = $year;
			$this->month = $month;
			$this->date = $date;
			$today = date("Ymd");
			$this->thisYear = substr($today,0,4);
			$this->thisMonth = substr($today,4,2);
			$this->thisDate = substr($today,6,2);
			
		}
		public function __destruct(){
			unset($this);
		}
		
		public function countUniversalAge(){
			
			if(!$this->year || !$this->month || !$this->date){
				return "error:날짜가 설정되지 않았습니다.";
			}
			$age = $this->thisYear-$this->year;
			if($this->year<$this->thisYear){
				if($this->month==$this->thisMonth){
					if($this->date>$this->thisDate){
						$age = $age-1;
					}	
				}elseif($this->month>$this->thisMonth){
					$age = $age-1;
				}
			}
			return $age;
		}
		
		public function countKoreanAge(){
			if(!$this->year){
				return "error:날짜가 설정되지 않았습니다.";
			}
			$age = (int)$this->thisYear-(int)$this->year+1;
			return $age;
		}
		
	}

?>