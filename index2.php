<?php
/*
To use this code, fill the correct values for 
the variables $gmail_username, $gmail_password
*/
 
function get_gmail($username , $password)
{
    $url = "https://mail.google.com/mail/feed/atom";
     
    $c = curl_init();
     
    $options = array(
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC ,
        CURLOPT_USERPWD => "$username:$password" ,
        CURLOPT_SSLVERSION => 3 ,
        CURLOPT_SSL_VERIFYPEER => FALSE ,
        CURLOPT_SSL_VERIFYHOST => 2 ,
        CURLOPT_RETURNTRANSFER => true ,
        CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)" ,
        CURLOPT_URL => $url
    );
     
    curl_setopt_array($c, $options);
    $output = curl_exec($c);
     
    return $output;
}
 
//$gmail_username = 'saniith.s@gmail.com';
//$gmail_password = 'lmrssmbzv@pundach';
$gmail_username = 'sanith.sumanthran@netscribes.com';
$gmail_password = 'lmrssmbzv';
 
echo get_gmail( $gmail_username , $gmail_password );
?>