<?php
error_reporting(0);
class sqlhelper extends DBconn
{
	public $link;
	
	function ValidateUser($username,$password)
	{
		$sql = "SELECT * FROM `users` WHERE `user_name` = '".str_replace("'","''",$username)."' AND `user_password` = '".str_replace("'","''",$password)."' AND `active` = '1'";
		$results = mysql_query($sql);
		//echo $sql;
		return $results;
	}
	
	public function getkeypeople($filter)
	{
		$sql="select  a.id,b.firstname ,b.middlename,b.lastname ,c.designation_name  from company_key_people a left outer join people_master b on a.people_master_id = b.id left outer join designation_master c on a.designation_master_id=c.id ".$filter." ";		
		$result = mysql_query($sql);
		return $result;
	}

	public function getcompanies($filter)
	{
		$sql="SELECT * FROM `company_master` where active = '1'".$filter;
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getcompany_segment_portfolio($company_id)
	{
		$sql = "SELECT a.id as company_segment_portfolioid,b.id as segmentid,b.segment_name,a.description FROM `company_segment_portfolio` a left outer join `segment_master` b on a.segment_master_id = b.id where a.company_master_id = '".$company_id."' "  ;
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getcompany_office_location($filter)
	{
		$sql = "select a.id,a.address,a.telephone,a.fax,a.email,a.website,b.location_id as countryid ,b.name as country , c.location_id as stateid , c.name as state, d.location_id as cityid ,d.name as city from company_office_location a left outer join mi_location b on a.country = b.location_id
				left outer join mi_location c on a.state = c.location_id left outer join mi_location d on a.city = d.location_id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getboard_of_directors($filter)
	{
		$sql = "SELECT a.id,b.id as peopleid,a.committee,a.title,b.firstname,b.middlename,b.lastname  FROM `company_board_directors` a left outer join `people_master` b on a.people_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getexecutive_profile($filter)
	{
		$sql = "SELECT a.id,b.id as peopleid,c.id as designationid,a.age,a.since,a.qualification,a.work_experience,b.firstname,b.middlename,b.lastname,c.designation_name FROM `company_executive_profile` a left outer join `people_master` b on a.people_master_id = b.id left outer join designation_master c on a.designation_master_id = c.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctyear($filter)
	{
		$sql = "SELECT distinct(year) as year from company_financial_performance_segment ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctyear_geo($filter)
	{
		$sql = "SELECT distinct(year) as year from company_financial_performance_geography ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctcountry_geo($filter)
	{
		$sql = "SELECT distinct(b.id) as location_id,geography from company_financial_performance_geography a left outer join  geography_master b on a.geography_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctparametertype($filter)
	{
		$sql = "SELECT distinct(type) as type from  key_ratio_parameter_master ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctparameteryear($filter)
	{
		$sql = "SELECT distinct(year) as year from  company_key_ratios ".$filter." order by year ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctparametertype_name($filter)
	{
		$sql = "SELECT distinct(type) as type from company_key_ratios a left outer join key_ratio_parameter_master b on a.key_ratio_parameter_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getallparameterdistinctname($filter)
	{
		$sql = "SELECT distinct(key_ratio_parameter_master_id) as key_ratio_parameter_master_id,parameter  from company_key_ratios a left outer join key_ratio_parameter_master b on a.key_ratio_parameter_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getallparametername_value($filter)
	{
		$sql = "SELECT *,a.id as company_key_ratios_id from company_key_ratios a left outer join key_ratio_parameter_master b on a.key_ratio_parameter_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	
	//Added By Sagar Surve--------------------------------------------------------
	public function GetProfiledCompanies($filter)
	{
		$sql = "SELECT * FROM  `company_overview` a JOIN  `company_type_master` b ON a.company_type_master_id = b.id JOIN  `company_master` c ON a.company_master_id = c.id WHERE c.active = '1'  ".$filter." ";
		
		//echo $sql;
		$result = mysql_query($sql);
		return $result;
	}
	
	public function GetKeyRatioYears($company_master_id)
	{
		$sql = "SELECT DISTINCT (YEAR) AS year FROM  `company_key_ratios` WHERE company_master_id ='".$company_master_id."' ORDER BY YEAR DESC ";
		
		$result = mysql_query($sql);
		return $result;
	}
	
	public function GetGraphRatioValues($company_master_id,$year)
	{
		$sql = "SELECT b.id,value FROM `company_key_ratios` a join key_ratio_parameter_master b on a.key_ratio_parameter_master_id = b.id WHERE `company_master_id` = '".$company_master_id."'  and b.id in (1,2,3,8) and year = '".$year."'";
		$result = mysql_query($sql);
		return $result;
		
		}
		
	public function GetGraphYOYComparison($company_master_id)
	{
		$sql = "SELECT year,`total_revenue`,`operating_income`,`gross_profit` FROM `company_financial_performance_summary` where `company_master_id` = '".$company_master_id."' order by year ";
		$result = mysql_query($sql);
		return $result;
		
		}
	
	
	//----------------------------------------------------------------------------
}

?>