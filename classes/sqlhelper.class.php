<?php
class sqlhelper extends DBconn
{
	public $link;
	
	function ValidateUser($username,$password)
	{
		$sql = "SELECT * FROM `users` WHERE `user_name` = '".str_replace("'","''",$username)."' AND `user_password` = '".str_replace("'","''",$password)."'  AND `active` = '1'";
		$results = mysql_query($sql);
		//echo $sql;
		return $results;
	}
	
	public function getkeypeople($filter)
	{
		$sql="select  a.id,b.firstname ,b.middlename,b.lastname ,a.designation  from company_key_people a left outer join people_master b on a.people_master_id = b.id ".$filter." ";		
		$result = mysql_query($sql);
		return $result;
	}

	public function getcompanies($obj)
	{
		$sql="SELECT * FROM `company_master` where active = '1'";
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
		$sql = "select a.id,a.address,a.office_location,a.toll_free,a.telephone,a.fax,a.email,a.website,b.location_id as countryid ,b.name as country , c.location_id as stateid , c.name as state, d.location_id as cityid ,d.name as city from company_office_location a left outer join mi_location b on a.country = b.location_id
				left outer join mi_location c on a.state = c.location_id left outer join mi_location d on a.city = d.location_id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getboard_of_directors($filter)
	{
		//$sql = "SELECT a.id,b.id as peopleid,a.committee,a.title,b.firstname,b.middlename,b.lastname  FROM `company_board_directors` a left outer join `people_master` b on a.people_master_id = b.id ".$filter." ";
		
		$sql = "SELECT a.id, b.id AS peopleid, c.committee,a.committee_master_id, a.title, b.firstname, b.middlename, b.lastname
FROM `company_board_directors` a
LEFT OUTER JOIN `people_master` b ON a.people_master_id = b.id
LEFT OUTER JOIN `committee_master` c ON a.committee_master_id = c.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getexecutive_profile($filter)
	{
		//$sql = "SELECT a.id,b.id as peopleid,c.id as designationid,a.age,a.since,a.qualification,a.work_experience,b.firstname,b.middlename,b.lastname,c.designation_name FROM `company_executive_profile` a left outer join `people_master` b on a.people_master_id = b.id left outer join designation_master c on a.designation_master_id = c.id ".$filter." ";
		
		$sql = "SELECT a.id, b.id AS peopleid, a.parent_people_master_id as parentid,  CONCAT_WS( ' ', d.firstname, d.middlename, d.lastname ) AS parentname, a.designation, a.age, a.since,a.qualification, a.work_experience, b.firstname, b.middlename, b.lastname,b.unique_description 
FROM `company_executive_profile` a LEFT OUTER JOIN `people_master` b ON a.people_master_id = b.id LEFT OUTER JOIN `people_master` d ON a.parent_people_master_id = d.id ".$filter." ";
		
		
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

	public function getcompany_trading_multiples($filter)
	{
		$sql="select a.id,a.marketcap,a.share_price,a.pe,a.pb,a.peg,a.pfcfe,a.tev_revenue,a.tev_ebitda,a.tev_ebit,b.company_name,b.id as company_id from company_trading a left outer join company_master b on a.trading_company_master_id = b.id where b.active = '1' ";
		$result = mysql_query($sql);
		return $result;
		
	}
	
	public function getsectorinvestment($filter)
	{
		$sql="select a.id,a.direct_investments,a.share,b.id as sector_id,b.sector from company_investments_sector a left outer join sector_master b on a.sector_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getsectorandsubsector($filter)
	{
		$sql="select * from subsector_master a left outer join sector_master b on a.sector_master_id = b.id ".$filter." ";
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
		
	public function GetGraphComparativeTrading($company_master_id)
	{
		$sql = "SELECT  `company_name` ,  `marketcap` ,  `share_price` ,  `pe` ,  `tev_ebitda` 
FROM  `company_trading` a
JOIN  `company_master` b ON a.`trading_company_master_id` = b.`id` 
WHERE a.`company_master_id` =  '".$company_master_id."'";
		$result = mysql_query($sql);
		return $result;
		
		}

public function GetCommittee()
		{
			$sql = "SELECT * FROM `committee_master` ORDER BY `committee_master`.`committee` ASC";
			$result = mysql_query($sql);
			return $result;
		}
		
		public function GetDepartments()
		{
			$sql = "SELECT * FROM `department_master` order by `department` ASC";
			$result = mysql_query($sql);
			return $result;
		}
		
		public function DeleteBoardOfDirector($id)
		{
			$sql = "delete FROM  `company_board_directors` where `id` = '".$id."'";
			mysql_query($sql);
			
		}
		public function DeleteKeyDecisionMakers($id)
		{
			$sql = "delete FROM `company_key_decision_makers` where `id` = '".$id."'";
			mysql_query($sql);
			
		}
		
		public function get_key_decion_makers($filter)
	{
		//$sql = "SELECT a.id,b.id as peopleid,a.committee,a.title,b.firstname,b.middlename,b.lastname  FROM `company_board_directors` a left outer join `people_master` b on a.people_master_id = b.id ".$filter." ";
		
		$sql = " SELECT a.id, b.id AS peopleid, a.department_master_id,c.department, a.designation, b.firstname, b.middlename, b.lastname FROM `company_key_decision_makers` a LEFT OUTER JOIN `people_master` b ON a.people_master_id = b.id LEFT OUTER JOIN `department_master` c ON a.department_master_id = c.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
		public function GetSwot($filter)
		{
			$sql = "SELECT * FROM `company_swot` ".$filter."  ";
			$result = mysql_query($sql);
			return $result;
		}

		public function get_org_chart($filter)
		{
			$sql = "SELECT a.id,a.parent_people_master_id as parentid,b.id as peopleid,a.parent_people_master_id,a.designation,a.age,a.since,a.qualification,a.work_experience,b.firstname,b.middlename,b.lastname,c.firstname as parent_firstname,c.middlename as parent_middlename ,c.lastname as parent_lastname ,CONCAT_WS( ' ', c.firstname, c.middlename, c.lastname ) AS parentname FROM `company_org_chart` a left outer join `people_master` b on a.people_master_id = b.id left outer join `people_master` c on a.parent_people_master_id = c.id ".$filter." ";
			$result = mysql_query($sql);
			return $result;
		}
		
		public function get_it_contracts($filter)
		{
			$sql = "SELECT a . * , b.geography AS clientgeography, c.geography AS vendorgeography, CONCAT_WS( ' ', d.firstname, d.middlename, d.lastname ) AS keydecionmaker FROM `company_it_contracts` a LEFT OUTER JOIN geography_master b ON a.client_geography_master_id = b.id LEFT OUTER JOIN geography_master c ON a.vendor_geography_master_id = c.id LEFT OUTER JOIN people_master d ON a.key_decision_maker_people_master_id = d.id ".$filter." ";
			
			$result = mysql_query($sql);
			return $result;
						}
						
		public function get_it_spending($filter)
		{
			$sql = "SELECT a . * , b.category FROM `company_it_spending` a left outer JOIN `it_category_master` b ON a.it_category_master_id = b.id ".$filter." ";
			$result = mysql_query($sql);
			return $result;
						}
						
		public function get_it_spending_category($filter)
		{
			$sql = "SELECT a . * , b.category AS category, c.parameter AS parameter FROM `company_it_spending_by_category` a JOIN it_category_master b ON a.it_category_master_id = b.id JOIN it_spending_parameter_master c ON a.it_spending_parameter_master_id = c.id ".$filter." ";
			
			$result = mysql_query($sql);
			return $result;
			
						}

public function GetFieldForTable($field,$tablename,$filter)
		{
			$sql = " select ".$field." as fld	from ".$tablename." ".$filter."  ";
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			$val = $row["fld"];
			return $val;
		}

public function GetCompanyOverviewDetails($filter)
		{
			$sql = "SELECT a.*,
								b.type_name,
								(SELECT 
									group_concat(d.geography)
									FROM `company_geographical_presence` c left outer join `geography_master` d on c.`geography_master_id` = d.`id` 
									where c.company_master_id = a.`company_master_id` group by c.`company_master_id`) as geographies
								FROM `company_overview` a join `company_type_master` b on a.`company_type_master_id` = b.`id`  
								".$filter." ";
			
			$result = mysql_query($sql);
			return $result;
			}
	
	
public function GetCompanyName($filter)
		{
			$sql = "SELECT company_name FROM `company_master`   ".$filter." ";
			
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			return $row["company_name"];
			}
	
	
	//----------------------------------------------------------------------------


//--------------vibhor start--------------------------
	public function getdirectinvestments($filter)
	{
		$sql = "SELECT a.id ,b.id as company_id,b.company_name,c.id as sector_id,c.sector,d.id as subsector_id,d.sub_sector,e.id as relation_id,e.relationship,f.id as geography_id,f.geography FROM `company_investments` a left outer join company_master b on a.company_master_id = b.id left outer join sector_master c on c.id = a.sector_master_id left outer join  subsector_master d on d.id = a.subsector_master_id left outer join relationship_type_master e on e.id = a.relationship_type_master_id left outer join geography_master f on f.id = a.geography_master_id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getcompany_activity_track($filter)
	{
		$sql="SELECT a.id, b.id AS category_id,a.category_master_id,a.date, b.category, a.news, a.Impact_business_company, a.opporrtunity_for_optum, a.source ,a.source_link FROM company_activity_track a LEFT OUTER JOIN activity_category_master b ON b.id = a.category_master_id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
		
	}
	public function getcompany_activity_track_new($filter)
	{
		$sql="SELECT * FROM company_activity_track_new  ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	

public function getdistinctmembership_year($filter)
	{
		$sql = "select distinct(year) as year from company_membership ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctmembership_geo($filter)
	{
		$sql = "SELECT DISTINCT (a.geography_id) AS geography_id, b.geography FROM company_membership a LEFT OUTER JOIN geography_master b ON a.geography_id = b.id  ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function gettotalyear($filter)
	{
		$sql = "select sum(value) as value,year from company_membership ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getmembership($filter)
	{
		$sql="select a.id,b.id as geography_id,a.year,a.value,b.geography from company_membership a left outer join geography_master b on a.geography_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}

public function getdistinctyear_claim($filter)
	{
		$sql="select distinct(year) as year from company_claims ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getclaim($filter)
	{
		$sql="select * from company_claims ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}

public function insertimage($page_name,$company_master_id,$page_level,$image,$image_type,$image_size,$image_name)
	{
		$sql = "insert into company_images (page_name,company_master_id,page_level,image,image_type,image_size,image_name) value ('".$page_name."','".$company_master_id."','".$page_level."','".$image."','".$image_type."','".$image_size."','".$image_name."')";
		mysql_query($sql);
	}

public function getdistinctfinancialperformancesegment_year($filter)
	{
		$sql = "SELECT distinct(year) FROM `company_financial_performance_segment` a left outer join segment_master b on a.segment_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistinctfinancialperformancesegment($filter)
	{
		$sql = "SELECT distinct(a.segment_master_id),segment_name FROM `company_financial_performance_segment` a left outer join segment_master b on a.segment_master_id = b.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getfinancialperformancesegment($filter)
	{
		$sql = "SELECT *,round(((a.value / (select sum(value) from `company_financial_performance_segment` where company_master_id = a.company_master_id  and year = a.year)) * 100),2) as percentage FROM `company_financial_performance_segment` a left outer join segment_master b on a.segment_master_id = b.id ".$filter." order by a.year ";
		$result = mysql_query($sql);
		return $result;
	}

	public function getsumgeo_revenue($filter)
	{
		$sql="SELECT year, sum(value) AS value FROM `company_financial_performance_geography` ".$filter."  ";
		$result = mysql_query($sql);
		return $result;
	}

	public function getcategorytotal($filter)
	{
		$sql = "SELECT b.category as category_name, sum(a.internal_it_spend) as internal , sum(a.external_it_spend) as external  FROM `company_it_spending` a left outer join it_category_master b on a.it_category_master_id = b.id  ".$filter." group by b.category";
		$result = mysql_query($sql);
		return $result;
		
	}

		public function getdistinctboard_of_directors($filter)
	{
		$sql = "SELECT c.id as committeeid,c.committee,count(a.committee_master_id) as count
				FROM `company_board_directors` a
				LEFT OUTER JOIN `committee_master` c ON a.committee_master_id = c.id ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function getdistincttitle($filter)
	{
		$sql = "SELECT a.title,count(title) as count
				FROM `company_board_directors` a
				LEFT OUTER JOIN `committee_master` c ON a.committee_master_id = c.id  ".$filter."";
		$result = mysql_query($sql);
		return $result;
	}

public function getdistinctcategory_activitytrack($filter)
	{
		$sql = "SELECT distinct(category) as category FROM company_activity_track_new ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}
	

//-------------------vibhor End------------------------------------

//clinical functions ----------------------------------------------

public function GetTherapies()
{
		$sql = "SELECT * FROM `clinical_therapy_master` ORDER BY `clinical_therapy_master`.`order` ASC";
		$result = mysql_query($sql);
		return $result;
	}
	
public function GetTherapiesWithFilter($filter)
{
		$sql = "SELECT * FROM `clinical_therapy_master` ".$filter." ORDER BY `clinical_therapy_master`.`order` ASC";
		
		//echo $sql;
		$result = mysql_query($sql);
		return $result;
	}
	
public function GetIndications($filter)
{
		$sql = "SELECT distinct `indication` FROM `clinical_pipeline` ".$filter." order by indication ";
		//echo $sql;
		$result = mysql_query($sql);
		return $result;
	}
	
	
	
	public function GetClinicalData($company_id,$indication_area)
	{
		$sql = "SELECT * FROM `clinical_pipeline` where `company_master_id` = '".$company_id."' and `indication_area` = '".$indication_area."' order by phase,drug ";
		//echo $sql;
$result = mysql_query($sql);
		return $result;
	}
	
	public function GetClinicalDataWithFilter($filter)
	{
		$sql = "SELECT * FROM `clinical_pipeline` ".$filter." order by phase,drug ";
		//echo $sql;
$result = mysql_query($sql);
		return $result;
	}
	
	public function GetPhases()
	{
		$sql = "SELECT * FROM `clinical_phase_master` ORDER BY `clinical_phase_master`.`order` ASC";
		$result = mysql_query($sql);
		return $result;
	}
	
	public function GetPhaseCount($company_id,$indication_area)
	{
		$sql = "SELECT count( DISTINCT `phase` ) AS cnt FROM `clinical_pipeline` WHERE `company_master_id` = '".$company_id."' AND `indication_area` = '".$indication_area."' ";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		
		return $row["cnt"];	
	}
	
	public function GetMoas($company_id,$indication_area)
	{
		/*$sql = 'SET @row_number = 0;
		select (@row_number:=@row_number + 1) AS num,moa from (SELECT distinct (moa) as moa FROM `clinical_pipeline` where `company_master_id` = \''.$company_id.'\' and `indication_area` = \''.$indication_area.'\'  order by moa) as tab ';*/
		
		$sql = "SET @row_number = 0;";
		
		mysql_query($sql);
		
		//$sql = 'select (@row_number:=@row_number + 1) AS num,moa from ((SELECT distinct (moa) as moa FROM `clinical_pipeline` where `company_master_id` = \''.$company_id.'\' and `indication_area` = \''.$indication_area.'\'  order by moa)) as tab ';
		$sql = 'select (@row_number:=@row_number + 1) AS num,moa from ((SELECT distinct (moa) as moa FROM `clinical_pipeline` where `company_master_id` = \''.$company_id.'\' order by moa)) as tab ';

		

		//echo $sql;
		$result = mysql_query($sql) or die(mysql_error());
		
		return $result;
		}

	public function GetDrugEntries($company_id,$indication_area,$indication,$drug)
	{
		$sql = "SELECT * FROM `clinical_pipeline` WHERE company_master_id = '".$company_id."' AND indication_area = '".$indication_area."' AND trim( indication ) <> '".$indication."' AND drug = '".$drug."'";
		//echo $sql;
		$result = mysql_query($sql);
		return $result;
		} 
		
	public function GetIndicationAreas($filter)
	{
		$sql = "SELECT DISTINCT  `indication_area` FROM  `clinical_pipeline` ".$filter." ORDER BY  `indication_area` ";
		//echo $sql;
		$result = mysql_query($sql);
		return $result;
		}
	public function GetBiomarkers($filter)
	{
		$sql = "SELECT distinct `biomarker` FROM `clinical_pipeline` ".$filter." order by `biomarker` ";
		//echo $sql;
		$result = mysql_query($sql);
		return $result;
		}

public function GetResults($sql)
{
	$result = mysql_query($sql);
		return $result;

}

public function getdistinct_cat_activitytrack($filter)
	{
		//$sql="SELECT distinct(category) as category FROM company_activity_track_new  ".$filter." ";
		$sql="SELECT category,count(*) as count FROM `company_activity_track_new` ".$filter." ";
		$result = mysql_query($sql);
		return $result;
	}

//-----------------------------------------------------------------

//-----------------------------------------------------------------


	
}
?>