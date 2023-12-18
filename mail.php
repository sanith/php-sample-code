<?php
 
//create array of data to be posted
//$post_data['firstName'] = 'Name';
//$post_data['action'] = 'Register';
$post_data['tip']  = 'Abuse Report';
$post_data['com']  = 'OpSec Security GmbH';
 
//traverse array and prepare data for posting (key1=value1)
foreach ( $post_data as $key => $value) {
    $post_items[] = $key . '=' . $value;
}
 
//create the final string to be posted using implode()
$post_string = implode ('&', $post_items);
 
//create cURL connection
//$curl_connection = curl_init('http://netqms.com:9000/leavemanagement/testmail.php');
$curl_connection = curl_init('http://www.videoweed.es/contact.php');
 
//set options
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl_connection, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
 
//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
 
//perform our request
$result = curl_exec($curl_connection);
 
//show information regarding the request
//print_r(curl_getinfo($curl_connection));
//print_r($result);
//echo $result;
//echo curl_errno($curl_connection) . '-' . curl_error($curl_connection);
$result = preg_replace('/[^\p{L}0-9 ]/', ' ', $result);
$result = trim(preg_replace('/\s+/', '', $result));
$position = strpos($result, 'Yourmessagehasbeensent');
if($position != "")
{
	echo "sanith";
}
else
{
	echo "sanith1";
}
 
//close the connection
curl_close($curl_connection);
 
?>