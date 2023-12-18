<?php
/*
 * PHP IMAP - Send an email using IMAP and save it to the Sent folder
 */

//for demo purposes we are gonna send an email to ourselves
$to = "saniith.s@gmail.com";
$subject = "Test Email";
$body = "This is only a test.";
$headers = "From: sanith.sumanthran@netscribes.com\r\n".
           "Reply-To: sanith.sumanthran@netscribes.com\r\n";
$cc = 'saniith.s@gmail.com';
$bcc = null;
$return_path = "sanith.sumanthran@netscribes.com";
//send the email using IMAP
$a = imap_mail($to, $subject, $body, $headers, $cc, $bcc, $return_path);
echo "Email sent!<br />";

// connect to the email account
$mbox = imap_open("{imap.gmail.com:993/imap/ssl}", "sanith.sumanthran@netscribes.com", "lmrssmbzv");

// save the sent email to your Sent folder by just passing a string composed 
// of the entire message + headers. 
// Notice the 'r' format for the date function, which formats the date correctly for messaging.

imap_append($mbox, "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail",
     "From: sanith.sumanthran@netscribes.com\r\n".
     "To: ".$to."\r\n".
     "Subject: ".$subject."\r\n".
     "Date: ".date("r", strtotime("now"))."\r\n".
     "\r\n".
     $body.
     "\r\n"
     );
echo "Message saved to Send folder!<br />";

// close mail connection.
imap_close($mbox);

?>