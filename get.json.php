<?php

session_start();
ob_start();

date_default_timezone_set('Europe/Istanbul');

$debug = false;
if ( $debug ) {
error_reporting(E_ALL);
ini_set('display_errors', 1);
}

include("config.php");
include("aigap.class.php");

$subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));

$aigap = new aigap();
$aigap->loadConfigToClass();

if ( $subdomain === "panel" ) {
    $aigap->setCookiePrefix("sdk_");
    $referer = $_SERVER["HTTP_REFERER"];

    if ( !preg_match( "/panel.aigap.com/i", $referer) ) {
        //    echo "REF".$referer."FER";
        //echo "<div>Direct request not support</div>";
        //exit();
    }
    
}


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

if ( $aigap->getCookieSession("browserUID") == "" ) {
    $gen_browserUID = uniqid(mt_rand(), false);
    $aigap->setCookieSession( "browserUID", $gen_browserUID);
}

if ( $aigap->getCookie("langCode") != "" ) {
    $aigap->setLangCode( $aigap->getCookie("langCode") );
}


if ( $aigap->getCookie("userTypeID") != "" ) {
    $aigap->setUserTypeID( $aigap->getCookie("userTypeID") );
}

header('Content-Type: application/json');

$get = $aigap->g("get");

if ( $get == "tranTabInputs_toa" ) {
    
    //services_AigapGetTranTabs( $tranID = 0, $stateID = 1, $ID = 0, $actionTiID = 0, $designPropertyTypeID = 0, $designPropertyID = 0, $tranIDForce = 0, $devRerouteServerApi = array(), $tranCallerTypeID = 0, $uTabID = ""  )

    $dev1 = $aigap->g("dev1");
    $dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);
    
    if ( $dev1_dec != "" ) {
        foreach( $dev1_dec as $key => $value ) {
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
            else if ( $key == "tranID" ) { $tranID = $value; }
            else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
            else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
            else if ( $key == "expireDate" ) { $expireDate = $value; }
        }
    }
    
    //echo json_encode( $dev1_dec );
    
    $tranID = $aigap->g("tranID");
    $ID = $aigap->g("ID");
    $tabID = $aigap->g("tabID");
    $referTranID = $aigap->g("referTranID");
    $referTabID = $aigap->g("referTabID");
    $referFwID = $aigap->g("referFwID");
    $devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( urldecode($aigap->g("devRerouteServerApi")) ), true );
    $activeDataArray = json_decode( urldecode( $aigap->g("activeDataJson") ), true );

    $inputTypeID = $aigap->g("inputTypeID");
    $tiID = $aigap->g("tiID");
    $actionTiID = $aigap->g("actionTiID");
    
    $tranFields__ = json_decode( urldecode( $aigap->g("tranFields") ), true );
    $fieldName__ = $tranFields__["fieldName"];
    $fieldValue__ = $tranFields__["fieldValue"];
    $tableID__ = $tranFields__["tableID"];
    
    $aigap->tranFields_add( $fieldName__, $fieldValue__, $tableID__ );
    
    $tabOutputActions = json_decode( urldecode( $aigap->g("tabOutputActions") ), true );

    $eventActionTypeID = $tabOutputActions["eventActionTypeID"];
    $formActionTypeID = $tabOutputActions["formActionTypeID"];
	
    $forceFwID = "0";
    
    $getUserData = $aigap->getUserData();
    if ( !empty($getUserData["activeFwID"]) && intval($getUserData["activeFwID"]) > 0 ) {
       // $forceFwID = $getUserData["activeFwID"];
    }
    
    //echo json_encode( $activeDataArray );

    $responseJson = $aigap->services_AigapGetTranTabInputs( $tranID, $tabID, 0, $ID, $actionTiID, 0, 0, 0, $devRerouteServerApiDec, 0, "", $forceFwID, $eventActionTypeID, $referTranID, $referTabID, $referFwID, $activeDataArray, $formActionTypeID, $tiID );
    
	//services_AigapGetTranTabInputs( $tranID = 0, $tabID = 0, $stateID = 1, $ID = "0", $actionTiID = 0, $designPropertyTypeID = 0, $designPropertyID = 0, $tranIDForce = 0, $devRerouteServerApi = array(), $tranCallerTypeID = 0, $uTabID = "", $forceFwID = "0", $eventActionTypeID = 0, $referFwID = "0", $activeData = array() )
		
	//echo json_encode( $responseJson )."\n\n";
	
    $returnCode = $responseJson["returnCode"];
    $messageID = $returnCode["messageID"];
    $message = $returnCode["message"];

    if ( $messageID == 0 )
    {
        $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

        $returnCode_1 = $jsonData["returnCode"];
        $messageID_1 = $returnCode_1["messageID"];
        $message_1 = $returnCode_1["message"];

        //echo json_encode(  $jsonData );
        
        if ( $messageID_1 == 0 )
        {

            $responseData = array();
            $tabOutputsClean = array();
            $tabOutputs = $jsonData["tabOutputs"];
            
            $tabOutputAction = json_decode( urldecode( $aigap->g("tabOutputActions") ), true);
            
            $actionTiID_array = array();
            $referFwID_array = array();
            $actionTiIDs = $tabOutputAction["actionTiIDs"];
            foreach( $actionTiIDs as $actionTiID ) {
                $actionTiID_array[] = $actionTiID["actionTiID"];
                $referFwID_array[] = $actionTiID["referFwID"];
                $responseData[ $actionTiID["actionTiID"] ] = array( "actionTiID" => $actionTiID["actionTiID"], "referFwID" => $actionTiID["referFwID"], "html" => "<div style=\"padding:10px;\">".$aigap->getLanguageValue("m.NoData")."</div>" );
            }
            
            $directoryPath = "";
            
            $tabOutputsNew = array();
            foreach ( $tabOutputs as $tabOutput ) {
                if ( $tabOutput["tiID"] == $tiID ) {
                    $tabOutput["parentTiID"] = 0;
                }
                $tabOutputsNew[] = $tabOutput;
            }
            
            $tabOutputsRebuild = $aigap->tabOutputs_rebuild_subitems( $tabOutputsNew, 0, $tranID, $tabOutputActions, $directoryPath );
            //echo json_encode( $tabOutputsNew  ). "\n\n";
            //echo json_encode( $tabOutputsRebuild  ). "\n\n";
            
            foreach( $tabOutputsRebuild as $tabOutput ) {
                
                $tiID = $tabOutput["tiID"];
                $inputTypeID = $tabOutput["inputTypeID"];
                
                if ( in_array($tiID, $actionTiID_array) || empty($actionTiID_array)  ) {
                    //$tabOutputsClean[] = $tabOutput;
                    
                    
                    $parameters = json_decode( $tabOutput["parameters"], true);
                    $functionName = "inputTypeID_".$inputTypeID;
                    $webItemWidth = $parameters["webItemWidth"];
        
                    if ( method_exists( $aigap, $functionName ) ) {
                        
                        $responseHtml = $aigap->$functionName( $tabOutput, $parameters, $tranID, $tabOutputActions );
                        
                        $responseData[ $tiID ]["html"] = "<div style=\"min-width: ".$webItemWidth."\">".$responseHtml."</div>";
                        $responseData[ $tiID ]["width"] = $webItemWidth;
                    }
                    
                }
                
            }
            
            $responseDataClean = array();
            foreach( $responseData as $responseDataRow ) { $responseDataClean[] = $responseDataRow; }

            echo json_encode( array("returnCode" => $returnCode_1, "responseData" => $responseDataClean ) );
            
        }
        else
        {
            echo json_encode( array("returnCode" => $returnCode_1 ) );
        }
    }
    else
    {
        echo json_encode( $returnCode );
    }
    
}
else if ( $get == "claimData" ) {
    
    
    $editID = $aigap->g("editID");
    $searchText = $aigap->g("searchText");
    $firstID = $aigap->g("firstID");
    $lastID = $aigap->g("lastID");
    $lastGroupID = $aigap->g("lastGroupID");
    $claimID = $aigap->g("claimID");
    $tabID = $aigap->g("tabID");
    $tiID = $aigap->g("tiID");
    $actionTranID = $aigap->g("actionTranID");
    $tranID = $aigap->g("tranID");
    $tranIDForce = $aigap->g("tranIDForce");
    $range = $aigap->g("range");
    
    $dev1 = $aigap->g("dev1");
    $dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);
    
    if ( $dev1_dec != "" ) {
        foreach( $dev1_dec as $key => $value ) {
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
            else if ( $key == "tranID" ) { $tranID = $value; }
            else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
            else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
            else if ( $key == "expireDate" ) { $expireDate = $value; }
        }
    }
    
    $devRerouteServerApi = urldecode( $aigap->g( "devRerouteServerApi") );
    $devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( $devRerouteServerApi ), true );
    
    $responseJson = $aigap->services_AigapGetClaim( $searchText, $lastID, $lastGroupID, $range, $claimID, $tiID, $editID, $tranID, $actionTranID, "", "", $tranIDForce, $devRerouteServerApiDec );
    
    $returnCode = $responseJson["returnCode"];
    $messageID = $returnCode["messageID"];
    $message = $returnCode["message"];

    if ( $messageID == 0 )
    {
        $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

        $returnCode_1 = $jsonData["returnCode"];
        $messageID_1 = $returnCode_1["messageID"];
        $message_1 = $returnCode_1["message"];

        if ( $messageID_1 == 0 )
        {

            echo json_encode( array("returnCode" => $returnCode_1, "responseData" => $jsonData ) );
            
        }
        else
        {
            echo json_encode( array("returnCode" => $returnCode_1 ) );
        }
    }
    else
    {
        echo json_encode( $returnCode );
    }
}
else if ( $get == "claimDataHtml" ) {
    
    
    $editID = $aigap->g("editID");
    $searchText = $aigap->g("searchText");
    $firstID = $aigap->g("firstID");
    $lastID = $aigap->g("lastID");
    $lastGroupID = $aigap->g("lastGroupID");
    $claimID = $aigap->g("claimID");
    $tabID = $aigap->g("tabID");
    $tiID = $aigap->g("tiID");
    $actionTranID = $aigap->g("actionTranID");
    $tranID = $aigap->g("tranID");
    $tranIDForce = $aigap->g("tranIDForce");
    $range = $aigap->g("range");
    $columnCount = $aigap->g("columnCount");
    
    $dev1 = $aigap->g("dev1");
    $dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);
    
    if ( $dev1_dec != "" ) {
        foreach( $dev1_dec as $key => $value ) {
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
            else if ( $key == "tranID" ) { $tranID = $value; }
            else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
            else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
            else if ( $key == "expireDate" ) { $expireDate = $value; }
        }
    }
    
    $devRerouteServerApi = urldecode( $aigap->g( "devRerouteServerApi") );
    $devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( $devRerouteServerApi ), true );
    
    $responseJson = $aigap->services_AigapGetClaim( $searchText, $lastID, $lastGroupID, $range, $claimID, $tiID, $editID, $tranID, $actionTranID, "", "", $tranIDForce, $devRerouteServerApiDec );
    
    $returnCode = $responseJson["returnCode"];
    $messageID = $returnCode["messageID"];
    $message = $returnCode["message"];

    if ( $messageID == 0 )
    {
        $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

        $returnCode_1 = $jsonData["returnCode"];
        $messageID_1 = $returnCode_1["messageID"];
        $message_1 = $returnCode_1["message"];

        if ( $messageID_1 == 0 )
        {
            $estimatedWidth = round( 100 / $columnCount ) ."%";
            $claimDataHtmlArray = array();
            $claimData = $jsonData["claimData"];
            
            if ( count( $claimData ) > 0 ) {
                foreach( $claimData as $claimDataRow ) {

                    $i++;

                    $ID_ = $claimDataRow["ID"];
                    $name_ = $claimDataRow["name"];
                    $imageURL_ = $claimDataRow["imageURL"];

                    $claimDataHtml = '<div style="display: inline-table; max-width: '.$estimatedWidth.'; width: '.$estimatedWidth.'; vertical-align: top;" >';
                    if ( $imageURL_ != "" ) {
                        $claimDataHtml .= '<div style="padding: 10px;"><img src="'.$imageURL_.'" heigth="200" width="100%"></div>';
                    }
                    if ( $name_ != "" ) {
                        $claimDataHtml .= '<div style="padding: 10px; font-weight: bold;">'.$name_.'</div>';
                    }

                    $dynamicView_ = $claimDataRow["dynamicView"];

                    if ( count($dynamicView_) > 0 ) {

                        $dynamicView_new_ = $aigap->dynamicViewLoop( $dynamicView_ );

                        $dynamicViewGen_ = $aigap->dynamicView( $dynamicView_new_, $tiID, $devRerouteServerApiEnc );
                        $claimDataHtml .= '<div>'.$dynamicViewGen_.'</div>';

                    }

                    $claimDataHtml .= '</div>';

                    $claimDataHtmlArray[] = rawurlencode( $claimDataHtml );

                }
            } else {

                //$claimDataHtml .= '<div>'.$aigap->getLanguageValue("m.NoData", $languageCode).'</div>';

            }
            
            
            $returnValues = array();
            $returnValues["returnCode"] = $returnCode_1;
            $returnValues["claimDataHtmlArray"] = $claimDataHtmlArray;
            
            $jsonDataClean = $jsonData;
            $jsonDataClean["claimData"] = array();
            
            $returnValueAll = array_merge( $returnValues, $jsonDataClean );
            
            echo json_encode( $returnValueAll );
            
        }
        else
        {
            echo json_encode( array("returnCode" => $returnCode_1 ) );
        }
    }
    else
    {
        echo json_encode( $returnCode );
    }
}
else if ( $get == "aigapMenu" ) {
    
    $params = $aigap->g("params");
    $paramsJsonDec = $aigap->AES256_decrypt( rawurldecode( $params ) );
    $paramsJsonArray = json_decode( $paramsJsonDec, true );
    
    $firstID = $paramsJsonArray["firstID"];
    $claimID = $paramsJsonArray["claimID"];
    $tiID = $paramsJsonArray["tiID"];
    $actionTranID = $paramsJsonArray["actionTranID"];
    $tranID = $paramsJsonArray["tranID"];
    
    $devRerouteServerApi = urldecode( $paramsJsonArray["devRerouteServerApi"] );
    $devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( $devRerouteServerApi ), true );
    
    	                  //services_AigapGetClaim( $s, $lastID , l, li, $claimID, $tiID, i, $tranID, $actionTranID, pt, pd, f, $devRerouteServerApi = array(), $uTabID = "", $eventActionTypeID = 0 )

    $responseJson = $aigap->services_AigapGetClaim( "", $firstID, 0, 20, $claimID, $tiID, 0, $tranID, $actionTranID, "", "", 0, $devRerouteServerApiDec );
    
    $returnCode = $responseJson["returnCode"];
    $messageID = $returnCode["messageID"];
    $message = $returnCode["message"];

    if ( $messageID == 0 )
    {
        $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

        $returnCode_1 = $jsonData["returnCode"];
        $messageID_1 = $returnCode_1["messageID"];
        $message_1 = $returnCode_1["message"];

        if ( $messageID_1 == 0 )
        {

            echo json_encode( array("returnCode" => $returnCode_1, "responseData" => $jsonData ) );
            
        }
        else
        {
            echo json_encode( array("returnCode" => $returnCode_1 ) );
        }
    }
    else
    {
        echo json_encode( $returnCode );
    }
}
else if ( $get == "stateCheck" ) {
    
    $dev1 = $aigap->g("dev1");
    $dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);
    
    $sess = $aigap->g("sess");
    $sess_ = unserialize( $aigap->AES256_decrypt( $sess ) );
    $_SESSION = $sess_;
    
    if ( $dev1_dec != "" ) {
        foreach( $dev1_dec as $key => $value ) {
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
            else if ( $key == "tranID" ) { $tranID = $value; }
            else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
            else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
            else if ( $key == "expireDate" ) { $expireDate = $value; }
        }
    }
    
    $data = $aigap->g("data");
    $dataJson = json_decode( stripcslashes( rawurldecode( $data ) ), true);
    
    $stateCheckID = $dataJson["stateCheckID"];
    $stateCheckIntervalSecond = $dataJson["stateCheckIntervalSecond"];
    $stateCheckTimeout = $dataJson["stateCheckTimeout"];
    $firewallURL = $dataJson["firewallURL"];
    $firewallPublicKey = $dataJson["firewallPublicKey"];
    $encTypeID = $dataJson["encTypeID"];
    $algorithmTypeID = $dataJson["algorithmTypeID"];
    $aimlFwID = $dataJson["aimlFwID"];
    $fwID = $dataJson["fwID"];
    $fwActionTypeID = $dataJson["fwActionTypeID"];
    $apiTypeID = $dataJson["apiTypeID"];
    $apiMethod = $dataJson["apiMethod"];
    
    $tranID = $dataJson["tranID"];
    $ID = $dataJson["ID"];
    $actionTiID = "114";//$dataJson["actionTiID"];
    $referData = $dataJson["referData"];
    $devRerouteServerApi = $dataJson["devRerouteServerApi"];
    
    $uTabID = $dataJson["uTabID"];
            
    $responseJson = $aigap->services_StateCheckServices( $uTabID, $tranID, 1, $ID, $actionTiID, $referData, $devRerouteServerApi, $aimlFwID, $algorithmTypeID, $apiMethod, $apiTypeID, $encTypeID, $firewallPublicKey, $firewallURL, $fwActionTypeID, $fwID );
        
    $returnCode = $responseJson["returnCode"];
    $messageID = $returnCode["messageID"];
    $message = $returnCode["message"];

    if ( $messageID == 0 )
    {
        $jsonData__ = json_decode( $responseJson["jsonDataDecrypted"], true );

        $returnCode_1 = $jsonData__["returnCode"];
        $messageID_1 = $returnCode_1["messageID"];
        $message_1 = $returnCode_1["message"];

        if ( $messageID_1 == 0 )
        {
            $statusTypeID = -1;
    
            $tranFields__ = $jsonData__["tranFields"];
            
            foreach( $tranFields__ as $tranField__ ) {

                $ID__ = $tranField__["ID"];
                $fieldName__ = $tranField__["fieldName"];
                $tableID__ = $tranField__["tableID"];
                $fieldValueText__ = $tranField__["fieldValueText"];

                if ( $fieldName__ == "int_aigap_provision_session_statusTypeID" ) { $statusTypeID = $ID__; }
            }
            
            
            $devRerouteServerApiDec__ = json_encode( $jsonData__["devRerouteServerApi"] );
            $devRerouteServerApiEnc__ = urlencode( $aigap->AES256_encrypt( $devRerouteServerApiDec__ ) );

            $jsonData__["tranFields"] = array();
            $jsonData__["statusTypeID"] = $statusTypeID;
            $jsonData__["devRerouteServerApi"] = $devRerouteServerApiEnc__;
            //$jsonData__["devRerouteServerApi"] = $devRerouteServerApiEnc;
            
            echo json_encode( array("returnCode" => $returnCode_1, "responseData" => $jsonData__ ) );
            
        }
        else
        {
            echo json_encode( array("returnCode" => $returnCode_1 ) );
        }
    }
    else
    {
        echo json_encode( $returnCode );
    }
    
}
else if ( $get == "setTranFields" ) {
	
	$prmInput = $aigap->g("prmInput");
	$tableID = $aigap->g("tableID");
	$ID = $aigap->g("ID");
        $tranID = $aigap->g("tranID");
        $tranIDForce = $aigap->g("tranIDForce");
        $uTabID = $aigap->g("uTabID");
        $tranFieldsArrayString = $aigap->g("tranFieldsArrayString");
        $tranFieldsArray = json_decode( rawurldecode( $tranFieldsArrayString ), true );
	$selectedProjectDataString = $aigap->g("selectedProjectDataString");
        
        //$_SESSION["cacheTranFields"] = array();
        
        //print_r( $_REQUEST );
        //print_r( $colomor->tranFields_get() );
        
        $aigap->tranFields_add( $prmInput, $ID, $tableID, $uTabID );
                
        foreach( $tranFieldsArray as $tranField ) {
            $field_ = strval( $tranField["field"] );
            $value_ = strval( $tranField["value"] );
            $tableID_ = strval( $tranField["tableID"] );
            $colomor->tranFields_add( $field_, $value_, $tableID_, $uTabID );
        }
	
        $reloadStatus = false;
        
        if ( $selectedProjectDataString != "" ) {
            
            $selectedProjectDataJson = json_decode( rawurldecode( $selectedProjectDataString ), false);
            $selectedProjectDataJsonEnc = base64_encode( $aigap->AES256_encrypt( json_encode( $selectedProjectDataJson ) ) );
            
            $aigap->setCookie( "selectedProjectData", $selectedProjectDataJsonEnc);
            $reloadStatus = true;
        }
        
	$returnCode = array("messageID" => "0", "message" => "OK", "reloadStatus" => $reloadStatus );
	
	echo json_encode( $returnCode );
}
else if ( $get == "removeSelectedProject" ) {
        
    $aigap->delCookie( "selectedProjectData" );
    $reloadStatus = true;
    $returnCode = array("messageID" => "0", "message" => "OK", "reloadStatus" => $reloadStatus );
    
    echo json_encode( $returnCode );
}
else if ( $get == "logout" ) {
    
    $waitSecond = 0;
    
    $aigap->delCookie( "userData_0" );    
    $aigap->delCookie( "userData_1" );
    $aigap->delCookie( "userTypeID" );
    $aigap->delCookie( "rememberUserData" );
    
    if ( $aigap->g("clearUserData") == true ) {
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
        $waitSecond = 2;
    }
    
    $reloadStatus = true;
    $returnCode = array("messageID" => 0, "message" => "OK", "reloadStatus" => $reloadStatus, "waitSecond" => $waitSecond );
    
    echo json_encode( $returnCode );
}
else if ( $get == "pageCache" ) {
    
    $htmlToken = $aigap->g("htmlToken");
    $htmlContent = $aigap->g("htmlContent");
    
    $cacheDir = "files/cache/";
    $htmlName = $htmlToken.".html.cache";
    
    $htmlClean = rawurldecode( base64_decode( $htmlContent ) );
    
    $htmlClean_l1 = explode( "<!--REMOVE-->", $htmlClean);
    $htmlClean_l2 = explode( "<!--/REMOVE-->", $htmlClean_l1[1]);
    $htmlClean_l3 = $htmlClean_l1[0] . $htmlClean_l2[1];
    
    $aigap->fileWrite(  $cacheDir.$htmlName, $htmlClean_l3);
    
    $reloadStatus = false;
    $returnCode = array("messageID" => 0, "message" => "OK", "reloadStatus" => $reloadStatus );
    
    echo json_encode( $returnCode );
}
else if ( $get == "tranTabInputs" ) {
    
    $dev1 = $aigap->g("dev1");
    $dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);
    
    if ( $dev1_dec != "" ) {
        foreach( $dev1_dec as $key => $value ) {
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
            else if ( $key == "tranID" ) { $tranID = $value; }
            else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
            else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
            else if ( $key == "expireDate" ) { $expireDate = $value; }
        }
    }
        
    $tranID = $aigap->g("tranID");
    $ID = $aigap->g("ID");
    $tabID = $aigap->g("tabID");
    $referTranID = "0";//$aigap->g("referTranID");
    $referTabID ="0";// $aigap->g("referTabID");
    $referFwID = "0";//$aigap->g("referFwID");
    $devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( urldecode($aigap->g("devRerouteServerApi")) ), true );
    $tranFields = json_decode( urldecode( $aigap->g("tranFields") ), true );
    $activeDataArray = json_decode( urldecode( $aigap->g("activeDataJson") ), true );
    $fieldName = $tranFields["fieldName"];
    $fieldValue = $tranFields["fieldValue"];
    $tableID = $tranFields["tableID"];
    $inputTypeID = $aigap->g("inputTypeID");
    $tiID = $aigap->g("tiID");
    $aigap->tranFields_add( $fieldName, $fieldValue, $tableID );

	
    $forceFwID = "0";
    $formActionTypeID = "0";
    
    $getUserData = $aigap->getUserData();
    if ( !empty($getUserData["activeFwID"]) && intval($getUserData["activeFwID"]) > 0 ) {
       // $forceFwID = $getUserData["activeFwID"];
    }
    
    //echo json_encode( $activeDataArray );

    $responseJson = $aigap->services_AigapGetTranTabInputs( $tranID, $tabID, 0, $ID, $tiID, 0, 0, 0, $devRerouteServerApiDec, 17, "", $forceFwID, "0", $referTranID, $referTabID, $referFwID, $activeDataArray, $formActionTypeID, "0" );
    
	//services_AigapGetTranTabInputs( $tranID = 0, $tabID = 0, $stateID = 1, $ID = "0", $actionTiID = 0, $designPropertyTypeID = 0, $designPropertyID = 0, $tranIDForce = 0, $devRerouteServerApi = array(), $tranCallerTypeID = 0, $uTabID = "", $forceFwID = "0", $eventActionTypeID = 0, $referFwID = "0", $activeData = array() )
		
	//echo json_encode( $responseJson )."\n\n";
	
    $returnCode = $responseJson["returnCode"];
    $messageID = $returnCode["messageID"];
    $message = $returnCode["message"];

    if ( $messageID == 0 )
    {
        $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

        $returnCode_1 = $jsonData["returnCode"];
        $messageID_1 = $returnCode_1["messageID"];
        $message_1 = $returnCode_1["message"];

        //echo json_encode(  $jsonData );
        
        if ( $messageID_1 == 0 )
        {

            $responseData = array();
            $tabOutputsClean = array();
            $tabOutputs = $jsonData["tabOutputs"];
            
            $tabOutputAction = json_decode( urldecode( $aigap->g("tabOutputActions") ), true);
            
            $actionTiID_array = array();
            $referFwID_array = array();
            $actionTiIDs = $tabOutputAction["actionTiIDs"];
            foreach( $actionTiIDs as $actionTiID ) {
                $actionTiID_array[] = $actionTiID["actionTiID"];
                $referFwID_array[] = $actionTiID["referFwID"];
                $responseData[ $actionTiID["actionTiID"] ] = array( "actionTiID" => $actionTiID["actionTiID"], "referFwID" => $actionTiID["referFwID"], "html" => "<div style=\"padding:10px;\">".$aigap->getLanguageValue("m.NoData")."</div>" );
            }
            
            $directoryPath = "";
            
            $tabOutputsNew = array();
            foreach ( $tabOutputs as $tabOutput ) {
                if ( $tabOutput["tiID"] == $tiID ) {
                    $tabOutput["parentTiID"] = 0;
                }
                $tabOutputsNew[] = $tabOutput;
            }
            
            $tabOutputsRebuild = $aigap->tabOutputs_rebuild_subitems( $tabOutputsNew, 0, $tranID, $tabOutputActions, $directoryPath );
            //echo json_encode( $tabOutputsNew  ). "\n\n";
            //echo json_encode( $tabOutputsRebuild  ). "\n\n";
            
            $returnHtml = "";
            $webItemWidth = "100%";
            
            foreach( $tabOutputsRebuild as $tabOutput ) {
                
                $tiID = $tabOutput["tiID"];
                $inputTypeID = $tabOutput["inputTypeID"];
                
                //if ( in_array($tiID, $actionTiID_array) || empty($actionTiID_array)  ) {
                    //$tabOutputsClean[] = $tabOutput;
                    
                    
                    $parameters = json_decode( $tabOutput["parameters"], true);
                    $functionName = "inputTypeID_".$inputTypeID;
                    $webItemWidth = $parameters["webItemWidth"];
        
                    if ( method_exists( $aigap, $functionName ) ) {
                        
                        $responseHtml = $aigap->$functionName( $tabOutput, $parameters, $tranID, $tabOutputActions );
                        
                        $returnHtml .= $responseHtml;

                    }
                    
                //}
                
            }
            
            $responseData[$tiID]["html"] = "<div style=\"min-width: " . $webItemWidth . "\">" . $returnHtml . "</div>";
            $responseData[$tiID]["width"] = $webItemWidth;

            $responseDataClean = array();
            foreach( $responseData as $responseDataRow ) { $responseDataClean[] = $responseDataRow; }

            echo json_encode( array("returnCode" => $returnCode_1, "responseData" => $responseDataClean ) );
            
        }
        else
        {
            echo json_encode( array("returnCode" => $returnCode_1 ) );
        }
    }
    else
    {
        echo json_encode( $returnCode );
    }
    
}

?>
