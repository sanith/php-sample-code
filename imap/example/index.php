<?php

require_once('../src/ImapMailbox.php');

// IMAP must be enabled in Google Mail Settings
define('GMAIL_EMAIL', 'saniith.s@gmail.com');
define('GMAIL_PASSWORD', 'lmrssmbzv@pundach');
define('ATTACHMENTS_DIR', dirname(__FILE__) . '/attachments');

$mailbox = new ImapMailbox('{imap.gmail.com:993/imap/ssl}INBOX', GMAIL_EMAIL, GMAIL_PASSWORD, ATTACHMENTS_DIR, 'utf-8');
$mails = array();

// Get some mail
//$mailsIds = $mailbox->searchMailBox('ALL');
$mailsIds = $mailbox->getListingFolders();//('recent');
if(!$mailsIds) {
	die('Mailbox is empty');
}

$mailId = reset($mailsIds);
$mail = $mailbox->getMail($mailId);

var_dump($mail);
var_dump($mail->getAttachments());

?>
