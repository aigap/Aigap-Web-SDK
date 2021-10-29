<?php

ini_set('date.timezone', 'Europe/Istanbul');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$fileDir = "";///download/";
$filePath = $fileDir."update.check.date";

$dateCheck = "";
if (file_exists( $filePath ) ) {
    $dateCheck = file_get_contents( $filePath );
}

$dateNow = date("YmdHis");
$dateNext = date("YmdHis", strtotime($dateNow." +1 day"));

if( $dateCheck == "" ) {
    $dateCheck = $dateNow;
}

if ( $dateNow >= $dateCheck ) {

    if (file_exists("aigap.class.php") ) { unlink("aigap.class.php"); }
    copy( "../aigap.class.php", "aigap.class.php" );
	
    include("ZipAll.php");
    include("aigap.class.php");
	
	$aigap = new aigap();

	$versionControlURL = "https://sdk.aigap.com/update/version.json";
    $versionControlJson = json_decode(file_get_contents(  $versionControlURL ) );

    $versionControl_code = $versionControlJson->version->code;
    $versionControl_build = $versionControlJson->version->build;
    $versionControl_required = $versionControlJson->version->required;
    $versionControl_url = $versionControlJson->version->url;

    $class_code = $aigap->getVersion()["version"];
    $class_build = $aigap->getVersion()["build"];

    $fileOpen = fopen( $filePath, "w") or die("Unable to open file!");
    fwrite( $fileOpen, $dateNext);
    fclose( $fileOpen );
    
    if ( $versionControl_code > $class_code || ( $versionControl_code == $class_code && $versionControl_build > $class_build ) && $versionControl_required == "1" ) {

        header("Location: update.last.php?do=update");
    }
    else {
        echo "Sdk already updated";
    }
    
    echo $dateNow.">".$dateCheck.">>".$dateNext;

}
else {
    echo "Next check time: ".$dateCheck;
}

?>