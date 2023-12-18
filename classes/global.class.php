<?php
class Common extends DBconn{

	public function showAllDetails($table_name="", $crit=""){

		$sql = "SELECT * FROM " . $table_name . " " . $crit ;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;

	}
	
	public function showAllDetailsbyid($table_name="", $crit=""){

		$sql = "SELECT * FROM " . $table_name . " " . $crit ;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;

	}

	public function pageShowAll($table_name="",$crit="",$pages=""){

		$sql = $sql = "SELECT * FROM " . $table_name . " " . $crit ."$pages->limit";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;

	}

	public function insertDetails($table_name="",$arrInsertDetails=""){
		$created_date  = date('Y-m-d H:i:s');
		$setfields = " created_date ='".$created_date."' ";
        	foreach($arrInsertDetails as $k => $v){
				$v  = str_replace("'null'","null",$v);
            		$setfields .= ", " . $k . "=" . $v ;
        	}
		 $sql    = "INSERT INTO " .$table_name . " SET " . $setfields;
		
		$result = $this->sql_query($sql);
		//echo $sql;
		
		mysql_error();
		//if(mysql_affected_rows() > 0)
		if(mysql_insert_id() > 0)
		{
			return mysql_insert_id();
		}
		else{
			return FALSE;
		}

	}
	
	public function insertDetailsExcel($table_name="",$arrInsertDetails=""){
		$updated_date  = date('Y-m-d H:i:s');
		$setfields = " updated_date ='".$updated_date."' ";
        	foreach($arrInsertDetails as $k => $v){
            		$setfields .= ", " . $k . "='" . $v . "'";
        	}
		$sql    = "INSERT INTO " .$table_name . " SET " . $setfields;
		
		$result = $this->sql_query($sql);
		echo mysql_error();
		//if(mysql_affected_rows() > 0)
		if(mysql_insert_id() > 0)
		{
			return mysql_insert_id();
		}
		else{
			return FALSE;
		}

	}

	public function updateDetails($table_name="", $arrUpdateDetails="", $crit=""){

		$setfields = " `updated_date` = now() ";
		foreach($arrUpdateDetails as $k => $v){
			$v  = str_replace("'null'","null",$v);
			$setfields .= ", " . $k . "='" . $v . "'";
		}
		echo $sql = "UPDATE " . $table_name . " SET " . $setfields . " " .$crit;
		$result = $this->sql_query($sql);

		if (mysql_affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	public function deleteData($table_name="", $crit=""){

		$sql = "DELETE FROM " . $table_name . " " . $crit;
		$result = $this->sql_query($sql);
		echo mysql_error();
		if(mysql_affected_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}

	}
	
	// function written by Ruchita to run custom query
	public function custom($query)
	{
		if($query != "")
		{
			$result = $this->sql_fetchrowset($this->sql_query($query));
			return $result;
		}
	}
	
	// function for check duplicate
	public function check_dup_customer($table_name="",$cond="")
	{
		$sql = $sql = "SELECT customer_id FROM " . $table_name . " " . $cond;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
}
?>