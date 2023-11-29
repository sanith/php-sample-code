<?php
	class Chart extends DBconn{
	
		public function viewAllTickets()
		{
			//$sql = "SELECT count(ticket_id) as ticketcount FROM nipl_ticket";
			$sql = "SELECT COUNT( ticket_id ) as count , STATUS FROM  `nipl_ticket`  WHERE dept_id=" . $_SESSION['dept_id'] ." GROUP BY STATUS";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewUnreadTickets()
		{
			//$sql = "SELECT count(ticket_id) as ticketcount FROM nipl_ticket WHERE staff_id=" . $staff_id;
			$sql = "SELECT COUNT( ticket_id ) AS unread FROM  `nipl_ticket`  WHERE dept_id=" . $_SESSION['dept_id'] ."  and controladmin_view =1 = 1";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewEscTickets()
		{
			$sql = "SELECT count(ticket_id) as ticketcount FROM nipl_ticket WHERE status=1";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewCloseTickets()
		{
			$sql = "SELECT count(ticket_id) as ticketcount FROM nipl_ticket WHERE status=2";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewOpenTickets()
		{
			$sql = "SELECT count(ticket_id) as ticketcount FROM nipl_ticket WHERE status=0";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewTonalityDetails($dept_id)
		{
			$sql = "SELECT count(ticket.tonality_id) as tonalitycount,tonality_type FROM nipl_ticket ticket LEFT JOIN nipl_tonality tonality ON ticket.tonality_id=tonality.tonality_id LEFT JOIN nipl_department department ON ticket.dept_id=department.dept_id WHERE department.dept_id=" . $dept_id . " GROUP BY(ticket.tonality_id) ";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewSourceCharts($dept_id)
		{
			$sql ="SELECT count(ticket.clasification_id) as complaintcount,complaint_type FROM nipl_ticket ticket LEFT JOIN nipl_complaint complaint ON ticket.clasification_id=complaint.complaint_id LEFT JOIN nipl_department department ON ticket.dept_id=department.dept_id WHERE department.dept_id=" . $dept_id . " GROUP BY(ticket.clasification_id)";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewKeyCharts($dept_id,$cond="")
		{
			//$sql ="SELECT count(ticket.levelone_id) as levelonecount,levelone_name FROM nipl_ticket ticket LEFT JOIN nipl_levelone levelone ON ticket.levelone_id=levelone.levelone_id LEFT JOIN nipl_department department ON ticket.dept_id=department.dept_id WHERE department.dept_id=" . $dept_id . " GROUP BY(ticket.levelone_id)";
			$sql ="SELECT COUNT( ticket.levelone_id ) AS levelonecount, levelone_name, complaint_type
					FROM nipl_ticket ticket
					LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
					LEFT JOIN nipl_department department ON ticket.dept_id = department.dept_id
					LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
					WHERE department.dept_id =" . $dept_id . "".$cond."
					GROUP BY (
					ticket.levelone_id
					)";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewFilterChart($filter)
		{
			$sql = "SELECT ticket.ticket_id,count(ticket.clasification_id) as clasificationcount,complaint_type,count(ticket.levelone_id) as levelonecount,levelone_name,count(ticket.tonality_id) as tonalitycount,tonality_type FROM nipl_ticket ticket LEFT JOIN nipl_complaint complaint ON ticket.complaint_id=complaint.complaint_id LEFT JOIN nipl_levelone levelone ON ticket.levelone_id=levelone.levelone_id LEFT JOIN nipl_tonality tonality ON ticket.tonality_id=tonality.tonality_id WHERE ticket.status=1" . $filter;
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewOpenInbetween($date)
		{
			$sql = "SELECT count(ticket_id) as opencount FROM nipl_ticket WHERE created_date LIKE '%" . $date . "%'  and status = 0";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewCloseInbetween($date="")
		{
			$sql = "SELECT count(ticket_id) as closecount FROM nipl_ticket WHERE created_date LIKE '%" . $date . "%'  and status = 2";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewtonalityPositive($date="")
		{
			$sql = "SELECT count(ticket.tonality_id) as tonalitycount,tonality_type FROM nipl_ticket ticket LEFT JOIN nipl_tonality tonality ON ticket.tonality_id=tonality.tonality_id WHERE ticket.created_date LIKE '%" . $date . "%' AND ticket.tonality_id='4'";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewtonalityNegative($date="")
		{
			$sql = "SELECT count(ticket.tonality_id) as tonalitycount,tonality_type FROM nipl_ticket ticket LEFT JOIN nipl_tonality tonality ON ticket.tonality_id=tonality.tonality_id WHERE ticket.created_date LIKE '%" . $date . "%' AND ticket.tonality_id='3'";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewtonalityNuetral($date="")
		{
			$sql = "SELECT count(ticket.tonality_id) as tonalitycount,tonality_type FROM nipl_ticket ticket LEFT JOIN nipl_tonality tonality ON ticket.tonality_id=tonality.tonality_id WHERE ticket.created_date LIKE '%" . $date . "%' AND ticket.tonality_id='8'";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewKeyExchange($date="")
		{
			$sql = "SELECT count(ticket.levelone_id) as levelonecount,levelone_name FROM nipl_ticket ticket LEFT JOIN nipl_levelone levelone ON ticket.levelone_id=levelone.levelone_id WHERE ticket.created_date LIKE'%" . $date . "%' AND ticket.levelone_id='4'";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function viewKeyDelivery($date="")
		{
			$sql = "SELECT count(ticket.levelone_id) as levelonecount,levelone_name FROM nipl_ticket ticket LEFT JOIN nipl_levelone levelone ON ticket.levelone_id=levelone.levelone_id WHERE ticket.created_date LIKE'%" . $date . "%' AND ticket.levelone_id='3'";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return  $result;
			
		}
		
		public function viewClasification($dept_id)
		{
			$sql = "SELECT COUNT( ticket.ticket_id ) AS ticket, clasification_type
					FROM nipl_ticket ticket
					LEFT JOIN nipl_clasification AS clasification ON clasification.clasification_id = ticket.clasification_id
					WHERE ticket.dept_id =".$dept_id."
					GROUP BY ticket.clasification_id";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return  $result;
		}
		
		public function sourceChartData($dept_id)
		{
			$sql = "SELECT COUNT( ticket.ticket_id ) AS complaintcount, complaint_type, tonality_type
					FROM nipl_ticket ticket
					LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
					LEFT JOIN nipl_tonality tonality ON ticket.tonality_id = tonality.tonality_id
					WHERE ticket.dept_id =".$dept_id."
					GROUP BY (
					ticket.complaint_id
					)";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return  $result;
		}
		
		public function viewKeyTonalityCharts($dept_id,$cond="")
		{
			//$sql ="SELECT count(ticket.levelone_id) as levelonecount,levelone_name FROM nipl_ticket ticket LEFT JOIN nipl_levelone levelone ON ticket.levelone_id=levelone.levelone_id LEFT JOIN nipl_department department ON ticket.dept_id=department.dept_id WHERE department.dept_id=" . $dept_id . " GROUP BY(ticket.levelone_id)";
			$sql ="SELECT COUNT( ticket.levelone_id ) AS levelonecount, levelone_name, tonality_type
					FROM nipl_ticket ticket
					LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
					LEFT JOIN nipl_department department ON ticket.dept_id = department.dept_id
					LEFT JOIN nipl_tonality tonality ON ticket.tonality_id = tonality.tonality_id
					WHERE department.dept_id =" . $dept_id . "".$cond."
					GROUP BY (
					ticket.levelone_id
					)";
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
		
		public function getReasonChart($date1,$date7)
		{
			$sql = "SELECT COUNT( ticket.ticket_id ) AS count, levelone_name, DATE( ticket.created_date ) as created_date
					FROM  `nipl_ticket` AS ticket
					LEFT JOIN nipl_levelone AS levelone ON ticket.levelone_id = levelone.levelone_id
					WHERE DATE( ticket.created_date ) 
					BETWEEN  '".$date7."'
					AND  '".$date1."'
					GROUP BY ticket.created_date, ticket.levelone_id order by created_date DESC" ;
			$result = $this->sql_fetchrowset($this->sql_query($sql));
			return $result;
		}
	}
?>