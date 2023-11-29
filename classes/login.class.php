<?php

class Login extends DBConn{

    public function authenticateUser($username="", $password="", $table_name=""){

        $sql = "SELECT `dp_username`,`dp_password`,`dept_id`,`dept_name`,`email_id` FROM `$table_name` WHERE `dp_username`='$username' AND `dp_password`='$password'";
        $result = $this->sql_fetchrowset($this->sql_query($sql));
        return $result;

    }

    public function registerLoginSession($email="", $password="", $dept_id="", $dept_name="", $username=""){

        $_SESSION['email']     = $email;
        $_SESSION['password']  = $password;
        $_SESSION['dept_id']   = $dept_id;
        $_SESSION['dept_name'] = $dept_name;
		$_SESSION['username']  = $username;
		
	
    }

	// function written by Ruchita for getting master data in session.
	public function registerRoleSession()
	{
		$sql = "SELECT role_id, role_name FROM  `nipl_roles`";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		for($i=0;$i<count($result);$i++)
		{
			$session_name = strtolower($result[$i]['role_name']);
			$_SESSION[$session_name]    = $result[$i]['role_id'];
		}
	}
	
    public function updateLoginCount($email="", $table_name=""){

        $lastlogin_date = date("Y-m-d H-m-s");
        $sql ="UPDATE `$table_name` SET `login_count`=login_count+1, `lastlogin_date`='$lastlogin_date'  WHERE `email`='$email'";
        $result = $this->sql_query($sql);
        if(mysql_affected_rows () > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }

    }
}

?>
