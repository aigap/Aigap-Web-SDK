<?php

session_start();
ob_start();
ob_start("ob_gzhandler");

include("aigap.sdk.php");

$aigap = new aigap();

$cacheDir = "files/cache/";

$requestToken = $aigap->g("requestToken");

if ( $requestToken == $config["pageToken"] ) {    
    $cacheFiles = scandir( $cacheDir );
    foreach( $cacheFiles as $cacheFile ) {
        if ( $cacheFile != "." && $cacheFile != ".." ) {
            if ( file_exists( $cacheDir.$cacheFile ) ) {
                unlink( $cacheDir.$cacheFile );
            }
        }
    }
}

$subdomain__ = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));
if ( $subdomain__ === "panel" ) {
    $cookiePrefix__ = "sdk_";
    $aigap->setCookiePrefix($cookiePrefix__);
}

if ( $aigap->getCookie("homePageURL") != "" ) {
    header( "Location: " . $aigap->getCookie("homePageURL") );
}


?>
