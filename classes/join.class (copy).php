<?php

class Join extends DBconn{

	public function showEmailList()
	{  
		$sql = "SELECT email.email_id,email,name,email.dept_id,email.priority_id,dept_name,priority_desc,email.created_date,email.updated_date FROM nipl_email email LEFT JOIN nipl_department dept ON dept.dept_id=email.dept_id LEFT JOIN nipl_priority pri ON pri.priority_id=email.priority_id ORDER BY email";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
		
	}
	
	public function showEmailListbyid($email_id)
	{  
		$sql = "SELECT email.email_id,email,name,email.dept_id,email.priority_id,email.mail_active,dept_name,priority_desc,email.created_date,email.updated_date FROM nipl_email email LEFT JOIN nipl_department dept ON dept.dept_id=email.dept_id LEFT JOIN nipl_priority pri ON pri.priority_id=email.priority_id WHERE email.email_id=" . $email_id . " ORDER BY email";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
		
	}
	
	public function showUserdetails($email_id)
	{
		$sql = "SELECT dept.dept_id, dept.email_id, dept.dept_name, dp_username, dp_password
				FROM nipl_department dept
				WHERE dept.email_id='" . $email_id ."'";
 		$result = $this->sql_fetchrowset($this->sql_query($sql));
 		return $result;
	}
	
	public function showStaffRoles()
	{
		$sql='SELECT grp.role_id,role_name,role_enabled,dept_access,count(staff.staff_id) as users, grp.created_date,grp.updated_date FROM nipl_roles grp LEFT JOIN nipl_staff staff USING(role_id) GROUP BY grp.role_id ORDER BY role_name';
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showStaffRolesbyid($role_id)
	{
		$sql='SELECT grp.role_id,role_name,role_enabled,dept_access,can_viewunassigned_tickets,can_create_tickets, 	can_edit_tickets,can_changepriority_tickets,can_assign_tickets,can_delete_tickets,can_close_tickets,can_transfer_tickets,can_ban_emails,can_manage_stdr as users, grp.created_date,grp.updated_date FROM nipl_roles grp LEFT JOIN nipl_staff staff USING(role_id) WHERE grp.role_id = '.$role_id .'';
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showAllStaff(){
		$sql = 'SELECT staff.staff_id, staff.role_id, staff.dept_id, st_firstname, st_lastname, username, email,isactive, role_name, role_enabled, dept_name, DATE(staff.created_date) as created_date, last_login,staff.updated_date FROM nipl_staff staff LEFT JOIN nipl_roles roles ON staff.role_id=roles.role_id LEFT JOIN nipl_department dept ON staff.dept_id=dept.dept_id ORDER BY staff.staff_id';
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showAllStaffbyid($staff_id)
 	{
 	
 		$sql = 'SELECT staff.staff_id, staff.role_id, staff.dept_id, st_firstname, st_lastname, username, email,phone,signature,password,mobile,isactive, role_name, role_enabled, dept_name, DATE(staff.created_date) as created_date, last_login,staff.updated_date  FROM nipl_staff staff LEFT JOIN nipl_roles roles ON staff.role_id=roles.role_id LEFT JOIN nipl_department dept ON staff.dept_id=dept.dept_id WHERE staff.staff_id=' . $staff_id;
 		$result = $this->sql_fetchrowset($this->sql_query($sql));
 		return $result;
 	}
	
	public function levelTwodetails()
	{
		$sql = "SELECT two.leveltwo_id,two.levelone_id,levelone_name,leveltwo_name,two.created_date,two.updated_date FROM nipl_leveltwo two LEFT JOIN nipl_levelone one ON two.levelone_id=one.levelone_id ORDER BY two.leveltwo_id ASC";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
		
	}
	
	public function showTicketdetails($dept_id="",$cond="")
	{
		$sql = "SELECT ticket.ticket_id, ticket.complaint_id, ticket.store_information, ticket.controladmin_view, brands.brand_name, status.status, complaint_type, ticket.clasification_id, clasification_type, ticket.levelone_id, levelone_name, ticket.priority_id, priority_desc, ticket.dept_id, dept_name, ticket.attachment, ticket.created_date, ct.firstname, ct.lastname, ct.email_id, ct.mobile_no
			FROM nipl_ticket ticket
			LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
			LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
			LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
			LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			LEFT JOIN nipl_status status ON ticket.status=status.status_id 
			LEFT JOIN nipl_customer ct ON ticket.customer_id = ct.customer_id
			WHERE dept.dept_id=" . $dept_id ." " .$cond. "  order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
		
	}
	
	public function showUnreadDetails($dept_id="",$cond="")
	{
		$sql = "SELECT ticket.ticket_id, ticket.complaint_id, ticket.store_information, ticket.controladmin_view, brands.brand_name, status.status, complaint_type, ticket.clasification_id, clasification_type, ticket.levelone_id, levelone_name, ticket.priority_id, priority_desc, ticket.dept_id, dept_name, ticket.attachment, ticket.created_date, ct.firstname, ct.lastname, ct.email_id, ct.mobile_no
			FROM nipl_ticket ticket
			LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
			LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
			LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
			LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			LEFT JOIN nipl_status status ON ticket.status=status.status_id 
			LEFT JOIN nipl_customer ct ON ticket.customer_id = ct.customer_id
			WHERE dept.dept_id=" . $dept_id ." " .$cond. " and controladmin_view = 1 order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
		
	}
	
	
	public function csv_data($cond)
	{
		/*$sql = "SELECT ticket.ticket_id, status.status, complaint_type, brands.brand_name, clasification_type, levelone_name, priority_desc, dept_name, ticket.attachment, ticket.created_date, st.st_firstname, st.st_lastname
			FROM nipl_ticket ticket
			LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
			LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
			LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
			LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
			LEFT JOIN nipl_staff st ON ticket.staff_id = st.staff_id
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			LEFT JOIN nipl_status status ON ticket.status=status.status_id 
			". $cond ." order by ticket.created_date desc";*/
		$sql = "SELECT ticket.ticket_id, status.status, complaint_type, brands.brand_name, clasification_type, levelone_name, priority_desc, dept_name, ticket.attachment, ticket.requested_date, ticket.created_date,ticket.updated_date, DATEDIFF( ticket.updated_date, ticket.created_date ) AS TAT, st.st_firstname, st.st_lastname ,ticket.summary,ticket.complaint_details,ticket.store_information, customer.firstname, customer.lastname, customer.mobile_no, customer.address, customer.city,customer.state, customer.email_id, customer.card_details, tonality.tonality_type
			FROM nipl_ticket ticket
			LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
			LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
			LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
			LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
			LEFT JOIN nipl_staff st ON ticket.staff_id = st.staff_id
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			LEFT JOIN nipl_customer customer ON ticket.customer_id = customer.customer_id 
			LEFT JOIN nipl_tonality tonality ON ticket.tonality_id = tonality.tonality_id
			LEFT JOIN nipl_status status ON ticket.status=status.status_id 
			" . $cond ." order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function csv_escalated($crit)
	{
		$sql = "SELECT ticket.ticket_id,clasification_type,complaint_type,firstname,lastname,brands.brand_name,
		priority_desc,dept_name,ticket.created_date 
		FROM nipl_ticket ticket 
		LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id 
		LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id 
		LEFT JOIN nipl_department department ON ticket.dept_id=" . $_SESSION['dept_id'] . " 
		LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id " . $crit ." order by ticket.created_date";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function csv_stillopen($crit)
	{
		$sql = "SELECT ticket.ticket_id,clasification_type,complaint_type,brands.brand_name,
		firstname,lastname,priority_desc,dept_name,ticket.created_date 
		FROM nipl_ticket ticket 
		LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
		LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id 
		LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id 
		LEFT JOIN nipl_department department ON ticket.dept_id=department.dept_id 
		LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id " . $crit ."
		order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function csv_close($crit,$dept_id)
	{
		$sql = "SELECT ticket.ticket_id,clasification_type,complaint_type,firstname,lastname,priority_desc,	dept_name,ticket.created_date ,brands.brand_name
		FROM nipl_ticket ticket 
		LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
		LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
		LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id
		LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id
		LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id " . $crit ." order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showCustomerTicketdetails($cust_id)
	{
		$sql = "SELECT ticket.ticket_id,ticket.complaint_id,complaint_type,ticket.clasification_id,
		clasification_type,ticket.levelone_id,levelone_name,ticket.priority_id,priority_desc,ticket.dept_id,dept_name,ticket.attachment,
		DATE(ticket.created_date) as created_date,ticket.status,firstname,lastname FROM nipl_ticket ticket
		LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
		LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
		LEFT JOIN nipl_levelone levelone ON ticket.levelone_id=levelone.levelone_id 
		LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id 
		LEFT JOIN nipl_department dept ON ticket.dept_id=dept.dept_id 
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id
		WHERE  ticket.customer_id=" . $cust_id;
		
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
		
	}
	
	public function showCustomerdetails($dept_id)
	{
		$sql = "SELECT cust.customer_id,cust.dept_id,dept_name,cust.firstname,cust.lastname,cust.mobile_no,cust.city,cust.state,cust.email_id FROM nipl_customer cust LEFT JOIN nipl_department dept ON cust.dept_id=dept.dept_id WHERE dept.dept_id=" . $dept_id ." ORDER BY cust.customer_id DESC";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showRecentactivity($dept_id)
	{
		/* $sql = "SELECT ticket.ticket_id,ticket.dept_id,dept_name,ticket.status,ticket.created_date,ticket.updated_date,brands.brand_name
				FROM nipl_ticket ticket
				LEFT JOIN nipl_department dept ON ticket.dept_id=dept.dept_id
				LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id
				WHERE dept.dept_id=" . $dept_id . " ORDER BY ticket.created_date DESC"; */
		$sql = "SELECT ticket.ticket_id, ticket.dept_id, dept_name, ticket.status, ticket.created_date, ticket.updated_date,
				brands.brand_name, comment.comment, note.notes, res.comments as final_resolution, comment.created_date as c_created_date, note.created_date as n_created_date, res.created_date as res_created_date
				FROM nipl_ticket ticket
				LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
				LEFT JOIN nipl_brands brands ON ticket.brand_id = brands.brand_id
				LEFT JOIN nipl_comments	comment ON comment.ticket_id = ticket.ticket_id
				LEFT JOIN nipl_notes note ON note.ticket_id = ticket.ticket_id
				LEFT JOIN nipl_finalresolution res ON res.ticket_id = ticket.ticket_id
				WHERE dept.dept_id =" . $dept_id . "
				ORDER BY ticket.created_date DESC ";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showAllOpenticket($crit)
	{
		/* $sql = "SELECT ticket.ticket_id,ticket.complaint_id,clasification_type,ticket.clasification_id,complaint_type,ticket.customer_id,
		firstname,lastname,ticket.priority_id,priority_desc,ticket.dept_id,dept_name,ticket.created_date 
		FROM nipl_ticket ticket 
		LEFT JOIN nipl_clasification complaint ON ticket.complaint_id=complaint.clasification_id 
		LEFT JOIN nipl_complaint clasification ON ticket.clasification_id=clasification.complaint_id 
		LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id 
		LEFT JOIN nipl_department department ON ticket.dept_id=" . $_SESSION['dept_id'] . " 
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id " . $crit ."
		order by ticket.created_date desc"; */
		$sql = "SELECT ticket.ticket_id, ticket.complaint_id, ticket.store_information, ticket.controladmin_view, brands.brand_name, status.status, complaint_type, ticket.clasification_id, clasification_type, ticket.levelone_id, levelone_name, ticket.priority_id, priority_desc, ticket.dept_id, dept_name, ticket.attachment, ticket.created_date, ct.firstname, ct.lastname, ct.email_id, ct.mobile_no
			FROM nipl_ticket ticket
			LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
			LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
			LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
			LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			LEFT JOIN nipl_status status ON ticket.status=status.status_id 
			LEFT JOIN nipl_customer ct ON ticket.customer_id = ct.customer_id " . $crit ."
			order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showFilteropenDetails($filter)
	{
		$sql = "SELECT ticket.ticket_id,ticket.complaint_id,clasification_type,ticket.clasification_id,complaint_type,ticket.customer_id,firstname,lastname,city,ticket.priority_id,priority_desc,DATE(ticket.created_date) as created_date FROM nipl_ticket ticket LEFT JOIN nipl_clasification complaint ON ticket.complaint_id=complaint.clasification_id LEFT JOIN nipl_complaint clasification ON ticket.clasification_id=clasification.complaint_id LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id WHERE ticket.status=0" . $filter;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showBrandDetails($crit="" )
	{
		$sql = "SELECT ticket.ticket_id,ticket.dept_id,dept_name FROM nipl_ticket ticket LEFT JOIN nipl_department dept ON ticket.dept_id=dept.dept_id " .$crit;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
		
	}
	
	public function showAllEscticket($crit)
	{
		$sql = "SELECT ticket.ticket_id, ticket.complaint_id, ticket.store_information, ticket.controladmin_view, brands.brand_name, status.status, complaint_type, ticket.clasification_id, clasification_type, ticket.levelone_id, levelone_name, ticket.priority_id, priority_desc, ticket.dept_id, dept_name, ticket.attachment, ticket.created_date, ct.firstname, ct.lastname, ct.email_id, ct.mobile_no
			FROM nipl_ticket ticket
			LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
			LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
			LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
			LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			LEFT JOIN nipl_status status ON ticket.status=status.status_id 
			LEFT JOIN nipl_customer ct ON ticket.customer_id = ct.customer_id " . $crit ."
			order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showFilterescDetails($filter)
	{
		$sql = "SELECT ticket.ticket_id,ticket.complaint_id,clasification_type,ticket.clasification_id,complaint_type,ticket.customer_id,firstname,lastname,city,ticket.priority_id,
		priority_desc,ticket.created_date FROM nipl_ticket ticket 
		LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
		LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
		LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id 
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id 
		WHERE ticket.status=1" . $filter ." order by ticket.created_date";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showAllCloseticket($crit)
	{
		$sql = "SELECT ticket.ticket_id, ticket.complaint_id, ticket.store_information, ticket.controladmin_view, brands.brand_name, status.status, complaint_type, ticket.clasification_id, clasification_type, ticket.levelone_id, levelone_name, ticket.priority_id, priority_desc, ticket.dept_id, dept_name, ticket.attachment, ticket.created_date, ct.firstname, ct.lastname, ct.email_id, ct.mobile_no
			FROM nipl_ticket ticket
			LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
			LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
			LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
			LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
			LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			LEFT JOIN nipl_status status ON ticket.status=status.status_id 
			LEFT JOIN nipl_customer ct ON ticket.customer_id = ct.customer_id " . $crit ."
			order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showFiltercloseDetails($filter)
	{
		$sql = "SELECT ticket.ticket_id,ticket.complaint_id,clasification_type,ticket.clasification_id,complaint_type,ticket.customer_id,firstname,lastname,city,ticket.priority_id,
		priority_desc,DATE(ticket.created_date) as created_date FROM nipl_ticket ticket
		LEFT JOIN nipl_clasification complaint ON ticket.complaint_id=complaint.clasification_id 
		LEFT JOIN nipl_complaint clasification ON ticket.clasification_id=clasification.complaint_id 
		LEFT JOIN nipl_priority priority ON ticket.priority_id=priority.priority_id 
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id 
		WHERE ticket.status=2" . $filter;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function viewTicketDetails($ticket_id)
	{
		$sql = "SELECT ticket.ticket_id,DATE(ticket.created_date) as created_date,ticket.clasification_id,complaint_type,ticket.summary,ticket.attachment,ticket.status,ticket.levelone_id,levelone_name,
		ticket.tonality_id,tonality_type,ticket.complaint_details,ticket.customer_id,firstname,lastname,mobile_no,email_id,address,city,ticket.staff_id,st_firstname,st_lastname
		FROM nipl_ticket ticket
		LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
		LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
		LEFT JOIN nipl_levelone levelone ON ticket.levelone_id=levelone.levelone_id
		LEFT JOIN nipl_tonality tonality ON ticket.tonality_id=tonality.tonality_id
		LEFT JOIN nipl_customer customer ON ticket.customer_id=customer.customer_id
		LEFT JOIN nipl_staff staff ON ticket.staff_id=staff.staff_id
		WHERE ticket.ticket_id=" . $ticket_id;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function ViewCommentDetails($ticket_id)
	{
		$sql = "SELECT comment.comment_id,comment.staff_id,st_firstname,st_lastname,DATE(comment.created_date) as created_date,comment.comment FROM nipl_comments comment LEFT JOIN nipl_staff staff ON comment.staff_id=staff.staff_id WHERE comment.ticket_id=" . $ticket_id;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function viewTatDetails($cond)
	{
		/* $sql = "SELECT ticket.ticket_id,ticket.dept_id,dept_name,brands.brand_name,count(ticket.ticket_id) as ticketcount, TIMEDIFF(ticket.updated_date,ticket.created_date) as datediff , ticket.created_date, ticket.updated_date
			FROM nipl_ticket  ticket 
			LEFT JOIN nipl_department department ON ticket.dept_id=department.dept_id 
			LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
			WHERE ticket.status=2 AND department.dept_id=" . $_SESSION['dept_id']. "" .$cond; */
		$sql = "SELECT ticket.ticket_id, TIMEDIFF( ticket.updated_date, ticket.created_date ) AS datediff, ticket.created_date, brands.brand_name, ticket.updated_date
				FROM nipl_ticket ticket
				LEFT JOIN nipl_department department ON ticket.dept_id = department.dept_id
				LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
				WHERE ticket.status=2 AND department.dept_id=" . $_SESSION['dept_id']. "" .$cond." order by ticket.created_date desc";;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function tat_data($cond)
	{
		$sql = "SELECT ticket.ticket_id, DATEDIFF( ticket.updated_date, ticket.created_date ) AS TAT, ticket.created_date as Date_assign, brands.brand_name,  ticket.updated_date as Date_closed
				FROM nipl_ticket ticket
				LEFT JOIN nipl_department department ON ticket.dept_id = department.dept_id
				LEFT JOIN nipl_brands brands ON ticket.brand_id=brands.brand_id 
				" .$cond." order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function showEscalationsDetails($dept_id="",$cond="")
	{
		$sql = "SELECT e.escalations_id, e.brands, e.priority as p_id, b.brand_name, p.priority, e.level_1_email_ids, e.level_2_email_ids, e.level_1_hours, e.level_2_hours
				FROM nipl_escalations AS e
				LEFT JOIN nipl_brands AS b ON b.brand_id = e.brands
				LEFT JOIN nipl_priority AS p ON p.priority_id = e.priority
				WHERE b.dept_id =".$dept_id;
		if($cond !="")
		{
			$sql .= $cond;
		}
		//echo $sql; die;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	public function getStore()
	{
		$sql = "Select * from nipl_store_information order by store_name";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function getBrand()
	{
		$sql = "Select * from nipl_brands where dept_id = ".$_SESSION['dept_id']." order by brand_name";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function getComplaint()
	{
		$sql = "Select * from nipl_complaint order by complaint_type";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function getPriority()
	{
		$sql = "Select * from nipl_priority order by priority";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function getClasification()
	{
		$sql = "Select * from nipl_clasification order by clasification_type";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	} 
	
	public function getReason()
	{
		$sql = "Select * from nipl_levelone order by levelone_name";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	} 
	public function getTonality()
	{
		$sql = "Select * from nipl_tonality order by tonality_type";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	} 
	
	public function store_info_data($cond)
	{
		//echo $dept_id; die;
		$sql = "SELECT ticket.ticket_id, status.status, complaint_type, brands.brand_name, clasification_type,
				levelone_name, priority_desc, dept_name, ticket.attachment, ticket.created_date, st.st_firstname, st.st_lastname,customer.firstname,customer.lastname
				FROM nipl_ticket ticket
				LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
				LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
				LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
				LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
				LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
				LEFT JOIN nipl_staff st ON ticket.staff_id = st.staff_id
				LEFT JOIN nipl_brands brands ON ticket.brand_id = brands.brand_id
				LEFT JOIN nipl_customer customer ON ticket.customer_id = customer.customer_id
				LEFT JOIN nipl_status status ON ticket.status = status.status_id
				WHERE ".$cond." order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	
	public function type_info_data($cond)
	{
		$sql = "SELECT COUNT( ticket.ticket_id ) AS ticket, clasification_type
				FROM nipl_ticket ticket
				LEFT JOIN nipl_clasification AS clasification ON clasification.clasification_id = ticket.clasification_id
				WHERE ticket.dept_id =".$_SESSION['dept_id']."".$cond."
				GROUP BY ticket.clasification_id";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function source_info_data($cond)
	{
		$sql = "SELECT COUNT( ticket.ticket_id ) AS complaintcount, complaint_type, tonality_type
				FROM nipl_ticket ticket
				LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
				LEFT JOIN nipl_tonality tonality ON ticket.tonality_id = tonality.tonality_id
				WHERE ticket.dept_id =".$_SESSION['dept_id']." and ".$cond."
				GROUP BY (
				ticket.complaint_id
				)";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	public function source_report_data($cond)
	{
		$sql = "SELECT ticket.ticket_id, status.status, complaint_type, brands.brand_name, clasification_type, levelone_name, priority_desc, dept_name, ticket.attachment, ticket.created_date, st.st_firstname, st.st_lastname, t.tonality_type
				FROM nipl_ticket ticket
				LEFT JOIN nipl_clasification clasification ON ticket.clasification_id = clasification.clasification_id
				LEFT JOIN nipl_complaint complaint ON ticket.complaint_id = complaint.complaint_id
				LEFT JOIN nipl_levelone levelone ON ticket.levelone_id = levelone.levelone_id
				LEFT JOIN nipl_priority priority ON ticket.priority_id = priority.priority_id
				LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
				LEFT JOIN nipl_staff st ON ticket.staff_id = st.staff_id
				LEFT JOIN nipl_brands brands ON ticket.brand_id = brands.brand_id
				LEFT JOIN nipl_status status ON ticket.status = status.status_id
				LEFT JOIN nipl_tonality t ON ticket.tonality_id = t.tonality_id
				WHERE " . $cond ." order by ticket.created_date desc";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
	/*public function showRecentactivity($dept_id="")
	{
		$sql = "SELECT ticket.ticket_id, ticket.dept_id, dept_name, ticket.status, ticket.created_date, ticket.updated_date,
				brands.brand_name, comment.comment, note.notes, res.comments as final_resolution, comment.created_date as c_created_date, note.created_date as n_created_date, res.created_date as res_created_date
				FROM nipl_ticket ticket
				LEFT JOIN nipl_department dept ON ticket.dept_id = dept.dept_id
				LEFT JOIN nipl_brands brands ON ticket.brand_id = brands.brand_id
				LEFT JOIN nipl_comments	comment ON comment.ticket_id = ticket.ticket_id
				LEFT JOIN nipl_notes note ON note.ticket_id = ticket.ticket_id
				LEFT JOIN nipl_finalresolution res ON res.ticket_id = ticket.ticket_id
				WHERE ticket.staff_id=" . $dept_id . " ORDER BY ticket.created_date DESC";
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}*/
	
	public function viewTatpiechart($cond)
	{
		$sql = "SELECT DATEDIFF( updated_date, created_date ) AS hours FROM nipl_ticket WHERE status=2 AND brand_id=" . $_SESSION['dept_id'] ." " . $cond;
		$result = $this->sql_fetchrowset($this->sql_query($sql));
		return $result;
	}
	
}

?>