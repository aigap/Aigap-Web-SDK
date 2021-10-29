<?php

date_default_timezone_set('Europe/Istanbul');

include("config.php");
include("aigap.class.php");

$subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));

$aigap = new aigap();

if ( $subdomain === "panel" ) {
    $aigap->setCookiePrefix("sdk_");
    $referer = $_SERVER["HTTP_REFERER"];

    if ( !preg_match( "/panel.aigap.com/i", $referer) ) {}
}

$guid = $aigap->GUID() . "-" . $aigap->GUID();

$aigap->setCookie( "collectUrl", $guid, true, 3600);

$homePageURL = $aigap->getCookie( "homePageURL" );

echo "Forward, Please wait!...";
//echo $homePageURL;

header("Location: ".$homePageURL."");

?>