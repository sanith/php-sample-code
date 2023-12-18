<?php 
$dbhost           = 'localhost';
$dbuser           = 'root';
$dbpass           = 'root';
$dbname           = 'ticketingdb';   

$imapserverstring = 'imap.gmail.com:993/imap/ssl/novalidate-cert';
$imapuser         = 'sanith.sumanthran@netscribes.com';
$imappass         = 'lmrssmbzv';
//$imapuser         = 'saniith.s@gmail.com';
//$imappass         = 'lmrssmbzv@pundach';

$mbox             = imap_open("{".$imapserverstring."}INBOX", $imapuser,$imappass) or die("can't connect: " . imap_last_error());
$emails           = imap_search($mbox,'UNSEEN');
$emailcount       = count($emails);
//foreach($emails as $mail) {
	if($emailcount >= 1)
	{
		for($i=0;$i<$emailcount;$i++)
		{
			$headerInfo  = imap_headerinfo($mbox,$emails[$i]);
			$subject     = $headerInfo->subject;
			$toaddress   = $headerInfo->toaddress;
			$date        = $headerInfo->date;
			$fromaddress = $headerInfo->fromaddress;
			$r_toaddress = $headerInfo->reply_toaddress;
			$emailStructure = imap_fetchstructure($mbox,$mail);
			exit();
			if(!isset($emailStructure->parts)) {
				$body = quoted_printable_decode(imap_fetchbody($mbox, $emails[$i], FT_UID));
			} else {
				//
			}
			$body = str_replace("&","and",$body);
			
			/*preg_match('/<b>Ticket ID:  :<\/b>(.*?)<br>/', $body, $match); 
			preg_match('/target="_blank">(.*?)<\/a>/', $body, $match1);
			preg_match('/<b>Contact no :<\/b>(.*?)<br>/', $body, $match2);
			preg_match('/<b>Store :<\/b>(.*?)<br>/', $body, $match3);
			preg_match('/<b>Brand :<\/b>(.*?)<br>/', $body, $match4);
			preg_match('/<b>City :<\/b>(.*?)<br>/', $body, $match5);
			preg_match('/<b>Address :<\/b>(.*?)<br>/s', $body, $match6);
			preg_match('/<b>Feedback :<\/b>(.*?)<br>/s', $body, $match7);
			$fullname  = $match[1];
			$email     = $match1[1];
			$contactno = $match2[1];
			$store     = $match3[1];
			$brand     = $match4[1];
			$city      = $match5[1];
			$address   = $match6[1];
			$feedback  = $match7[1];
			$fullname  = preg_split("/[\s]+/", $fullname);
			$firstname = $fullname[1];
			$sec_name  = $fullname[2];*/
			$post_data['tip']  = 'Abuse Report';
			$post_data['name'] = 'Daniel Dworatschek';
			$post_data['com']  = 'OpSec Security GmbH';
			$post_data['mail'] = 'ddworatschek@opsecsecurity.com';
			$post_data['msg']  = $body;
			foreach ( $post_data as $key => $value) {
				$post_items[] = $key . '=' . $value;
			}
			$post_string = implode ('&', $post_items);
			$curl_connection = curl_init('http://netqms.com:9000/leavemanagement/testmail.php');
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
			$result = curl_exec($curl_connection);
			//print_r(curl_getinfo($curl_connection));
			//echo curl_errno($curl_connection) . '-' . 
			curl_error($curl_connection);
			curl_close($curl_connection);
		}
		//$conn    = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
		//mysql_select_db($dbname);
		//$query   = "INSERT INTO `nipl_customer` ( `dept_id`, `firstname`, `lastname`, `mobile_no`, `address`, `city`, `email_id`) VALUES ( '12', '{$firstname}', '{$sec_name}', '{$contactno}', '{$address}', '{$city}', '{$email}');";
		//$result  = mysql_query($query);
		//mysql_close($conn);
	}
	else
	{
		echo "<h1>There are no new mails in the inbox</h1>";
	}
//}
//imap_delete($mbox, 1); 
imap_close($mbox); 
?>