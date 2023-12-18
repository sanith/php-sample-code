<?php
//$user = 'saniith.s@gmail.com';
//$pass = 'lmrssmbzv@pundach';
$user = 'sanith.sumanthran@netscribes.com';
$pass = 'lmrssmbzv';
$host = 'imap.gmail.com:993/imap';

// Connect to the pop3 email inbox belonging to $user
// If you need SSL remove the novalidate-cert section
$con = imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX", $user, $pass);

$MC = imap_check($con); 

// Get the number of emails in inbox
$range = "1:".$MC->Nmsgs; 
echo $range;
// Retrieve the email details of all emails from inbox
$response = imap_fetch_overview($con,$range); 

// displays basic email info such as from, to, date, subject etc...
foreach ($response as $msg) {

        echo '<pre>';
        var_dump($msg);
        echo '</pre><br>-----------------------------------------------------<br>';
}
?>