<?php
$max_time_limit = 600; // in seconds
ini_set ("date.timezone","America/New_York");
ini_set ("SMTP","smtp.domain.com");
ini_set ("sendmail_from","noreply@domain.com");

function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {

	    foreach($messageParts as $part) {
	        $flattenedParts[$prefix.$index] = $part;
	        if(isset($part->parts)) {
	            if($part->type == 2) {
	                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
	            }
	            elseif($fullPrefix) {
	                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
	            }
	            else {
	                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
	            }
	            unset($flattenedParts[$prefix.$index]->parts);
	        }
	        $index++;
	    }

	    return $flattenedParts;
	}

function getPart($connection, $messageNumber, $partNumber, $encoding) {

	    $data = imap_fetchbody($connection, $messageNumber, $partNumber);
	    switch($encoding) {
	        case 0: return $data; // 7BIT
	        case 1: return $data; // 8BIT
	        case 2: return $data; // BINARY
	        case 3: return base64_decode($data); // BASE64
	        case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
	        case 5: return $data; // OTHER
	    }


	}

function getFilenameFromPart($part) {

	    $filename = '';

	    if($part->ifdparameters) {
	        foreach($part->dparameters as $object) {
	            if(strtolower($object->attribute) == 'filename') {
	                $filename = $object->value;
	            }
	        }
	    }

	    if(!$filename && $part->ifparameters) {
	        foreach($part->parameters as $object) {
	            if(strtolower($object->attribute) == 'name') {
	                $filename = $object->value;
	            }
	        }
	    }

	    return $filename;

	}




$db_host = 'server';
$db_un = 'sa';
$db_pass = 'pw';

/* Authenticate to Mailserver */
$mailserver = "{smtp.domain.com:143}";
$mailuser = "user";
$mailpass = "pw";

$date = date("m-d-y-h-i-s");

/* Open Mailbox Stream */
$mbox = imap_open($mailserver, $mailuser, $mailpass) or die ("Couldn't connect to $mailserver");

/* Search For Message Criteria  See:  http://us.php.net/manual/en/function.imap-search.php */
$crit = "SUBJECT \"###\"";
$header = imap_search($mbox, $crit);

/* Return Results Of Search */
foreach ($header as $val) {
	$id="";

	/* Retrieve Body Of Message */
	$body = imap_fetchbody($mbox, $val, 1.1 , FT_PEEK);

	/* Retrieve Details From Header Of Message */
	// [subject] [from] [to] [date] [message_id] [size] [uid] [msgno] [recent] [flagged] [answered] [deleted [seen] [draft]

	$v = imap_fetch_overview($mbox, $val);
	foreach ($v as $ov) {
		$strsubject = $ov->subject;  // subject
		$strfrom = $ov->from;  // from
		$strto = $ov->to;  // to
		$strdate = $ov->date;  // date
		$messageid = $ov->message_id;  // Message ID
		$msgno = $ov->msgno;  // Message #

	}

$JOBNUM = str_replace(' ', '', $strsubject);
$JOBNUM = substr(ltrim($JOBNUM),3,6);



 	echo "<br>From: " . $strfrom . "<br>To: " . $strto . "<br>Date: " . $strdate . "<br>". "Subject: " . $strsubject . "<br>";
	echo "Job Number: " . $JOBNUM. "<br>";
	echo "MessageID: " . $messageid. "<br><br>";
	echo nl2br($body)."<br><br>";
	echo $date;
	echo "<br><br>";


	//DO DB insert here and save Files to Disk
	$conn = odbc_connect($db_host,$db_un,$db_pass);
    //mysql_select_db($db_name);

 $body =  str_replace("'",'&#39;',$body);
 $body =  str_replace("\"",'&#34;',$body);
 $body =  str_replace("\\",'&#92;',$body);
 $strsubject =  str_replace("'",'&#39;',$strsubject);
 $strsubject =  str_replace("\"",'&#34;',$strsubject);
 $strsubject =  str_replace("\\",'&#92;',$strsubject);


$stmt = odbc_prepare($conn, "INSERT INTO tblEmail (MailFrom, Subject, Body, JOBNUM, EMAILID) VALUES('" . $strfrom . "','" . $strsubject . "','" . $body . "','" .$JOBNUM. "','" . $messageid . "');");
if (!odbc_execute($stmt)) {
    /* error  */
    echo "Whoops";

}
//get attachments

    $structure = imap_fetchstructure($mbox, $msgno);
	$flattenedParts = flattenParts($structure->parts);

	foreach($flattenedParts as $partNumber => $part) {

	    switch($part->type) {

	        case 0:
	            // the HTML or plain text part of the email
	            $message = getPart($mbox, $msgno, $partNumber, $part->encoding);

	            // now do something with the message, e.g. render it
	        break;

	        case 1:
	            // multi-part headers, can ignore

	        break;
	        case 2:
	            // attached message headers, can ignore
	        break;

	        case 3: // application
	        case 4: // audio
	        case 5: // image
	        case 6: // video
	        case 7: // other
	            $filename = getFilenameFromPart($part);
	            if($filename) {
	                // it's an attachment
                $attachment = getPart($mbox, $msgno, $partNumber, $part->encoding);
	                // now do something with the attachment, e.g. save it somewhere
				$Interpath = "F:/Interoffice_uploads/uploads/" . $JOBNUM . "/";
				mkdir(str_replace('//','/',$Interpath), 0755, true);
                //echo $date->format('U = Y-m-d H:i:s') . "\n"
				$filename =  $date . "-" .$filename;
				$filename =  str_replace(' ','-',$filename);
				$filename =  str_replace('&','-',$filename);
				$filename =  str_replace('=','-',$filename);
				$filename =  strtoupper($filename);

				$tFileHandle = fopen($Interpath . $filename, "w");
				//$tFileHandle = fopen('F:/Interoffice_uploads/uploads/' . 'JF-' . $filename, "w");
				$fileContent = imap_fetchbody($mbox, $msgno, $partNumber);
                fwrite($tFileHandle, imap_base64($fileContent));
                fclose ($tFileHandle);
				echo "Attachment:  " . $filename;
				echo "<br>";
				$stmt = odbc_prepare($conn, "INSERT INTO tblEmailFiles (FILENAME, EMAILID) VALUES('" . $filename . "','" . $messageid . "');");
				if (!odbc_execute($stmt)) {
   			 /* error  */
    			echo "Whoops";

}



	            }
	            else {
	                // don't know what it is
	            }
	        break;

	    }

	}

	echo "---------------------------------------------------------------------------------------------------<br>";
	echo "---------------------------------------------------------------------------------------------------<br>";

//send email
 $to = $strfrom;
$newmsg = "Email attached to JOB#  ".$JOBNUM;
$newsubject = "Email Upload Complete";
mail($to,$newsubject,$newmsg);

	odbc_close ($conn);
	imap_delete($mbox, $val);  // delete the e-mail
}


/* Delete Messages */
imap_expunge($mbox);

/* Close Mailbox Stream */
imap_close($mbox);

?>
