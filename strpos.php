<?php
$text     = 'Videoweed

    Home
    Login
    Sign up
    Premium

Your message has been sent!
Home | FAQ | Premium | Terms of Service | Contact ';
$text = preg_replace('/[^\p{L}0-9 ]/', ' ', $text);
$text = trim(preg_replace('/\s+/', '', $text));
$position = strpos($text, 'Yourmessagehasbeensent');
if($position != "")
{
	echo "sanith";
}
else
{
	echo "sanith1";
}

?>