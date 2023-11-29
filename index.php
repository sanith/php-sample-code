<?php
error_reporting(E_ALL);
$dbhost           = 'mysql.healthcare.netscribes.net';
$dbuser           = 'healthcare_root';
$dbpass           = 'netscr1bes';
$dbname           = 'healthcare_db';
$conn             = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);


$imapserverstring = 'imap.gmail.com:993/imap/ssl/novalidate-cert';
$imapuser         = 'nsapdmca@gmail.com';
$imappass         = 'nsapdmca1';

$mbox             = imap_open("{".$imapserverstring."}INBOX", $imapuser,$imappass) or die("can't connect: " . imap_last_error());
$emails           = imap_search($mbox,'UNSEEN');
$emailcount       = count($emails);
//foreach($emails as $mail) {
	if($emailcount >= 1)
	{
		$count = 1;
		for($i=0;$i<=$emailcount;$i++)
		{
			$headerInfo  = imap_headerinfo($mbox,$emails[$i]);
			$subject     = $headerInfo->subject;
			$toaddress   = $headerInfo->toaddress;
			$date        = $headerInfo->date;
			$fromaddress = $headerInfo->fromaddress;
			$r_toaddress = $headerInfo->reply_toaddress;

			$subject1  = preg_replace('/[^\p{L}0-9 ]/', ' ', $subject);
			$subject1  = trim(preg_replace('/\s+/', '', $subject1));
			$sitename  = strpos($subject1, 'httpwwwvideoweedcom');
			if($sitename != "")
			{
				$site_name = "http://www.videoweed.com";
				$emailStructure = imap_fetchstructure($mbox,$mail);
				if(!isset($emailStructure->parts)) {
					$body = quoted_printable_decode(imap_fetchbody($mbox, $emails[$i], FT_UID));
				} else {
				}
				$body              = str_replace("&","and",$body);
				$body              = str_replace("'","''",$body);
				$body              = explode("Netscribes is a consulting",$body);
				$body              = $body[0];
				$body              = substr($body, 0, -9);
				$post_data['tip']  = 'Abuse Report';
				$post_data['name'] = 'Daniel Dworatschek';
				$post_data['com']  = 'OpSec Security GmbH';
				$post_data['mail'] = 'ddworatschek@opsecsecurity.com';
				$post_data['msg']  = $body;
				$created_date      = date("y-m-d H:i:s");
				$created_ip        = $_SERVER['REMOTE_ADDR'];
				foreach ( $post_data as $key => $value) {
					$post_items[] = $key . '=' . $value;
				}
				$post_string     = implode ('&', $post_items);
				$curl_connection = curl_init('http://www.videoweed.es/contact.php');
				curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($curl_connection, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
				curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curl_connection,CURLOPT_HTTPHEADER,array("Expect:  "));
				curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
				$result = curl_exec($curl_connection);
				sleep(3);
				//print_r(curl_getinfo($curl_connection));
				//echo curl_errno($curl_connection) . '-' . curl_error($curl_connection);
				//echo "<br />+++++++++++++++++++++++";
				$result   = preg_replace('/[^\p{L}0-9 ]/', ' ', $result);
				$result   = trim(preg_replace('/\s+/', '', $result));
				$position = strpos($result, 'Yourmessagehasbeensent');
				if($position != "")
				{
					$remove_character = array("\n", "\r\n", "\r", ":\s");
					$body = str_replace($remove_character , ' ' , $body);
					$body = preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $body);
					$flag    = 1;
					$query   = "INSERT INTO `gmail_parser` ( `mail_subject`, `site_name`, `mail_body`, `mail_date`, `flag`,`created_date`, `created_ip`) VALUES ( '{$subject}', '{$site_name}', '{$body}', '{$date}', '{$flag}','{$created_date}', '{$created_ip}');";
					$result1 = mysql_query($query);
				}
				else
				{
					$remove_character = array("\n", "\r\n", "\r", ":\s");
					$body = str_replace($remove_character , ' ' , $body);
					$body = preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $body);
					$flag    = 0;
					$query   = "INSERT INTO `gmail_parser` ( `mail_subject`, `site_name`, `mail_body`, `mail_date`, `flag`, `created_date`, `created_ip`) VALUES ( '{$subject}', '{$site_name}', '{$body}', '{$date}','{$flag}', '{$created_date}', '{$created_ip}');";
					$result1 = mysql_query($query);
				}
				curl_close($curl_connection);
			}
			$count = $count+1;
			if($count == 20)
			{
				exit();
			}
		}
	}
	else
	{
		echo "<h1>There are no new mails in the inbox</h1>";
	}
//}
//imap_delete($mbox, 1);
imap_close($mbox);
mysql_close($conn);
?>
