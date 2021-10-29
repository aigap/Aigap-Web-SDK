<?php

session_start();
ob_start();
ob_start("ob_gzhandler");

$cacheEnable = true;
$debug = false;
if ( $debug ) {
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
}

//include("aigap.sdk.php");

header('Content-Type: application/json');

//$aigap = new aigap();

$action = addslashes( $_REQUEST["action"] );

$cookiePrefix = "";

$subdomain__ = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));
if ( $subdomain__ === "panel" ) {
    $cookiePrefix = "sdk_";
}

$responseArray = array();
$responseArray["action"] = $action;
$responseArray["status"] = "0";
$responseArray["message"] = "Done";

$cacheDir = "files/cache/";

if ( $action == "clearCache" ) {
    
    try {
        $cacheFiles = scandir( $cacheDir );
        foreach( $cacheFiles as $cacheFile ) {
            if ( $cacheFile != "." && $cacheFile != ".." ) {
                if ( file_exists( $cacheDir.$cacheFile ) ) {
                    unlink( $cacheDir.$cacheFile );
                }
            }
        }
    } catch (Exception $e) {
        $responseArray["status"] = "9999";
        $responseArray["message"] = $e->getMessage();
    }
    
}
else if ( $action == "clearCachePage" ) {
    
    $pageCode = addslashes( $_REQUEST["pageCode"] );
    $langCode = addslashes( $_REQUEST["langCode"] );
    
    $pageFile = $pageCode.".".$langCode.".html.cache";

    if ( file_exists( $cacheDir.$pageFile ) ) {
        unlink( $cacheDir.$pageFile );
    }
    
}
else if ( $action == "clearCookie" ) {
    
    try {
        
        foreach( $_SESSION as $key => $value ) {
            if ( $key != $cookiePrefix."browserUID" && $key != $cookiePrefix."langCode" ) {
                unset($_SESSION[$key]);
            }
        }

        foreach( $_COOKIE as $key => $value ) {
            if ( $key != $cookiePrefix."browserUID" && $key != $cookiePrefix."langCode" ) {
                unset($_COOKIE[$key]); 
                setcookie( $key, null, -1, '/'); 
            }
        }
        
    } catch (Exception $e) {
        $responseArray["status"] = "9999";
        $responseArray["message"] = $e->getMessage();
    }
    
    
}
else if ( $action == "update" ) {
    
    try {
        
        $versionControlURL = "https://sdk.aigap.com/update/version.json";
        $versionControlJson = json_decode(file_get_contents(  $versionControlURL ) );

        $versionControl_code = $versionControlJson->version->code;
        $versionControl_build = $versionControlJson->version->build;
        $versionControl_required = $versionControlJson->version->required;
        $versionControl_url = $versionControlJson->version->url;
        
        $destinationFile = "download/update.zip";

        $copyFileOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false ) );

        if ( file_exists($destinationFile) ) { unlink($destinationFile); }

        $copyFile = copy( $versionControl_url, $destinationFile, stream_context_create($copyFileOptions) );

        if ( $copyFile ) {
            
                $message = "Kopyalama tamamlandı<br><br>";
            
                $zip = new ZipArchive;
            $res = $zip->open($destinationFile);
            if ($res === TRUE) {
                $zip->extractTo('./');
                $zip->close();
                $message .= "Arşiv açıldı ve yüklendi";
                unlink( $destinationFile );

                $responseArray["message"] = $message;
                
                //echo "<script> setTimeout(function(){ location.href = \"update.last.php\"; }, 1000);</script>";

            } else {
                $responseArray["status"] = "9801";
                $responseArray["message"] = "Arşiv açılamadı";
            }
        }
        else {
            $responseArray["status"] = "9801";
            $responseArray["message"] = "Kopyalama tamamlanamadı";
        }
    } catch (Exception $e) {
        $responseArray["status"] = "9999";
        $responseArray["message"] = $e->getMessage();
    }
}

echo json_encode( $responseArray );

?>
