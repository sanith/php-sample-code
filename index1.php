<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>PHP get the unread emails from Gmail Inbox using PHP</title><meta name="google-site-verification" content="liGddaK7I8_x0tSdKv36CRi_rMfRt3yMNjILkbOAxxY" /><link href='http://feeds2.feedburner.com/webinfopedia' rel='alternate' title='Webinfopedia-Learn SEO, Web Designing and Web development easily with example and demos' type='application/rss+xml'/><meta name="msvalidate.01" content="1CBFD6FA96646CD69CE09C869B2F6313" /><META name="y_key" content="2e447c925218040f" /><link rel="search" type="application/opensearchdescription+xml" href="http://www.webinfopedia.com/classes/opensearch.xml" title="SEO,PHP and Ajax blog" /> <meta content="php gmail, gmail, php gmail smtp, php mail gmail, gmail php mail, gmail lite, php gamil, get emails, gmail email fetch, php gmail API, Gmail PHP fetch, Gmail php api, how to php gmail, how to gmail php" name="keywords"  /><meta name="author" content="webinfopedia" /><meta name="copyright" content="webinfopedia.com" /><meta name="Robots" content="index, follow" /><meta name="language" content="English" /><link rel="shortcut icon" href="http://www.webinfopedia.com/images/webinfopedia-fav.png"  />
</head>
<body>  <div class="maindiv">
<div class="innerbg">
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td align="left" valign="middle" bgcolor="#008000"><div style="margin:0px 10px; font-weight:bold; color:#FFF; font-size:16px;">How to get emails from Gmail Inbox in PHP</div></td>
    </tr>
  <tr>
    <td align="center" valign="middle">
    <form method="post">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <!-- testing the git command for GUI -->
    <!-- testing the git command for GUI 2 -->
    <!-- testing the git command for GUI 2 -->
    </tr>
  <tr>
    <td width="15%">Username</td>
    <td width="27%"><label for="username"></label>
      <input name="username" type="text" id="username" /></td>
    <td width="10%">Password</td>
    <td width="25%"><label for="password"></label>
      <input name="password" type="password" id="password" /></td>
    <td width="23%"><input type="submit" name="getgmails" id="getgmails" value="Get Gmail" /></td>
  </tr>
  <tr>
    <td colspan="5">
    <div class="newsli">
<?php
if(isset($_POST['getgmails']))
{
//fucntion to get unread emails taking username and password as parametes
function check_email($username, $password)
{ 
    //url to connect to
    $url = "https://mail.google.com/mail/feed/atom"; 

    // sendRequest 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    $curlData = curl_exec($curl);
    curl_close($curl);
	
    //returning retrieved feed
    return $curlData;
}

//making page to behave like xml document to show feeds
//header('Content-Type:text/html; charset=UTF-8');
//calling function
	$feed = check_email($_POST['username'], $_POST['password']);
	//$feed = check_email('sanith.sumanthran@netscribes.com', 'lmrssmbzv');
	$x = new SimpleXmlElement($feed);
	echo "<ul>";
	foreach($x->entry as $entry)
	{
		?>
		<li><p><strong class="links"><?php echo $entry->title; ?></strong><br>
			<?php echo $entry->summary; ?><br />
			<?php echo $entry->modified; ?><br />
			<?php echo $enrty->issued; ?><br />
			<?php echo $enrty->author->name; ?><br />
		</p></li>
		<?php
	}
	echo "</ul>";
	echo "<ul>";
	foreach($x->author as $author)
	{
		?>
		<li><?php echo $author->email; ?></li>
		<?php
	}
	echo "</ul>";
}
?>
    </div>
    </td>
    </tr>
</table>
</form>
    </td>
    </tr>
</table>
</div>
</div>

</body></html>