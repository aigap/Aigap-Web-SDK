<?php

date_default_timezone_set('Europe/Istanbul');

include("config.php");
include("aigap.class.php");


$subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));

$aigap = new aigap();
$aigap->loadConfigToClass();

if ( $subdomain === "panel" ) {
    $aigap->setCookiePrefix("sdk_");
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

if ( $aigap->getCookie("userTypeID") != "" ) {
    $aigap->setUserTypeID( $aigap->getCookieSession("userTypeID") );
}

if ( $aigap->getCookieSession("browserUID") == "" ) {
    $gen_browserUID = uniqid(mt_rand(), false);
    $aigap->setCookieSession( "browserUID", $gen_browserUID);
}

if ( $aigap->getCookieSession("langCode") != "" ) {
    $aigap->setLangCode( $aigap->getCookie("langCode") );
}

if ( $aigap->getCookie("userData_0") == "" ) { $aigap->delSession("userData_0"); }
if ( $aigap->getCookie("userData_1") == "" ) { $aigap->delSession("userData_1"); }

$serviceUrlList = $aigap->getServiceUrlList();
$serviceUrl_0 = $serviceUrlList[0];

$userData_1_Encrypted = $aigap->getCookie("userData_1");
$userData_1_Decrypted = $aigap->AES256_decrypt( $userData_1_Encrypted );
$userData_1_Decrypted_array  = json_decode( $userData_1_Decrypted, true );

$userLoginStatus = false;
$visitorLoginStatus = false;

//echo "EE >> " . $userData_1_Encrypted . " >> EE";


if ( $userData_1_Encrypted == null || $userData_1_Encrypted == "" ) {
    if ( $userData_1_Decrypted_array["user"]["userID"] != 0 ) {
        $userLoginStatus = true;
        $visitorLoginStatus = false;
    }
}
else {
    if ( !empty($userData_1_Decrypted_array["user"]) ) {
        $userLoginStatus = true;
        if ( $userData_1_Decrypted_array["user"]["email"] == $config["visitorUser"] ) {
            $visitorLoginStatus = true;
        }
    }
    else if ( $userData_1_Decrypted_array["user"]["email"] != $config["visitorUser"] && $userData_1_Decrypted_array["user"]["userID"] != 0  ) {
        $userLoginStatus = true;
        $visitorLoginStatus = true;
    }
}

$userName = $config["visitorUser"];//"colomor@colomor.com";
$password = $config["visitorPassword"];//"a1358230dcc10075c9b3716c3558c7ce"; // MD5_2
            
if ( $visitorLoginStatus ) {
    $aigap->setUserTypeID( "7" );
    $aigap->setCookieSession("userTypeID", "7");
}

if ( $aigap->getCookie("rememberUserData") != "" && ( $userData_1_Encrypted == null || $userData_1_Encrypted == "" ) ) {

    $rememberUserDataEnc = $aigap->getCookie("rememberUserData");
    $rememberUserDataDec = json_decode( urldecode( $aigap->AES256_decrypt( $rememberUserDataEnc ) ), true);

    $userName = $rememberUserDataDec["userID"];
    $password = $rememberUserDataDec["password"];
    $userTypeID__ = $rememberUserDataDec["userTypeID"];
    $aigap->setUserTypeID( $userTypeID__ );
    $aigap->setCookieSession( "userTypeID", $userTypeID__);
}

//print_r( $_SESSION["tranFields"] );

//print_r( $userData_1_Decrypted_array );
//echo json_encode( $userData_1_Decrypted_array );
//$userLoginStatus = false;

$parametersTran = array();
$tabs = array();

$tranID_res = "0";
$ID_res = "0";
$actionTiID_res = "0";

$dev1 = $aigap->g("dev1");
$dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);


$expireDate = "";

if ( $dev1_dec != "" ) {
    foreach( $dev1_dec as $key => $value ) {
        //echo "<div>". $key . " : " . $value . "</div>";
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
        else if ( $key == "tranID" ) {
            $tranID = $value;
            $tranID_res = $value;
        }
        else if ( $key == "companyID" ) { $aigap->setCompanyID( $value ); }
        else if ( $key == "iCompanyID" ) { $aigap->setICompanyID( $value ); }
        else if ( $key == "expireDate" ) { $expireDate = $value; }
    }
}



$dev2 = $aigap->g("dev2");
$tranID_res = $aigap->g("t")==""?"0":$aigap->g("t");
$ID_res = $aigap->g("i")==""?"0":$aigap->g("i");
$actionTiID_res = $aigap->g("ati")==""?"0":$aigap->g("ati");

$drsi = $aigap->g("drsi");
$devRerouteServerApi = $drsi;
$devRerouteServerApiDec = json_decode( $aigap->AES256_decrypt( $drsi ) , true );

//echo "Drsi - 2<br>";
//print_r( $devRerouteServerApiDec );
//echo "<br>Drsi - 2<br>";


$trf = $aigap->g("trf");
$searchText = $aigap->g("searchText");
if ( $trf != "" ) {
    $tranFieldsDec = json_decode( $aigap->AES256_decrypt( $trf ) , true );
        
    if ( count($tranFieldsDec) > 0 ) {
        foreach( $tranFieldsDec as $tranField ) {
            $fieldName_ = $tranField["fieldName"];
            $fieldValue_ = $tranField["fieldValue"];
            $tableID_ = $tranField["tableID"];
            if ( $searchText != "" ) { $fieldValue_ = $searchText; }
            $aigap->tranFields_add( $fieldName_, $fieldValue_, $tableID_ );
        }
    }
}

$asm = $aigap->g("asm");
$stateID__ = "1";
if ( $asm != "" && intval($asm) > 0 ) {
    $stateID__ = $asm;
} 


if ( $expireDate != "" ) {
    $expireDateO = strtotime($expireDate);
    $dateO = strtotime(date("Y-m-d H:i:s"));
    if ( $dateO > $expireDateO ) {
        echo "<div style=\"font-size:22px;\">Link expired</div>";
        exit;
    } 
}

$tranTabResponseStatus = false;
if ( $aigap->getSession("tranTabResponse") != "" ) {
    $tranTabResponse__ = json_decode( $aigap->getSession("tranTabResponse"), true);
    if ( !empty($tranTabResponse__["tabs"]) ) {
        $tabs = $tranTabResponse__["tabs"];
        $tranTabResponseStatus = true;
    }
    $aigap->delSession("tranTabResponse");
    //echo json_encode( $tabs );
} 

//echo $tranID_res . " >> " .$userLoginStatus;

if ( $tranTabResponseStatus == false ) {
    if ( $tranID_res > 0 ) {

        if ( !$userLoginStatus ) {

            $serviceServiceUrlList = $aigap->getServiceServiceUrlList();
            $serviceServiceUrl_0 = $serviceServiceUrlList[0];

                $langVersion__ = $aigap->getLanguageValue("langVersion");
                $responseJson_service = $aigap->services_CoreGetTransferEngineApiURL( $serviceServiceUrl_0, $config["countryID"], $langVersion__);

                $returnCode_service = $responseJson_service["returnCode"];
                $messageID_service = $returnCode_service["messageID"];
                $message_service = $returnCode_service["message"];

                
                //echo json_encode( $serviceServiceUrlList )."<br>";
                //echo json_encode( $responseJson_service );

                if ( $messageID_service == 0 )
                {

                    $jsonData_service = json_decode( $responseJson_service["jsonDataDecrypted"], true );

                    $aigapKeysArray_service = array();
                    $aigapKeysArray_service["Key_0"] = $aigap->getAigapKey("0");
                    $keyChainJson_service = $jsonData_service["keyChain"];
                    $aigapKeysArray_service["Key_1"] = $keyChainJson_service;
                    $aigapKeysArray_service["Key_1"]["publicKey"] = $aigapKeysArray_service["Key_0"]["publicKey"];
                    $keyChainJsonEncrypted_service = $aigap->AES256_encrypt( json_encode( $aigapKeysArray_service ) );
                    $aigap->setCookieSession( "userData_0", $keyChainJsonEncrypted_service );

                    $transferURLs = $jsonData_service["transferURLs"];
                    $transferURLsEncrypted = $aigap->AES256_encrypt( json_encode( $transferURLs ) );
                    $aigap->setCookie( "userData_958", $transferURLsEncrypted );

                    $transferRouteURLs = $jsonData_service["transferRouteURLs"];
                    $transferRouteURLsEncrypted = $aigap->AES256_encrypt( json_encode( $transferRouteURLs ) );
                    $aigap->setCookie( "userData_998", $transferRouteURLsEncrypted );  


                    $langFields = $jsonData_service["langFields"];
                    $screenFields = $jsonData_service["screenFields"];

                    $langVersion = $jsonData_service["langVersion"];
                    $langFieldVersion = $jsonData_service["langFieldVersion"];

                    //echo json_encode( $jsonData_service );

                    if ( count($screenFields) > 0 && count($langFields) > 0 ) {
                        $newJsonData = array();

                        $newJsonData[68]["langFieldVersion"] = $langFieldVersion;
                        $newJsonData[68]["langFieldIVersion"] = "0";
                        $newJsonData[68]["langVersion"] = $langVersion;

                        foreach( $screenFields as $screenFieldsRow ) {

                            $fieldID_ = $screenFieldsRow["fieldID"];
                            $screenID_ = $screenFieldsRow["screenID"];

                            foreach( $langFields as $langFieldsRow ) {

                                $fieldID__ = $langFieldsRow["fieldID"];
                                $field_ = $langFieldsRow["field"];
                                $value_ = $langFieldsRow["value"];

                                if ( $fieldID__ == $fieldID_ ) {
                                     $newJsonData[$screenID_][$field_] = $value_;

                                }
                            }
                        }


                        $newJsonDataJson = json_encode( $newJsonData );

                        $languageFile = "files/languages/" . $aigap->getCookie("langCode") . ".json";
                        if ( file_exists( $languageFile ) ) { unlink($languageFile); }
                        if ( !file_exists( $languageFile ) ) {
                            $fileOpen = fopen( $languageFile, "w") or die("Unable to open file!");
                            fwrite( $fileOpen, $newJsonDataJson);
                            fclose( $fileOpen );
                        }
                    }

                    //$serviceUrlList = $aigap->getServiceUrlList();
                    //$serviceUrl_0 = $serviceUrlList[0];
                    $serviceUrl_0 = $transferURLs[0]["URL"];

                    $responseJson = $aigap->services_AigapLoginUser( $serviceUrl_0, $config["countryID"], $userName, $password);

                    $returnCode = $responseJson["returnCode"];
                    $messageID = $returnCode["messageID"];
                    $message = $returnCode["message"];

    //                echo json_encode( $responseJson );

                    if ( $messageID == 0 )
                    {
                        $jsonDataLogin = json_decode( $responseJson["jsonDataDecrypted"], true );

                        //echo json_encode( $jsonDataLogin );

                        $aigapKeysArray = array();
                        $aigapKeysArray["Key_0"] = $aigap->getAigapKey("0");
                        $keyChainJson = $jsonDataLogin["keyChain"];
                        $aigapKeysArray["Key_1"] = $keyChainJson;
                        $aigapKeysArray["Key_1"]["publicKey"] = $aigapKeysArray["Key_0"]["publicKey"];
                        $keyChainJsonEncrypted = $aigap->AES256_encrypt( json_encode( $aigapKeysArray ) );
                        $aigap->setCookieSession( "userData_0", $keyChainJsonEncrypted );

                        if ( empty($tranTabResponse["activeICompanyID"]) ) {
                            $tranTabResponse["activeICompanyID"] = "11";
                        }

                        $userData_1 = array();
                        $userData_1["activeTranID"] = $tranTabResponse["activeTranID"];
                        $userData_1["activeTabID"] = $tranTabResponse["activeTabID"];
                        $userData_1["activeICompanyID"] = $tranTabResponse["activeICompanyID"];
                        $userData_1["activeFwID"] = $tranTabResponse["activeFwID"];
                        $userData_1["user"] = $jsonDataLogin["user"];
                        $userData_1["userToken"] = $jsonDataLogin["userToken"];
                        $userData_1["claimCategories"] = $jsonData["claimCategories"];
                        $userData_1_Json = json_encode( $userData_1 );
                        $userData_1_JsonEncrypted = $aigap->AES256_encrypt( $userData_1_Json );
                        $aigap->setCookieSession( "userData_1", $userData_1_JsonEncrypted );

                        //echo json_encode( $userData_1 );

                        $responseJson = $aigap->services_AigapGetTranTabs( $tranID_res,  $stateID__, $ID_res, array(), $actionTiID_res, 0, 0, 0, $devRerouteServerApiDec );

                        $returnCode = $responseJson["returnCode"];
                        $messageID = $returnCode["messageID"];
                        $message = $returnCode["message"];

                        //-echo json_encode($responseJson);

                        if ( $messageID == 0 )
                        {
                            $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

                            $jsonData_returnCode = $jsonData["returnCode"];
                            $jsonData_messageID = $jsonData_returnCode["messageID"];
                            $jsonData_message = $jsonData_returnCode["message"];

                            if ( $jsonData_messageID == 0 ) {
                                $tabs = $jsonData["tabs"];

                                if ( !empty($tranTabResponse["parameters"]) ) {
                                    $parametersTran = json_decode( stripcslashes( $jsonData["parameters"] ), true);
                                }
                            }
                            else {
                                echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $jsonData_message . "</div></div>";
                            }
                        }
                    }
                    else {
                        echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $message . "</div></div>";
                    }

                }
                else {
                    echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $message_service . "</div></div>";
                }

            }
            else {

                /*
                $activeTranID = $userData_1_Decrypted_array["activeTranID"];
                $activeICompanyID = $userData_1_Decrypted_array["activeICompanyID"];
                $activeTabID = $userData_1_Decrypted_array["activeTabID"];
                $activeFwID = $userData_1_Decrypted_array["activeFwID"];

                $activeDataArray__ = array( "activeTranID" => $activeTranID, "activeTabID" => $activeTabID, "activeFwID" => $activeFwID );
*/
                $responseJson = $aigap->services_AigapGetTranTabs( $tranID_res, $stateID__, $ID_res, array(), $actionTiID_res, 0, 0, 0, $devRerouteServerApiDec );

                
                //echo json_encode( $responseJson );

                $returnCode = $responseJson["returnCode"];
                $messageID = $returnCode["messageID"];
                $message = $returnCode["message"];


                if ( $messageID == 0 )
                {
                    $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

                    $jsonData_returnCode = $jsonData["returnCode"];
                    $jsonData_messageID = $jsonData_returnCode["messageID"];
                    $jsonData_message = $jsonData_returnCode["message"];

                    if ( $jsonData_messageID == 0 ) {
                        $tabs = $jsonData["tabs"];

                        if ( !empty($jsonData["parameters"]) ) {
                            $parametersTran = json_decode( stripcslashes( $jsonData["parameters"] ), true);
                        }
                    }
                    else {
                        echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $jsonData_message . "</div></div>";
                    }
                }
                else {
                    echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $message . "</div></div>";
                }


            }

    }
    else {
        //$userLoginStatus = false;
        //$aigap->delCookie("userData_1");

        //echo "<br><br>AA-".$userLoginStatus."-BB<br><br>";

        if ( !$userLoginStatus ) {

            $serviceServiceUrlList = $aigap->getServiceServiceUrlList();
            $serviceServiceUrl_0 = $serviceServiceUrlList[0];

            $langVersion__ = $aigap->getLanguageValue("langVersion");
            $responseJson_service = $aigap->services_CoreGetTransferEngineApiURL( $serviceServiceUrl_0, $config["countryID"], $langVersion__);

            $returnCode_service = $responseJson_service["returnCode"];
            $messageID_service = $returnCode_service["messageID"];
            $message_service = $returnCode_service["message"];


                
            if ( $messageID_service == 0 )
            {

                    $jsonData_service = json_decode( $responseJson_service["jsonDataDecrypted"], true );

                    $aigapKeysArray_service = array();
                    $aigapKeysArray_service["Key_0"] = $aigap->getAigapKey("0");
                    $keyChainJson_service = $jsonData_service["keyChain"];
                    $aigapKeysArray_service["Key_1"] = $keyChainJson_service;
                    $aigapKeysArray_service["Key_1"]["publicKey"] = $aigapKeysArray_service["Key_0"]["publicKey"];
                    $keyChainJsonEncrypted_service = $aigap->AES256_encrypt( json_encode( $aigapKeysArray_service ) );
                    $aigap->setCookieSession( "userData_0", $keyChainJsonEncrypted_service );

                    $transferURLs = $jsonData_service["transferURLs"];
                    $transferURLsEncrypted = $aigap->AES256_encrypt( json_encode( $transferURLs ) );
                    $aigap->setCookie( "userData_958", $transferURLsEncrypted );

                    $transferRouteURLs = $jsonData_service["transferRouteURLs"];
                    $transferRouteURLsEncrypted = $aigap->AES256_encrypt( json_encode( $transferRouteURLs ) );
                    $aigap->setCookie( "userData_998", $transferRouteURLsEncrypted );  

                    $langFields = $jsonData_service["langFields"];
                    $screenFields = $jsonData_service["screenFields"];

                    if ( count($screenFields) > 0 && count($langFields) > 0 ) {
                        $newJsonData = array();

                        $newJsonData[68]["langFieldVersion"] = "0";
                        $newJsonData[68]["langFieldIVersion"] = "0";
                        $newJsonData[68]["langVersion"] = $langVersion;

                        foreach( $screenFields as $screenFieldsRow ) {

                            $fieldID_ = $screenFieldsRow["fieldID"];
                            $screenID_ = $screenFieldsRow["screenID"];

                            foreach( $langFields as $langFieldsRow ) {

                                $fieldID__ = $langFieldsRow["fieldID"];
                                $field_ = $langFieldsRow["field"];
                                $value_ = $langFieldsRow["value"];

                                if ( $fieldID__ == $fieldID_ ) {
                                     $newJsonData[$screenID_][$field_] = $value_;

                                }
                            }
                        }


                        $newJsonDataJson = json_encode( $newJsonData );

                        $languageFile = "files/languages/" . $aigap->getCookie("langCode") . ".json";
                        if ( file_exists( $languageFile ) ) { unlink($languageFile); }
                        if ( !file_exists( $languageFile ) ) {
                            $fileOpen = fopen( $languageFile, "w") or die("Unable to open file!");
                            fwrite( $fileOpen, $newJsonDataJson);
                            fclose( $fileOpen );
                        }
                    }

                    //$transferRouteURLs = $jsonData_service["transferRouteURLs"];
                    //$transferRouteURLsEncrypted = $aigap->AES256_encrypt( json_encode( $transferRouteURLs ) );
                    //$aigap->setCookie( "userData_998", $transferRouteURLsEncrypted );  

                    //$serviceUrlList = $aigap->getServiceUrlList();
                    //$serviceUrl_0 = $serviceUrlList[0];
                    $serviceUrl_0 = $transferURLs[0]["URL"];
                    
                    
                    //echo $userName.">".$password;
                    
                    $responseJson = $aigap->services_AigapLoginUser( $serviceUrl_0, $config["countryID"], $userName, $password);

                    $returnCode = $responseJson["returnCode"];
                    $messageID = $returnCode["messageID"];
                    $message = $returnCode["message"];



            //echo json_encode( $responseJson );

                    if ( $messageID == 0 )
                    {

                            $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

                            $returnCode_1 = $jsonData["returnCode"];
                            $messageID_1 = $returnCode_1["messageID"];
                            $message_1 = $returnCode_1["message"];

                            //echo json_encode( $jsonData );

                            if ( $messageID_1 == 0 )
                            {
                                $aigapKeysArray = array();
                                $aigapKeysArray["Key_0"] = $aigap->getAigapKey("0");
                                $keyChainJson = $jsonData["keyChain"];
                                $aigapKeysArray["Key_1"] = $keyChainJson;
                                $aigapKeysArray["Key_1"]["publicKey"] = $aigapKeysArray["Key_0"]["publicKey"];
                                $keyChainJsonEncrypted = $aigap->AES256_encrypt( json_encode( $aigapKeysArray ) );
                                $aigap->setCookieSession( "userData_0", $keyChainJsonEncrypted );

                                    //$lang = $jsonData["lang"];

                                    $tranTabResponse = $jsonData["tranTabResponse"];
                                    $tranTabResponse["tabs"] = array();

                                    if ( empty($tranTabResponse["activeICompanyID"]) ) {
                                        $tranTabResponse["activeICompanyID"] = "11";
                                    }

                                    $userData_1 = array();
                                    $userData_1["activeTranID"] = $tranTabResponse["activeTranID"];
                                    $userData_1["activeTabID"] = $tranTabResponse["activeTabID"];
                                    $userData_1["activeICompanyID"] = $tranTabResponse["activeICompanyID"];
                                    $userData_1["activeFwID"] = $tranTabResponse["activeFwID"];
                                    $userData_1["user"] = $jsonData["user"];
                                    $userData_1["userToken"] = $jsonData["userToken"];
                                    $userData_1["claimCategories"] = $jsonData["claimCategories"];
                                    $userData_1_Json = json_encode( $userData_1 );
                                    $userData_1_JsonEncrypted = $aigap->AES256_encrypt( $userData_1_Json );
                                    $aigap->setCookieSession( "userData_1", $userData_1_JsonEncrypted );


                                    //echo json_encode( $userData_1 );

                                    if ( !empty($jsonData["tranTabResponse"]) ) {

                                        $tranTabResponse = $jsonData["tranTabResponse"];

                                        $tabs = $tranTabResponse["tabs"];

                                        if ( !empty($tranTabResponse["parameters"]) ) {
                                            $parametersTran = json_decode( stripcslashes( $tranTabResponse["parameters"] ), true);
                                        }    
                                    }


                            }
                            else {
                                echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $message_1 . "</div></div>";
                            }

                            //echo json_encode( array("returnCode" => $returnCode_1, "jsonData" => $jsonData ) );

                    }
                    else {
                        echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $message . "</div></div>";
                    }
            }
            else {
                echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $message_service . "</div></div>";
            }

        }
        else {



                $activeTranID = $userData_1_Decrypted_array["activeTranID"];
                $activeICompanyID = $userData_1_Decrypted_array["activeICompanyID"];
                $activeTabID = $userData_1_Decrypted_array["activeTabID"];
                $activeFwID = $userData_1_Decrypted_array["activeFwID"];

                $activeDataArray__ = array( "activeTranID" => $activeTranID, "activeTabID" => $activeTabID, "activeFwID" => $activeFwID );
                
                //echo jsob_encode( $userData_1_Decrypted_array );
                
                $responseJson = $aigap->services_AigapGetTranTabs( $activeTranID, $stateID__, 0, $activeDataArray__, 0, 0, 0, 0, $devRerouteServerApiDec );
               // echo json_encode( $responseJson );

                $returnCode = $responseJson["returnCode"];
                $messageID = $returnCode["messageID"];
                $message = $returnCode["message"];


                if ( $messageID == 0 )
                {

                    $jsonData = json_decode( $responseJson["jsonDataDecrypted"], true );

                    $jsonData_returnCode = $jsonData["returnCode"];
                    $jsonData_messageID = $jsonData_returnCode["messageID"];
                    $jsonData_message = $jsonData_returnCode["message"];

                    if ( $jsonData_messageID == 0 ) {
                        $tabs = $jsonData["tabs"];

                        if ( !empty($jsonData["parameters"]) ) {
                            $parametersTran = json_decode( stripcslashes( $jsonData["parameters"] ), true);
                        } 
                    }
                    else {
                        echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $jsonData_message . "</div></div>";
                    }

                }
                else {
                    echo "<div class=\"errorArea\"><div class=\"errorMessage\">" . $message . "</div></div>";
                }
                        //echo "<br><br>";
                        //echo json_encode( $jsonData );
                        //echo "<br><br>";
            }


    }
}

?>
