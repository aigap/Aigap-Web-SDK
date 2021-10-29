<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

session_start();
ob_start();

include("config.php");
include("aigap.class.php");

//$httpReferer = $_SERVER["HTTP_REFERER"];
//echo $httpReferer;



$aigap = new aigap();
$aigap->loadConfigToClass();


$token = $aigap->g("token");

$aigap->setDeviceTypeID( $config["deviceTypeID"] );
$aigap->setUserTypeID( $config["userTypeID"] );
$aigap->setProjectID( $config["projectID"] );
$aigap->setOProjectID( $config["oProjectID"] );
$aigap->setDeveloperID( $config["developerID"] );
$aigap->setDreamerID( $config["dreamerID"] );
$aigap->setAppID( $config["appID"] );
$aigap->setAigapKey( "0", $config["keys"][0]);
$aigap->setCompanyID( $config["companyID"] );
$aigap->setICompanyID( $config["iCompanyID"] );
$aigap->setFWID( $config["fwID"] );
$aigap->setFWActionTypeID( $config["fwActionTypeID"] );

$dev1 = $aigap->g("dev1");
$dev2 = $aigap->g("dev2");
$dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);

$cookiePrefix = $aigap->g("cookiePrefix");

$expireDate = "";

if ( $dev1_dec != "" ) {
    foreach( $dev1_dec as $key => $value ) {
        //echo $key ." : " . $value;
        //echo "<br>";

        if ( $key == "fwID" ) { $aigap->setFWID( $value ); }
        else if ( $key == "fwActionTypeID" ) { $aigap->setFWActionTypeID( $value ); }
        else if ( $key == "firewallURL" ) { $aigap->setFirewallURL( $value ); }
        else if ( $key == "firewallPublicKey" ) { $aigap->setFirewallPublicKey( $value ); }
        else if ( $key == "encTypeID" ) { $aigap->setEncTypeID( $value ); }
        else if ( $key == "algorithmTypeID" ) { $aigap->setAlgorithmTypeID( $value ); }
        else if ( $key == "dreamerID" ) { $aigap->setDreamerID( $value ); }
        else if ( $key == "developerID" ) { $aigap->setDeveloperID( $value ); }
        else if ( $key == "oProjectID" ) { $aigap->setOProjectID( $value ); }
        else if ( $key == "projectID" ) { $aigap->setProjectID( $value ); }
        else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
        else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
        else if ( $key == "tranID" ) { $tranID = $value; }
    }
}

if ( $token != "" ) {
    //$reCaptchaVerify = $aigap->reCaptchaVerify( $aigap->getRecaptchaKey("secret") , $token);

    $reCaptchaVerify["success"] = false;
    $reCaptchaVerify["score"] = 0.2;

    if ( $token == $_SESSION["token"] ) {
        $reCaptchaVerify["success"] = true;
        $reCaptchaVerify["score"] = 1.0;
        $_SESSION["token"] = "";
        session_unset("token");
    }
    
    if ( $reCaptchaVerify["success"] == true && $reCaptchaVerify["score"] >= 0.5 ) {


    } 
    else {
        echo json_encode( array("returnCode" => array( "messageID" => "-99999", "message" => json_encode( $reCaptchaVerify ) ) ) );
        exit;
    }
    
}

$uTabID = $aigap->g("uTabID");
$uTabIDParent = $aigap->g("uTabIDParent");

$referFwID = $aigap->g("referFwID")==""?"0":$aigap->g("referFwID");
$referTranID = $aigap->g("referTranID")==""?"0":$aigap->g("referTranID");
$referTabID = $aigap->g("referTabID")==""?"0":$aigap->g("referTabID");

$referData = array();
$referDataEnc = $aigap->g("referData");
if ( $referDataEnc != "" ) {
    $referData = json_decode( $aigap->AES256_decrypt( urldecode( $referDataEnc ) ), true );
    if ( !empty($referData["referTranID"]) && $referData["referTranID"] != "" ) {
        $referTranID = $referData["referTranID"];
    }
    if ( !empty($referData["referTabID"]) && $referData["referTabID"] != "" ) {
        $referTabID = $referData["referTabID"];
    }
    if ( !empty($referData["referFwID"]) && $referData["referFwID"] != "" ) {
        $referFwID = $referData["referFwID"];
    }
}

$tranFieldsUpdate = $aigap->g("tranFieldsUpdate");
if ( $tranFieldsUpdate != "" ) {

    
    $tranFieldsUpdateJson = json_decode( rawurldecode($tranFieldsUpdate), true );
    $_fieldName = $tranFieldsUpdateJson["fieldName"];
    $_tableID = $tranFieldsUpdateJson["tableID"];
    $_ID = $tranFieldsUpdateJson["ID"];
    //$_tranID = $tranFieldsUpdateJson["tranID"];

    if ( $_fieldName != "" && $_tableID != "" && $_ID != "" ) {

            $aigap->tranFields_add( $_fieldName, $_ID, $_tableID, $uTabID );
    }	
}

$actionTiID = $aigap->g("actionTiID")==""?0:$aigap->g("actionTiID");
$activeTabID = $aigap->g("activeTabID")==""?0:$aigap->g("activeTabID");
$editID = $aigap->g("editID");
$tranID = $aigap->g("tranID");
$stateID = $aigap->g("stateID");
$tranIDForce = $aigap->g("tranIDForce");
$returnJson = $aigap->g("returnJson");
$deleteParameters = $aigap->g("deleteParameters");
if ( $deleteParameters != "" )
{
	$stateID = 3;
}
$designPropertyTypeID = $aigap->g("designPropertyTypeID");
$designPropertyID = $aigap->g("designPropertyID");

$devRerouteServerApi = urldecode( $aigap->g("devRerouteServerApi") );
$devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( $devRerouteServerApi ), true );

if ( $devRerouteServerApiDec != "" ) {
    foreach( $devRerouteServerApiDec as $key => $value ) {
        //echo $key ." : " . $value;
        //echo "<br>";

        if ( $key == "fwID" ) { $aigap->setFWID( $value ); }
        else if ( $key == "fwActionTypeID" ) { $aigap->setFWActionTypeID( $value ); }
        else if ( $key == "firewallURL" ) { $aigap->setFirewallURL( $value ); }
        else if ( $key == "firewallPublicKey" ) { $aigap->setFirewallPublicKey( $value ); }
        else if ( $key == "encTypeID" ) { $aigap->setEncTypeID( $value ); }
        else if ( $key == "algorithmTypeID" ) { $aigap->setAlgorithmTypeID( $value ); }
        else if ( $key == "dreamerID" ) { $aigap->setDreamerID( $value ); }
        else if ( $key == "developerID" ) { $aigap->setDeveloperID( $value ); }
        else if ( $key == "oProjectID" ) { $aigap->setOProjectID( $value ); }
        else if ( $key == "projectID" ) { $aigap->setProjectID( $value ); }
        else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
        else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
        else if ( $key == "tranID" ) { $tranID = $value; }
    }
}

$devRerouteServerApi_change = $aigap->g("devRerouteServerApi_change");

if ( $devRerouteServerApi_change != "" ) {
    $devRerouteServerApi_change_Dec = json_decode( $aigap->AES256_decrypt( $devRerouteServerApi_change ), true);
    
    foreach( $devRerouteServerApi_change_Dec as $key_ => $value_ ) {
        if ( !empty($devRerouteServerApiDec[$key_]) ) {
            $devRerouteServerApiDec[$key_] = $value_;
        }
    }
    
    $devRerouteServerApiDec["extra"]["dreamerID"] = $devRerouteServerApi_change_Dec["dreamerID"];
    $devRerouteServerApiDec["extra"]["developerID"] = $devRerouteServerApi_change_Dec["developerID"];
    $devRerouteServerApiDec["extra"]["projectID"] = $devRerouteServerApi_change_Dec["projectID"];
    $devRerouteServerApiDec["extra"]["oProjectID"] = $devRerouteServerApi_change_Dec["oProjectID"];

    
}

if ( $designPropertyTypeID == "" ) { $designPropertyTypeID = 0; }
if ( $designPropertyID == "" ) { $designPropertyID = 0; }

$tabInputs = array();
$tabInputsNew = array();



if ( isset($_REQUEST["tabs"]) )
{
    if ( !empty($_REQUEST["tabs"]) )
    {
        foreach( $_REQUEST["tabs"] as $tKey => $tValue )
        {

            $tabX = array();
            $tabX["tabID"] = $tValue;

            if( isset($_REQUEST["tabOutputs"]) && isset($_REQUEST["tabOutputs"][$tValue]) )
            {
                if ( !empty($_REQUEST["tabOutputs"]) && !empty($_REQUEST["tabOutputs"][$tValue]) )
                {
                    foreach( $_REQUEST["tabOutputs"][$tValue] as $tabOutputs_ )
                    {
                        $tabOutputs = json_decode(base64_decode($tabOutputs_));
                                                
                        $__encryptTypeID = $tabOutputs->encryptTypeID;
                        $__encryptKey = $tabOutputs->encryptKey;
                        
                        if ( isset($_REQUEST["sw_"]) )
                        {
                            if ( isset($_REQUEST["sw_"][$tValue] ) )
                            {
                                if ( isset($_REQUEST["sw_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID] ) )
                                {
                                    if ( is_array($_REQUEST["sw_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID]) )
                                    {

                                        $i = -1;

                                        foreach( $_REQUEST["sw_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID] as $toKey => $toValue )
                                        {

                                            $i++;

                                            if ( is_array($toValue) )
                                            {						

                                                $tabInputMultiples = array();

                                                
                                                foreach( $_REQUEST["swo_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID][$toKey] as $tooKey => $tooValue )
                                                {

                                                    $tooValue_check = "0";
                                                    if ( !empty($_REQUEST["sw_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID][$toKey][$tooKey]) ) {
                                                        $tooValue_check = "1";
                                                    }
                                                    
                                                    $tooValue_new = "0";
                                                    if ( $tooValue_check != $tooValue ) {
                                                        if ( $tooValue == "1" && $tooValue_check == "0" ) {
                                                            $tooValue_new = "3";
                                                        }
                                                        else if ( $tooValue == "0" && $tooValue_check == "1" ) {
                                                            $tooValue_new = "1";
                                                        }
                                                    }

                                                    if ( $tooValue_check != $tooValue ) {

                                                        $tabInputMultiples[] = array(
                                                                                    "tiID" => $tabOutputs->tiID,
                                                                                    "tableID" => $tabOutputs->tableID,
                                                                                    "value" => rawurldecode($tooValue_new),
                                                                                    "ID" => $tooKey
                                                                                    );
                                                    }
                                                }

                                                $tabInputMultiples_ = array();
                                                $tabInputMultiples_["tableID"] = $tabOutputs->tableID;
                                                $tabInputMultiples_["ID"] = "0";
                                                $tabInputMultiples_["tabInputValues"] = $tabInputMultiples;

                                                $tabX["tabInputValues"] = array();
                                                $tabX["tabInputMultipleValues"][] = $tabInputMultiples_;

                                            }
                                            else
                                            {

                                                
                                                $ID_ = "0";
                                                if ( !empty($tabOutputs->multipleValues[$i]) )
                                                {
                                                        $ID_ = $tabOutputs->multipleValues[$i]->ID;
                                                }

                                                if ( empty($toValue) || $toValue == null ) { $toValue = ""; }
                                                
                                                // ---- Encryption ----
                                        
                                                if ( $__encryptTypeID == 1 ) {

                                                }
                                                else if ( $__encryptTypeID == 2 ) { // md5 2X
                                                    $toValue = md5( md5( $toValue ) );
                                                }
                                                else if ( $__encryptTypeID == 3 ) { // RSA

                                                }
                                                else if ( $__encryptTypeID == 5 ) { // md5 4X
                                                    $toValue = md5( md5( md5( md5( $toValue ) ) ) );
                                                }

                                                // ---- Encryption ----
                                                
                                                $singleRow = array(
                                                                    "tiID" => $tabOutputs->tiID,
                                                                    "tableID" => $tabOutputs->tableID,
                                                                    "value" => rawurldecode($toValue),
                                                                    "ID" => $ID_
                                                                    );

                                                $tabX["tabInputValues"][] = $singleRow;
                                                $tabX["tabInputMultipleValues"] = array();
                                            }

                                        }

                                    }
                                    else
                                    {
                                        $sValue = addslashes($_REQUEST["sw_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID]);
                                        $sValueText = "";
                                        if ( isset( $_REQUEST["sw_text_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID] ) )
                                        {
                                                $sValueText = $_REQUEST["sw_text_"][$tValue][$tabOutputs->tiID."-".$tabOutputs->referFwID];
                                        }
                                        
                                        // ---- Encryption ----
                                        
                                        if ( $__encryptTypeID == 1 ) {
                                            
                                        }
                                        else if ( $__encryptTypeID == 2 ) { // md5 2X
                                            $sValue = md5( md5( $sValue ) );
                                        }
                                        else if ( $__encryptTypeID == 3 ) { // RSA
                                            
                                        }
                                        else if ( $__encryptTypeID == 5 ) { // md5 4X
                                            $sValue = md5( md5( md5( md5( $sValue ) ) ) );
                                        }
                                        
                                        // ---- Encryption ----

                                        $rowArray = array();
                                        $rowArray["tiID"] = $tabOutputs->tiID;
                                        $rowArray["referFwID"] = $tabOutputs->referFwID;
                                        $rowArray["tableID"] = $tabOutputs->tableID;
                                        $rowArray["value"] = rawurldecode($sValue);
                                        $rowArray["valueText"] = rawurldecode($sValueText);

                                        $tabX["tabInputValues"][] = $rowArray;
                                        $tabX["tabInputMultipleValues"] = array();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $tabInputsNew[] = $tabX;
        }
    }
}


$filesFormatted_ = array();
$filesID = -1;

$filesFormatted = array();

if ( isset($_FILES["images"]) )
{
    foreach( $_FILES["images"] as $key_0 => $value_0 )
    {
        foreach( $value_0 as $key_1 => $value_1 )
        {
            foreach( $value_1 as $key_2 => $value_2 )
            {
                foreach( $value_2 as $key_3 => $value_3 )
                {
                        $filesFormatted[$key_2][$key_3][$key_0] = $value_3;
                }
            }
        }
    }

    //$filesFormatted_ = array();
    foreach( $filesFormatted as $a => $b )
    {
        $filesID = -1;
        foreach( $b as $aa => $ab )
        {
            if ( $ab["name"] != NULL && $ab["tmp_name"] != NULL )
            {
                $filesID++;
                $filesFormatted_[$a][$filesID] = $ab;
                $filesFormatted_[$a][$filesID]["fileType"] = "IMAGE";
                $filesFormatted_[$a][$filesID]["generateThumbnail"] = "0";
                $filesFormatted_[$a][$filesID]["tiID"] = $a; 
                $filesFormatted_[$a][$filesID]["filesID"] = $filesID; 
            }
        }
    }
}

$filesFormatted = array();

if ( isset($_FILES["videos"]) )
{
    foreach( $_FILES["videos"] as $key_0 => $value_0 )
    {
        foreach( $value_0 as $key_1 => $value_1 )
        {
            foreach( $value_1 as $key_2 => $value_2 )
            {
                foreach( $value_2 as $key_3 => $value_3 )
                {
                        $filesFormatted[$key_2][$key_3][$key_0] = $value_3;
                }
            }
        }
    }

    foreach( $filesFormatted as $a => $b )
    {
        $filesID = -1;
        foreach( $b as $aa => $ab )
        {
            if ( $ab["name"] != NULL && $ab["tmp_name"] != NULL )
            {
                $filesID++;
                $filesFormatted_[$a][$filesID] = $ab;
                $filesFormatted_[$a][$filesID]["fileType"] = "VIDEO";
                $filesFormatted_[$a][$filesID]["generateThumbnail"] = "0";
                $filesFormatted_[$a][$filesID]["tiID"] = $a; 

                $filesID++;
                $filesFormatted_[$a][$filesID] = $ab;
                $filesFormatted_[$a][$filesID]["fileType"] = "IMAGE";
                $filesFormatted_[$a][$filesID]["generateThumbnail"] = "1";
                $filesFormatted_[$a][$filesID]["tiID"] = $a; 
            }
        }
    }
}

$filesFormatted = array();

if ( isset($_FILES["pdf"]) )
{
    foreach( $_FILES["pdf"] as $key_0 => $value_0 )
    {
        foreach( $value_0 as $key_1 => $value_1 )
        {
            foreach( $value_1 as $key_2 => $value_2 )
            {
                foreach( $value_2 as $key_3 => $value_3 )
                {
                        $filesFormatted[$key_2][$key_3][$key_0] = $value_3;
                }
            }
        }
    }

    foreach( $filesFormatted as $a => $b )
    {
        $filesID = -1;
        foreach( $b as $aa => $ab )
        {
            if ( $ab["name"] != NULL && $ab["tmp_name"] != NULL )
            {
                $filesID++;
                $filesFormatted_[$a][$filesID] = $ab;
                $filesFormatted_[$a][$filesID]["fileType"] = "PDF";
                $filesFormatted_[$a][$filesID]["generateThumbnail"] = "0";
                $filesFormatted_[$a][$filesID]["tiID"] = $a; 
            }
        }
    }
}

$deleteParameters = $aigap->g("deleteParameters");
if ( $deleteParameters != "" )
{
	$stateID = 3;
        
        	$deleteParametersJson = json_decode( base64_decode( $deleteParameters ), true);
                
                //print_r( $deleteParametersJson );
				
	$aigap->tranFields_add( $deleteParametersJson["tran"]["prmInput"], $deleteParametersJson["tran"]["ID"], $deleteParametersJson["tran"]["tableID"], $deleteParametersJson["tran"]["tranID"] );
	
        $deleteValueArray = array( "tabID" => $deleteParametersJson["input"]["tabID"], "tabInputValues" => array(), "tabInputMultipleValues" => array() );
        
        $tabInputsNew[] = $deleteValueArray;
        
	$editID = $deleteParametersJson["tran"]["ID"];
        $actionTiID = $deleteParametersJson["actionTiID"];
        $designPropertyTypeID = $deleteParametersJson["designPropertyTypeID"];
        $designPropertyID = $deleteParametersJson["designPropertyID"];
        $devRerouteServerApi = $deleteParametersJson["devRerouteServerApi"];
        $devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( $devRerouteServerApi ), true );
        
        $devRerouteServerApi_change = $deleteParametersJson["devRerouteServerApi_change"];

        if ( $devRerouteServerApi_change != "" ) {
            $devRerouteServerApi_change_Dec = json_decode( $aigap->AES256_decrypt( $devRerouteServerApi_change ), true);

            foreach( $devRerouteServerApi_change_Dec as $key_ => $value_ ) {
                if ( !empty($devRerouteServerApiDec[$key_]) ) {
                    $devRerouteServerApiDec[$key_] = $value_;
                }
            }

            $devRerouteServerApiDec["extra"]["dreamerID"] = $devRerouteServerApi_change_Dec["dreamerID"];
            $devRerouteServerApiDec["extra"]["developerID"] = $devRerouteServerApi_change_Dec["developerID"];
            $devRerouteServerApiDec["extra"]["projectID"] = $devRerouteServerApi_change_Dec["projectID"];
            $devRerouteServerApiDec["extra"]["oProjectID"] = $devRerouteServerApi_change_Dec["oProjectID"];


        }
        
        //echo $devRerouteServerApi;
        //print_r( $devRerouteServerApiDec );
        
        $referParam = json_decode( rawurldecode( $deleteParametersJson["referParam"] ), true );
        
        $referFwID = $referParam["referFwID"];
        $referTranID = $referParam["referTranID"];
        $referTabID = $referParam["referTabID"];
        
}

$activeTranID = 0;
$activeTabID = 0;
$activeFwID = 0;
if ( $aigap->g("activeData") != "" ) {
    $activeDataArray = json_decode( urldecode( $aigap->g("activeData") ), true );
    if ( !empty($activeDataArray["activeTranID"]) ) {
        $activeTranID = $activeDataArray["activeTranID"];
    }
    if ( !empty($activeDataArray["activeTabID"]) ) {
        $activeTabID = $activeDataArray["activeTabID"];
    }
    if ( !empty($activeDataArray["activeFwID"]) ) {
        $activeFwID = $activeDataArray["activeFwID"];
    }
}

//echo json_encode( $tabInputsNew )."\n\n";

$response = $aigap->services_AigapExecuteTranTabInputs( $tranID, 0, $stateID, $editID, $actionTiID, $tabInputsNew, $designPropertyTypeID, $designPropertyID, $tranIDForce, $devRerouteServerApiDec, $uTabID, $uTabIDParent, $activeTabID, $referFwID, $referTranID, $referTabID, $activeDataArray );

$response_jsonData_array = json_decode( $response["jsonDataDecrypted"], true );
//$response_jsonData_array["keyChain"] = array();

header('Content-Type: application/json');

//print_r( $response_jsonData_array );

if ( !empty($response_jsonData_array["images"]) ) {
    $i = -1;
    $images_array = $response_jsonData_array["images"];

    foreach( $images_array as $rowIndex => $image ) {
        $i++;
        
        $imageValue = $image;
        $tiID = $imageValue["tiID"];
        $imageURL = $imageValue["imageURL"];
        $imageURL_path = parse_url( $imageURL, PHP_URL_PATH);
        $imageURL_ext = pathinfo($imageURL_path, PATHINFO_EXTENSION);
        $imageValue["fileType"] = $aigap->extToFileType( $imageURL_ext );
        $fileType = $imageValue["fileType"];


        foreach ( $filesFormatted_ as $file_tiID => $file_value ) {

            if ( $file_tiID == $tiID ) {
                                
                foreach( $file_value as $file_value_ID => $file_value_value ) {
                                        
                    $file_value_fileType = $file_value_value["fileType"];
                    $file_value_filesID = $file_value_value["filesID"];

                    if ( $fileType == $file_value_fileType && $i == $file_value_filesID ) {

                        $generateThumbnail = $file_value_value["generateThumbnail"];
                        if ( $generateThumbnail == "1" ) { $fileType = "VIDEO_IMAGE"; }

                        if ( $fileType == "PDF" )
                        {

                            $fileTempLocation = $file_value_value["tmp_name"];
                            $fileTempNewLocation = str_replace( array(" ","-","(",")"), array("_","_","_","_"), $file_value_value["name"]);

                            $fileNewTmpFolder = "./PDF_TMP_122343554/";

                            move_uploaded_file( $fileTempLocation, $fileNewTmpFolder.$fileTempNewLocation );

                            $fileTempLocationCrypted = str_replace( ".pdf", "_crypt.pdf", $fileTempNewLocation );

                            pdfEncrypt( $fileNewTmpFolder.$fileTempNewLocation, "ASdf1234!Aa$455", $fileNewTmpFolder.$fileTempLocationCrypted );

                            $pdfOriginal = file_get_contents( $fileNewTmpFolder.$fileTempLocationCrypted );
                            //$pdfOriginal = file_get_contents( $fileNewTmpFolder.$fileTempNewLocation );

                            $pdfBinary = base64_encode( $pdfOriginal );

                            $imageValue["imageBinary"] = $pdfBinary;

                            unlink( $fileNewTmpFolder.$fileTempNewLocation );
                            unlink( $fileNewTmpFolder.$fileTempLocationCrypted );
                    }
                    else if ( $fileType == "VIDEO" || $fileType == "VIDEO_IMAGE" )
                    {

                            $fileTempLocation = $file_value_value["tmp_name"];
                            $fileTempNewLocation = str_replace( array(" ","-","(",")"), array("_","_","_","_"), $file_value_value["name"]);
                            $fileNewTmpFolder = "./VIDEO_TMP_122343559/";

                            $imageURL = $imageValue["imageURL"];
                            $imageURLPathInfo = pathinfo( $imageURL );
                            $imageURLExt = $imageURLPathInfo["extension"];
                            $imageURLType = "";


                            if ( $fileType == "VIDEO" )
                            {
                                    if ( !file_exists($fileNewTmpFolder.$fileTempNewLocation) )
                                    {
                                            move_uploaded_file( $fileTempLocation, $fileNewTmpFolder.$fileTempNewLocation );
                                    }

                                    $lastVideoExt = $imageURLExt;

                                    $videoFileIn = $fileNewTmpFolder.$fileTempNewLocation;
                                    $videoFileOut = str_replace( 
                                            array($imageURLExt,strtoupper($imageURLExt)), 
                                            array("res.".$imageURLExt,"res.".$imageURLExt), 
                                            $videoFileIn
                                    );
                                    $videoFileOutPNG = $videoFileIn.".png";

                                    $execResponse_1 = "";
                                    $execResponse_2 = "";

                                    if ( !file_exists($videoFileOut) )
                                    {
                                            exec("ffmpeg -y -i $videoFileIn -strict experimental -preset ultrafast -s 640x480 -vcodec h264 -acodec aac $videoFileOut", $execRequest_1, $execResponse_1 );
                                            exec("ffmpeg -i $videoFileOut -ss 00:00:2.0 -vframes 1 $videoFileOutPNG", $execRequest_2, $execResponse_2 );					
                                    }

                                    $videoBinary = base64_encode(file_get_contents( $videoFileOut ));

                                    $imageValue["imageBinary"] = $videoBinary;


                            }
                            else if ( $fileType == "VIDEO_IMAGE" )
                            {
                                    if ( !file_exists($fileNewTmpFolder.$fileTempNewLocation) )
                                    {
                                            move_uploaded_file( $fileTempLocation, $fileNewTmpFolder.$fileTempNewLocation );
                                    }

                                    $videoFileIn = $fileNewTmpFolder.$fileTempNewLocation;
                                    $videoFileOut = str_replace( 
                                            array($imageURLExt,strtoupper($imageURLExt)), 
                                            array("res.".$imageURLExt,"res.".$imageURLExt), 
                                            $videoFileIn
                                    );
                                    $videoFileOutPNG = $videoFileIn.".png";

                                    $execResponse_1 = "";
                                    $execResponse_2 = "";

                                    if ( !file_exists($videoFileOut) )
                                    {
                                            exec("ffmpeg -y -i $videoFileIn -strict experimental -preset ultrafast -s 640x480 -vcodec h264 -acodec aac $videoFileOut", $execRequest_1, $execResponse_1 );
                                            exec("ffmpeg -i $videoFileOut -ss 00:00:2.0 -vframes 1 $videoFileOutPNG", $execRequest_2, $execResponse_2 );					
                                    }

                                    $videoImageBinary = base64_encode(file_get_contents( $videoFileOutPNG ));

                                    //echo $videoFileIn . " > " . $videoFileOut . " >> " . $videoFileOutPNG;
                                    //echo $videoImageBinary;

                                    $imageValue["imageBinary"] = $videoImageBinary;

                            }

                            //unlink()
                            if ( $debugMode )
                            {
                                    echo "<div style=\"font-size:40px;\">Temp : ".$fileTempLocation." : ".$fileTempNewLocation. " : " . $videoFileOutPNG . " [".$i."]</div>";
                            }

                        }
                        else if ( $fileType == "IMAGE" )
                        {
                                $imageBinary = base64_encode(file_get_contents( $file_value_value["tmp_name"] ));
                                $imageValue["imageBinary"] = $imageBinary;
                        }
                        else
                        {
                                //echo "<div style=\"font-size:40px;\">UNKNOWN :<br>".print_r($imageValue)."</div>";
                        }

                        //echo "---- File ----";
                        //print_r( $file_value_value );
                        //echo "---- Remote ----";
                        //print_r( $imageValue );
                        
                        $imageServerURL = $imageValue["imageServerURL"];
                        $UploadImage = $aigap->UploadImage( $imageServerURL, $imageValue );
                        //print_r( $UploadImage );

                    }
                }
            }
        }

    }
}

$goHomePage = false;
$tranTabResponse = "";


if ( !empty($response_jsonData_array["loginResp"]) ) {
    
    //echo json_encode( $response_jsonData_array["loginResp"] )."\n\n";
    
    $goHomePage = true;
    
    $loginResp__ = $response_jsonData_array["loginResp"];
    $tranTabResponse__ = $loginResp__["tranTabResponse"];
        
    $user__ = $loginResp__["user"];
    if ( empty($tranTabResponse__["activeICompanyID"]) ) {
        $tranTabResponse__["activeICompanyID"] = "0";
    }
    $userToken__ = $loginResp__["userToken"];
    
    $userTypeID__ = $user__["userTypeID"];
    
    $userData_1 = array();
    $userData_1["activeTranID"] = $tranTabResponse__["activeTranID"];
    $userData_1["activeTabID"] = $tranTabResponse__["activeTabID"];
    $userData_1["activeICompanyID"] = $tranTabResponse__["activeICompanyID"];
    $userData_1["activeFwID"] = $tranTabResponse__["activeFwID"];
    $userData_1["user"] = $user__;
    $userData_1["userToken"] = $userToken__;
    $userData_1["claimCategories"] = array();
    $userData_1_Json = json_encode( $userData_1 );
    $userData_1_JsonEncrypted = $aigap->AES256_encrypt( $userData_1_Json );
    $aigap->setCookieSession( "userData_1", $userData_1_JsonEncrypted );
    
    $aigap->setCookieSession("userTypeID", $userTypeID__);
    
    if ( !empty($tranTabResponse__["tabs"]) ) {
        $tabs__ = $tranTabResponse__["tabs"];
        foreach( $tabs__ as $tab__ ) {
            $tranFields__2 = $tab__["tranFields"];
            foreach ( $tranFields__2 as $tranField__2 ) {
                $tranField__2_ID = $tranField__2["ID"];
                $tranField__2_fieldName = $tranField__2["fieldName"];
                $tranField__2_tableID = $tranField__2["tableID"];
                $aigap->tranFields_add( $tranField__2_fieldName, $tranField__2_ID, $tranField__2_tableID );     
            }
        }
    }
    
    if ( !empty($tranTabResponse__["tranFields"]) ) {
        $tranFields__1 = $tranTabResponse__["tranFields"];
        foreach ( $tranFields__1 as $tranField__1 ) {
            $tranField__1_ID = $tranField__1["ID"];
            $tranField__1_fieldName = $tranField__1["fieldName"];
            $tranField__1_tableID = $tranField__1["tableID"];
            $aigap->tranFields_add( $tranField__1_fieldName, $tranField__1_ID, $tranField__1_tableID );     
        }
    }
    
    if ( $tranTabResponse__ != "" ) {
        $aigap->setSession( "tranTabResponse", json_encode( $tranTabResponse__ ));
    }
    
    $userID_ = "";
    $password_ = "";
    $encryptTypeID_ = "";
    $encryptKey_ = "";
    $rememberMe_ = false;
    
    
    $loginUserData = $aigap->getLoginUserData();
    
    foreach( $loginUserData as $tiID__ => $data__ ) {
        $prmInput__ = $data__["prmInput"];
        $encryptTypeID__ = $data__["encryptTypeID"];
        $encryptKey__ = $data__["encryptKey"];
        foreach( $tabInputsNew as $tabInput__ ) {
            $tabInputValues__ = $tabInput__["tabInputValues"];
            foreach( $tabInputValues__ as $tabInputValuesRow__ ) {
                $tiID___ = $tabInputValuesRow__["tiID"];
                $value___ = $tabInputValuesRow__["value"];
                if ( $tiID__ == $tiID___ ) {
                    switch ( $prmInput__ ) {
                        case "userID" : $userID_ = $value___; break;
                        case "password" : $password_ = $value___; $encryptTypeID_ = $encryptTypeID__; $encryptKey_ = $encryptKey__; break;
                        case "rememberMe" : $rememberMe_ = intval($value___)>=1?true:false; break;
                    }
                }
            }
        }
    }
    
    if ( $rememberMe_ ) {
        
        $rememberUserData = array();
        $rememberUserData["userID"] = $userID_;
        $rememberUserData["password"] = $password_;
        $rememberUserData["encryptTypeID"] = $encryptTypeID_;
        $rememberUserData["encryptKey"] = $encryptKey_;
        $rememberUserData["userTypeID"] = $userTypeID__;
        $rememberUserDataJson = json_encode( $rememberUserData );
        $rememberUserDataEnc = $aigap->AES256_encrypt( urlencode($rememberUserDataJson) );
        
        $aigap->setCookie( $cookiePrefix."rememberUserData", $rememberUserDataEnc);
        
    }
    

        
}

if ( !empty($response_jsonData_array["tranFields"]) ) {
    $__tranFields = $response_jsonData_array["tranFields"];
    
    foreach( $__tranFields as $__tranFields_row ) {
        $__ID = $__tranFields_row["ID"];
        $__fieldName = $__tranFields_row["fieldName"];
        $__tableID = $__tranFields_row["tableID"];
        $aigap->tranFields_add(  $__fieldName, $__ID, $__tableID);
    }
    //echo json_encode( $__tranFields );
}

if ( !empty($response_jsonData_array["keyChain"]) ) {
    $keyChain__ = $response_jsonData_array["keyChain"];
    
    $aigapKeysArray = array();
    $aigapKeysArray["Key_0"] = $aigap->getAigapKey("0");
    $aigapKeysArray["Key_1"] = $keyChain__;
    $aigapKeysArray["Key_1"]["publicKey"] = $aigapKeysArray["Key_0"]["publicKey"];
    $keyChainJsonEncrypted = $aigap->AES256_encrypt( json_encode( $aigapKeysArray ) );
    $aigap->setCookieSession( "userData_0", $keyChainJsonEncrypted );
    
    //$response_jsonData_array_new["keyChain_new"] = $aigapKeysArray;
}

//echo json_encode( $response_jsonData_array )."\n\n";

$devRerouteServerApi_response_json = json_encode( $response_jsonData_array["devRerouteServerApi"] );
$devRerouteServerApi_response_json_enc = urlencode( $aigap->AES256_encrypt( $devRerouteServerApi_response_json ) );
        
$response_jsonData_array_new["returnCode"] = $response_jsonData_array["returnCode"];
$response_jsonData_array_new["autoRunTranID"] = $response_jsonData_array["autoRunTranID"];
$response_jsonData_array_new["autoRunStateID"] = $response_jsonData_array["autoRunStateID"];
$response_jsonData_array_new["devRerouteServerApi"] = $devRerouteServerApi_response_json_enc;
$response_jsonData_array_new["goHomePage"] = $goHomePage;
$response_jsonData_array_new["tranTabResponse"] = $tranTabResponse;
        
$referParam = array( "referFwID" => $referFwID, "referTabID" => $referTabID, "referTranID" => $referTranID );
$referParamJson = rawurlencode( json_encode($referParam) );

$response_jsonData_array_new["referParam"] = $referParamJson;

if ( $tranFieldsUpdate != "" ) {
    $tranFielsResponse = json_decode( rawurldecode($tranFieldsUpdate), true );
    $response_jsonData_array_new["tranFields"][] = $tranFielsResponse;
}

echo json_encode( $response_jsonData_array_new );

//echo "\n>> Files >>\n";
//print_r( $_FILES );
//echo ">> Request >>\n";
//print_r( $_REQUEST );
//echo ">> tabInputs >>\n";
//print_r( $tabInputs );
//echo ">> tabInputs >>\n";
//print_r( $tabInputsNew );


?>