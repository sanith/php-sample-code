<?php
error_reporting(E_ALL);
$dbhost           = 'mysql.healthcare.netscribes.net';
$dbuser           = 'healthcare_root';
$dbpass           = 'netscr1bes';
$dbname           = 'healthcare_db';

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
			$subject1  = preg_replace('/[^\p{L}0-9 ]/', ' ', $subject);
			$subject1  = trim(preg_replace('/\s+/', '', $subject1));
			$sitename  = strpos($subject1, 'httpsharedsx');
			if(!isset($emailStructure->parts)) {
				$body = quoted_printable_decode(imap_fetchbody($mbox, $emails[$i], FT_UID));
			} else {
				//
			}
			$body = str_replace("&","and",$body);
			if($sitename != "")
			{
				$sitename  = "http://shared.sx";
				preg_match('/Title:(.*?)\\n/m', $body, $match);
				preg_match('/Infringement Source:(.*?)\\n/m', $body, $match1);
				preg_match('/Initial Infringement Date:(.*?)\\n/m', $body, $match2);
				preg_match('/Infringing URL\(s\):(.*?)This/ims', $body, $match3);
				$title     = $match[1];
				$infsource = $match1[1];
				$infdate   = $match2[1];
				$infring   = $match3[1];
				$crdate    = date("y-m-d H:i:s");
				$createdip = $_SERVER['REMOTE_ADDR'];
				$conn      = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
				mysql_select_db($dbname);
				$query     = "INSERT INTO `gmail_parser_new` ( `mail_subject`, `site_name`, `mail_date`, `title`,`infringement_source`,`infrigment_date`,`infringment_urls`,`created_date`, `created_ip`) VALUES ( '{$subject}', '{$sitename}', '{$date}', '{$title}', '{$infsource}', '{$infdate}', '{$infring}', '{$crdate}', '{$createdip}');";
				$result1 = mysql_query($query);
				mysql_close($conn);
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
?>