<?php 
include("mysql.inc.php");
include("dbconn.class.php");
include("global.class.php");

$global           = new Common;
$table_name       = 'gmail_parser';
$crit             = "WHERE `site_name`='http://www.cloudtime.to' AND `flag`='0' ORDER BY `id` ASC";
$arrResult        = $global->showAllDetails($table_name,$crit);
$count            = 1;
foreach($arrResult as $result)
{
	$body                      = $result['mail_body'];
	$id                        = $result['id'];
	$post_data['tip']          = 'Abuse Report';
	$post_data['name']         = 'Daniel Dworatschek';
	$post_data['organisation'] = 'OpSec Security GmbH';
	$post_data['email']        = 'ddworatschek@opsecsecurity.com';
	$post_data['description']  = $body;
	$created_date              = date("y-m-d H:i:s");
	$updated_ip                = $_SERVER['REMOTE_ADDR'];
	foreach ( $post_data as $key => $value) {
		$post_items[] = $key . '=' . $value;
	}
	$post_string     = implode ('&', $post_items);
	$curl_connection = curl_init('http://www.cloudtime.to/contact.php');
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_connection, CURLOPT_HTTPHEADER,array("Expect:  "));
	curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
	$result   = curl_exec($curl_connection);
	sleep(3);
	$result   = preg_replace('/[^\p{L}0-9 ]/', ' ', $result);
	$result   = trim(preg_replace('/\s+/', '', $result));
	$position = strpos($result, 'Yourmessagehasbeensent');
	if($position != "")
	{
		$arrUpdate  = array(
							"flag" => '1',
							"updated_ip" => $_SERVER['REMOTE_ADDR']
		);
		$table_name = 'gmail_parser';
		$crit       = "WHERE `id`='" . $id . "' AND `flag`='0'";
		$global->updateDetails($table_name,$arrUpdate,$crit);
	}
	else
	{
		$arrUpdate  = array(
							"flag" => '0',
							"updated_ip" => $_SERVER['REMOTE_ADDR']
		);
		$table_name = 'gmail_parser';
		$crit       = "WHERE `id`='" . $id . "' AND `flag`='0'";
		$global->updateDetails($table_name,$arrUpdate,$crit);
	}
	curl_close($curl_connection);
	$count = $count+1;
	if($count == 20)
	{
		exit();
	}
}
?>
