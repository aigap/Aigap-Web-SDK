<?php

class aigap
{
    private $version = 1;
    private $build = 13;
    
    private $projectID = "0";
    private $oProjectID = "0";
    private $developerID = "0";
    private $dreamerID = "0";
    
	private $userTypeID = "7";
	private $appID = "1";
	private $deviceTypeID = "7";
        
        private $companyID = "1";
        private $iCompanyID = "1";
        private $countryID = "238";
        private $langCode = "en";
        private $fwID = "0";
        private $fwActionTypeID = "0";
        
        private $firewallURL = "";
        private $firewallPublicKey = "";
        private $encTypeID = "";
        private $algorithmTypeID = "";
        
        private $cookiePrefix = "";

        private $serviceUrlList = array( "http://srv.colomor.com/AigapCoreTransferTestApi/api/AigapCoreTransferApi/",
                                    "http://url.colomor.net/OnremoUrlEngine/OnremoUrlEngine.asmx",
                                    "http://url.onremo.com/OnremoUrlEngine/OnremoUrlEngine.asmx",
                                    "http://url1.colomor.com/OnremoUrlEngine/OnremoUrlEngine.asmx",
                                    "http://url1.colomor.net/OnremoUrlEngine/OnremoUrlEngine.asmx",
                                    "http://url1.onremo.com/OnremoUrlEngine/OnremoUrlEngine.asmx",
                                    "http://url2.colomor.com/OnremoUrlEngine/OnremoUrlEngine.asmx",
                                    "http://url2.colomor.net/OnremoUrlEngine/OnremoUrlEngine.asmx",
                                    "http://url2.onremo.com/OnremoUrlEngine/OnremoUrlEngine.asmx" );
        
        private $css_ava_versionCode = "1.0.6";
        private $reCaptchaKeys = array("site" => "6LfWEsIUAAAAAHcA639uS6PwgY8StGP2FptT4-Ay", "secret" => "6LfWEsIUAAAAALcGA--l7aM9_unyTFN6nu-3tsF6" );
	
        private $aigapKeys = array( "Key_0" => array("privateKey" => "7e12229472d900f9a022670eb9130b3624f3d694e08c3b483927e3be5426b1e9", "publicKey" => "AIGAPN04aBKK5cd0w1JevhfUOUOMaJE84KADDE", "encTypeID" => "5", "algorithmTypeID" => "3", "keyID" => "1" ));

        function setProjectID( $projectID ) { $this->projectID = $projectID; }
        function setOProjectID( $oProjectID ) { $this->oProjectID = $oProjectID; }
        function setDeveloperID( $developerID ) { $this->developerID = $developerID; }
        function setDreamerID( $dreamerID ) { $this->dreamerID = $dreamerID; }
        function setFWID( $fwID ) { $this->fwID = $fwID; }
        function setFWActionTypeID( $fwActionTypeID ) { $this->fwActionTypeID = $fwActionTypeID; }
        function setUserTypeID( $userTypeID ) { $this->userTypeID = $userTypeID; }
        function setAppID( $appID ) { $this->appID = $appID; }
        function setDeviceTypeID( $deviceTypeID ) { $this->deviceTypeID = $deviceTypeID; }
        function setCompanyID( $companyID ) { $this->companyID = $companyID; }
        function setICompanyID( $iCompanyID ) { $this->iCompanyID = $iCompanyID; }
        function setCountryID( $countryID ) { $this->countryID = $countryID; }
        function setLangCode( $langCode ) { $this->langCode = $langCode; }
        
        function setFirewallURL( $firewallURL ) { $this->firewallURL = $firewallURL; }
        function setFirewallPublicKey( $firewallPublicKey ) { $this->firewallPublicKey = $firewallPublicKey; }
        function setEncTypeID( $encTypeID ) { $this->encTypeID = $encTypeID; }
        function setAlgorithmTypeID( $algorithmTypeID ) { $this->algorithmTypeID = $algorithmTypeID; }
        
        function setCookiePrefix( $cookiePrefix ) { $this->cookiePrefix = $cookiePrefix; }
        function getCookiePrefix() { return $this->cookiePrefix; }
        
	function setAigapKey( $keyNumber, $keyDataArray ) { $this->aigapKeys["Key_".$keyNumber] = $keyDataArray; }
	function getAigapKey( $keyNumber )
	{ 
            $return = array();
            if ( $keyNumber != "0" ) {
                $userData_0_encrypted = $this->getCookieSession("userData_0");
                $userData_0_decrypt = $this->AES256_decrypt( $userData_0_encrypted );
                $userData_0 = json_decode( $userData_0_decrypt, true );                
                $return = $userData_0["Key_".$keyNumber];
                
            }
            else
            {
                $return = $this->aigapKeys["Key_0"];
            }
            
            return $return;
	}

	function setServiceUrlList( $serviceUrlList ) { $this->serviceUrlList = $serviceUrlList; }
	function getServiceUrlList() {
            
            $serviceUrlListArray = array();
            
            if ( $this->getCookieSession("userData_998") != "" ) {
                
                $userData_998_encrypted = $this->getCookieSession("userData_998");
                $userData_998_decrypt = $this->AES256_decrypt( $userData_998_encrypted );
                $userData_998_array = json_decode( $userData_998_decrypt, true );
                foreach( $userData_998_array as $url_array ) {
                    $serviceUrlListArray[] = $url_array["URL"];
                }
            }
            
            foreach( $this->serviceUrlList as $url_ ) {
                $serviceUrlListArray[] = $url_;
            }
            
            return $serviceUrlListArray;
        }
        
        function getCssJavaVersionCode() { return $this->css_ava_versionCode; }
        
        function getRecaptchaKey( $type ) { return $this->reCaptchaKeys[$type]; }
        
        function getVersion() { return array( "version" => $this->version, "build" => $this->build ); }
	
        function getGlobal( $field ) {
            $return = "";
	
		if ( isset($GLOBALS[$field]) )
		{
			$return = $GLOBALS[$field];
		}
		
		return $return;
        }
        
        function setGlobal( $field, $value ) {
            $GLOBALS[$field] = $value;
        }
        
	function getSession( $field )
	{
            $return = "";

            $field = $this->cookiePrefix.$field;

            if ( isset($_SESSION[$field]) )
            {
                $return = $_SESSION[$field];
            }

            return $return;
	}
	
	function setSession( $field, $value )
	{
            $field = $this->cookiePrefix.$field;
            $_SESSION[$field] = $value;
	}
	
	function delSession( $field )
	{
            $field = $this->cookiePrefix.$field;
            unset($_SESSION[$field]);
	}
        
        function setCookieSession( $field, $value ) {
            
            $field = $this->cookiePrefix.$field;
            
            $pageSecure = false;
            if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { $pageSecure = true; }
	    setcookie( $field, $value, time()+31565000, "/", null, $pageSecure, true);
            $_SESSION[$field] = $value;
            
        }
        
        function getCookieSession( $field ) {
            $return = "";
	
            $field = $this->cookiePrefix.$field;
            
            if ( isset($_COOKIE[$field]) ) {
                $return = $_COOKIE[$field];
            }
            else if ( isset($_SESSION[$field]) ) {
                $return = $_SESSION[$field];
            }

            return $return;
        }
        
        function delCookieSession( $field ) {
            
            $field = $this->cookiePrefix.$field;
            
            unset($_COOKIE[$field]); 
            setcookie($field, null, -1, "/");
            unset($_SESSION[$field]);
        }
	
	function setCookie( $field, $value, $httpOnly = true )
	{
            $field = $this->cookiePrefix.$field;
            
            $pageSecure = false;
            if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { $pageSecure = true; }
	    setcookie( $field, $value, time()+31565000, "/", null, $pageSecure, $httpOnly);
	}
	
	function getCookie( $field )
	{
            $field = $this->cookiePrefix.$field;
            
		$return = "";
	
		if ( isset($_COOKIE[$field]) )
		{
			$return = $_COOKIE[$field];
		}
		
		return $return;
	}
        
        function setCookieGlobal( $field, $value )
	{
            $field = $this->cookiePrefix.$field;
            
            if ( isset($_COOKIE[ $field ]) ) {
                $_COOKIE[ $field ] = $value;
                //echo "<br><br>SetCookie : lv : 0 :<br><br>";

            }
            else {
                $this->setCookie( $field, $value );
                //echo "<br><br>SetCookie : lv : 1 :<br><br>";
            }
	}
	
	function delCookie( $field )
	{
            $field = $this->cookiePrefix.$field;
            
		unset($_COOKIE[$field]); 
    	setcookie($field, null, -1, '/'); 
	}
	
	function g( $field, $addSlash = true )
	{
		$return = "";
		
		if ( isset($_REQUEST[$field]) )
		{
			if ( $addSlash )
			{
				$return = addslashes($_REQUEST[$field]);
			}
			else
			{
				$return = $_REQUEST[$field];
			}
		}
		else if ( isset($_GET[$field]) )
		{
			if ( $addSlash )
			{
				$return = addslashes($_GET[$field]);
			}
			else
			{
				$return = $_GET[$field];
			}
		}
		else if ( isset($_POST[$field]) )
		{
			if ( $addSlash )
			{
				$return = addslashes($_POST[$field]);
			}
			else
			{
				$return = $_POST[$field];
			}
		}
		
		return $return;
	}
	
	function AES256_encrypt( $data, $key="", $iv="" )
	{
		if ( $key == "" ) { $key = base64_decode("IfH0aqWS0jU6xP4+WK0SdlFKu5HGIvOH87fWDn46hSY="); }
		else { $key = base64_decode( $key ); }
		if ( $iv == "" ) { $iv = base64_decode("TzOHAeCPI+PjiKokYSThtw=="); }
		else { $iv = base64_decode( $iv ); }
				
		$iv = str_pad($iv, 16, "\0");
		
		$encrypted = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
		
		return base64_encode( $encrypted );
	}
	
	function AES256_decrypt( $data, $key="", $iv="" )
	{
		if ( $key == "" ) { $key = base64_decode("IfH0aqWS0jU6xP4+WK0SdlFKu5HGIvOH87fWDn46hSY="); }
		else { $key = base64_decode( $key ); }
		if ( $iv == "" ) { $iv = base64_decode("TzOHAeCPI+PjiKokYSThtw=="); }
		else { $iv = base64_decode( $iv ); }
		
		$iv = str_pad($iv, 16, "\0");
		
		$decrypted = openssl_decrypt( base64_decode($data), "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
		
		return $decrypted;
	}
	
	function tranFields_add( $fieldName, $fieldValue, $tableID, $uTabID = "" ) {
            
            $uTabID = str_replace( "-", "", $uTabID );
            $uTabID = $uTabID;
            
            $userData_ = $this->getUserData();
            $userID_ = $userData_["loginId"];

            //$currentData = array();
            //$currentDataEnc = $this->fileRead( "files/tranFields/" . $userID_ . ".trf" );
                
            //if ( $currentDataEnc != "" ) { $currentData = json_decode( base64_decode( $this->AES256_decrypt($currentDataEnc) ) , true); }

            $currentData = $_SESSION["tranFields"];
            
            $currentData["0"][$fieldName] =  array( "fieldName" => $fieldName, "fieldValue" => $fieldValue, "tableID" => $tableID );

            if ( $uTabID != "" ) {
                $currentData["".$uTabID.""][$fieldName] = array( "fieldName" => $fieldName, "fieldValue" => $fieldValue, "tableID" => $tableID );
            }
            
            $_SESSION["tranFields"] = $currentData;
            
            
            //$this->fileWrite( "files/tranFields/" . $userID_ . ".trf" , $this->AES256_encrypt( base64_encode( json_encode( $currentData ) ) ) );
	}
	
	function tranFields_get( $tranID = 0, $tranIDForce = 0, $uTabID = "", $uTabIDParent = "" ) {
		$uTabID = str_replace( "-", "", $uTabID );
                $uTabIDParent = str_replace( "-", "", $uTabIDParent );
                
                //$userData_ = $this->getUserData();
                //$userID_ = $userData_["loginId"];

                $currentData = array();
		//$currentDataEnc = $this->fileRead( "files/tranFields/" . $userID_ . ".trf" );

                if ( isset($_SESSION["tranFields"]) ) {
                $currentData = $_SESSION["tranFields"];
                }
                
		//if ( $currentDataEnc != "" ) { $currentData = json_decode( base64_decode( $this->AES256_decrypt($currentDataEnc) ), true ); }

		$responseArray = array();
                
                if ( count($currentData) > 0 ) {
                    foreach( $currentData["0"] as $fieldName => $fieldValue ) {
                        $responseArray[$fieldName] = array( "ID" => $fieldValue["fieldValue"], "fieldName" => $fieldValue["fieldName"], "tableID" => $fieldValue["tableID"] );
                    }
                }
                
                
                if ( $uTabID != "" ) {
                    foreach( $currentData as $uTabIDFound => $fields ) {
                        
                        if ( $uTabIDFound != "0" && ( $uTabIDFound == $uTabID ) ) {
                            foreach( $fields as $fieldName => $fieldValue ) {
                                $responseArray[$fieldName] = array( "ID" => $fieldValue["fieldValue"], "fieldName" => $fieldValue["fieldName"], "tableID" => $fieldValue["tableID"] );
                            }
                        }
                    }
                }
                
                if ( $uTabIDParent != "" ) {
                    foreach( $currentData as $uTabIDFound => $fields ) {
                        
                        if ( $uTabIDFound != "0" && ( $uTabIDFound == $uTabIDParent ) ) {
                            foreach( $fields as $fieldName => $fieldValue ) {
                                $responseArray[$fieldName] = array( "ID" => $fieldValue["fieldValue"], "fieldName" => $fieldValue["fieldName"], "tableID" => $fieldValue["tableID"] );
                            }
                        }
                    }
                }
                
                $responseArrayClean = array();
                foreach( $responseArray as $values ) {
                    $responseArrayClean[] = $values;
                }
                

                $ddd = false;
                if ( $ddd ) {
                print_r( $currentData );
                //print_r( $currentData[$tranID] );
                echo "\nTranID : " . $tranID . " >> " . $tranIDForce;
                print_r( $responseArrayClean );
                }
		
                
		return $responseArrayClean;
	}
        
        
        function tranFields_clear( ) {


            
            $_SESSION["tranFields"] = array();
	}
        
        function fileWrite( $fileName, $dataString ) {
            
            $fileOpen = fopen( $fileName, "w") or die("Unable to open file!");
            fwrite( $fileOpen, $dataString);
            fclose( $fileOpen );
        }
        
        function fileRead( $fileName ) {
            $return = "File Not Found";
            if (file_exists($fileName) ) {
                $return = file_get_contents( $fileName );
            }
            return $return;
            
        }


        function soapRequestCURL( $url, $data, $action )
	{
		$handle   = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml; charset=utf-8", 'Accept-Charset: UTF-8', 'SOAPAction: "http://tempuri.org/' . $action . '"'));
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT , 30); 
		curl_setopt($handle, CURLOPT_TIMEOUT, 30);
		//curl_setopt($handle, CURLOPT_SSLVERSION, 2);
		$response = curl_exec($handle);
		if ( $response )
		{
                    if (empty($response)) {
			$response = curl_error($handle) . " : " . curl_errno($handle);
                    }
		}
		else
		{
                    echo "CURL ERROR : " . curl_error($response);
		}
		curl_close($handle);
		 
		return $response;
	}
        
	function requestCURL( $url, $data, $aigapToken )
	{
		$curl_init   = curl_init();
		curl_setopt($curl_init, CURLOPT_URL, $url);
		curl_setopt($curl_init, CURLOPT_HTTPHEADER, Array("Content-Type: application/json; charset=utf-8", 'Accept-Charset: UTF-8', "AigapSupervisorToken:".$aigapToken ));
		curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_init, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl_init, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl_init, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_init, CURLOPT_CONNECTTIMEOUT ,15); 
		curl_setopt($curl_init, CURLOPT_TIMEOUT, 15);
		//curl_setopt($handle, CURLOPT_SSLVERSION, 2);
		$response = curl_exec($curl_init);
		if ( $response )
		{
                    if (empty($response)) {
			$response = curl_error($curl_init) . " : " . curl_errno($curl_init);
                    }
		}
		else
		{
                    echo "CURL ERROR : " . curl_errno($curl_init) . " :: " . curl_error($curl_init);
		}
		curl_close($curl_init);
		 
		return $response;
	}
	
	function getCountryList()
	{
		$return = array();
		
		$fileCountry = file_get_contents( "country.csv" );
		$fileCountry_0 = explode("\n", $fileCountry);
		for( $i = 0; $i < count($fileCountry_0); $i++ )
		{
			if ( $fileCountry_0[$i] != "" )
			{
				$fileCountry_0_ = explode(",", $fileCountry_0[$i]);
				$fileCountry_1_ID = $fileCountry_0_[0];
				$fileCountry_1_name = $fileCountry_0_[1];
				if ( $fileCountry_1_ID != "" && $fileCountry_1_name != "" )
				{
					$return[] = array( "ID" => $fileCountry_1_ID, "name" => $fileCountry_1_name );
				}	
			}
		}
		
		return $return;
	}
	
	function genSignature( $aigapPrivateKey, $aigapPublicKey, $deviceID, $requestDate, $encTypeID, $methodURL, $imei, $deviceTypeID )
	{
		$userData = $this->getUserData();
		$secretKey = "AIGAP_4GHQ46FG9TYDD356B5N8K3GSDHORJRHSBAEOJHPORMDVFFFF01MKO019UU5UO5K4J3MN0LMBG09??!KY69109J19K11NKknv0?!";
			
		$generatedKey = "";

		$generatedKey = $generatedKey.$aigapPublicKey;
		$generatedKey = $generatedKey.$aigapPrivateKey;
		$generatedKey = $generatedKey.$secretKey;
		$generatedKey = $generatedKey.$deviceID;
		$generatedKey = $generatedKey.$requestDate;
		
		$generatedKey = $generatedKey.$encTypeID;
		$generatedKey = $generatedKey.$methodURL;
		$generatedKey = $generatedKey.$this->iCompanyID;
		$generatedKey = $generatedKey.$imei;
		$generatedKey = $generatedKey.$deviceTypeID;
		
		$generatedKey = $generatedKey.$this->appID;
		$generatedKey = $generatedKey.$userData["langCode"];
		$generatedKey = $generatedKey.$userData["loginToken"];
		$generatedKey = $generatedKey.$userData["loginId"];
		$generatedKey = $generatedKey.$this->userTypeID;
                
                $generatedKey1 = "";

		$generatedKey1 = $generatedKey1."aigapPublicKey : ".$aigapPublicKey."<br>";
		$generatedKey1 = $generatedKey1."aigapPrivateKey : ".$aigapPrivateKey."<br>";
		$generatedKey1 = $generatedKey1."secretKey : ".$secretKey."<br>";
		$generatedKey1 = $generatedKey1."deviceID : ".$deviceID."<br>";
		$generatedKey1 = $generatedKey1."requestDate : ".$requestDate."<br>";
		$generatedKey1 = $generatedKey1."encTypeID : ".$encTypeID."<br>";
		$generatedKey1 = $generatedKey1."methodURL : ".$methodURL."<br>";
		$generatedKey1 = $generatedKey1."iCompanyID : ".$this->iCompanyID."<br>";
		$generatedKey1 = $generatedKey1."imei : ".$imei."<br>";
		$generatedKey1 = $generatedKey1."deviceTypeID : ".$deviceTypeID."<br>";
		$generatedKey1 = $generatedKey1."appID : ".$this->appID."<br>";
		$generatedKey1 = $generatedKey1."langCode : ".$userData["langCode"]."<br>";
		$generatedKey1 = $generatedKey1."loginToken : ".$userData["loginToken"]."<br>";
		$generatedKey1 = $generatedKey1."loginId : ".$userData["loginId"]."<br>";
		$generatedKey1 = $generatedKey1."userTypeID : ".$this->userTypeID."<br>";
		                
                //echo "GK >> " . $generatedKey . " >> GK";
                
                //echo "---- Signature ----<br>";
                //echo $generatedKey1;
                //echo "<br>---- Signature ----<br>";
                
		$return_l1 = hash("sha256", $generatedKey);
		$return_l2 = hash("sha256", $return_l1);
		    
		return $return_l1.$return_l2;
	}
        
        function genSignature_en( $aigapPrivateKey, $aigapPublicKey, $deviceID, $requestDate, $encTypeID, $methodURL, $imei, $deviceTypeID )
	{
		$userData = $this->getUserData();
		$secretKey = "AIGAP_4GHQ46FG9TYDD356B5N8K3GSDHORJRHSBAEOJHPORMDVFFFF01MKO019UU5UO5K4J3MN0LMBG09??!KY69109J19K11NKknv0?!";
			
		$generatedKey = "";

		$generatedKey = $generatedKey.$aigapPublicKey;
		$generatedKey = $generatedKey.$aigapPrivateKey;
		$generatedKey = $generatedKey.$secretKey;
		$generatedKey = $generatedKey.$deviceID;
		$generatedKey = $generatedKey.$requestDate;
		
		$generatedKey = $generatedKey.$encTypeID;
		$generatedKey = $generatedKey.$methodURL;
		$generatedKey = $generatedKey.$this->iCompanyID;
		$generatedKey = $generatedKey.$imei;
		$generatedKey = $generatedKey.$deviceTypeID;
		
		$generatedKey = $generatedKey.$this->appID;
		$generatedKey = $generatedKey."en";
		$generatedKey = $generatedKey.$userData["loginToken"];
		$generatedKey = $generatedKey.$userData["loginId"];
		$generatedKey = $generatedKey.$this->userTypeID;
                
                $generatedKey1 = "";

		$generatedKey1 = $generatedKey1."aigapPublicKey : ".$aigapPublicKey."<br>\n";
		$generatedKey1 = $generatedKey1."aigapPrivateKey : ".$aigapPrivateKey."<br>\n";
		$generatedKey1 = $generatedKey1."secretKey : ".$secretKey."<br>\n";
		$generatedKey1 = $generatedKey1."deviceID : ".$deviceID."<br>\n";
		$generatedKey1 = $generatedKey1."requestDate : ".$requestDate."<br>\n";
		$generatedKey1 = $generatedKey1."encTypeID : ".$encTypeID."<br>\n";
		$generatedKey1 = $generatedKey1."methodURL : ".$methodURL."<br>\n";
		$generatedKey1 = $generatedKey1."iCompanyID : ".$this->iCompanyID."<br>\n";
		$generatedKey1 = $generatedKey1."imei : ".$imei."<br>\n";
		$generatedKey1 = $generatedKey1."deviceTypeID : ".$deviceTypeID."<br>\n";
		$generatedKey1 = $generatedKey1."appID : ".$this->appID."<br>\n";
		$generatedKey1 = $generatedKey1."langCode : en<br>\n";
		$generatedKey1 = $generatedKey1."loginToken : ".$userData["loginToken"]."<br>\n";
		$generatedKey1 = $generatedKey1."loginId : ".$userData["loginId"]."<br>\n";
		$generatedKey1 = $generatedKey1."userTypeID : ".$this->userTypeID."<br>\n";
		                
                //echo "GK >> " . $generatedKey . " >> GK";
                
                /*
                echo "---- Signature ----<br>\n";
                echo $generatedKey1;
                echo "<br>\n---- Signature ----<br>\n";
                */
                
		$return_l1 = hash("sha256", $generatedKey);
		$return_l2 = hash("sha256", $return_l1);
		    
		return $return_l1.$return_l2;
	}
	
	function getUserData()
	{
            
		$userDataCookie = $this->getCookieSession("userData_1");
                
                $knownLanguage = "en";

                $langCodeBrowser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                if ( $langCodeBrowser != "" ) {
                    $lancCodeList = array( "en", "tr" );
                    if (in_array( $langCodeBrowser, $lancCodeList) ) { $knownLanguage = $langCodeBrowser; }    
                }
                if ( $this->getCookieSession("langCode") != "" && $this->getCookieSession("langCode") != null && $this->getCookieSession("langCode") != "null" ) { $knownLanguage = $this->getCookieSession("langCode"); }
                                
		if ( $userDataCookie != "" )
		{
			$userDataCookie_Decrypted = $this->AES256_decrypt( $userDataCookie );
			$userDataCookie_Decrypted_array  = json_decode( $userDataCookie_Decrypted, true );
			$userToken = $userDataCookie_Decrypted_array["userToken"];
                        $user = $userDataCookie_Decrypted_array["user"];
                        
                        $user["userID"] = "".$user["userID"]."";
                        
                        //print_r( $userDataCookie_Decrypted_array );
                        
                        if ( $user["userID"] == "" ) { $user["userID"] = "0"; }
						
			$rDataArray = $userDataCookie_Decrypted_array["user"];
			$rDataArray["loginId"] = "".$user["userID"]."";
			$rDataArray["loginToken"] = $userToken["token"];
			$rDataArray["langCode"] = $knownLanguage;
			$rDataArray["companyID"] = $this->companyID;
			$rDataArray["iCompanyID"] = $this->iCompanyID;
			$rDataArray["userTypeID"] = $this->userTypeID;
			$rDataArray["applicationId"] = 1;
                        $rDataArray["activeTranID"] = $userDataCookie_Decrypted_array["activeTranID"];
                        $rDataArray["activeTabID"] = $userDataCookie_Decrypted_array["activeTabID"];
                        $rDataArray["activeFwID"] = $userDataCookie_Decrypted_array["activeFwID"];
			
                        //print_r( $rDataArray );
			return $rDataArray;
		}
		else
		{
			$userDataEmpty = array();
			$userDataEmpty["loginId"] = "0";
                        $userDataEmpty["userID"] = "0";
			$userDataEmpty["loginToken"] = "";
			$userDataEmpty["langCode"] = $knownLanguage;
			$userDataEmpty["companyID"] = $this->companyID;
			$userDataEmpty["iCompanyID"] = $this->iCompanyID;
			$userDataEmpty["userTypeID"] = $this->userTypeID;
			$userDataEmpty["applicationId"] = 1;
                        $rDataArray["activeTranID"] = "-1";
                        $rDataArray["activeTabID"] = "-1";
                        $rDataArray["activeFwID"] = "-1";

					
			return $userDataEmpty;
		}
	}
	
	function gen_serviceDetail( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID )
	{
		$serviceDetail = array(); 
		$serviceDetail["serviceTypeID"] = 2;
		$serviceDetail["protocolID"] = 2;
		$serviceDetail["serviceURL"] = $serviceURL;
		$serviceDetail["soapAction"] = "http://localhost/AigapTransferEngineApi2/";
		$serviceDetail["methodURL"] = $methodURL;
		$serviceDetail["methodTypeID"] = "Post";
		$serviceDetail["privateKey"] = "26da381285394bd3f65fe76890169f48807059ba67c170207b1177aa86be2283";
		$serviceDetail["encTypeID"] = $encTypeID;
		$serviceDetail["apiTypeID"] = $apiTypeID;
		$serviceDetail["algorithmTypeID"] = $algorithmTypeID;
		$serviceDetail["keyID"] = $keyID;
		
		return $serviceDetail;
	}
	
	function gen_publics( $dateTime, $timeZone, $deviceID, $countryID, $deviceIsJailbroken=false )
	{
		$getUserData = $this->getUserData();
                
                if ( $deviceID == "" ) {
                    $deviceID = uniqid(mt_rand(), false);
                    $this->setCookieSession( "browserUID", $deviceID);
                }
                
                $projectID_ = $this->projectID;
                if ( $this->getCookieSession("projectID") != "" ) { $projectID_ = $this->getCookieSession("projectID"); }
                
                $oProjectID_ = $this->oProjectID;
                if ( $this->getCookieSession("oProjectID") != "" ) { $oProjectID_ = $this->getCookieSession("oProjectID"); }
                
                $dreamerID_ = $this->dreamerID;
                if ( $this->getCookieSession("dreamerID") != "" ) { $dreamerID_ = $this->getCookieSession("dreamerID"); }
                
                $developerID_ = $this->developerID;
                if ( $this->getCookieSession("developerID") != "" ) { $developerID_ = $this->getCookieSession("developerID"); }
                		
		$publics = array();
                $publics["userID"] = $getUserData["loginId"];
		$publics["token"] = $getUserData["loginToken"];
		$publics["version"] = "2.0.0";
		$publics["langCode"] = $getUserData["langCode"];
		$publics["companyID"] = $getUserData["companyID"];
		$publics["iCompanyID"] = $getUserData["iCompanyID"];
		$publics["userTypeID"] = $this->userTypeID;
		$publics["tranDateTime"] = $dateTime;
		$publics["appID"] = $this->appID;
		$publics["deviceTypeID"] = $this->deviceTypeID;
		$publics["TZ"] = $timeZone;
		$publics["deviceID"] = $deviceID;
		$publics["IMEI"] = "";
		$publics["countryID"] = $countryID;
		$publics["isRooted"] = $deviceIsJailbroken;
		$publics["platID"] = 1;
		$publics["resolution"] = "320x240@72|1.0";
		$publics["orientation"] = "1";
		$publics["projectID"] = $projectID_;
                $publics["oProjectID"] = $oProjectID_;
                $publics["developerID"] = $developerID_;
                $publics["dreamerID"] = $dreamerID_;
		
		return $publics;
	}
        
        function gen_publics_en( $dateTime, $timeZone, $deviceID, $countryID, $deviceIsJailbroken=false )
	{
		$getUserData = $this->getUserData();
                
                if ( $deviceID == "" ) {
                    $deviceID = uniqid(mt_rand(), false);
                    $this->setCookieSession( "browserUID", $deviceID);
                }
                
                $projectID_ = $this->projectID;
                if ( $this->getCookieSession("projectID") != "" ) { $projectID_ = $this->getCookieSession("projectID"); }
                
                $oProjectID_ = $this->oProjectID;
                if ( $this->getCookieSession("oProjectID") != "" ) { $oProjectID_ = $this->getCookieSession("oProjectID"); }
                
                $dreamerID_ = $this->dreamerID;
                if ( $this->getCookieSession("dreamerID") != "" ) { $dreamerID_ = $this->getCookieSession("dreamerID"); }
                
                $developerID_ = $this->developerID;
                if ( $this->getCookieSession("developerID") != "" ) { $developerID_ = $this->getCookieSession("developerID"); }
                
		
		$publics = array();
                $publics["userID"] = $getUserData["loginId"];
		$publics["token"] = $getUserData["loginToken"];
		$publics["version"] = "2.0.0";
		$publics["langCode"] = "en";
		$publics["companyID"] = $getUserData["companyID"];
		$publics["iCompanyID"] = $getUserData["iCompanyID"];
		$publics["userTypeID"] = $this->userTypeID;
		$publics["tranDateTime"] = $dateTime;
		$publics["appID"] = $this->appID;
		$publics["deviceTypeID"] = $this->deviceTypeID;
		$publics["TZ"] = $timeZone;
		$publics["deviceID"] = $deviceID;
		$publics["IMEI"] = "";
		$publics["countryID"] = $countryID;
		$publics["isRooted"] = $deviceIsJailbroken;
		$publics["platID"] = 1;
		$publics["resolution"] = "320x240@72|1.0";
		$publics["orientation"] = "1";
		$publics["projectID"] = $projectID_;
                $publics["oProjectID"] = $oProjectID_;
                $publics["developerID"] = $developerID_;
                $publics["dreamerID"] = $dreamerID_;
		
		return $publics;
	}
	
	function services_CoreGetTransferEngineApiURL( $serviceURL, $countryID, $langVersion  )
	{
		$countryID = $this->countryID;
		$methodURL = "api/CoreGetTransferEngineApiURL";
		$apiTypeID = "1";
		$publicKey = "AIGAPDJFG45KJDG?!GDFKKKHLtRHSBAEOJHPORMDVFFFF02MKO019UU5UO5MBG09";
		$dateTimeNow = date("Y-m-d H:i:s");
		
		$aigapKey_0 = $this->getAigapKey("0");
		$aigapPrivateKey = $aigapKey_0["privateKey"];
		$aigapPublicKey = $aigapKey_0["publicKey"];
		$encTypeID = $aigapKey_0["encTypeID"];
		$algorithmTypeID = $aigapKey_0["algorithmTypeID"];
		$keyID = $aigapKey_0["keyID"];
		
		$fwID = 0;
                $fwActionTypeID = 0;
                
                if ( $this->firewallURL != "" ) { $serviceURL = $this->firewallURL; }
                if ( $this->firewallPublicKey != "" ) { $publicKey = $this->firewallPublicKey; }
                if ( $this->encTypeID != "" ) { $encTypeID = $this->encTypeID; }
                if ( $this->algorithmTypeID != "" ) { $algorithmTypeID = $this->algorithmTypeID; }
                if ( $this->fwID != "" ) { $fwID = $this->fwID; }
                if ( $this->fwActionTypeID != "" ) { $fwActionTypeID = $this->fwActionTypeID; }
                
		$serviceDetail = $this->gen_serviceDetail ( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID  );
                $browserUID = $this->getCookieSession("browserUID");
		$publics = $this->gen_publics( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		$publics_en = $this->gen_publics_en( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		
		$request = array();
		$request["aigapPublicKey"] = $aigapPublicKey;
		$request["aigapPrivateKey"] = $aigapPrivateKey;
		$request["publicKey"] = $publicKey;
		$request["requestDate"] = $dateTimeNow;
                $request["fwID"] = $fwID;
                $request["fwActionTypeID"] = $fwActionTypeID;
                
		$request["serviceDetail"] = $serviceDetail;
		$request["publics"] = $publics_en;
		
		$jsonData = array();
		foreach( $publics as $key => $value )
		{
			$jsonData[$key] = $value;
		}
		$jsonData["platID"] = 1;
		$jsonData["companyCode"] = "";
		$jsonData["verificationCode"] = "";
		$jsonData["langVersion"] = $langVersion;
                $jsonData["fwID"] = $fwID;
                $jsonData["fwActionTypeID"] = $fwActionTypeID;
		
		$jsonData["publics"] = $publics;
		
		
		$generatedAigapPrivateKey = base64_encode( substr( $aigapPrivateKey, 0, 64 ) );
		$AES256_Key = base64_encode( substr($generatedAigapPrivateKey, 0, 32) );
		$AES256_IV = base64_encode( substr($generatedAigapPrivateKey, 32, 16) );
		
		$jsonDataJson = json_encode( $jsonData );
		$jsonData_encoded = $this->AES256_encrypt( $jsonDataJson, $AES256_Key, $AES256_IV );
		
			
		$request["jsonData"] = $jsonData_encoded;

		
		$requetsJson = json_encode($request);
		
		$signature = $this->genSignature_en( $aigapPrivateKey, $aigapPublicKey, $browserUID, $dateTimeNow, $encTypeID, $methodURL, "", $this->deviceTypeID );
		
		$responseJsonStr = $this->requestCURL( $serviceURL, $requetsJson, $signature ); 
		$responseJson = json_decode( $responseJsonStr, true );
		
		$returnCode = $responseJson["returnCode"];
		$messageID = $returnCode["messageID"];
		$message = $returnCode["message"];
		if ( $messageID == 0 )
		{
			$res_jsonData = $responseJson["jsonData"];
			$res_jsonData_dec = $this->AES256_decrypt( $res_jsonData, $AES256_Key, $AES256_IV );
			$responseJson["jsonDataDecrypted"] = $res_jsonData_dec;
		}
		else
		{
			
		}
                
                //echo json_encode( $publics );
                //echo json_encode( $jsonDataJson );
		//print_r( $requetsJson );
		//print_r( $responseJson );
		
		return $responseJson;

	}
	
	function services_AigapLoginUser( $serviceURL, $countryID, $userName, $password )
	{
		$countryID = $this->countryID;
		$methodURL = "api/AigapLoginUser";
		$apiTypeID = "2";
		$publicKey = "AIGAPDJFG45KJDG?!GDFKKKHLtRHSBAEOJHPORMDVFFFF02MKO019UU5UO5MBG09";
		$dateTimeNow = date("Y-m-d H:i:s");
		
		$aigapKey_0 = $this->getAigapKey("1");
		$aigapPrivateKey = $aigapKey_0["privateKey"];
		$aigapPublicKey = $aigapKey_0["publicKey"];
		$encTypeID = $aigapKey_0["encTypeID"];
		$algorithmTypeID = $aigapKey_0["algorithmTypeID"];
		$keyID = $aigapKey_0["keyID"];
                                
                $fwID = 0;
                $fwActionTypeID = 0;
                
                if ( $this->firewallURL != "" ) { $serviceURL = $this->firewallURL; }
                if ( $this->firewallPublicKey != "" ) { $publicKey = $this->firewallPublicKey; }
                if ( $this->encTypeID != "" ) { $encTypeID = $this->encTypeID; }
                if ( $this->algorithmTypeID != "" ) { $algorithmTypeID = $this->algorithmTypeID; }
                if ( $this->fwID != "" ) { $fwID = $this->fwID; }
                if ( $this->fwActionTypeID != "" ) { $fwActionTypeID = $this->fwActionTypeID; }
		
		$serviceDetail = $this->gen_serviceDetail ( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID  );
                $browserUID = $this->getCookieSession("browserUID");
		$publics = $this->gen_publics( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		$publics_en = $this->gen_publics_en( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		
		$request = array();
		$request["aigapPublicKey"] = $aigapPublicKey;
		$request["aigapPrivateKey"] = $aigapPrivateKey;
		$request["publicKey"] = $publicKey;
		$request["requestDate"] = $dateTimeNow;
                $request["fwID"] = $fwID;
                $request["fwActionTypeID"] = $fwActionTypeID;
			
		$request["serviceDetail"] = $serviceDetail;
		$request["publics"] = $publics_en;
		
		$jsonData = array();
		foreach( $publics as $key => $value )
		{
			$jsonData[$key] = $value;
		}
		$jsonData["platID"] = 1;
		$jsonData["companyCode"] = "";
		$jsonData["verificationCode"] = "";
		$jsonData["langVersion"] = 0;
		$jsonData["userInfo"] = array( "facebookID" => "0", "name" => "", "surname" => "", "GSM" => "", "facebookToken" => "" );
		$jsonData["userName"] = $userName;
		$jsonData["password"] = $password;
		$jsonData["fwID"] = $fwID;
                $jsonData["fwActionTypeID"] = $fwActionTypeID;
                
		$jsonData["publics"] = $publics;
		
    
		
		    /*        jsonData.put("version", global.getVersion());
            jsonData.put("companyID", global.getCompanyIdA());
            jsonData.put("platID", 2);
            jsonData.put("companyCode", "");
            jsonData.put("verificationCode", "");
            jsonData.put("langCode", global.getLanguageCode());
            jsonData.put("userType", global.getUserTypeId());
            jsonData.put("countryID", countryID);
            jsonData.put("tranDateTime", dateTimeNow);
            jsonData.put("langVersion", 0);*/

		
		$generatedAigapPrivateKey = base64_encode( substr( $aigapPrivateKey, 0, 64 ) );
		$AES256_Key = base64_encode( substr($generatedAigapPrivateKey, 0, 32) );
		$AES256_IV = base64_encode( substr($generatedAigapPrivateKey, 32, 16) );
		
		$jsonDataJson = json_encode( $jsonData );
		$jsonData_encoded = $this->AES256_encrypt( $jsonDataJson, $AES256_Key, $AES256_IV );
			
		$request["jsonData"] = $jsonData_encoded;

		
		$requetsJson = json_encode($request);
		
		$signature = $this->genSignature_en( $aigapPrivateKey, $aigapPublicKey, $browserUID, $dateTimeNow, $encTypeID, $methodURL, "", $this->deviceTypeID );
		
		$responseJsonStr = $this->requestCURL( $serviceURL, $requetsJson, $signature ); 
		$responseJson = json_decode( $responseJsonStr, true );
		
		$returnCode = $responseJson["returnCode"];
		$messageID = $returnCode["messageID"];
		$message = $returnCode["message"];
		
		if ( $messageID == 0 )
		{
			$res_jsonData = $responseJson["jsonData"];
			$res_jsonData_dec = $this->AES256_decrypt( $res_jsonData, $AES256_Key, $AES256_IV );
			$responseJson["jsonDataDecrypted"] = $res_jsonData_dec;
		}
		else
		{
			
		}
                
                //echo json_encode( $jsonData );
                //print_r( json_encode($request) );
		//print_r( $requetsJson );
		//print_r( $responseJson );
		
		return $responseJson;

	}
	
        function services_AigapGetTranCategories()
        {
		$serviceUrlList = $this->getServiceUrlList();
		$serviceURL = $serviceUrlList[0];
		$countryID = $this->countryID;
		
		$methodURL = "api/AigapGetTranCategories";
		$apiTypeID = "10";
		$publicKey = "AIGAPDJFG45KJDG?!GDFKKKHLtRHSBAEOJHPORMDVFFFF02MKO019UU5UO5MBG09";
		$dateTimeNow = date("Y-m-d H:i:s");
		
		$aigapKey_1 = $this->getAigapKey("1");
		$aigapPrivateKey = $aigapKey_1["privateKey"];
		$aigapPublicKey = $aigapKey_1["publicKey"];
		$encTypeID = $aigapKey_1["encTypeID"];
		$algorithmTypeID = $aigapKey_1["algorithmTypeID"];
		$keyID = $aigapKey_1["keyID"];
		
		
		$serviceDetail = $this->gen_serviceDetail ( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID  );
                $browserUID = $this->getCookieSession("browserUID");
		$publics = $this->gen_publics( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		
		$request = array();
		$request["aigapPublicKey"] = $aigapPublicKey;
		$request["aigapPrivateKey"] = $aigapPrivateKey;
		$request["publicKey"] = $publicKey;
		$request["requestDate"] = $dateTimeNow;
			
		$request["serviceDetail"] = $serviceDetail;
		$request["publics"] = $publics;
		
		$jsonData = array();
		$jsonData["publics"] = $publics;
		


		
		$generatedAigapPrivateKey = base64_encode( substr( $aigapPrivateKey, 0, 64 ) );
		$AES256_Key = base64_encode( substr($generatedAigapPrivateKey, 0, 32) );
		$AES256_IV = base64_encode( substr($generatedAigapPrivateKey, 32, 16) );
		
		$jsonDataJson = json_encode( $jsonData );
		$jsonData_encoded = $this->AES256_encrypt( $jsonDataJson, $AES256_Key, $AES256_IV );
			
		$request["jsonData"] = $jsonData_encoded;

		
		$requetsJson = json_encode($request);
		
		$signature = $this->genSignature( $aigapPrivateKey, $aigapPublicKey, $browserUID, $dateTimeNow, $encTypeID, $methodURL, "", $this->deviceTypeID );
		
		$responseJsonStr = $this->requestCURL( $serviceURL, $requetsJson, $signature ); 
		$responseJson = json_decode( $responseJsonStr, true );
		
		$returnCode = $responseJson["returnCode"];
		$messageID = $returnCode["messageID"];
		$message = $returnCode["message"];
		
		if ( $messageID == 0 )
		{
			$res_jsonData = $responseJson["jsonData"];
			$res_jsonData_dec = $this->AES256_decrypt( $res_jsonData, $AES256_Key, $AES256_IV );
			$responseJson["jsonDataDecrypted"] = $res_jsonData_dec;
		}
		else
		{
			
		}
		//print_r( $requetsJson );
		//print_r( $responseJson );
		
		return $responseJson;
	}
	
	function services_AigapGetTranTabs( $tranID = 0, $stateID = 1, $ID = "0", $actionTiID = 0, $designPropertyTypeID = 0, $designPropertyID = 0, $tranIDForce = 0, $devRerouteServerApi = array(), $tranCallerTypeID = 0, $uTabID = ""  )
	{
            $timeStart =  date("H:i:s.u");
            
                $serviceUrlList = $this->getServiceUrlList();
                $serviceURL = $serviceUrlList[0];
                $countryID = $this->countryID;
		
                $methodURL = "api/AigapGetTranTabs";
                $apiTypeID = "6";
                $publicKey = "AIGAPDJFG45KJDG?!GDFKKKHLtRHSBAEOJHPORMDVFFFF02MKO019UU5UO5MBG09";
                $dateTimeNow = date("Y-m-d H:i:s");
                
                $aigapKey_1 = $this->getAigapKey("1");
                $aigapPrivateKey = $aigapKey_1["privateKey"];
                $aigapPublicKey = $aigapKey_1["publicKey"];
                $encTypeID = $aigapKey_1["encTypeID"];
                $algorithmTypeID = $aigapKey_1["algorithmTypeID"];
                $keyID = $aigapKey_1["keyID"];
		                                
                $fwID = 0;
                $fwActionTypeID = 0;

                
                if ( $this->firewallURL != "" ) { $serviceURL = $this->firewallURL; }
                if ( $this->firewallPublicKey != "" ) { $publicKey = $this->firewallPublicKey; }
                if ( $this->encTypeID != "" ) { $encTypeID = $this->encTypeID; }
                if ( $this->algorithmTypeID != "" ) { $algorithmTypeID = $this->algorithmTypeID; }
                if ( $this->fwID != "" ) { $fwID = $this->fwID; }
                if ( $this->fwActionTypeID != "" ) { $fwActionTypeID = $this->fwActionTypeID; }
                
                $selectedProjectData = $this->getCookie( "selectedProjectData" );
                if ( $selectedProjectData != "" ) {
                    
                    $selectedProjectDataArray = json_decode( $this->AES256_decrypt( base64_decode( $selectedProjectData ) ), true );
                    
                    foreach( $selectedProjectDataArray as $_field => $_value ) {
                        switch ( $_field ) {
                            case "fwID" : $fwID = $_value; break;
                            case "firewallURL" : $serviceURL = $_value; break;
                            case "firewallPublicKey" : $publicKey = $_value; break;
                            case "encTypeID" : $encTypeID = $_value; break;
                            case "algorithmTypeID" : $algorithmTypeID = $_value; break;
                            case "fwActionTypeID" : $fwActionTypeID = $_value; break;
                            case "developerID" : $this->setDeveloperID( $_value ); break;
                            case "projectID" : $this->setProjectID( $_value ); break;
                            //case "oProjectID" : $this->setOProjectID( $_value ); break;
                            case "companyID" : $this->setCompanyID( $_value ); break;
                            case "iCompanyID" : $this->setICompanyID( $_value ); break;
                            //case "tranID" : $tranID = $_value; break;
                        }
                    }
                }
                
                if ( !empty($devRerouteServerApi) ){
                    if ( count($devRerouteServerApi) > 0 ) {
                        $fwID = $devRerouteServerApi["fwID"];
                        $serviceURL = $devRerouteServerApi["firewallURL"];
                        $publicKey = $devRerouteServerApi["firewallPublicKey"];
                        $encTypeID = $devRerouteServerApi["encTypeID"];
                        $algorithmTypeID = $devRerouteServerApi["algorithmTypeID"];
                        $fwActionTypeID = !empty($devRerouteServerApi["fwActionTypeID"])?$devRerouteServerApi["fwActionTypeID"]:0;
                    }
                }
               
                
		$serviceDetail = $this->gen_serviceDetail ( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID  );
                $browserUID = $this->getCookieSession("browserUID");
		$publics = $this->gen_publics( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		$publics_en = $this->gen_publics_en( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		
		$request = array();
		$request["aigapPublicKey"] = $aigapPublicKey;
		$request["aigapPrivateKey"] = $aigapPrivateKey;
		$request["publicKey"] = $publicKey;
		$request["requestDate"] = $dateTimeNow;
                $request["fwID"] = $fwID;
                $request["fwActionTypeID"] = $fwActionTypeID;
                $request["actionTiID"] = $actionTiID;
			
		$request["serviceDetail"] = $serviceDetail;
		$request["publics"] = $publics_en;
		
		$jsonData = array();
		$jsonData["publics"] = $publics;
		$jsonData["tranID"] = $tranID;
		$jsonData["stateID"] = $stateID;
                $jsonData["fwID"] = $fwID;
                $jsonData["fwActionTypeID"] = $fwActionTypeID;
		$jsonData["oDefault"] = 0;
		$jsonData["tranFields"] = $this->tranFields_get( $tranID, $tranIDForce, $uTabID );
		$jsonData["ID"] = $ID;
                $jsonData["actionTiID"] = $actionTiID;
		$jsonData["tranCallerTypeID"] = $tranCallerTypeID;
		$jsonData["coordinates"] = array( "latitude" => "0.0", "longitude" => "0.0" );
		$jsonData["designPropertyTypeID"] = $designPropertyTypeID;
		$jsonData["designPropertyID"] = $designPropertyID;

		$generatedAigapPrivateKey = base64_encode( substr( $aigapPrivateKey, 0, 64 ) );
		$AES256_Key = base64_encode( substr($generatedAigapPrivateKey, 0, 32) );
		$AES256_IV = base64_encode( substr($generatedAigapPrivateKey, 32, 16) );
		
		$jsonDataJson = json_encode( $jsonData );
		$jsonData_encoded = $this->AES256_encrypt( $jsonDataJson, $AES256_Key, $AES256_IV );
			
		$request["jsonData"] = $jsonData_encoded;

		
		$requetsJson = json_encode($request);
		
		$signature = $this->genSignature_en( $aigapPrivateKey, $aigapPublicKey, $browserUID, $dateTimeNow, $encTypeID, $methodURL, "", $this->deviceTypeID );
		
		$responseJsonStr = $this->requestCURL( $serviceURL, $requetsJson, $signature ); 
		$responseJson = json_decode( $responseJsonStr, true );
		
		$returnCode = $responseJson["returnCode"];
		$messageID = $returnCode["messageID"];
		$message = $returnCode["message"];
		
		if ( $messageID == 0 )
		{
			$res_jsonData = $responseJson["jsonData"];
			$res_jsonData_dec = $this->AES256_decrypt( $res_jsonData, $AES256_Key, $AES256_IV );
			$responseJson["jsonDataDecrypted"] = $res_jsonData_dec;
                                                
                        $jsonData_JSON = json_decode( $res_jsonData_dec, true );
                        

                        if ( !empty($jsonData_JSON["tabs"]) ) {
                            if ( count($jsonData_JSON["tabs"]) > 0 ) {
                                $tabs_ = $jsonData_JSON["tabs"];
                                if (count($tabs_) > 0 ) {
                                    $tabs_0_ = $tabs_[0];
                                    if ( !empty($tabs_0_) ) {
                                        if ( !empty($tabs_0_["tranFields"]) ) {
                                            if( count($tabs_0_["tranFields"]) > 0 ) {
                                                $tranFields_ = $tabs_0_["tranFields"];
                                                foreach( $tranFields_ as $tranFields_row ) {
                                                   $ID_ = $tranFields_row["ID"];
                                                   $fieldName_ = $tranFields_row["fieldName"];
                                                   $tableID_ = $tranFields_row["tableID"];

                                                   $this->tranFields_add( $fieldName_, $ID_, $tableID_, $uTabID);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                        
		}
		else
		{
			
		}
                
                //echo "---- GetTranTabs Full Request ----<br>";
		//echo json_encode($jsonData);
                //echo $requetsJson;
                //echo "<br>---- GetTranTabs Full Request ----<br>";
		//print_r( $jsonDataJson );
		//print_r( $jsonData );
                //echo "<br><br>";
		//echo json_encode( $responseJson );
		                
                $timeEnd = date("H:i:s.u");
                
                $responseJson["performance"]["timeStart"] = $timeStart;
                $responseJson["performance"]["timeEnd"] = $timeEnd;
                
		return $responseJson;
	}
	
	function services_AigapGetTranTabInputs( $tranID = 0, $tabID = 0, $stateID = 1, $ID = 0, $actionTiID = 0, $designPropertyTypeID = 0, $designPropertyID = 0, $tranIDForce = 0, $devRerouteServerApi = array(), $tranCallerTypeID = 0, $uTabID = "", $forceFwID = "0", $eventActionTypeID = 0, $eventActionID = 0, $referFwID = "0", $activeData = array() )
	{
            
            $timeStart = date("H:i:s.u");
            
                $serviceUrlList = $this->getServiceUrlList();
                $serviceURL = $serviceUrlList[0];
                $countryID = $this->countryID;

                $methodURL = "api/AigapGetTranTabInputs";
                $apiTypeID = "7";
                $publicKey = "AIGAPDJFG45KJDG?!GDFKKKHLtRHSBAEOJHPORMDVFFFF02MKO019UU5UO5MBG09";
                $dateTimeNow = date("Y-m-d H:i:s");

                $aigapKey_1 = $this->getAigapKey("1");
                $aigapPrivateKey = $aigapKey_1["privateKey"];
                $aigapPublicKey = $aigapKey_1["publicKey"];
                $encTypeID = $aigapKey_1["encTypeID"];
                $algorithmTypeID = $aigapKey_1["algorithmTypeID"];
                $keyID = $aigapKey_1["keyID"];
		
                $fwID = 0;
                $fwActionTypeID = 0;

                if ( $this->firewallURL != "" ) { $serviceURL = $this->firewallURL; }
                if ( $this->firewallPublicKey != "" ) { $publicKey = $this->firewallPublicKey; }
                if ( $this->encTypeID != "" ) { $encTypeID = $this->encTypeID; }
                if ( $this->algorithmTypeID != "" ) { $algorithmTypeID = $this->algorithmTypeID; }
                if ( $this->fwID != "" ) { $fwID = $this->fwID; }
                if ( $this->fwActionTypeID != "" ) { $fwActionTypeID = $this->fwActionTypeID; }
                
                if ( $forceFwID != "0" ) {
                    $fwID = $forceFwID;
                }
                
                $selectedProjectData = $this->getCookie( "selectedProjectData" );
                if ( $selectedProjectData != "" ) {
                    
                    $selectedProjectDataArray = json_decode( $this->AES256_decrypt( base64_decode( $selectedProjectData ) ), true );
                    //echo json_encode( $selectedProjectDataArray)."\n\n";

                    foreach( $selectedProjectDataArray as $_field => $_value ) {
                        switch ( $_field ) {
                            case "fwID" : $fwID = $_value; break;
                            case "firewallURL" : $serviceURL = $_value; break;
                            case "firewallPublicKey" : $publicKey = $_value; break;
                            case "encTypeID" : $encTypeID = $_value; break;
                            case "algorithmTypeID" : $algorithmTypeID = $_value; break;
                            case "fwActionTypeID" : $fwActionTypeID = $_value; break;
                            case "developerID" : $this->setDeveloperID( $_value ); break;
                            case "projectID" : $this->setProjectID( $_value ); break;
                            //case "oProjectID" : $this->setOProjectID( $_value ); break;
                            case "companyID" : $this->setCompanyID( $_value ); break;
                            case "iCompanyID" : $this->setICompanyID( $_value ); break;
                            //case "tranID" : $tranID = $_value; break;
                        }
                    }
                }
                
                //$this->setProjectID( "100000100000000032" );
                //$this->setOProjectID( "100000100000000032" );
                
                if ( !empty($devRerouteServerApi) ){
                    if ( count($devRerouteServerApi) > 0 ) {
                        $fwID = $devRerouteServerApi["fwID"];
                        $serviceURL = $devRerouteServerApi["firewallURL"];
                        $publicKey = $devRerouteServerApi["firewallPublicKey"];
                        $encTypeID = $devRerouteServerApi["encTypeID"];
                        $algorithmTypeID = $devRerouteServerApi["algorithmTypeID"];
                        $fwActionTypeID = !empty($devRerouteServerApi["fwActionTypeID"])?$devRerouteServerApi["fwActionTypeID"]:0;
                    }
                }
                
                $activeTranID = "0";
                if ( !empty($activeData) ) {
                    if ( count($activeData) > 0 ) {
                        $tranID = $activeData["activeTranID"];
                    }
                }

                
		$serviceDetail = $this->gen_serviceDetail ( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID  );
                $browserUID = $this->getCookieSession("browserUID");
		$publics = $this->gen_publics( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		$publics_en = $this->gen_publics_en( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
                
		$request = array();
		$request["aigapPublicKey"] = $aigapPublicKey;
		$request["aigapPrivateKey"] = $aigapPrivateKey;
		$request["publicKey"] = $publicKey;
		$request["requestDate"] = $dateTimeNow;
                $request["fwID"] = $fwID;
                $request["fwActionTypeID"] = $fwActionTypeID;
			
		$request["serviceDetail"] = $serviceDetail;
		$request["publics"] = $publics_en;
		
		$jsonData = array();
		$jsonData["publics"] = $publics;
		$jsonData["tranID"] = $tranID;
                $jsonData["referFwID"] = $referFwID;
		$jsonData["tabID"] = $tabID;
		$jsonData["stateID"] = $stateID;
                $jsonData["fwID"] = $fwID;
                $jsonData["fwActionTypeID"] = $fwActionTypeID;
		$jsonData["oDefault"] = 0;
		$jsonData["tranFields"] = $this->tranFields_get( $tranID, $tranIDForce, $uTabID );
		$jsonData["tabInputs"] = array();
		$jsonData["ID"] = $ID;
		$jsonData["tranCallerTypeID"] = $tranCallerTypeID;
		$jsonData["actionTiID"] = $actionTiID;
		$jsonData["coordinates"] = array( "latitude" => "0.0", "longitude" => "0.0" );
		$jsonData["designPropertyTypeID"] = $designPropertyTypeID;
		$jsonData["designPropertyID"] = $designPropertyID;
                $jsonData["eventActionTypeID"] = $eventActionTypeID;
                $jsonData["eventActionID"] = $eventActionID;
		

		

		$generatedAigapPrivateKey = base64_encode( substr( $aigapPrivateKey, 0, 64 ) );
		$AES256_Key = base64_encode( substr($generatedAigapPrivateKey, 0, 32) );
		$AES256_IV = base64_encode( substr($generatedAigapPrivateKey, 32, 16) );
		
		$jsonDataJson = json_encode( $jsonData );
		$jsonData_encoded = $this->AES256_encrypt( $jsonDataJson, $AES256_Key, $AES256_IV );
			
		$request["jsonData"] = $jsonData_encoded;

		
		$requetsJson = json_encode($request);
		
		$signature = $this->genSignature_en( $aigapPrivateKey, $aigapPublicKey, $browserUID, $dateTimeNow, $encTypeID, $methodURL, "", $this->deviceTypeID );
		
		$responseJsonStr = $this->requestCURL( $serviceURL, $requetsJson, $signature ); 
		$responseJson = json_decode( $responseJsonStr, true );
		
		$returnCode = $responseJson["returnCode"];
		$messageID = $returnCode["messageID"];
		$message = $returnCode["message"];
		
		if ( $messageID == 0 )
		{
			$res_jsonData = $responseJson["jsonData"];
			$res_jsonData_dec = $this->AES256_decrypt( $res_jsonData, $AES256_Key, $AES256_IV );
			$responseJson["jsonDataDecrypted"] = $res_jsonData_dec;
                        
                         $jsonData_JSON = json_decode( $res_jsonData_dec, true );
                         if ( !empty($jsonData_JSON["tranFields"]) ) {
                             if( count($jsonData_JSON["tranFields"]) > 0 ) {
                                 $tranFields_ = $jsonData_JSON["tranFields"];
                                 foreach( $tranFields_ as $tranFields_row ) {
                                    $ID_ = $tranFields_row["ID"];
                                    $fieldName_ = $tranFields_row["fieldName"];
                                    $tableID_ = $tranFields_row["tableID"];
                                    
                                    $this->tranFields_add( $fieldName_, $ID_, $tableID_, $uTabID);
                                 }
                             }
                         }

		}
		else
		{
			
		}
                
                //print_r( $jsonData );
                //echo "ServiceURL : " . $serviceURL;
                //print_r($devRerouteServerApi );
                //print_r( json_encode($jsonData) );
		//echo $requetsJson."\n\n";
		//print_r( $responseJson );
		
                $timeEnd = date("H:i:s.u");
                
                $responseJson["performance"]["timeStart"] = $timeStart;
                $responseJson["performance"]["timeEnd"] = $timeEnd;
                
		return $responseJson;
	}
	
	function services_AigapGetClaim( $searchText = "", $lastID = 0, $lastGroupID = 0, $limit = 0, $claimID = 0, $tiID = 0, $ID = 0, $tranID = 0, $actionTranID = 0, $parameterTemplate = "", $parameterTemplateDelete = "", $tranIDForce = 0, $devRerouteServerApi = array(), $uTabID = "", $eventActionTypeID = 0 )
	{
                $serviceUrlList = $this->getServiceUrlList();
                $serviceURL = $serviceUrlList[0];
                $countryID = $this->countryID;

                $methodURL = "api/AigapGetClaim";
                $apiTypeID = "8";
                $publicKey = "AIGAPDJFG45KJDG?!GDFKKKHLtRHSBAEOJHPORMDVFFFF02MKO019UU5UO5MBG09";
                $dateTimeNow = date("Y-m-d H:i:s");

                $aigapKey_1 = $this->getAigapKey("1");
                $aigapPrivateKey = $aigapKey_1["privateKey"];
                $aigapPublicKey = $aigapKey_1["publicKey"];
                $encTypeID = $aigapKey_1["encTypeID"];
                $algorithmTypeID = $aigapKey_1["algorithmTypeID"];
                $keyID = $aigapKey_1["keyID"];
                
                $fwID = 0;
                $fwActionTypeID = 0;
                
                                
                if ( $this->firewallURL != "" ) { $serviceURL = $this->firewallURL; }
                if ( $this->firewallPublicKey != "" ) { $publicKey = $this->firewallPublicKey; }
                if ( $this->encTypeID != "" ) { $encTypeID = $this->encTypeID; }
                if ( $this->algorithmTypeID != "" ) { $algorithmTypeID = $this->algorithmTypeID; }
                if ( $this->fwID != "" ) { $fwID = $this->fwID; }
                if ( $this->fwActionTypeID != "" ) { $fwActionTypeID = $this->fwActionTypeID; }
                
                $selectedProjectData = $this->getCookie( "selectedProjectData" );
                if ( $selectedProjectData != "" ) {
                    
                    $selectedProjectDataArray = json_decode( $this->AES256_decrypt( base64_decode( $selectedProjectData ) ), true );
                    
                    foreach( $selectedProjectDataArray as $_field => $_value ) {
                        switch ( $_field ) {
                            case "fwID" : $fwID = $_value; break;
                            case "firewallURL" : $serviceURL = $_value; break;
                            case "firewallPublicKey" : $publicKey = $_value; break;
                            case "encTypeID" : $encTypeID = $_value; break;
                            case "algorithmTypeID" : $algorithmTypeID = $_value; break;
                            case "fwActionTypeID" : $fwActionTypeID = $_value; break;
                            case "developerID" : $this->setDeveloperID( $_value ); break;
                            case "projectID" : $this->setProjectID( $_value ); break;
                            //case "oProjectID" : $this->setOProjectID( $_value ); break;
                            case "companyID" : $this->setCompanyID( $_value ); break;
                            case "iCompanyID" : $this->setICompanyID( $_value ); break;
                            //case "tranID" : $tranID = $_value; break;
                        }
                    }
                }
                
                if ( !empty($devRerouteServerApi) ){
                    if ( count($devRerouteServerApi) > 0 ) {
                        $fwID = $devRerouteServerApi["fwID"];
                        $serviceURL = $devRerouteServerApi["firewallURL"];
                        $publicKey = $devRerouteServerApi["firewallPublicKey"];
                        $encTypeID = $devRerouteServerApi["encTypeID"];
                        $algorithmTypeID = $devRerouteServerApi["algorithmTypeID"];
                        $fwActionTypeID = $devRerouteServerApi["fwActionTypeID"];
                    }
                }
                
		$serviceDetail = $this->gen_serviceDetail ( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID  );
                $browserUID = $this->getCookieSession("browserUID");
		$publics = $this->gen_publics( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		$publics_en = $this->gen_publics_en( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
		
		$request = array();
		$request["aigapPublicKey"] = $aigapPublicKey;
		$request["aigapPrivateKey"] = $aigapPrivateKey;
		$request["publicKey"] = $publicKey;
		$request["requestDate"] = $dateTimeNow;
			
		$request["serviceDetail"] = $serviceDetail;
		$request["publics"] = $publics_en;
		
		$jsonData = array();
		$jsonData["publics"] = $publics;
		
                $jsonData["fwID"] = $fwID;
                $jsonData["fwActionTypeID"] = $fwActionTypeID;
                $jsonData["eventActionTypeID"] = $eventActionTypeID;
                
		$filterParams = array();
		$filterParams["letters"] = $searchText;
		$filterParams["actionType"] = 1;
		$filterParams["firstID"] = 0;
		$filterParams["lastID"] = $lastID;
		$filterParams["range"] = $limit;
		$filterParams["ID"] = $ID;
		$filterParams["tranID"] = $tranID;
		$filterParams["tiID"] = $tiID;
		$filterParams["claimID"] = $claimID;
		$filterParams["sensibility"] = 0;
		$filterParams["lastGroupID"] = $lastGroupID;
                $filterParams["fwID"] = $fwID;
		$filterParams["coordinates"] = array( "latitude" => "0.0", "longitude" => "0.0", "name" => "", "title" => "" );
		
		$jsonData["filterParams"] = $filterParams;
		
		$jsonData["tranFields"] = $this->tranFields_get( $tranID, $tranIDForce, $uTabID );
		$jsonData["tabInputs"] = array();

		$generatedAigapPrivateKey = base64_encode( substr( $aigapPrivateKey, 0, 64 ) );
		$AES256_Key = base64_encode( substr($generatedAigapPrivateKey, 0, 32) );
		$AES256_IV = base64_encode( substr($generatedAigapPrivateKey, 32, 16) );
		
		$jsonDataJson = json_encode( $jsonData );
		$jsonData_encoded = $this->AES256_encrypt( $jsonDataJson, $AES256_Key, $AES256_IV );
			
		$request["jsonData"] = $jsonData_encoded;

		
		$requetsJson = json_encode($request);
		
		$signature = $this->genSignature_en( $aigapPrivateKey, $aigapPublicKey, $browserUID, $dateTimeNow, $encTypeID, $methodURL, "", $this->deviceTypeID );

                //echo json_encode( $requetsJson )."<br><br>";
		
		$responseJsonStr = $this->requestCURL( $serviceURL, $requetsJson, $signature ); 
		$responseJson = json_decode( $responseJsonStr, true );
		
		$returnCode = $responseJson["returnCode"];
		$messageID = $returnCode["messageID"];
		$message = $returnCode["message"];
		
		if ( $messageID == 0 )
		{
			$res_jsonData = $responseJson["jsonData"];
			$res_jsonData_dec = $this->AES256_decrypt( $res_jsonData, $AES256_Key, $AES256_IV );
			
			$res_jsonData_dec_json = json_decode( $res_jsonData_dec, true );
			
			foreach( $res_jsonData_dec_json["claimData"] as $key => $value ) {

				$res_jsonData_dec_json["claimData"][$key]["actionURL"] = null;
				$res_jsonData_dec_json["claimData"][$key]["deleteURL"] = null;
				
				$ID_ = $res_jsonData_dec_json["claimData"][$key]["ID"];
				
				if ( $parameterTemplate != "" )
				{
					$actionURLTemplate = base64_decode( $parameterTemplate );
					$actionURLTemplate = str_replace("[[ID]]", $ID_, $actionURLTemplate);
					$actionURLTemplate = str_replace("[[TRANID_TO_ID]]", $ID_, $actionURLTemplate);
					$res_jsonData_dec_json["claimData"][$key]["actionURL"] = "tran.tabs.php?parameters=".base64_encode($actionURLTemplate);
				}

				if ( $parameterTemplateDelete != "" )
				{
					$deleteURLTemplate = base64_decode( $parameterTemplateDelete );
					$deleteURLTemplate = str_replace("[[ID]]", $ID_, $deleteURLTemplate);
					$deleteURLTemplate = str_replace("[[TRANID_TO_ID]]", $ID_, $deleteURLTemplate);
					$res_jsonData_dec_json["claimData"][$key]["deleteURL"] = "tran.save.async.php?deleteParameters=".base64_encode($deleteURLTemplate)."&editID=".$ID_."&tranID=".$actionTranID."&stateID=3";
				}
				
			}
			
			$res_jsonData_dec = json_encode( $res_jsonData_dec_json );
			
			$responseJson["jsonDataDecrypted"] = $res_jsonData_dec;
		}
		else
		{
			
		}
		
                //echo json_encode( $jsonData );
		//print_r( $jsonDataJson );
		//echo $requetsJson;
		//echo json_encode( $responseJson );
		
		return $responseJson;
	}
	
	function services_AigapExecuteTranTabInputs( $tranID = 0, $tabID = 0, $stateID = 1, $ID = 0, $actionTiID = 0, $tabInputs = array(), $designPropertyTypeID = 0, $designPropertyID = 0, $tranIDForce = 0, $devRerouteServerApi = array(), $uTabID = "", $uTabIDParent = "", $activeTabID = 0  )
	{
            $serviceUrlList = $this->getServiceUrlList();
            $serviceURL = $serviceUrlList[0];
            $countryID = $this->countryID;

            $methodURL = "api/AigapExecuteTranTabInputs";
            $apiTypeID = "9";
            $publicKey = "AIGAPDJFG45KJDG?!GDFKKKHLtRHSBAEOJHPORMDVFFFF02MKO019UU5UO5MBG09";
            $dateTimeNow = date("Y-m-d H:i:s");

            $aigapKey_1 = $this->getAigapKey("1");
            $aigapPrivateKey = $aigapKey_1["privateKey"];
            $aigapPublicKey = $aigapKey_1["publicKey"];
            $encTypeID = $aigapKey_1["encTypeID"];
            $algorithmTypeID = $aigapKey_1["algorithmTypeID"];
            $keyID = $aigapKey_1["keyID"];

            $fwID = 0;
            $fwActionTypeID = 1;
                                
            if ( $this->firewallURL != "" ) { $serviceURL = $this->firewallURL; }
            if ( $this->firewallPublicKey != "" ) { $publicKey = $this->firewallPublicKey; }
            if ( $this->encTypeID != "" ) { $encTypeID = $this->encTypeID; }
            if ( $this->algorithmTypeID != "" ) { $algorithmTypeID = $this->algorithmTypeID; }
            if ( $this->fwID != "" ) { $fwID = $this->fwID; }
            if ( $this->fwActionTypeID != "" ) { $fwActionTypeID = $this->fwActionTypeID; }

            $selectedProjectData = $this->getCookie( "selectedProjectData" );
                if ( $selectedProjectData != "" ) {
                    
                    $selectedProjectDataArray = json_decode( $this->AES256_decrypt( base64_decode( $selectedProjectData ) ), true );
                    
                    foreach( $selectedProjectDataArray as $_field => $_value ) {
                        switch ( $_field ) {
                            case "fwID" : $fwID = $_value; break;
                            case "firewallURL" : $serviceURL = $_value; break;
                            case "firewallPublicKey" : $publicKey = $_value; break;
                            case "encTypeID" : $encTypeID = $_value; break;
                            case "algorithmTypeID" : $algorithmTypeID = $_value; break;
                            case "fwActionTypeID" : $fwActionTypeID = $_value; break;
                            case "developerID" : $this->setDeveloperID( $_value ); break;
                            case "projectID" : $this->setProjectID( $_value ); break;
                            //case "oProjectID" : $this->setOProjectID( $_value ); break;
                            case "companyID" : $this->setCompanyID( $_value ); break;
                            case "iCompanyID" : $this->setICompanyID( $_value ); break;
                            //case "tranID" : $tranID = $_value; break;
                        }
                    }
                }
                
            if ( !empty($devRerouteServerApi) ){
                if ( count($devRerouteServerApi) > 0 ) {
                    $fwID = $devRerouteServerApi["fwID"];
                    $serviceURL = $devRerouteServerApi["firewallURL"];
                    $publicKey = $devRerouteServerApi["firewallPublicKey"];
                    $encTypeID = $devRerouteServerApi["encTypeID"];
                    $algorithmTypeID = $devRerouteServerApi["algorithmTypeID"];
                    $fwActionTypeID = $devRerouteServerApi["fwActionTypeID"];
                }
            }
            
            

            $serviceDetail = $this->gen_serviceDetail ( $serviceURL, $methodURL, $encTypeID, $algorithmTypeID, $keyID, $apiTypeID  );
            $browserUID = $this->getCookieSession("browserUID");
            $publics = $this->gen_publics( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );
            $publics_en = $this->gen_publics_en( $dateTimeNow, "Europe/Istanbul", $browserUID, $countryID, false );

            $request = array();
            $request["aigapPublicKey"] = $aigapPublicKey;
            $request["aigapPrivateKey"] = $aigapPrivateKey;
            $request["publicKey"] = $publicKey;
            $request["requestDate"] = $dateTimeNow;

            $request["serviceDetail"] = $serviceDetail;
            $request["publics"] = $publics_en;

            $jsonData = array();
            $jsonData["publics"] = $publics;
            $jsonData["tranID"] = $tranID;
            $jsonData["activeTabID"] = $activeTabID;
            $jsonData["stateID"] = $stateID;
            $jsonData["ID"] = $ID;
            $jsonData["fwID"] = $fwID;
            $jsonData["fwActionTypeID"] = $fwActionTypeID;
            $jsonData["designPropertyTypeID"] = $designPropertyTypeID;
            $jsonData["designPropertyID"] = $designPropertyID;

            $jsonData["tranFields"] = $this->tranFields_get( $tranID, $tranIDForce, $uTabID, $uTabIDParent );
            $jsonData["tabInputs"] = $tabInputs;
            $jsonData["actionTiID"] = $actionTiID;




            $generatedAigapPrivateKey = base64_encode( substr( $aigapPrivateKey, 0, 64 ) );
            $AES256_Key = base64_encode( substr($generatedAigapPrivateKey, 0, 32) );
            $AES256_IV = base64_encode( substr($generatedAigapPrivateKey, 32, 16) );

            $jsonDataJson = json_encode( $jsonData );
            $jsonData_encoded = $this->AES256_encrypt( $jsonDataJson, $AES256_Key, $AES256_IV );

            $request["jsonData"] = $jsonData_encoded;


            $requetsJson = json_encode($request);

            $signature = $this->genSignature_en( $aigapPrivateKey, $aigapPublicKey, $browserUID, $dateTimeNow, $encTypeID, $methodURL, "", $this->deviceTypeID );

            $responseJsonStr = $this->requestCURL( $serviceURL, $requetsJson, $signature ); 
            $responseJson = json_decode( $responseJsonStr, true );

            $returnCode = $responseJson["returnCode"];
            $messageID = $returnCode["messageID"];
            $message = $returnCode["message"];

            if ( $messageID == 0 )
            {
                    $res_jsonData = $responseJson["jsonData"];
                    $res_jsonData_dec = $this->AES256_decrypt( $res_jsonData, $AES256_Key, $AES256_IV );
                    $responseJson["jsonDataDecrypted"] = $res_jsonData_dec;
            }
            else
            {

            }
            
            //echo $uTabID . " >> " . $uTabIDParent;

            //print_r( json_encode( $jsonData ) );
            //echo "\n";
            //print_r( $jsonDataJson );
            //print_r( $requetsJson );
            //print_r( $responseJson );
            

            return $responseJson;
	}
	
        function getLanguageFileArray( $screenIDs = array( 0 ), $langCode = "en" ) {
            
            if ( $langCode == "" ) { $langCode = $this->getCookie("langCode"); }
            
            $languageArray = array();

            if (file_exists("files/languages/".$langCode.".json") ) {
                $languageFile = file_get_contents( "files/languages/".$langCode.".json" );
                $languageFileArray = json_decode( $languageFile , true );

                foreach ( $languageFileArray as $id_ => $value_ ) {
                    if ( $id_== 68 || $id_ == 69 || in_array( $id_, $screenIDs) ) {
                        foreach( $value_ as $id__ => $value__ ) {
                            $languageArray[$id__] = $value__;
                        }
                    }
                }
            }

            return $languageArray;
        }
        
	function getLanguageValue( $a, $b  = "tr", $screenID = 0 ) {
            
            if ( $b == "" ) { $b = $this->getCookie("langCode"); }
            
            $return = "{{" . $a . " - " . $b . "}}";
            
            $languageArray = $this->getLanguageFileArray( array(0), $b );
            
            if ( isset($languageArray[$a]) ) {
                $return = $languageArray[$a];
            }
            
            return $return;
	}
	
	function redirectLogin() {
		header("Location: login.php");
		exit();
	}
	
	function generateToken() {
		
		$token = uniqid(mt_rand(), true);
		$this->sessionAddToken( $token );
		
		return $token;
	}
	
	function sessionAddToken( $token ) {
		
		if ( $this->getSession("token") != "" ) {
			$tokenArray = unserialize( $this->getSession("token") );
			$this->setSession( "token", serialize($tokenArray) );
		}
		else {
			$tokenArray = array();
			$tokenArray[] = $token;
			$this->setSession( "token", serialize($tokenArray) );
		}
		
	}
	
	function sessionGetTokens() {
		
		$tokenArray = array();
		if ( $this->getSession("token") != "" ) {
			$tokenArray = unserialize( $this->getSession("token") );
		}
		return $tokenArray;

	}
	
	function sessionCheckToken( $token ) {
		
		$return = false;
		if ( $this->getSession("token") != "" ) {
			$tokenArray = unserialize( $this->getSession("token") );
			foreach( $tokenArray as $_index => $_token ) {
				if ( $token == $_token ) {
					$return = true;
				}
			}
		}
		
		return $return;
	}
        
        function UploadImage( $imageServiceURL, $imageParameters = array() )
	{
		$return = new stdClass();
		
		//$url = $this->getSession("companyURL");
		$url = $imageServiceURL;
		$url = str_replace(".asmx","Json.asmx", $url);
		
		
		$xmlHeader = "UploadImage";
		$currentDate =  date('Y-m-d')."T".date('H:i:s.000');
		
		$languageCode = $this->getSession("languageCodeSel");
		
		$imageFormat = explode(",",$imageParameters["imageFormat"]);
                
                $getUserData = $this->getUserData();
		
		$xmlStr = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xmlStr .= "<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\n";
		$xmlStr .= "<soap:Body>\n";
		$xmlStr .= "<".$xmlHeader." xmlns=\"http://tempuri.org/\">\n";
		$xmlStr .= "<request>\n";
		$xmlStr .= "<publics>\n";
		$xmlStr .= "<userID>".$getUserData["loginId"]."</userID>\n";
		$xmlStr .= "<token>".$getUserData["loginToken"]."</token>\n";
		$xmlStr .= "<version>1</version>\n";
		$xmlStr .= "<langCode>".$getUserData["langCode"]."</langCode>\n";
		$xmlStr .= "<companyID>".$getUserData["companyID"]."</companyID>\n";
		$xmlStr .= "<iCompanyID>".$getUserData["iCompanyID"]."</iCompanyID>\n";
		$xmlStr .= "<userType>" . $this->getCookie("userType") . "</userType>\n";
		$xmlStr .= "<tranDateTime>".$currentDate."</tranDateTime>\n";
		$xmlStr .= "<lVersion>0</lVersion>\n";
		$xmlStr .= "<appID>0</appID>\n";
		$xmlStr .= "<deviceTypeID>4</deviceTypeID>\n";
		$xmlStr .= "</publics>\n";
		$xmlStr .= "<image>\n";
		$xmlStr .= "<imagePath>".$imageParameters["imagePath"]."</imagePath>\n";
		$xmlStr .= "<type></type>\n";
		$xmlStr .= "<imageURL>".$imageParameters["imageURL"]."</imageURL>\n";
		$xmlStr .= "<image>".$imageParameters["imageBinary"]."</image>\n";
		$xmlStr .= "<width>".$imageFormat[0]."</width>\n";
		$xmlStr .= "<height>".$imageFormat[1]."</height>\n";
		$xmlStr .= "<userType>" . $this->getCookie("userType") . "</userType>\n";
		$xmlStr .= "<tiID>".$imageParameters["tiID"]."</tiID>\n";
		$xmlStr .= "<imageID>".$imageParameters["imageID"]."</imageID>\n";
		$xmlStr .= "<uploaderURL>".$imageParameters["uploaderURL"]."</uploaderURL>\n";
		$xmlStr .= "<actionTypeID>".$imageParameters["actionTypeID"]."</actionTypeID>\n";
		$xmlStr .= "<imageTypeID>".$imageParameters["imageTypeID"]."</imageTypeID>\n";
		$xmlStr .= "<counter>0</counter>\n";
		$xmlStr .= "</image>\n";
		$xmlStr .= "</request>\n";
		$xmlStr .= "</".$xmlHeader.">\n";
		$xmlStr .= "</soap:Body>\n";
		$xmlStr .= "</soap:Envelope>\n";
		
				
		$responseJsonStr = $this->soapRequestCURL( $url, $xmlStr, $xmlHeader );
		//echo $responseJsonStr;
		$responseJson = json_decode( $responseJsonStr );
		
		$message = $responseJson->returnCode->message;
		$messageID = $responseJson->returnCode->messageID;
			
		$return->messageID = $messageID;
		$return->message = $message;
			
		
		if ( $messageID == 0 )
		{
                    $return->request = $xmlStr;
		}
		
		return $return;
	}
        
        function extToFileType( $ext ) {
	
            if ( $ext == "mp4" || $ext == "3gp" || $ext == "mpg" || $ext == "mpeg" || $ext == "divx" || $ext == "avi" || $ext == "ra" ) {
                    return "VIDEO";
            }
            else if ( $ext == "png" || $ext == "jpg" || $ext == "jpeg" || $ext == "gif" || $ext == "tiff" || $ext == "bmp" ) {
                    return "IMAGE";
            }
            else if ( $ext == "pdf" ) {
                    return "PDF";
            }

        }
	
        function flatColors( $colorID )
	{
		$colorList = array();
		$colorList[] = "#55efc4";
		$colorList[] = "#81ecec";
		$colorList[] = "#74b9ff";
		$colorList[] = "#a29bfe";
		$colorList[] = "#ffeaa7";
		$colorList[] = "#fab1a0";
		$colorList[] = "#ff7675";
		$colorList[] = "#fd79a8";
		$colorList[] = "#00b894";
		$colorList[] = "#00cec9";
		$colorList[] = "#0984e3";
		$colorList[] = "#6c5ce7";
		$colorList[] = "#fdcb6e";
		$colorList[] = "#e17055";
		$colorList[] = "#d63031";
		$colorList[] = "#e84393";
		
		return $colorID > count($colorList)? $colorList[rand(0,count($colorList))]:$colorList[$colorID];
	}
        
        function reCaptchaVerify( $serverKey, $token ) {

            $curlCaptcha = curl_init();
            curl_setopt($curlCaptcha, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($curlCaptcha, CURLOPT_POST, 1);
            curl_setopt($curlCaptcha, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $serverKey, 'response' => $token)));
            curl_setopt($curlCaptcha, CURLOPT_RETURNTRANSFER, true);
            $responseCaptcha = curl_exec($curlCaptcha);
            curl_close($curlCaptcha);
            $arrayCaptcha = json_decode($responseCaptcha, true);
            
            return $arrayCaptcha;
        }
        
        function postFormInternal( $url, $postArray ) {


            $postString = http_build_query($postArray);

            $curlInternal = curl_init();

            curl_setopt( $curlInternal, CURLOPT_URL, $url);
            curl_setopt( $curlInternal ,CURLOPT_POST, true);
            curl_setopt( $curlInternal ,CURLOPT_POSTFIELDS, $postString);

            curl_setopt( $curlInternal,CURLOPT_RETURNTRANSFER, true); 

            $result = curl_exec( $curlInternal);
            echo $result;
        }
        
        function genereteView( $orientation, $viewData ) {
                
                $viewTypeID__[1] = '<div style="[{STYLE_S1}]">[{TEXT_S1}]</div>';
                $viewTypeID__[2] = '<div style="[{STYLE_S1}]"><div class="42-button" style="[{STYLE_S2}]">[{TEXT_S1}]</div></div>';
                $viewTypeID__[3] = '<div style="[{STYLE_S1}]"><div class="42-button" style="[{STYLE_S2}]"><img src="[{IMAGE_S1}]" style="style="[{STYLE_S2}]" width="30"/></div></div>';
                $viewTypeID__[4] = '<div style="[{STYLE_S1}]"><img src="[{IMAGE_S1}]" style="[{STYLE_S2}]" width="30"/> [{TEXT_S1}]</div>';
                $viewTypeID__[5] = '<div style="[{STYLE_S1}]"><img src="[{IMAGE_S1}]" style="[{STYLE_S2}]" width="30"/></div>';
                
                $viewGen = '<table width="100%">';
                for( $k = 0; $k < count($viewData); $k++ ) {

                    $viewData_row = $viewData[$k];
                    $viewTypeID_ = $viewData_row["viewTypeID"];
                    $name_ = $viewData_row["name"];
                    $height_ = $viewData_row["height"];
                    $width_ = $viewData_row["width"];
                    $backgroundRGBColor_ = $viewData_row["backgroundRGBColor"];
                    $textRGBColor_ = $viewData_row["textRGBColor"];
                    $imageURL_ = $viewData_row["imageURL"];
                    
                    if ( !preg_match( "/%/", $width_) ) { $width_ = $width_."px"; }
                    if ( !preg_match( "/%/", $height_) ) { $height_ = $height_."px"; }
                    
                    $textSize_ = $viewData_row["textSize"]<=0?12:$viewData_row["textSize"];

                    #max-width: " . $width_ . ";
                    $style_ = "max-height: " . $height_ . ";  overflow: hidden; font-size: " . $textSize_ . "; background-color: #" . $backgroundRGBColor_ . "; ";
                    $style_ .= "color : #" . $textRGBColor_ ."; "; 
                    $style_2_ = "" ;

                    $viewGen .= '<td>';

                    $_divMain = $viewTypeID__[$viewTypeID_];

                    $_divMain = str_replace( "[{TEXT_S1}]", $name_, $_divMain );
                    $_divMain = str_replace( "[{STYLE_S1}]", $style_, $_divMain );
                    $_divMain = str_replace( "[{STYLE_S2}]", $style_2_, $_divMain );
                    $_divMain = str_replace( "[{IMAGE_S1}]", $imageURL_, $_divMain);

                    $viewGen .=  $_divMain;


                    $viewGen .= '</td>';
                }

                $viewGen .= '</table>';
                
                return $viewGen;
            }
            
    function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
    
    function getUserType_subdomain( $subdomain ) {
        
        /*
          1 : Customer
          2 : Cashier
          3 : Network Owner
          4 : Company
          6 : Partner
          7 : Visitor
          8 : Card Member
          9 : Card User
          10 : IntegrationUser
          11 : Promoter
          12 : POS - Android Terminal
          13 : Badge User ( Access Control 4 Rozet App)
          14 : Cloud Admin
          15 : Developer User
          16 : Dreamer
         */
        
        $return = 1;
        if ( $subdomain == "dreamer-europe-ger-s4y-1" ) { $return = 16; }
        else if ( $subdomain == "network-owner-europe-ger-s4y-1" ) { $return = 3; }
        else if ( $_SERVER["HTTP_HOST"] == "192.168.10.71" ) { $return = 3; }
                    
        return $return;
    }
    
    function tabOutputs_rebuild_find_parent_inputTypeID( $tabOutputs, $parentTiID ) {

        $parent["inputTypeID"] = 0;
        $parent["verticalAlign"] = "top";
        foreach ( $tabOutputs as $tabOutput ) {
            $inputTypeID = $tabOutput["inputTypeID"];
            $tiID = $tabOutput["tiID"];
            if ( $tiID == $parentTiID ) {
                $parent["inputTypeID"] = $inputTypeID;
                
                $parameters = json_decode( $tabOutput["parameters"], true);
                $verticalAlign = "top";
                if ( !empty( $parameters["verticalAlign"] ) ) { $verticalAlign = $parameters["verticalAlign"]; }
                
                $parent["verticalAlign"] = $verticalAlign;
            }
        }
        
        return $parent;
    }
    
    function tabOutputs_rebuild_parent_inputTypeID( $tabOutputs, $directoryPath = "" ) {
        
        $tabOutputsNew = array();
        
        foreach ( $tabOutputs as $tabOutput ) {
            
            $tabOutput["__directoryPath"] = $directoryPath;

            $tiID = $tabOutput["tiID"];
            $parentTiID = $tabOutput["parentTiID"];
            if ( $parentTiID == $tiID && $tiID > 0 ) {
                $parentTiID = 0;
                $tabOutput["parentTiID"] = 0;
            }
            
            if ( $parentTiID > 0 ) {
                $find_parent_inputTypeID = $this->tabOutputs_rebuild_find_parent_inputTypeID( $tabOutputs, $parentTiID);
                $tabOutput["parent_inputTypeID"] = $find_parent_inputTypeID["inputTypeID"];
                $tabOutput["parent_verticalAlign"] = $find_parent_inputTypeID["verticalAlign"];
            }
            
            $tabOutputsNew[] = $tabOutput;
        }
        
        return $tabOutputsNew;
    }
    
    function tabOutputs_rebuild_subitems( $tabOutputs = array(), $parentTiID = 0, $tranID = 0, $tabOutputActions = array(), $directoryPath = "" ) {
        
        $return = array();
        
        
        $tabOutputs = $this->tabOutputs_rebuild_parent_inputTypeID( $tabOutputs, $directoryPath );
        
        $tabOutputs_l1 = array();
        
        foreach( $tabOutputs as $tabOutput ) {
            
            $tiID_ = $tabOutput["tiID"];
            $parentTiID_ = $tabOutput["parentTiID"];
            
            if ( $parentTiID_ == $tiID_ && $tiID_ > 0 ) {
                $parentTiID_ = 0;
                $tabOutput["parentTiID"] = 0;
            }
            
            if ( $parentTiID_ == 0 ) {
                $tabOutputs_l1[$tiID_] = $tabOutput;
            }
            
            $subItemsFind = $this->tabOutputs_rebuild_subitems_find( $tiID_, $tabOutputs, $tranID, $tabOutputActions );
            if ( count($subItemsFind) > 0 ) {
                $tabOutputs_l1[$tiID_]["subItems"] = $subItemsFind;
            }            

        }
        
        return $tabOutputs_l1;
    }
    
    function tabOutputs_rebuild_subitems_find( $tiID_, $tabOutputs_, $tranID_ = 0, $tabOutputActions_ = array() ) {
        
        $subItems_ = array();
        
        foreach( $tabOutputs_ as $tabOutput_ ) {

            $tiID = $tabOutput_["tiID"];
            $parentTiID = $tabOutput_["parentTiID"];
            
            if ( $parentTiID == $tiID && $tiID > 0 ) {
                $parentTiID = 0;
                $tabOutput_["parentTiID"] = 0;
            }
            
            if ( $tiID_ == $parentTiID && $parentTiID > 0 ) {
                $subItems_[$tiID] = $tabOutput_;
                
                $subItemsFind = $this->tabOutputs_rebuild_subitems_find( $tiID, $tabOutputs_, $tranID_, $tabOutputActions_ );
                if ( count($subItemsFind) > 0 ) {
                    $subItems_[$tiID]["subItems"] = $subItemsFind;
                } 
            }
        }
        return $subItems_;
    }

    
    function tabOutputs_process_subItems( $tabOutputs, $parameters = array(), $tranID = 0, $tabOutputActions = array() ) {
     
        $returnHtml = "";
                
        foreach( $tabOutputs as $tabOutput ) {
            $returnHtml .= $this->tabOutput_process_html( $tabOutput, $parameters, "not", $tranID, $tabOutputActions );
        }
        
        return $returnHtml;
    }
    
    
    function tabOutput_process_html( $tabOutput, $__parameters = array(), $parent_verticalAlign = "not", $tranID = 0, $tabOutputActions = array() ) {

        $name = $tabOutput["name"];
        $tiID = $tabOutput["tiID"];
        $inputTypeID = $tabOutput["inputTypeID"];
        $sortID = $tabOutput["sortID"];
        $tabID = $tabOutput["tabID"];
        $referFwID = $tabOutput["referFwID"];
        $parent_inputTypeID = $tabOutput["parent_inputTypeID"]==""?0:$tabOutput["parent_inputTypeID"];
        $parent_verticalAlign = $tabOutput["parent_verticalAlign"]==""?"top":$tabOutput["parent_verticalAlign"];
        $parameters = json_decode( $tabOutput["parameters"], true);
        $parameters["__directoryPatch"] = $__parameters["__directoryPatch"];
        
        $functionName = "inputTypeID_".$inputTypeID;
        
        $subItems = "";
        
        $returnHtml = "";
        
        if ( $inputTypeID == "" && $tiID == "" ) { return $returnHtml; }


        $subItemsCount = 1;
        if ( !empty($tabOutput["subItems"]) ) {
            //print_r( $tabOutputs["subItems"] );
            $subItemsCount = count( $tabOutput["subItems"] );
            $subItems = $this->tabOutputs_process_subItems( $tabOutput["subItems"], $parameters, $tranID, $tabOutputActions );            
        }
        
        if ( $inputTypeID > 0 ) {
            
            //echo "<div>COU:".$subItemsCount.":OUC</div>";
            $subItemsWidth = round( 100 / $subItemsCount ) . "%";
            if ( !empty($parameters["webItemWidth"]) && $parameters["webItemWidth"] != "" ) {
                //if ( preg_match("/%/i", $parameters["webItemWidth"]) ) {
                //    $subItemsWidth = '100%';//$parameters["webItemWidth"];
                //}
                //else {
                    $subItemsWidth = $parameters["webItemWidth"];
                //}
            }
            
            $tabOutputClean = $tabOutput;
            $tabOutputClean["subItems"] = "";
            $tabOutputClean["parameters"] = "";
            $tabOutputClean["frameworkClaimData"] = "";
            $tabOutputClean["encryptTypeID"] = $parameters["encryptTypeID"];
            $tabOutputClean["encryptKey"] = $parameters["encryptKey"];
            
            //echo $verticalAlign."<br><br>";
            $_referTranID = "0"; //strval( $tab_referTranID_l_0 );// strval( $tabOutputs["referTranID"] );
            $_referTabID = "0"; //strval( $tab_referTabID_l_0 );// strval( $tabOutputs["referTabID"] );
            $_referFwID = strval( $tabOutput["referFwID"] );
                                                                
            $referParam = array( "referFwID" => $_referFwID, "referTranID" => $_referTranID, "referTabID" => $_referTabID );
            $referParamJson = rawurlencode(json_encode( $referParam ));
            
            if ( $parent_inputTypeID == 101 ) { $returnHtml .= "<tr><td valign=\"".$parent_verticalAlign."\" width=\"".$subItemsWidth."\">"; }
            if ( $parent_inputTypeID == 102 ) { $returnHtml .= "<td valign=\"".$parent_verticalAlign."\" width=\"".$subItemsWidth."\">"; }
            if ( method_exists( $this, $functionName ) ) {
                $returnHtml .= "<!-- editbox-start --><div class=\"editboxArea\" name=\"".$name."\" tiID=\"".$tiID."\" inputTypeID=\"".$inputTypeID."\" referParamJson=\"".$referParamJson."\"></div><!-- editbox-end -->";
                if ( $inputTypeID != 101 && $inputTypeID != 102 ) {
                $returnHtml .= "<input type=\"hidden\" name=\"tabOutputs[".$tabID."][]\" value=\"".base64_encode(json_encode($tabOutputClean))."\">";
                }
                $returnHtml .= $this->$functionName( $tabOutput, $parameters, $tranID, $tabOutputActions );
            }
            else {
                $returnHtml .= $this->inputTypeID_unknown( $tabOutput, $parameters );
            }
            if ( $parent_inputTypeID == 102 ) { $returnHtml .= "</td>"; }
            if ( $parent_inputTypeID == 101 ) { $returnHtml .= "</td></tr>"; }
        }
        
        if ( $subItems != "" && ( $inputTypeID == 101 || $inputTypeID == 102 ) ) {
            $returnHtml = str_replace( "[[SUB_ITEMS]]", $subItems, $returnHtml);
        }
        
        return $returnHtml;
    }
    
    
    
    function inputTypeID_1( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
        
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $inputTypeID = $tabOutput["inputTypeID"];
        $mandatory = $tabOutput["mandatory"];
        $referFwID = $tabOutput["referFwID"];
        //$parameters = json_decode( $tabOutput["parameters"], true);
        $multipleValues = $tabOutput["multipleValues"];
        
        //print_r( $tabOutput );
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $required = "";
        if( $mandatory == 1 ){ $required = "required"; }

        $secureText = false;
        if ( !empty($parameters["secureText"]) )
        {
            if ( $parameters["secureText"] != NULL )
            {
                if ( $parameters["secureText"] != "" )
                {
                        $secureText = $parameters["secureText"] == 1 ? true : false;
                }
            }
        }

        $type = "text";
        $step = "";
        
        if ( $inputTypeID == 2 ) {  $type = "number"; }
        else if ( $inputTypeID == 3 ) {  $type = "number"; $step = "0.01"; }
        
        if ( $secureText ) { $type = "password"; }
        
        $styles = $this->processParameters( $parameters );
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<input type="'.$type.'" step="'.$step.'" class="form-control" style="'.$styles["style_2"].'" id="" placeholder="'.$name.'" value="'.$valueString.'" name="sw_['.$tabID.']['.$tiID.'-'.$referFwID.']" '.$required.' />';
        $return .= '</div>';
        
        return $return;
        
    }
    
    function inputTypeID_2( $tabOutput = array(), $parameters = array() ){
        return $this->inputTypeID_1( $tabOutput, $parameters );
    }
    
    function inputTypeID_3( $tabOutput = array(), $parameters = array() ){
        return $this->inputTypeID_1( $tabOutput, $parameters );
    }
    
    function inputTypeID_4( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
                
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];
        $referFwID = $tabOutput["referFwID"];
        $uTabID = "xxxx-xxxx-xxxx";
        $inputTypeID = $tabOutput["inputTypeID"];
        $mandatory = $tabOutput["mandatory"];
        //$parameters = json_decode( $tabOutput["parameters"], true);
        $multipleValues = $tabOutput["multipleValues"];
        $claimData = $tabOutput["claimData"];
        
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $required = "";
        if( $mandatory == 1 ){ $required = "required"; }
        
        $styles = $this->processParameters( $parameters );
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<select class="form-control" style="'.$styles["style_2"].'" name="sw_['.$tabID.']['.$tiID.'-'.$referFwID.']" prmInput="'.$prmInput.'" tableID="'.$tableID.'" uTabID="'.$uTabID.'" onchange="javascript:inputTypeID_4_onChange(this);" '.$required.' >';
	$return .= '<option value="">'.$name.'</option>';
        
        $selectedLangCode = $valueString;
        if ( $prmInput == "aigap_framework_dev_panel_language_picker" ) {
            if ( $this->getCookie("langCode") == "" ) {
                $browserLangCode = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                if ( !empty( $claimData )) {
                    foreach( $claimData[0]["listValue"] as $claimData_ ) {
                        if ( $claimData_["ID"] == $browserLangCode ) {
                            $this->setCookie( "langCode", $browserLangCode, false );
                            $this->setLangCode( $browserLangCode );
                            $selectedLangCode = $browserLangCode;
                        }
                    }
                }

            }
            else {
                $selectedLangCode = $this->getCookie( "langCode" );
            }
        }

        
        if ( !empty( $claimData )) {
            foreach( $claimData[0]["listValue"] as $claimData_ ) {

                $selected = "";
                if ( $claimData_["ID"] == $selectedLangCode ) {
                    $selected = "selected=\"selected\"";
                }
        
                $return .= '<option value="'.$claimData_["ID"].'" '.$selected.' >'. $claimData_["name"].'</option>';
            }
        }
        $return .= '</select>';
        $return .= '</div>';
        
        return $return;
        
    }
    
    
    function inputTypeID_5( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
        
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $inputTypeID = $tabOutput["inputTypeID"];
        $referFwID = $tabOutput["referFwID"];
        $mandatory = $tabOutput["mandatory"];
        //$parameters = json_decode( $tabOutput["parameters"], true);
        $multipleValues = $tabOutput["multipleValues"];
        
        //print_r( $tabOutput );
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $required = "";
        if( $mandatory == 1 ){ $required = "required"; }
        
        $checked = "";
        if ( $valueString == "True" || $valueString == "1" ) { $checked = "checked=\"checked\""; }

        $parameters["itemHeight"] = "";
        
        $styles = $this->processParameters( $parameters );
        
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<input type="hidden" name="sw_['.$tabID.']['.$tiID.'-'.$referFwID.']"  value="0" >';
        $return .= '<input type="checkbox" style="'.$styles["style_2"].'" id="checkbox_'.$tabID.'_'.$tiID.'_'.$referFwID.'" name="sw_['.$tabID.']['.$tiID.'-'.$referFwID.']" '. $checked .' value="1" >';
        $return .= '<label class="label_checkbox" for="checkbox_'.$tabID.'_'.$tiID.'_'.$referFwID.'">'.$name.'</label>';
        $return .= '</div>';
        
        return $return;
        
    }
    
    function inputTypeID_10( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
                
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $inputTypeID = $tabOutput["inputTypeID"];
        $mandatory = $tabOutput["mandatory"];
        //$parameters = json_decode( $tabOutput["parameters"], true);
        $multipleValues = $tabOutput["multipleValues"];
        
        $actionTranID = $tabOutput["actionTranID"];
        
        $fontAwesome = $parameters["fontAwesome"];
        $HTMLAddress = $parameters["HTMLAddress"];
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
        
        $tranFieldsJsonEnc = "";
        
        $targetURL = $this->textToParameter($name).'?t='.$actionTranID.'&i=0&ati='.$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
        $targetAction = "_self";
        if ( $HTMLAddress != "" ) {
            $targetURL = $HTMLAddress;
            $targetAction = "_blank";
        }
        
        //echo json_encode( $parameters )."<br><br>";
        //print_r( $tabOutput );
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $a_href_status = false;
        if ( $actionTranID > 0 || $HTMLAddress != "" ) { $a_href_status = true; }
        
        if ( $fontAwesome == 0 ) {
        
            $styles = $this->processParameters( $parameters );

            $return .= '<div class="" style="'.$styles["style_1"].'">';
            if ( $a_href_status ) {
                $return .= '<div style="'.$styles["style_2"].'"><a href="'.$targetURL.'" target="'.$targetAction.'" style="'.$styles["style_3"].'">'.$name.'</a></div>';
            } else {
                $return .= '<div style="'.$styles["style_2"].'">'.$name.'</div>';
            }
            $return .= '</div>';
        
        }
        else {
            
            $faStyle = "";
            $itemTextColor = $parameters["itemTextColor"];
            if ( $itemTextColor != "" ) {
                $faStyle = "color: #".$itemTextColor."; ";
            }
            
            if ( $a_href_status ) {
            $return .= '<a href="'.$targetURL.'" target="'.$targetAction.'" style="'.$styles["style_3"].'">';
            }
            $return .= '<i class="'.$name.'" style="'.$faStyle.'"></i>';
            if ( $a_href_status ) {
            $return .= '</a>';
            }
            
        }
        
        return $return;
        
    }
    
    function inputTypeID_12( $tabOutput = array(), $parameters = array() ){
        return $this->inputTypeID_10( $tabOutput, $parameters );
    }
    
    function inputTypeID_13( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
                
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $referFwID = $tabOutput["referFwID"];
        $mandatory = $tabOutput["mandatory"];
        $multipleValues = $tabOutput["multipleValues"];
        
        $format = str_replace( array("HH","hh","MM","mm","DD","dd","yyyy","ss"), array("H","h","m","i","d","d","Y","s"), $format);
        $languageCode = $this->getCookieSession("langCode");
        if ( $languageCode == "" ) { $languageCode = "tr"; }

        if ( !empty($parameters["datePickerPHP"]) ) { $format = $parameters["datePickerPHP"]; }

        $tranFieldFormat = "";
        if ( !empty($parameters["tranFieldFormat"]) ) { $tranFieldFormat = $parameters["tranFieldFormat"]; }
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $required = "";
        if( $mandatory == 1 ){ $required = "required"; }
        
        $return .= '<script>';
	$return .= '$(document).ready(function(){';
	$return .= '$.datetimepicker.setLocale(\''.$languageCode.'\');';
	$return .= '$("#sw_'.$tabID.'_'.$tiID.'").datetimepicker({';
        $return .= 'datepicker : false,';
        $return .= 'format : \''.$format.'\',';
        $return .= 'lang : \''.$languageCode.'\',';
        $return .= 'scrollInput : false,';
        $return .= 'closeOnWithoutClick : false,';
        $return .= 'onChangeDateTime : function( dp, $input ) {';
        $return .= 'var selectedDate = $input.val();';
        $return .= 'var selectedDateFormatted = selectedDate;';
        if ( $tranFieldFormat != "" ) {
        $return .= 'selectedDateFormatted = $.format.date(  Date.parse(selectedDate), \''.$tranFieldFormat.'\' );';
        }
        $return .= '}';
        $return .= '});';
	$return .= '});';
	$return .= '</script>';
        
        
        
        $return .= '<div class="s_tb">';
        $return .= '<input type="text" class="form-control" placeholder="'.$name.'" value="'.$valueString.'" name="sw_['.$tabID.']['.$tiID.'-'.$referFwID.']" '.$required.' id="sw_'.$tabID.'_'.$tiID.'">';
        $return .= '</div>';

        
        return $return;
    }
    
    
    function inputTypeID_14( $tabOutput = array(), $parameters = array(), $tranID = 0, $devRerouteServerApi = "" ){
        
        $return = '';
                
        
        $listRange = 1000;
        $claimID = $tabOutput["claimID"];
        $tiID = $tabOutput["tiID"];
        $ID = $tabOutput["ID"];
        $uTabID = "xxxx-xxxx-xxxx";
        
        $name_A = "";
        $name_AA = "";
        $tabID = 0;
        
        if ( !empty($tabOutput["devRerouteServerApi"]) ) {
            $devRerouteServerApi = $tabOutput["devRerouteServerApi"];
        }
        
        if ( !is_array($devRerouteServerApi) ) {
            $devRerouteServerApi = json_decode( $devRerouteServerApi, true);
        }
        
        
        $GetFrameworkClaimData_ = $this->services_AigapGetClaim( "", 0, 0, $listRange, $claimID, $tiID, $ID, $tranID, 0, "","", 0, $devRerouteServerApi, $uTabID );
        $GetFrameworkClaimData = json_decode( $GetFrameworkClaimData_["jsonDataDecrypted"] );

        //echo json_encode( $GetFrameworkClaimData );

         $designTypeID = 0;
         if ( $devRerouteServerApi != null ) {
             $devRerouteServerApi_json = json_decode( $devRerouteServerApi, true );
             if ( !empty($devRerouteServerApi_json["designTypeID"]) ) {
                 $designTypeID = $devRerouteServerApi_json["designTypeID"];
             }
         }
        $imageURLShow = 0;

        $tranAsID = false;
        if ( $prmInput == "aigap_framework_dev_panel_tranID" ) {
                $tranAsID = true;
                $actionTranID = "[[TRANID_TO_ID]]";
        }

        $tableViewOrientation = "Vertical";
        if ( count($GetFrameworkClaimData->fields) > 0 )
        {
                $tableViewOrientation = "Horizontal";

                $fields__ = $GetFrameworkClaimData->fields;

                if ( count($fields__) > 0 )
                {
                        foreach ( $fields__ as $id => $field__ )
                        {
                                if ( $field__->field == "imageURL" ) { $imageURLShow = 1; }
                        }
                }

        }


        $parameterTemplate = "";
        $parameterTemplateDelete = "";

        if ( in_array("2",$formatParse)) {
            $tranCallerTypeID_ = 0;
            if ( $tranAsID ) { $tranCallerTypeID_ = 11; }
            $parameterTemplate = base64_encode("{ \"tranID\" : ".$actionTranID.", \"actionTiID\" : \"".$tiID."\", \"menuName\" : \"".$name_A."\", \"menuParentName\" : \"".$name_AA."\", \"ID\" : \"[[ID]]\", \"fieldName\" : \"".$prmInput."\", \"fieldValue\" : \"[[ID]]\", \"tableID\" : \"".$tableID."\", \"uTabIDSend\" : \"".$uTabID."\", \"menuTranID\" : \"".$menuTranID."\", \"menuCategoryID\" : \"".$menuCategoryID."\", \"menuName\" : \"".$menuName."\", \"menuParentName\" : \"".$menuParentName."\", \"designPropertyTypeID\" : \"".$designPropertyTypeID."\", \"designPropertyID\" : \"".$designPropertyID."\", \"devRerouteServerApi\" : \"".$devRerouteServerApiEnc."\", \"tranCallerTypeID\" : ".$tranCallerTypeID_.", \"actionTiID\" : \"".$tiID."\", \"designTypeID\" : \"".$designTypeID."\" }");
        }

        if ( in_array("3",$formatParse)) {
            $deleteParametersA = array( "input" => array("tiID" => $actionTranID, "tableID" => $tableID, "value" => "1", "ID" => "[[ID]]", "tabID" => $tabID), "tran" => array( "prmInput" => $prmInput, "ID" => "[[ID]]", "tableID" => $tableID, "tranID" => $actionTranID ) , "actionTiID" => $tiID, "designPropertyTypeID" => $designPropertyTypeID, "designPropertyID" => $designPropertyID, "devRerouteServerApi" => $devRerouteServerApiEnc, "designTypeID" => $designTypeID );
            $parameterTemplateDelete = base64_encode(json_encode($deleteParametersA));
        }
        
        
        $return .= '<div class="table-responsive">';
	$return .= '<table class="table table-striped" width="100%" cellpadding="5" cellspacing="0">';
        $return .= '<tbody>';
        $return .= '<tr>';
        $return .= '<td width="100%">';
        $return .= '<input type="text" name="search_it_id_14_'.$tabID.'_'.$tiID.'_'.$uTabID.'" uTabID="'.$uTabID.'" value="" placeholder="'.$this->getLanguageValue("h.Search", $languageCode).'" style="width:100%;"  class="form-control search-text-area" autofocus />';
        $return .= '</td>';
        $return .= '<td>&nbsp;</td>';
        $return .= '<td><input type="button" id="search_it_id_14_'.$tabID.'_'.$tiID.'_'.$uTabID.'_clear_button" uTabID="'.$uTabID.'" value="'.$this->getLanguageValue("b.Clear", $languageCode).'" class="btn btn-warning" onClick="javascript:aigapGetClaim( \''.$tranID.'\', \''.$claimID.'\', \'0\', \'0\', \'0\', \''.$listRange.'\', \'table_'.$tabID.'_'.$tiID.'_'.$uTabID.'\', \''.$tabID.'\', \''.$tiID.'\', \''.$parameterTemplate.'\', \''.$parameterTemplateDelete.'\', \'2\', \''.$tableViewOrientation.'\', \''.$imageURLShow.'\', \''.$actionTranID.'\', \''.$IDA.'\', \''.$tranAsID.'\', \''.$uTabID.'\', \''.$devRerouteServerApiEnc.'\' );" /></td>';
        $return .= '<td>&nbsp;</td>';
        $return .= '<td><input type="button" id="search_it_id_14_'.$tabID.'_'.$tiID.'_'.$uTabID.'_search_button" uTabID="'.$uTabID.'" value="'.$this->getLanguageValue("b.Search", $languageCode).'" class="btn btn-success" onClick="javascript:aigapGetClaim( \''.$tranID.'\', \''.$claimID.'\', \'0\', \'0\', \'0\', \''.$listRange.'\', \'table_'.$tabID.'_'.$tiID.'_'.$uTabID.'\', \''.$tabID.'\', \''.$tiID.'\', \''.$parameterTemplate.'\', \''.$parameterTemplateDelete.'\', \'1\', \''.$tableViewOrientation.'\', \''.$imageURLShow.'\', \''.$actionTranID.'\', \''.$IDA.'\', \''.$tranAsID.'\', \''.$uTabID.'\', \''.$devRerouteServerApiEnc.'\' );" /></td>';
        $return .= '</tr>';
        $return .= '</tbody>';
        $return .= '</table>';
        $return .= '</div>';
        
        $return .= '<div  class="s_tb scroll_area table-responsive">';
        $return .= '<table width="100%" cellpadding="5" cellspacing="0" id="table_'.$tabID.'_'.$tiID.'_'.$uTabID.'" uTabID="'.$uTabID.'" style="border: 1px solid #DDDDDD;" class="table table-striped table-hover">';
        $return .= '<thead class="thead-light">';
        $return .= '<input type="hidden" name="tab_'.$tabID.'_'.$tiID.'_'.$uTabID.'_firstID" uTabID="'.$uTabID.'" value="0" />';
	$return .= '<input type="hidden" name="tab_'.$tabID.'_'.$tiID.'_'.$uTabID.'_lastID" uTabID="'.$uTabID.'" value="'.$GetFrameworkClaimData->lastID.'" />';
						
        $claimData_ = $GetFrameworkClaimData->claimData;
        $fields_ = $GetFrameworkClaimData->fields;
        $footer_ = $GetFrameworkClaimData->footer;

        if ( count($fields_) > 0 )
        {
        $fieldCount = count($fields_);
        $tdWidth = ( 100 / $fieldCount )."%"; 

        $return .= '<tr>';

        foreach ( $fields_ as $id => $field )
        {
            if ( $field->field == "imageURL" ) { $imageURLShow = 1; }
            $return .= '<td><div style="padding:5px; font-weight:bold; letter-spacing:0.05em;">'.$field->field.'</div></td>';
        }

        $return .= '</tr>';  
        }
        
        $return .= '</thead>';
	$return .= '<tbody>';
        
        

            
        $i = 0;
        if ( count( $claimData_ ) > 0 ) {
        foreach( $claimData_ as $claimData ) {

            
                $i++;
                $IDA = $claimData->ID;
                $name_ = $claimData->name;
                $values_ = $claimData->values;
                $customClaimData = $claimData->customClaimData;
                $checkVal = $claimData->checkVal;
                $imageURL = $claimData->imageURL;
                $collected = $claimData->collected;
                $actionDate = $claimData->actionDate;

                $leftView = $claimData->leftView;
                $rightView = $claimData->rightView;

                //print_r( $claimData );

                if ( $prmInput == "aigap_framework_dev_panel_tranID" ) {
                        $actionTranID = $IDA;
                }

                $URL = "tran.tabs.frame.php?data=".base64_encode("{ \"tranID\" : ".$actionTranID.", \"menuName\" : \"".$name_A."\", \"menuParentName\" : \"".$name_AA."\", \"ID\" : \"".$IDA."\", \"fieldName\" : \"".$prmInput."\", \"fieldValue\" : \"".$IDA."\", \"tableID\" : \"".$tableID."\", \"uTabIDSend\" : \"".$uTabID."\", \"menuTranID\" : \"".$menuTranID."\", \"menuCategoryID\" : \"".$menuCategoryID."\", \"menuName\" : \"".$menuName."\", \"menuParentName\" : \"".$menuParentName."\", \"designPropertyTypeID\" : \"".$designPropertyTypeID."\", \"designPropertyID\" : \"".$designPropertyID."\", \"devRerouteServerApi\" : \"".$devRerouteServerApiEnc."\", \"tranCallerTypeID\" : \"".$tranCallerTypeID_."\", \"actionTiID\" : \"".$tiID."\", \"designTypeID\" : \"".$designTypeID."\"  }");

                $deleteParameters = array();
                $deleteParameters = array( "input" => array("tiID" => $tiID, "tableID" => $tableID, "value" => "1", "ID" => $IDA, "tabID" => $tabID), "tran" => array( "prmInput" => $prmInput, "ID" => $IDA, "tableID" => $tableID, "tranID" => $actionTranID ) , "devRerouteServerApi" => $devRerouteServerApiEnc, "designPropertyTypeID" => $designPropertyTypeID, "designPropertyID" => $designPropertyID, "tranCallerTypeID" => $tranCallerTypeID_, "actionTiID" => $tiID, "designTypeID" => $designTypeID );

                $returnURLEncoded = urlencode("tran.tabs.php?parameters=".$parameters);

                $URL_delete = "tran.save.async.php?deleteParameters=".base64_encode(json_encode($deleteParameters))."&editID=".$IDA."&tranID=".$actionTranID."&stateID=3";

                $onClick_string = "onClick=\"javascript:tableOnClick('".$URL."', '0','".$name_."', '".$actionTranID."', '".$IDA."', '".$frameStatus."', '".$uTabID."' );\"";
                $onDblClick_string = "onDblClick=\"javascript:tableOnDblClick('".$URL."', '0','".$name_."', '".$actionTranID."', '".$IDA."', '".$frameStatus."', '".$uTabID."' );\"";

                if ( $tableViewOrientation == "Horizontal" ) {
                    
                
                $return .= '<tr>';

                if ( $imageURL != "" ) {
                $return .= '<td <?php if ( in_array("2",$formatParse) ) { echo $onClick_string." ".$onDblClick_string; } ?> >';
                $return .= '<div style="padding:5px; margin:0 auto;">';
                $return .= '<img src="'.$imageURL.'" height="40" class="mx-auto d-block">';
                $return .= '</div>';
                $return .= '</td>';
                } else {
                if ( $imageURLShow == 1 ) {
                $return .= '<td <?php if ( in_array("2",$formatParse) ) { echo $onClick_string." ".$onDblClick_string; } ?> >&nbsp;</td>';
                }
                }

                $return .= '<td <?php if ( in_array("2",$formatParse) ) { echo $onClick_string." ".$onDblClick_string; } ?>>';
                $return .= '<div style="padding:5px;">'.$IDA.'</div>';
                $return .= '</td>';
                $return .= '<td <?php if ( in_array("2",$formatParse) ) { echo $onClick_string." ".$onDblClick_string;} ?>>';
                $return .= '<div style="padding:5px;">'.$name_.'</div>';
                $return .= '</td>';
                foreach( $values_ as $values ) {
                $return .= '<td <?php if ( in_array("2",$formatParse) ) { echo $onClick_string." ".$onDblClick_string; } ?>>';
                $return .= '<div style="padding:5px;">'.$values->val.'</div>';
                $return .= '</td>';
                }
                if ( in_array("3",$formatParse)) {
                $return .= '<td bgcolor="#FF0000" onClick="javascript:tableOnClick(\''.$URL_delete.'\', \'1\',\'\',\''.$actionTranID.'\',\'0\',\'0\',\''.$uTabID.'\');" width="1">';
                $return .= '<div style="padding: 10px; color: #FFFFFF; font-size: 14px; ">'.$this->getLanguageValue("b.Delete").'</div>';
                $return .= '</td>';
                }

                $dynamicView_ = json_decode( json_encode( $claimData->dynamicView ), true);
                if ( count($dynamicView_) > 0 ) {

                    $dynamicView_new_ = $this->dynamicViewLoop( $dynamicView_ );

                    $dynamicViewGen_ = $this->dynamicView( $dynamicView_new_, $tiID, $devRerouteServerApiEnc, $uTabID );
                    $return .= '<td >'.$dynamicViewGen_.'</td>';

                }
                
                $return .= '</tr>';
                
                
                
                } else {
                                   

                $return .= '<tr>';
                if ( $imageURL != "" ) {
                $return .= '<td width="80"  >';
                $return .= '<div style="padding:5px; margin:0 auto;">';
                $return .= '<img src="'.$imageURL.'" height="60" class="mx-auto d-block">';
                $return .= '</div>';
                $return .= '</td>';
                } else {
                $return .= '<td>&nbsp;</td>';
                }
                $return .= '<td width="100%" >';
                $return .= '<div style="padding:5px; font-weight:bold;">'.$name_.'</div>';
                $return .= '<div style="padding: 0 5px 5px 5px; ">';
                foreach( $values_ as $values ) {
                $return .= '<div>'.$values->val.'</div>';
                }
                $return .= '</div>';
                $return .= '</td>';
                if ( in_array("3",$formatParse)) {
                $return .= '<td bgcolor="#FF0000" onClick="javascript:tableOnClick(\''.$URL_delete.'\', \'1\',\'\',\''.$actionTranID.'\',\'0\',\'0\',\''.$uTabID.'\');">';
                $return .= '<div style="padding: 10px; color: #FFFFFF; font-size: 14px; ">'.$this->getLanguageValue("t.Delete").'</div>';
                $return .= '</td>';
                }
                $return .= '</tr>';
                
                $dynamicView_ = json_decode( json_encode( $claimData->dynamicView ), true);
                if ( count($dynamicView_) > 0 ) {

                    $dynamicView_new_ = $this->dynamicViewLoop( $dynamicView_ );

                    $dynamicViewGen_ = $this->dynamicView( $dynamicView_new_, $tiID, $devRerouteServerApiEnc, $uTabID );
                    $return .= '<tr><td >'.$dynamicViewGen_.'</td></tr>';

                }

                }
                }

                } else {
                $return .= '<tr>';
                $return .= '<td colspan="20">'.$this->getLanguageValue("m.NoData").'</td>';
                $return .= '</tr>';
                }
                $return .= '</tbody>';
        
        return $return;
    }
    
    function inputTypeID_17( $tabOutput = array(), $parameters = array(), $tranID = 0, $tabOutputActions = array(), $cancel = false ){
        
        $return = '';
                
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $prmInput = $tabOutput["prmInput"];
        $ID = "0";//$tabOutput["prmInput"];
        $referFwID = $tabOutput["referFwID"];
        $tableID = $tabOutput["tableID"];
        $name = $tabOutput["name"];
        $uTabID = "xxxx-xxxx-xxxx";
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
        $devRerouteServerApiDec = json_decode( $devRerouteServerApiJson, true );
        
        $buttonClass = "button-green";
        if ( $cancel ) { $buttonClass = "button-red"; }
        
        
        $buttonStyle = "";
        if ( !empty($parameters["itemHeight"]) && $parameters["itemHeight"] != "" ) {
            $buttonStyle .= "height: " . $parameters["itemHeight"] . "; ";
            
            $parameters["itemHeight"] = "";
        }
        
        if ( !empty($parameters["itemTextColor"]) && $parameters["itemTextColor"] != "" ) {
            $buttonStyle .= "color: #" . $parameters["itemTextColor"] . "; ";
            
            $parameters["itemTextColor"] = "";
        }
        
        if ( !empty($parameters["itemBackgroundColor"]) && $parameters["itemBackgroundColor"] != "" ) {
            $buttonStyle .= "background-color: #" . $parameters["itemBackgroundColor"] . "; ";
            
            $parameters["itemBackgroundColor"] = "";
        }
        
        if ( !empty($parameters["itemBorderRadius"]) && $parameters["itemBorderRadius"] != "" ) {
            $buttonStyle .= "border-radius: " . $parameters["itemBorderRadius"] . "px; ";
            
            $parameters["itemBorderRadius"] = "";
        }
        
        if ( ( !empty($parameters["itemBorderSize"]) && $parameters["itemBorderSize"] != "" ) && ( !empty($parameters["itemBorderColor"]) && $parameters["itemBorderColor"] != "" ) ) {
            $buttonStyle .= "border: ".$parameters["itemBorderSize"]." solid #" . $parameters["itemBorderColor"] . "; ";
            
            $parameters["itemBorderSize"] = "";
            $parameters["itemBorderColor"] = "";
        }
        
        //echo "TOA_0_".json_encode( $tabOutput )."_TOA<br><br>";
        //echo "TOA_1_".json_encode( $tabOutputActions )."_TOA<br><br>";
        
        $tabOutputActions_status = false;
        $tabOutputActions_ = array();
        if ( !empty( $tabOutputActions[$tiID] ) ) {
            $tabOutputActions_status = true;
            $tabOutputActions_ = $tabOutputActions[$tiID];
        }
        
        //$return .= "<div>".$tabOutputActions_status." --- ".json_encode( $tabOutputActions_ )."</div>";
        
        $styles = $this->processParameters( $parameters );

        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">';
        
        $button_onClick = "onClick=\"javascript:buttonSubmitOnClick(this);\"";
        
        if ( $tabOutputActions_status ) {
            
            $tabOutputActions_enc = urlencode(json_encode($tabOutputActions_));
            $tranFields = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
            $tranFields_enc = urlencode(json_encode($tranFields));
            $button_onClick = "onClick=\"javascript:tabOutputActions( this, '".$tranID."', '".$tabID."', '".$referFwID."', '".$tabOutputActions_enc."', '".$tranFields_enc."', '".$devRerouteServerApiEnc."' );\" class=\"onClickView inputType_tiID_".$tiID."_item\" title=\"".$name."\" alt=\"".$name."\"";
        }
        
        $return .= '<button type="submit" class="button '.$buttonClass.'" style="'.$buttonStyle.'" uTabID="'.$uTabID.'" tranID="'.$tranID.'" tabID="'.$tabID.'" actionTiID="'.$tiID.'" '.$button_onClick.' >'.$name.'</button>';
        
        $return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function inputTypeID_19( $tabOutput = array(), $parameters = array(), $tranID = 0, $cancel = false ){
        
        $return = '';
                
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $uTabID = "xxxx-xxxx-xxxx";
        $claimID = $tabOutput["claimID"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];
        $referFwID = $tabOutput["referFwID"];
        $max = $tabOutput["max"];
        $tranIDForce = "0";
        $multipleValues = $tabOutput["multipleValues"];
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
        
        $buttonClass = "button-green";
        if ( $cancel ) { $buttonClass = "button-red"; }
        
        //echo json_encode( $tabOutput )."<br><br>";
        
        $styles = $this->processParameters( $parameters );
        
        $itemHeight = "26";
        $inputStyle = "box-sizing: border-box; -moz-box-sizing: border-box; ";
        if ( !empty($parameters["itemHeight"]) && $parameters["itemHeight"] != "" ) {
            $itemHeight = $parameters["itemHeight"];
            $inputStyle .= " height: ".$parameters["itemHeight"]."; ";
        }
        
        $directoryPath = $tabOutput["__directoryPath"];
        //echo "<br>".json_encode( $tabOutput )."<br>";
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];
                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $leftImageURL = "";
        if ( !empty($parameters["leftImageURL"]) && $parameters["leftImageURL"] != "" ) {
            $leftImageURL = '<img src="'.$parameters["leftImageURL"].'" height="'.$itemHeight.'" width="'.$itemHeight.'" style="position: absolute; top: 50%; left: 2px; transform: translateY(-50%); pointer-events: none; cursor: default;" />';
            
            $itemWidthNew = $itemHeight;
            if ( preg_match("/%/i", $itemHeight) ) {
                $itemWidthNew_ = str_replace( "%", "", $itemHeight);
                $itemWidthNew =  ( $itemWidthNew_ + 2 )."%";
            }
            else if ( preg_match("/px/i", $itemHeight) ) {
                $itemWidthNew_ = str_replace( "px", "", $itemHeight);
                $itemWidthNew =  ( $itemWidthNew_ + 4 )."px";
            }
            else {
                $itemWidthNew =  ( $itemHeight + 4 )."px";
            }
            
            $inputStyle .= "padding-left: ".$itemWidthNew."; ";
        }
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].' position: relative;">';
                
        $return .= '
                                                <div class="inputTypeID_19_main">
                                                    <input type="hidden" class=inputTypeID_4_hidden_text" name="sw_text_['.$tabID.']['.$tiID.'-'.$referFwID.']" uTabID="'.$uTabID.'" value="'.$valueTextString.'">
                                                    <input type="hidden" class=inputTypeID_4_hidden_text" name="sw_['.$tabID.']['.$tiID.'-'.$referFwID.']" uTabID="'.$uTabID.'" value="'.$valueString.'">
                                                    <input class="form-control sw_select_19" name="sw_select_['.$tabID.']['.$tiID.'-'.$referFwID.']" value="'.$valueTextString.'" directoryPath="'.$directoryPath.'" readonly style="background-color:#FFFFFF; cursor: context-menu; '.$inputStyle.'" title="'.$valueTextString.'" onClick="javascript:inputTypeID_19_click( this );" placeholder="'.$name.'" tranID="'.$tranID.'" tranIDForce="'.$tranIDForce.'" tabID="'.$tabID.'" tiID="'.$tiID.'" referFwID="'.$referFwID.'" uTabID="'.$uTabID.'" firstID="0" lastID="0" lastGroupID="0" claimID="'.$claimID.'" prmInput="'.$prmInput.'" tableID="'.$tableID.'" devRerouteServerApi="'.$devRerouteServerApiEnc.'"  devRerouteServerApi_change="'.$devRerouteServerApi_change.'" tranID="'.$tranID.'" tranIDForce="'.$tranIDForce.'" range="'.$max.'" firstLoad="0" disableScroll="0" />
                                                    '.$leftImageURL.'
                                                    <img src="'.$directoryPath.'/images/icon_select.png" width="10" height="17" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); pointer-events: none; cursor: default;" />
                                                    <a class="" style="position: absolute; top: 50%; right: 25px; transform: translateY(-50%);" id="button_remove_tiid_'.$tiID.'_'.$uTabID.'" uTabID="'.$uTabID.'" href="javascript:void(0)" onClick="javascript:inputTypeID_19_remove( this );" ><img src="'.$directoryPath.'/images/icon_cancel_2.png" height="20" /></a>

                                                    <div class="options_div">
                                                        <div class="search">
                                                            <table width="100%" cellpadding="0" cellspacing="0" class="options_div_table">
                                                                <tr style="padding:0;">
                                                                    <td width="100%" style="padding:0; position: relative;">
                                                                        <input type="text" class="form-control" placeholder="'.$this->getLanguageValue("h.Search", $languageCode).'" name="search_text_div" autocomplete="off"/>
                                                                        <div style="position: absolute; right: 2px; top: 6px; display: none;" class="spinner-border loadSpinner"><span class="sr-only">Loading...</span></div>
                                                                    </td>
                                                                    <td style="padding:0;">&nbsp;</td>
                                                                    <td width="100%" style="padding:0;"><input type="button" name="search_search_div" class="btn btn-secondary" value="'.$this->getLanguageValue("b.Search", $languageCode).'" onClick="javascript:inputTypeID_19_search(this);" /></td>
                                                                    <td style="padding:0;">&nbsp;</td>
                                                                    <td width="100%" style="padding:0;"><input type="button" name="search_clear_div" class="btn btn-warning" value="'.$this->getLanguageValue("b.Clear", $languageCode).'" onClick="javascript:inputTypeID_19_clear(this);" /></td>
                                                                    <?php if ( $URL_add != "0" ) { ?>
                                                                    <td style="padding:0;"><div class="menu_add" inputTypeID_19_status="1" targetUrl="'.$URL_add.'" uTabID=""  modalID="modal-itid-19-add-new"  style="padding: 5px;"><img src="'.$directoryPath.'/images/icon_plus.png" width="34" height="34" ></div></td>
                                                                    <?php } ?>
                                                                    <td style="padding:0;"><div targetUrl="" onClick="javascript:inputTypeID_19_close(this);" style="padding: 5px;" class="close_button"><img src="'.$directoryPath.'/images/icon_cancel_2.png" width="34" height="34" ></div></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="content">
                                                            <div>'.$this->getLanguageValue("t.PleaseWait").'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                ';
        
        $return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function inputTypeID_27( $tabOutput = array(), $parameters = array(), $tranID = 0 ) {
        
        $return = '';
        
        $uTabID = "xxxx-xxxx-xxxx";
        $tiID = $tabOutput["tiID"];
        $prmInput = $tabOutput["prmInput"];
        $claimID = $tabOutput["claimID"];
        $ID = $tabOutput["ID"];
        $actionTranID = $tabOutput["actionTranID"];
        
        $aigapMenuStatus = false;
        $clickJavascript = "";
        $clickClass = "";
        
        $HTMLAddress = $parameters["HTMLAddress"];
        if ( !empty($HTMLAddress) && $HTMLAddress != "" ) {
            
            if ( $HTMLAddress == "[{homePage}]" ) {
                
                $homePageURL = $this->getCookie("homePageURL");
                if ( $homePageURL == "" ) { $homePageURL = "/"; }
                
                $HTMLAddress_target = "_self";
                $HTMLAddress_url = $homePageURL;
            }
            else {
                $HTMLAddress_parse = explode("|", $HTMLAddress);

                $HTMLAddress_target = "_self";
                $HTMLAddress_url = $HTMLAddress;

                if ( count($HTMLAddress_parse) > 1 ) {                
                    $HTMLAddress_target = $HTMLAddress_parse[0];
                    $HTMLAddress_url = $HTMLAddress_parse[1];
                }
            }
            
            $clickClass = "onClickView";
            $clickJavascript = 'onClick="javascript: onClickHTML( \''.urlencode($HTMLAddress_url).'\', \''.$HTMLAddress_target.'\' );"';
        }
        
        if ( $prmInput == "aigap_framework_dev_panel_project_picker" ) {
            $aigapMenuStatus = true;
            $clickJavascript = 'onClick="javascript: aigapMenuShow();"';
            
        }
        
        $carouselID = "image-carousel-" . $uTabID . "-" . $tiID;
        
        $imageList = array();

        $multipleValues = $tabOutput["multipleValues"];
        if ( !empty($tabOutput["multipleValues"]) ) {
            if ( count($multipleValues) > 0 ) {
                $multipleValues_0 = $multipleValues[0];
                $outputValues = $multipleValues_0["outputValues"];
                if ( count($outputValues) > 0 ) {
                    $imageList = $outputValues;
                }
            }
        }
        
        if ( !empty( $parameters["emptyImageURL"]) ) {
            if ( $parameters["emptyImageURL"] != "" ) {
                $emptyImageURL = $parameters["emptyImageURL"];
                if ( count($imageList) == 0 ) {
                    $imageList[] = array( "value" => $emptyImageURL, "name" => $emptyImageURL );
                }
            }
        }
                                                
        $styles = $this->processParameters( $parameters );
        
        if ( $aigapMenuStatus ) {
            
            $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
            $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
            
            $params = array();
            $params["firstID"] = 0;
            $params["tranID"] = $tranID;
            $params["claimID"] = $claimID;
            $params["ID"] = 0;
            $params["tiID"] = $tiID;
            $params["actionTranID"] = $actionTranID;
            $params["devRerouteServerApi"] = $devRerouteServerApiEnc;
            
            $paramsJson = json_encode( $params );
            $paramsJsonEnc = rawurlencode( $this->AES256_encrypt( $paramsJson ) );
            
            //echo "<br><br>REQ<br><br>".$paramsJsonEnc."<br><br>";
            
        $return .= '<style>'
                . '.aigap-menu { display: none; position: absolute; top: 0; left: 0; min-width: 5px; min-height: 5px; background-color: #FFFFFF; border-radius: 6px; overflow: hidden; z-index: 1000; }'
                . '.aigap-menu tr { display: none; }'
                . '.aigap-menu tr:nth-child(even) { background-color: #EDEDED; }'
                . '.aigap-menu td { padding: 8px; }'
                . '</style>';
        
        $return .= '<script>'
                . 'function aigapMenuShow() {'
                . '$(".aigap-menu > table > tbody").html("");'
                . ' $(".aigap-menu").fadeIn("fast", function(){'
                . '$(this).mouseleave(function(){'
                . 'aigapMenuHide();'
                . '});'
                . '});'
                . '$(document).ready(function(){'
                . '$.ajax({'
		. 'url: "get.json.php",'
		. 'type: "POST",'
		. 'crossDomain: true,'
		. 'data: {'
                . '"get": "aigapMenu",'
                . '"params" : "'.$paramsJsonEnc.'"'
		. '},'
		. 'dataType: "json",'
		. 'success: function (result) {'
                . 'var resultJson = JSON.parse( JSON.stringify(result) );'
		. 'if ( resultJson.returnCode.messageID === 0 ) {'
                . 'var claimData = resultJson.responseData.claimData;'
                . '$(claimData).each( function( index, item ) {'
                . 'var valuesString = encodeURIComponent( JSON.stringify(item.values) );'
                . 'var appendItemString = "<tr onClick=\"javascript: aigapMenuSelect( \'"+valuesString+"\' );\" style=\"cursor: pointer;\"><td>"+item.ID+"</td><td>"+item.name+"</td></tr>"; '
                . 'var appendItem = $(appendItemString);'
                . ' $(".aigap-menu > table > tbody").append( appendItem ); '
                . 'appendItem.delay( ( index * 100 ) ).fadeIn("slow");'
                . '});'
                . '}'
                . '},'
		. 'error: function (xhr, status, error) {'
                . 'console.log(  status + " : " + error );'
		. 'showMessageBottom( error, "e" );'
		. '}'
                . ''
                . '});'
                . '});'
                . '}'
                . ''
                . 'function aigapMenuHide() {'
                . '$(".aigap-menu").fadeOut("fast");'
                . '}'
                . 'function aigapMenuSelect( selected ) {'
                . 'var selectedJson = JSON.parse(decodeURIComponent(selected));'
                . 'var selectedNew = {};'
                . '$(selectedJson).each( function( index, item ){'
                . 'var field_ = item.field;'
                . 'field_ = field_.replace("aigap_framework_action_type_change_","");'
                . 'var val_ = item.val;'
                . 'console.log( field_+">"+val_ );'
                . 'selectedNew[field_] = val_;'
                . '});'
                . 'console.log( selectedNew );'
                . 'aigapMenuHide()'
                . '}'
                . '</script>';
        
        }
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].' position: relative;">';
        
        
        $itemHeight = $parameters["itemHeight"];
        $webItemWidth = $parameters["webItemWidth"];
        
        foreach( $imageList as $idx => $image ) {
        $return .= '<div class="carousel-item '.($idx==0?"active":"").' '.$clickClass.'" '.$clickJavascript.' >';
        $return .= '<img class="d-block w-100" src="'.$image["value"].'" height="'.$itemHeight.'" width="'.$webItemWidth.'" alt="'.$image["name"].'">';
        $return .= '</div>';
        }
        
        if ( $aigapMenuStatus ) {
            
        $return .= '<div class="aigap-menu">'
                . '<table cellpadding="0" cellspacing="0">'
                . '<tbody>'
                . '<tr><td colspan="2"><img src="/images/ajax-loader-new.gif"></td></tr>'
                . ''
                . ''
                . '</tbody>'
                . '</table>'
                . '</div>';
        }
        
        $return .= '</div>';
        $return .= '</div>';
        
        return $return;
        
    }
    
    function inputTypeID_28( $tabOutput = array(), $parameters = array() ){
        
        
        $styles = $this->processParameters( $parameters );

        $multipleValues = $tabOutput["multipleValues"];

        $width = "800";
        $height = "600";
        
        if ( !empty($parameters["width"]) ) {
            if ( $parameters["width"] != "" && $parameters["width"] > 0 ) {
                $width = $parameters["width"];
            }
        }
        
        if ( !empty($parameters["height"]) ) {
            if ( $parameters["height"] != "" && $parameters["height"] > 0 ) {
                $height = $parameters["height"];
            }
        }
        

        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">';
        //$return .= json_encode( $tabOutput );
        
        $extensionList = array("mp4","avi","mpg","mpeg","3gp");
        
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                foreach( $outputValues as $outputValue ) {
                    
                    $name_ = $outputValue["name"];
                    $value_ = $outputValue["value"];
                    
                    $extension_ = pathinfo($value_, PATHINFO_EXTENSION);
                    
                    if ( in_array($extension_, $extensionList) ) {
                        $return .= '<video width="'.$width.'" height="'.$height.'" controls>';
                        $return .= '<source src="'.$value_.'" type="video/mp4">';
                        $return .= '</video>';
                    }
                }
            }
        }
        
        $return .= '</div>';
        $return .= '</div>';
        
        
        return $return;
    }

    function inputTypeID_30( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
                

        //$parameters = json_decode( $tabOutput["parameters"], true);
        $multipleValues = $tabOutput["multipleValues"];
        
        //print_r( $tabOutput );
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $styles = $this->processParameters( $parameters );
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'"><img src="https://chart.googleapis.com/chart?cht=qr&chs=150x150&choe=UTF-8&chl='.$valueString.'" width="150" height="150"></div>';
        $return .= '</div>';
        
        return $return;
    }

    function inputTypeID_33( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
                

        //$parameters = json_decode( $tabOutput["parameters"], true);
        $multipleValues = $tabOutput["multipleValues"];
        
        //echo json_encode( $tabOutput );
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $styles = $this->processParameters( $parameters );
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">'. nl2br($valueString).'</div>';
        $return .= '</div>';
        
        return $return;
    }

    function inputTypeID_38( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $return = '';
                

        
        $ID = $tabOutput["ID"];        
        $tabID = $tabOutput["tabID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $claimID = $tabOutput["claimID"];
        $actionTranID = $tabOutput["actionTranID"];
        $uTabID = "xxxx-xxxx-xxxx";
        //$parameters = json_decode( $tabOutput["parameters"], true);
        $multipleValues = $tabOutput["multipleValues"];
        $tranFields = array();
        $includedClaim = $tabOutput["includedClaim"];
        $listRange = $tabOutput["max"];
        
        $columnCount = "1";
        if ( !empty($parameters["columnCount"]) ) {
            $columnCount = $parameters["columnCount"];
        }
        $middleSpace = !empty($parameters["middleSpace"])?$parameters["middleSpace"]:"0";
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
        $devRerouteServerApiDec = json_decode( $devRerouteServerApiJson, true );
        
        //echo json_encode( $tabOutput );
        //print_r( $tabOutput );
        
        $valueString = "";
        $valueTextString = "";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];

                $valueString = $outputValues_0["value"];
                $valueTextString = $outputValues_0["text"];
            }
        }
        
        $parameters["itemHeight"] = "";
        
        $styles = $this->processParameters( $parameters );
        
        $randUUID = "iti_38_" . str_replace( "-", "_", $this->GUID() );
        
        
        $lastID = "0";
        $lastGroupID = "0";
        
        if ( $includedClaim == "1" ) {            
            if ( !empty($tabOutput["frameworkClaimData"]) ) {
                $frameworkClaimData = $tabOutput["frameworkClaimData"];
                if ( count($frameworkClaimData) > 0 ) {
                    $frameworkClaimData_0 = $frameworkClaimData[0];
                    if ( !empty($frameworkClaimData_0["claimData"]) ) {
                        $claimData_ = json_decode( json_encode( $frameworkClaimData_0["claimData"] ), true);
                    }
                }
            }
        }
        else {
                                                     
            $GetFrameworkClaimData = $this->services_AigapGetClaim( "", 0, 0, $listRange, $claimID, $tiID, $ID, $tranID, $actionTranID, "", "", 0, $devRerouteServerApiDec, $uTabID );
            $GetFrameworkClaimData_jsonData = json_decode( $GetFrameworkClaimData["jsonDataDecrypted"], true );
            
            $lastID = $GetFrameworkClaimData_jsonData["lastID"];
            $lastGroupID = $GetFrameworkClaimData_jsonData["lastGroupID"];
            
            $claimData_ = $GetFrameworkClaimData_jsonData["claimData"];
            
        }
           
        
        $return .= "<script> $(document).ready(function(){ inputTypeID_38_scrollListener( '".$randUUID."' ); }); </script> ";
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'" toaTiID = "'.$tiID.'" class="inputTypeID_38" firstID="0" lastID="'.$lastID.'" lastGroupID="'.$lastGroupID.'" listRange="'.$listRange.'" columnCount="'.$columnCount.'" claimID = "'.$claimID.'" tranID="'.$tranID.'" tabID="'.$tabID.'" tiID="'.$tiID.'" actionTranID="'.$actionTranID.'" devRerouteServerApi = "'.$devRerouteServerApiEnc.'"  disableScroll="0" id="'.$randUUID.'">';
       
        /*
        $return .= '<style>';
	$return .= 'table tr { all:unset; }';
	$return .= 'table tr td:hover { background-color: #CCCCCC; }';
	$return .= '</style>';
         * 
         */
                
        $formatParse = explode(",", $format);
	if ( in_array("1",$formatParse)) {
            $return .= "<script> $(document).ready(function(){ menu_add_show(); });</script>";
	}
	if ( in_array("4",$formatParse)) {
            $return .= "<script> $(document).ready(function(){ menu_filter_show(); });</script>";
	}
								
        
        //$return .= json_encode( $tabOutput );
        
        $return .= '<script>'
        . '$(document).ready( function(){ '
        . 'var columnSize = '.$columnCount.'; '
        . 'var parentObject = $("[toaTiID_l2='.$tiID.']"); '
        . 'var parentWidth = parentObject.width(); '
        . 'var newWidth = Math.floor( parentWidth / columnSize ) - 1; '
        . '$(parentObject).children("div").each( function( index, item ) { '
        . '$(item).css({ width: newWidth+"px", maxWidth: newWidth+"px" }); '
        . '}); '
        . '}); '
        . '</script>';
                
                
	$return .= '<div style=" " toaTiID_l2 = "'.$tiID.'" >';
        

        
        $estimatedWidth = round( 100 / $columnCount ) ."%";
        
	$i = 0;
        if ( count( $claimData_ ) > 0 ) {
            foreach( $claimData_ as $claimDataRow ) {

                $i++;

                $ID_ = $claimDataRow["ID"];
                $name_ = $claimDataRow["name"];
                $imageURL_ = $claimDataRow["imageURL"];

                $return .= '<div style="display: inline-table; max-width: '.$estimatedWidth.'; width: '.$estimatedWidth.'; vertical-align: top;" >';
                if ( $imageURL_ != "" ) {
                    $return .= '<div style="padding: 10px;"><img src="'.$imageURL_.'" heigth="200" width="100%"></div>';
                }
                if ( $name_ != "" ) {
                    $return .= '<div style="padding: 10px; font-weight: bold;">'.$name_.'</div>';
                }
                
                $dynamicView_ = $claimDataRow["dynamicView"];

                if ( count($dynamicView_) > 0 ) {

                    $dynamicView_new_ = $this->dynamicViewLoop( $dynamicView_ );

                    $dynamicViewGen_ = $this->dynamicView( $dynamicView_new_, $tiID, $devRerouteServerApiEnc );
                    $return .= '<div>'.$dynamicViewGen_.'</div>';

                }
                
                $return .= '</div>';


            }
        } else {
            
            $return .= '<div>'.$this->getLanguageValue("m.NoData", $languageCode).'</div>';
            
        }
                              		
        $return .= '</div>';
        $return .= '</div>';
        if ( $includedClaim != "1" ) {
        $return .= '<div style="text-align: center;"><div class="buttonLoadStatus"><i class="fas fa-spinner fa-pulse progressIcon"></i> '.$this->getLanguageValue( "b.LoadNext" ).'</div>';
        }
        $return .= '</div>';
        
        return $return;
    }

    function inputTypeID_39( $tabOutput = array(), $parameters = array(), $tranID = 0, $tabOutputActions = array() ){
        return $this->inputTypeID_17( $tabOutput, $parameters, $tranID, $tabOutputActions = array(), true );
    }
    
    function inputTypeID_42( $tabOutput = array(), $parameters = array(), $tranID = 0, $tabOutputActions = array() ){
        
        $return = '';
                
        //echo json_encode( $tabOutput  );
        
        $tabID = $tabOutput["tabID"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];
        $referFwID = $tabOutput["referFwID"];
        $uTabID = "";
        $menuTranID = "0";
        $menuCategoryID = "0";
        $menuName = "";
        $menuParentName = "";
        $designPropertyID = "0";
        $designPropertyTypeID = "0";
        
        $webIsGroupOrientationVertical = !empty($parameters["webIsGroupOrientationVertical"])? ( $parameters["webIsGroupOrientationVertical"]=="1"?true:false ) : false;
        
        $tiID = $tabOutput["tiID"];
        $actionTranID = $tabOutput["actionTranID"];
        $tdWidth = "100%";
        
        $styles = $this->processParameters( $parameters );
        
        $tabOutputActions_status = false;
        $tabOutputActions_ = array();
        if ( !empty( $tabOutputActions[$tiID] ) ) {
            $tabOutputActions_status = true;
            $tabOutputActions_ = $tabOutputActions[$tiID];
        }
                
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
        $devRerouteServerApiDec = json_decode( $devRerouteServerApiJson, true );
                
        $parameterTemplate = "";
        $parameterTemplateDelete = "";
        
        $format = $tabOutput["format"];
        
        $formatParse = explode(",", $format);

        if ( in_array("2",$formatParse)) {

        $tranCallerTypeID_ = 0;
        //if ( $tranAsID ) { $tranCallerTypeID_ = 11; }

        $name_A = "";
        $name_AA = "";
        
        $parameterTemplate = base64_encode("{ \"tranID\" : ".$actionTranID.", \"actionTiID\" : \"".$tiID."\", \"menuName\" : \"".$name_A."\", \"menuParentName\" : \"".$name_AA."\", \"ID\" : \"[[ID]]\", \"fieldName\" : \"".$prmInput."\", \"fieldValue\" : \"[[ID]]\", \"tableID\" : \"".$tableID."\", \"uTabIDSend\" : \"".$uTabID."\", \"menuTranID\" : \"".$menuTranID."\", \"menuCategoryID\" : \"".$menuCategoryID."\", \"menuName\" : \"".$menuName."\", \"menuParentName\" : \"".$menuParentName."\", \"designPropertyTypeID\" : \"".$designPropertyTypeID."\", \"designPropertyID\" : \"".$designPropertyID."\", \"devRerouteServerApi\" : \"".$devRerouteServerApiDec."\", \"tranCallerTypeID\" : ".$tranCallerTypeID_." }");

        }



        
        $frameworkClaimData = $tabOutput["frameworkClaimData"];
        
        //echo json_encode( $frameworkClaimData )."<br><br>";
        
        $itemSelectedBackgroundColor = empty($parameters["itemSelectedBackgroundColor"])? "" : "#".$parameters["itemSelectedBackgroundColor"];
        $itemSelectedTextColor = empty($parameters["itemSelectedTextColor"]) ? "" : "#".$parameters["itemSelectedTextColor"];
        $itemHoverBackgroundColor = empty($parameters["itemHoverBackgroundColor"]) ? "" : "#".$parameters["itemHoverBackgroundColor"];
        $itemHoverTextColor = empty($parameters["itemHoverTextColor"]) ? "" : "#".$parameters["itemHoverTextColor"];
        
        $return .= '
            <style>
            .inputType_tiID_'.$tiID.'_item:hover { background-color: '.$itemHoverBackgroundColor.'; color: '.$itemSelectedTextColor.'; }
            .inputType_tiID_'.$tiID.'_item.selected { background-color: '.$itemSelectedBackgroundColor.'; color: '.$itemHoverTextColor.'; }
            </style>
        ';
        
        if ( count($frameworkClaimData) > 0 ) {

            $frameworkClaimData_0 = $frameworkClaimData[0];
            $claimData = $frameworkClaimData_0["claimData"];
            $claimGroupData = $frameworkClaimData_0["claimGroupData"];
            $claimGroupDataNew = array();
            
            //echo json_encode( $claimData )."<br><br>";
            
            if ( count($claimGroupData) > 0 ) {
                foreach( $claimGroupData as $claimGroupDataRow ) {
                    
                    $claimGroupDataRowNew = $claimGroupDataRow;
                    
                    $claimGroupDataRow_ID = $claimGroupDataRow["ID"];
                    
                    $claimGroupData_claimData = array();
                    if ( count($claimData) > 0 ) {
                        foreach( $claimData as $claimDataRow ) {
                            
                            $claimDataRow_groupID = $claimDataRow["groupID"];
                            
                            if ( $claimGroupDataRow_ID == $claimDataRow_groupID ) {
                                $claimGroupData_claimData[] = $claimDataRow;
                            }
                        }
                    }
                    
                    $claimGroupDataRowNew["claimData"] = $claimGroupData_claimData;
                    $claimGroupDataNew[] = $claimGroupDataRowNew;
                    
                    //echo json_encode($claimGroupDataRow)."<br>";
                }
            }
            
            //echo json_encode( $claimGroupDataNew )."<br>";
            
            $fields = $frameworkClaimData_0["fields"];
            $footer = $frameworkClaimData_0["footer"];

            $imageURLStatus = false;
            $tdWidth = "50%";
            if ( count($fields) > 0 ) {
            $tdWidth = ceil( 100 / count($fields) ) . "%";
                foreach( $fields as $field ) {
                    if ( $field["field"] == "imageURL" ) {
                    $imageURLStatus = true;
                    break;
                    }
                }
            }
            
            $return .= '<div class="" style="'.$styles["style_1"].'">';
            $return .= '<div style="'.$styles["style_2"].'" toaTiID = "'.$tiID.'">';
            
            $return .= '<table class="table table-striped" width="100%">';

            if ( count($fields) > 0 ) {
            $return .= '<thead>';
            $return .= '<tr>';
            foreach( $fields as $field ) {
            $return .= '<td width="'.$tdWidth.'" ><div style="font-weight:bold;">'.$field["field"].'</div></td>';
            }
            if ( in_array("3",$formatParse)) { $return .= '<td>&nbsp;</td>'; }
            $return .= '</tr>';
            $return .= '</thead>';
            }
            
            
            if ( count($claimGroupDataNew) > 0 ) {
                                
                $return .= '<tbody>';
                if ( $webIsGroupOrientationVertical ) {
                    foreach( $claimGroupDataNew as $claimGroupDataNewRow ) {

                        $group_name = $claimGroupDataNewRow["name"];
                        $group_claimData = $claimGroupDataNewRow["claimData"];

                        $return .= $this->inputTypeID_42_claimData( $tranID, $tabID, $tiID, $actionTranID, $group_claimData, $tdWidth, $format, $group_name, $claimGroupDataNewRow, $tabOutputActions_, $devRerouteServerApiEnc, $prmInput, $tableID );
                    }
                }
                else {
                    
                    
                    $return .= '<tr>';
                    foreach( $claimGroupDataNew as $claimGroupDataNewRow ) {

                        $group_name = $claimGroupDataNewRow["name"];
                        $group_claimData = $claimGroupDataNewRow["claimData"];

                        $return .= '<td valign="top">';
                        $return .= '<table>';
                        $return .= '<tbody>';
                        $return .= '<tr><td>';
                        $return .= $this->inputTypeID_42_claimData( $tranID, $tabID, $tiID, $actionTranID, $group_claimData, $tdWidth, $format, $group_name, $claimGroupDataNewRow, $tabOutputActions_, $devRerouteServerApiEnc, $prmInput, $tableID );
                        $return .= '</td></tr>';
                        $return .= '</tbody>';
                        $return .= '</table>';
                        $return .= '</td>';
                        
                    }
                    $return .= '</tr>';
                    
                }
                
                $return .= '</tbody>';
            }
            else {
                
                $return .= '<tbody>';

                $return .= $this->inputTypeID_42_claimData( $tranID, $tabID, $tiID, $actionTranID, $claimData, $tdWidth, $format, NULL, NULL, $tabOutputActions_, $devRerouteServerApiEnc, $prmInput, $tableID );

                $return .= '</tbody>';


            }
            
            $return .= '</table>';

        }
        
        $return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function inputTypeID_42_claimData( $tranID, $tabID, $tiID, $actionTranID, $claimData, $tdWidth = "50%", $format, $groupName = "", $groupDataArray = array(), $tabOutputActions = array(), $devRerouteServerApiEnc = "", $prmInput = "", $tableID = "0"  ) {
        
        $return = "";
                
        $valuesDismiss = array("aigap_framework_claim_action_openWebURL");
        
        $uTabID = "";
        $designPropertyID = "0";
        $designPropertyTypeID = "0";
        $tranCallerTypeID_ = "0";
        
        if ( $groupName != "" ) {
            
            $groupData_style = $this->viewTypeID_style( $groupDataArray );
            
            $return .= '<tr><td colspan="10" style="'.$groupData_style.'"><b>'.$groupName."</b></td></tr>";    
        }
                
        $tabOutputActions_status = false;
        if ( !empty( $tabOutputActions ) ) {
            $tabOutputActions_status = true;
        }
        
        $formatParse = explode(",", $format);
        
        //echo json_encode( $claimData ) . "<br><br>";
        
        if ( count($claimData) > 0 ) {
            foreach( $claimData as $claimDataRow ) {

                $ID = $claimDataRow["ID"];
                $name = $claimDataRow["name"];
                $values = $claimDataRow["values"];
                $imageURL = $claimDataRow["imageURL"];
                //$actionTranID = $claimDataRow["actionTranID"];
                

                $leftView_ = $claimDataRow["leftView"]["customClaimData"];
                $leftView_orientation = $claimDataRow["leftView"]["orientation"];
                $rightView_ = $claimDataRow["rightView"]["customClaimData"];
                $rightView_orientation = $claimDataRow["leftView"]["orientation"];
                $fields = $claimDataRow["fields"];

                $imageURLStatus = true;
                $tdWidth = "50%";
                if ( count($fields) > 0 ) {
                    $imageURLStatus = false;
                $tdWidth = ceil( 100 / count($fields) ) . "%";
                    foreach( $fields as $field ) {
                        if ( $field["field"] == "imageURL" ) {
                        $imageURLStatus = true;
                        break;
                        }
                    }
                }
            
                //$rightView_orientation = $claimDataRow["leftView"]["orientation"];

                $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );


                if ( in_array("3",$formatParse)) {

                  $deleteParameters = array( "input" => array("tiID" => $actionTranID, "tableID" => $tableID, "value" => "1", "ID" => $ID, "tabID" => $tabID), "tran" => array( "prmInput" => $prmInput, "ID" => $ID, "tableID" => $tableID, "tranID" => $actionTranID ) , "actionTiID" => $tiID, "designPropertyTypeID" => $designPropertyTypeID, "designPropertyID" => $designPropertyID, "devRerouteServerApi" => $devRerouteServerApiEnc );
                }

                $URL_42 = "tran.tabs.frame.php?data=".base64_encode("{ \"tranID\" : ".$actionTranID.", \"menuName\" : \"".$name."\", \"menuParentName\" : \"".$name."\", \"ID\" : \"".$ID."\", \"fieldName\" : \"".$prmInput."\", \"fieldValue\" : \"".$ID."\", \"tableID\" : \"".$tableID."\", \"uTabIDSend\" : \"".$uTabID."\",  \"designPropertyTypeID\" : \"".$designPropertyTypeID."\", \"designPropertyID\" : \"".$designPropertyID."\", \"devRerouteServerApi\" : \"".$devRerouteServerApiEnc."\", \"tranCallerTypeID\" : \"".$tranCallerTypeID_."\"  }");
                $URL_delete_42 = "tran.save.async.php?deleteParameters=".base64_encode(json_encode($deleteParameters))."&editID=".$ID."&tranID=".$actionTranID."&stateID=3";

                $onClick_string_42 = "";
                if ( in_array("2",$formatParse) ) { 
                    $targetURLGen = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
                    $onClick_string_42 = "onClick=\"javascript:onClick( '".$targetURLGen."' );\" class=\"onClickView inputType_tiID_".$tiID."_item\" title=\"".$name."\" alt=\"".$name."\"";
                }
                
                if ( $tabOutputActions_status ) {
                                        
                    $tabOutputActions_enc = urlencode(json_encode($tabOutputActions));
                    $tranFields = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                    $tranFields_enc = urlencode(json_encode($tranFields));
                    $onClick_string_42 = "onClick=\"javascript:tabOutputActions( this, '".$tranID."', '".$tabID."', '0','".$tabOutputActions_enc."', '".$tranFields_enc."', '".$devRerouteServerApiEnc."', '".$ID."' );\" class=\"onClickView inputType_tiID_".$tiID."_item\" title=\"".$name."\" alt=\"".$name."\"";
                }

                $openWebURL = "";
                if ( count($values) > 0 ) {
                    foreach ( $values as $value ) {
                        $field = $value["field"];
                        $val = $value["val"];
                        if ( $field == "aigap_framework_claim_action_openWebURL" ) {
                            $openWebURL = $val;
                        }
                    }
                }

                if ( $openWebURL != "" ) {
                    $onClick_string_42 = "onClick=\"javascript:onClick( '".$openWebURL."' );\" class=\"onClickView\" title=\"".$name."\" alt=\"".$name."\" ";
                }
                
                $return .= '<tr>';
                if ( count($leftView_) > 0 ) {
                    $leftViewGen = $this->genereteView( $leftView_orientation, $leftView_);
                    $return .= '<td '.$onClick_string_42.'>'.$leftViewGen.'</td>';
                }

                if ( $imageURLStatus && $imageURL != "" ) {
                    $return .= '<td><img src="'.$imageURL.'" height="60" class="mx-auto d-block"></td>';
                }

                $claimDataRow_style = $this->viewTypeID_style( $claimDataRow );
                
                $return .= '<td width="'.$tdWidth.'" '.$onClick_string_42.' style="'.$claimDataRow_style.'">'.$name.'</td>';
                if ( count($values) > 0 ) {
                foreach( $values as $value ) {
                    $field = $value["field"];
                    $val = $value["val"];
                    if ( !in_array( $field, $valuesDismiss)) {
                        
                        $value_style = $this->viewTypeID_style($value);
                        $return .= '<td width="'.$tdWidth.'" '.$onClick_string_42.' style="'.$value_style.'">'.$val.'</td>';
                    }
                }
                }
                if ( count($rightView_) > 0 ) {
                    $rightViewGen = $this->genereteView( $rightView_orientation, $rightView_);
                    $return .= '<td '.$onClick_string_42.'>'.$rightViewGen.'</td>';
                }

                /*
                if ( in_array("3",$formatParse)) {
                    <td bgcolor="#FF0000" onClick="javascript:tableOnClick('<?php echo $URL_delete_42 ?>', '1','','<?php echo $actionTranID; ?>','0','0','<?php echo $uTabID; ?>');" width="1">
                    <div style="padding: 10px; color: #FFFFFF; font-size: 14px; "><?php echo $this->getLanguageValue("b.Delete"); ?></div>
                    </td>
                }*/
                $return .= '</tr>';

                $dynamicView_ = $claimDataRow["dynamicView"];
                
                if ( count($dynamicView_) > 0 ) {

                    $dynamicView_new_ = $this->dynamicViewLoop( $dynamicView_ );

                    $dynamicViewGen_ = $this->dynamicView( $dynamicView_new_, $tiID, $devRerouteServerApiEnc );
                    $return .= '<tr><td '.$onClick_string_42.' colspan="10" style="position: relative;">'.$dynamicViewGen_.'</td></tr>';

                }

            }
        }
        
        return $return;
    }
    
    function inputTypeID_42_claimData_vertical( $tranID, $tabID, $tiID, $actionTranID, $claimData, $tdWidth = "50%", $format, $groupName = "", $groupDataArray = array(), $tabOutputActions = array(), $devRerouteServerApiEnc = "", $prmInput = "", $tableID = "0"  ) {
        
        $return = "";
                
        $valuesDismiss = array("aigap_framework_claim_action_openWebURL");
        
        $uTabID = "";
        $designPropertyID = "0";
        $designPropertyTypeID = "0";
        $tranCallerTypeID_ = "0";
        
        if ( $groupName != "" ) {
            
            $groupData_style = $this->viewTypeID_style( $groupDataArray );
            
            $return .= '<tr><td colspan="10" style="'.$groupData_style.'"><b>'.$groupName."</b></td></tr>";    
        }
                
        $tabOutputActions_status = false;
        if ( !empty( $tabOutputActions ) ) {
            $tabOutputActions_status = true;
        }
        
        $formatParse = explode(",", $format);
        
        //echo json_encode( $claimData ) . "<br><br>";
        
        if ( count($claimData) > 0 ) {
            foreach( $claimData as $claimDataRow ) {

                $ID = $claimDataRow["ID"];
                $name = $claimDataRow["name"];
                $values = $claimDataRow["values"];
                $imageURL = $claimDataRow["imageURL"];
                //$actionTranID = $claimDataRow["actionTranID"];
                

                $leftView_ = $claimDataRow["leftView"]["customClaimData"];
                $leftView_orientation = $claimDataRow["leftView"]["orientation"];
                $rightView_ = $claimDataRow["rightView"]["customClaimData"];
                $rightView_orientation = $claimDataRow["leftView"]["orientation"];
                $fields = $claimDataRow["fields"];

                $imageURLStatus = false;
                $tdWidth = "50%";
                if ( count($fields) > 0 ) {
                $tdWidth = ceil( 100 / count($fields) ) . "%";
                    foreach( $fields as $field ) {
                        if ( $field["field"] == "imageURL" ) {
                        $imageURLStatus = true;
                        break;
                        }
                    }
                }
            
                //$rightView_orientation = $claimDataRow["leftView"]["orientation"];

                $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );


                if ( in_array("3",$formatParse)) {

                  $deleteParameters = array( "input" => array("tiID" => $actionTranID, "tableID" => $tableID, "value" => "1", "ID" => $ID, "tabID" => $tabID), "tran" => array( "prmInput" => $prmInput, "ID" => $ID, "tableID" => $tableID, "tranID" => $actionTranID ) , "actionTiID" => $tiID, "designPropertyTypeID" => $designPropertyTypeID, "designPropertyID" => $designPropertyID, "devRerouteServerApi" => $devRerouteServerApiEnc );
                }

                $URL_42 = "tran.tabs.frame.php?data=".base64_encode("{ \"tranID\" : ".$actionTranID.", \"menuName\" : \"".$name."\", \"menuParentName\" : \"".$name."\", \"ID\" : \"".$ID."\", \"fieldName\" : \"".$prmInput."\", \"fieldValue\" : \"".$ID."\", \"tableID\" : \"".$tableID."\", \"uTabIDSend\" : \"".$uTabID."\",  \"designPropertyTypeID\" : \"".$designPropertyTypeID."\", \"designPropertyID\" : \"".$designPropertyID."\", \"devRerouteServerApi\" : \"".$devRerouteServerApiEnc."\", \"tranCallerTypeID\" : \"".$tranCallerTypeID_."\"  }");
                $URL_delete_42 = "tran.save.async.php?deleteParameters=".base64_encode(json_encode($deleteParameters))."&editID=".$ID."&tranID=".$actionTranID."&stateID=3";

                $onClick_string_42 = "";
                if ( in_array("2",$formatParse) ) { 
                    $targetURLGen = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
                    $onClick_string_42 = "onClick=\"javascript:onClick( '".$targetURLGen."' );\" class=\"onClickView inputType_tiID_".$tiID."_item\" title=\"".$name."\" alt=\"".$name."\"";
                }
                
                if ( $tabOutputActions_status ) {
                    
                    $tabOutputActions_enc = urlencode(json_encode($tabOutputActions));
                    $tranFields = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                    $tranFields_enc = urlencode(json_encode($tranFields));
                    $onClick_string_42 = "onClick=\"javascript:tabOutputActions( this, '".$tranID."', '".$tabID."', '0', '".$tabOutputActions_enc."', '".$tranFields_enc."', '".$devRerouteServerApiEnc."' );\" class=\"onClickView inputType_tiID_".$tiID."_item\" title=\"".$name."\" alt=\"".$name."\"";
                }

                $openWebURL = "";
                if ( count($values) > 0 ) {
                    foreach ( $values as $value ) {
                        $field = $value["field"];
                        $val = $value["val"];
                        if ( $field == "aigap_framework_claim_action_openWebURL" ) {
                            $openWebURL = $val;
                        }
                    }
                }

                if ( $openWebURL != "" ) {
                    $onClick_string_42 = "onClick=\"javascript:onClick( '".$openWebURL."' );\" class=\"onClickView\" title=\"".$name."\" alt=\"".$name."\" ";
                }
                
                $return .= '<tr>';
                if ( count($leftView_) > 0 ) {
                    $leftViewGen = $this->genereteView( $leftView_orientation, $leftView_);
                    $return .= '<td '.$onClick_string_42.'>'.$leftViewGen.'</td>';
                }

                if ( $imageURLStatus ) {
                    $return .= '<td><img src="'.$imageURL.'" height="60" class="mx-auto d-block"></td>';
                }

                $claimDataRow_style = $this->viewTypeID_style( $claimDataRow );
                
                $return .= '<td width="'.$tdWidth.'" '.$onClick_string_42.' style="'.$claimDataRow_style.'">'.$name.'</td>';
                if ( count($values) > 0 ) {
                foreach( $values as $value ) {
                    $field = $value["field"];
                    $val = $value["val"];
                    if ( !in_array( $field, $valuesDismiss)) {
                        
                        $value_style = $this->viewTypeID_style($value);
                        $return .= '<td width="'.$tdWidth.'" '.$onClick_string_42.' style="'.$value_style.'">'.$val.'</td>';
                    }
                }
                }
                if ( count($rightView_) > 0 ) {
                    $rightViewGen = $this->genereteView( $rightView_orientation, $rightView_);
                    $return .= '<td '.$onClick_string_42.'>'.$rightViewGen.'</td>';
                }

                /*
                if ( in_array("3",$formatParse)) {
                    <td bgcolor="#FF0000" onClick="javascript:tableOnClick('<?php echo $URL_delete_42 ?>', '1','','<?php echo $actionTranID; ?>','0','0','<?php echo $uTabID; ?>');" width="1">
                    <div style="padding: 10px; color: #FFFFFF; font-size: 14px; "><?php echo $this->getLanguageValue("b.Delete"); ?></div>
                    </td>
                }*/
                $return .= '</tr>';

                $dynamicView_ = $claimDataRow["dynamicView"];
                
                if ( count($dynamicView_) > 0 ) {

                    $dynamicView_new_ = $this->dynamicViewLoop( $dynamicView_ );

                    $dynamicViewGen_ = $this->dynamicView( $dynamicView_new_, $tiID, $devRerouteServerApiEnc );
                    $return .= '<tr><td '.$onClick_string_42.'>'.$dynamicViewGen_.'</td></tr>';

                }

            }
        }
        
        return $return;
    }


    function inputTypeID_43( $tabOutput = array(), $parameters = array() ) {
        
        $return = "";
        
        $tiID = $tabOutput["tiID"];
        $actionTranID = $tabOutput["actionTranID"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];

        $aigap = new aigap();
        
        $claimData = array();
        
        $autoPlay = 0;
        $animationTimer = "3000";
        if ( !empty($parameters["animationTimer"]) && $parameters["animationTimer"] > 0 ) {
            $autoPlay = 1;
            $animationTimer = $parameters["animationTimer"] * 1000;
        }
                
        if ( !empty($tabOutput["frameworkClaimData"]) ) {
            $frameworkClaimData = $tabOutput["frameworkClaimData"];
            if ( count($frameworkClaimData) > 0 ) {
                $frameworkClaimData_0 = $frameworkClaimData[0];
                if ( !empty($frameworkClaimData_0["claimData"]) ) {
                    $claimData = $frameworkClaimData_0["claimData"];
                }
            }
        }
        
        $height = str_replace( array( "px", "%"), "", $parameters["itemHeight"] );
        $width = $parameters["webItemWidth"];
        $webItemMaxWidth = $parameters["webItemMaxWidth"];
        $pageControlShow = $parameters["pageControlShow"];
        $thumbnailHeight = str_replace( array( "px", "%"), "", $parameters["thumbnailHeight"] );
        $thumbnailWidth = $parameters["thumbnailWidth"];
        $heightAll = $parameters["itemHeight"] + $parameters["thumbnailHeight"];
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
        
        //echo json_encode( $parameters );
        
        //echo json_encode( $claimData );
        
        $heightCalc = $height;
        if ( $pageControlShow == "1" ) { $heightCalc = $height + $thumbnailHeight + 4; }
        
        
        $styles = $this->processParameters( $parameters );
        
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">';
        
        $return .= '<div id="jssor_'.$tiID.'" style="position: relative; top: 0px; left: 0px; width: '.$webItemMaxWidth.'; height: '.$heightCalc.'px; overflow: hidden;">';
        $return .= '<div data-u="slides" style="position: relative; top: 0px; left: 0px; width: '.$webItemMaxWidth.'; height: '.$height.'px; overflow: hidden;">';
        foreach( $claimData as $claim ) {
            $ID_ = $claim["ID"];
            $name_ = $claim["name"];
            $imageURL_ = $claim["imageURL"];
            $values_ = $claim["values"];
            
            $dynamicView_ = $claim["dynamicView"];
            
                        
            $genURL = "";
            if ( $actionTranID > 0 ) {
                
                $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
                
                $genUrlString = $this->textToParameter($name_)."?t=".$actionTranID."&i=".$ID_."&ati=".$tiID."&trf=".$tranFieldsJsonEnc;
                $genURL = "onClick = \"javascript:onClick( '".$genUrlString."' ); \"";
            }
            $return .= '<div '.$genURL.' data-fillmode="5">';
            $return .= '<img data-u="image" src="'.$imageURL_.'" />';
            $return .= '<img data-u="thumb" src="'.$imageURL_.'" />';
            

            if ( !empty($dynamicView_) && count($dynamicView_) > 0 ) {
                
                $dynamicView_new_ = $this->dynamicViewLoop( $dynamicView_ );
                $positionStyle_ = "";
                                            
                $firstItem = array_values($dynamicView_new_)[0];
                $firstItemMargin = $firstItem["customClaimData"][0]["margin"];
                                
                $positionStyle = "top: 0; left: 0; width: 100%; height: 100%; ";

                
                $return .= '<div style="position: absolute; '.$positionStyle.'>';
                $return .= $this->dynamicView( $dynamicView_new_, $tiID, $devRerouteServerApiEnc );
                $return .= '</div>';
            }
            
            $return .= '</div>';
        }
        
        $return .= '</div>';

        if ( $pageControlShow == 1 ) {
            
        $return .= '<style>
            .jssora106 {display:block;position:absolute;cursor:pointer;}
            .jssora106 .c {fill:#fff;opacity:.3;}
            .jssora106 .a {fill:none; stroke-width:350;stroke-miterlimit:10;}
            .jssora106:hover .c {opacity:.5;}
            .jssora106:hover .a {opacity:.8;}
            .jssora106.jssora106dn .c {opacity:.2;}
            .jssora106.jssora106dn .a {opacity:1;}
            .jssora106.jssora106ds {opacity:.3;pointer-events:none;}
            
            .jssort101 .p {position: absolute;top:0;left:0;box-sizing:border-box;}
            .jssort101 .p .cv {position:relative;top:0;left:0;width:100%;height:100%; box-sizing:border-box;z-index:1;}
            .jssort101 .a {fill:none;stroke:#fff;stroke-width:400;stroke-miterlimit:10;visibility:hidden;}
            .jssort101 .p:hover .cv, .jssort101 .p.pdn .cv {border:none;border-color:transparent;}
            .jssort101 .p:hover{padding:2px;}
            .jssort101 .p:hover .cv {background-color:rgba(0,0,0,6);opacity:.35;}
            .jssort101 .p:hover.pdn{padding:0;}
            .jssort101 .p:hover.pdn .cv {border:2px solid #fff;background:none;opacity:.35;}
            .jssort101 .pav .cv {border-color:#fff;opacity:.35;}
            .jssort101 .pav .a, .jssort101 .p:hover .a {visibility:visible;}
            .jssort101 .t {position:absolute;top:0;left:0;width:100%;height:100%;border:none;opacity:.6;}
            .jssort101 .pav .t, .jssort101 .p:hover .t{opacity:1;}
        </style>
        <!-- Thumbnail Navigator -->
            <div data-u="thumbnavigator" class="jssort101" style="position:absolute;left:0px;bottom:0px;width:'.$webItemMaxWidth.';height:'.$thumbnailHeight.'px; " data-autocenter="1" data-scale-bottom="0.75">
                <div data-u="slides">
                    <div data-u="prototype" class="p" style="width:'.$thumbnailWidth.'px ;height:'.$thumbnailHeight.'px;">
                        <div data-u="thumbnailtemplate" class="t"></div>
                    </div>
                </div>
            </div>
            ';
        
        }
        
        $return .= '<script>';
        $return .= '    var jssor_' . $tiID . '_slider_SlideshowTransitions = [ { $Duration:1000, $Opacity:2 } ]; ';
        $return .= '    var options_'.$tiID.' = { $AutoPlay: '.$autoPlay.', $Idle: '.$animationTimer.', $ArrowNavigatorOptions: { $Class: $JssorArrowNavigator$ }, $ThumbnailNavigatorOptions : { $Class: $JssorThumbnailNavigator$, $ChanceToShow: 2, $SpacingX: 5, $SpacingY: 5 }, $SlideshowOptions: { $Class: $JssorSlideshowRunner$, $Transitions: jssor_'.$tiID.'_slider_SlideshowTransitions, $TransitionsOrder: 1 } };';
        $return .= '    var jssor_'.$tiID.'_slider = new $JssorSlider$("jssor_'.$tiID.'", options_'.$tiID.');';
        
        $return .= 'function ScaleSlider_'.$tiID.'() {';
        
        $widthNew = str_replace( array("px","%"), "", $width);
        
        $return .= '
		var MAX_WIDTH = 2500;

                    var containerElement = jssor_'.$tiID.'_slider.$Elmt.parentNode;
                    var containerWidth = containerElement.clientWidth;
                    var bodyWidth = document.body.clientWidth;
                    if ( bodyWidth < containerWidth ) { containerWidth = bodyWidth; }

                    if (containerWidth) {

                        var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                        jssor_'.$tiID.'_slider.$ScaleWidth(expectedWidth);
                        
                    }
                    else {
                        window.setTimeout(ScaleSlider, 30);
                    }

	';
        $return .= '}';

        $return .= 'ScaleSlider_'.$tiID.'();';

        $return .= '$(window).bind("load", ScaleSlider_'.$tiID.');';
        $return .= '$(window).bind("resize", ScaleSlider_'.$tiID.');';
        $return .= '$(window).bind("orientationchange", ScaleSlider_'.$tiID.');';
        
        $return .= '</script>';
        
        //echo json_encode( $claimData );
        
        $return .= '</div>';
        
        return $return;
    }
    
    function inputTypeID_45( $tabOutput = array(), $parameters = array() ){
        
        
        $styles = $this->processParameters( $parameters );
        
        $multipleValues = $tabOutput["multipleValues"];
        $tiID = $tabOutput["tiID"];
        
        $width = "800";
        $height = "600";
        
        if ( !empty($parameters["width"]) ) {
            if ( $parameters["width"] != "" && $parameters["width"] > 0 ) {
                $width = $parameters["width"];
            }
        }
        
        if ( !empty($parameters["height"]) ) {
            if ( $parameters["height"] != "" && $parameters["height"] > 0 ) {
                $height = $parameters["height"];
            }
        }

        
        $videoID = "75UtG1z7-Uw";
        if ( !empty($multipleValues) )
        {
            $multipleValues_0 = $multipleValues[0];
            $outputValues = $multipleValues_0["outputValues"];
            if ( !empty($outputValues) ) {
                $outputValues_0 = $outputValues[0];
                $videoID = $outputValues_0["value"];
            }
        }
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">';
        
        $return .= '<div id="youtubeplayer_'.$tiID.'"></div>';
        $return .= '<script>';
        $return .= 'var tag = document.createElement(\'script\');';
        $return .= 'tag.src = "https://www.youtube.com/player_api";';
        $return .= 'var firstScriptTag = document.getElementsByTagName(\'script\')[0];';
        $return .= 'firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);';
        $return .= 'var player;';
        $return .= 'function onYouTubePlayerAPIReady() {';
        $return .= 'player = new YT.Player(\'youtubeplayer_'.$tiID.'\', {';
        $return .= 'autoplay: \'1\', ';
        $return .= 'rel: \'0\', ';
        $return .= 'height: \''.$height.'\', ';
        $return .= 'width: \''.$width.'\', ';
        $return .= 'videoId: \''.$videoID.'\' ';
        $return .= '});';
        $return .= '}';
        $return .= '</script>';
        
        $return .= '</div>';
        $return .= '</div>';
        
        
        return $return;
    }
    
    function inputTypeID_53( $tabOutput = array(), $parameters = array() ){
        
        $return = '';
        
        $tiID = $tabOutput["tiID"];
        
        $apiKey = "AIzaSyBhkS-VAO7ZPw3ZwmJQq5t5FndE4Oz_lQs";
        if ( !empty($parameters["apiKey"]) && $parameters["apiKey"] != "" ) {
            $apiKey = $parameters["apiKey"];
        }
        
        
        
        $defaultLatitude = $parameters["defaultLatitude"];
        $defaultLongitude = $parameters["defaultLongitude"];
        $mapWidth = "400px";
        $mapHeight = "250px";
        
        if ( !empty($parameters["webItemWidth"]) && $parameters["webItemWidth"] != "" ) {
            $mapWidth = $parameters["webItemWidth"];
        }
        
        if ( !empty($parameters["itemHeight"]) && $parameters["itemHeight"] != "" ) {
            $mapHeight = $parameters["itemHeight"];
        }
        
        $styles = $this->processParameters( $parameters );
                
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">';
        
        
        $return .= '<div id="map-'.$tiID.'" class="google_map" style="width: '.$mapWidth.'; height: '.$mapHeight.';"></div>';
        $return .= '<script>';
        $return .= 'function initMap() {';
        $return .= 'var default_'.$tiID.' = {lat: '.$defaultLatitude.', lng: '.$defaultLongitude.'};';
        $return .= 'var map_'.$tiID.' = new google.maps.Map(';
        $return .= 'document.getElementById(\'map-'.$tiID.'\'), {zoom: 4, center: default_'.$tiID.'});';
        $return .= 'var marker_'.$tiID.' = new google.maps.Marker({position: default_'.$tiID.', map: map_'.$tiID.'});';
        $return .= '}';
        $return .= '</script>';
        $return .= '<script async defer src="https://maps.googleapis.com/maps/api/js?key='.$apiKey.'&callback=initMap">';
        $return .= '</script>';

        
        $return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function inputTypeID_63( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $return = '';
        
        $actionTranID = $tabOutput["actionTranID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $prmInput = $tabOutput["prmInput"];
        $ID = "";
        $tableID = $tabOutput["tableID"];
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
                
        $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
        $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
        
                        
        $styles = $this->processParameters( $parameters );
        
        $webItemWidth = $parameters["webItemWidth"];
        //$webItemWidth = str_replace( array( "%", "px" ), "",  $webItemWidth);
        
        
        $buttonStyle = "";
        $textStyle = "";
        
        $itemButtonText = $parameters["itemButtonText"];
        
        if ( !empty($parameters["itemBackgroundColor"]) && $parameters["itemBackgroundColor"] != "clear" ) { $textStyle .= "background-color: #".$parameters["itemBackgroundColor"]."; "; }        
        if ( !empty($parameters["itemTextColor"]) ) {
            $textStyle .= "color: #".$parameters["itemTextColor"]."; ";
        }
        if ( !empty($parameters["itemBorderRadius"]) ) { $textStyle .= "border-radius: ".$parameters["itemBorderRadius"]."px 0 0 ".$parameters["itemBorderRadius"]."px; "; }
        if ( !empty($parameters["itemBorderSize"]) && !empty($parameters["itemBorderColor"]) ) { $textStyle .= "border: ".$parameters["itemBorderSize"]."px solid #".$parameters["itemBorderColor"]."; "; }
        if ( !empty($parameters["itemTextSize"]) ) {
            $textStyle .= "font-size: ".$parameters["itemTextSize"]."px; ";
        }
        if ( !empty($parameters["itemHeight"]) ) { $textStyle .= "height: ".$parameters["itemHeight"]."px; "; }

        if ( !empty($parameters["itemButtonBackgroundColor"]) && $parameters["itemButtonBackgroundColor"] != "clear" ) { $buttonStyle .= "background-color: #".$parameters["itemButtonBackgroundColor"]."; "; }        
        if ( !empty($parameters["itemButtonTextColor"]) ) {
            $buttonStyle .= "color: #".$parameters["itemButtonTextColor"]."; ";
        }
        if ( !empty($parameters["itemButtonBorderRadius"]) ) { $buttonStyle .= "border-radius: 0 ".$parameters["itemButtonBorderRadius"]."px ".$parameters["itemButtonBorderRadius"]."px 0; "; }
        if ( !empty($parameters["itemButtonTextAlignment"]) ) { $buttonStyle .= "text-alignment: ".$parameters["itemButtonTextAlignment"]."; "; }
        if ( !empty($parameters["itemButtonHeight"]) ) { $buttonStyle .= "height: ".$parameters["itemButtonHeight"]."px; "; }
        if ( !empty($parameters["itemButtonWidth"]) ) { $buttonStyle .= "width: ".$parameters["itemButtonWidth"]."px; "; }
        if ( !empty($parameters["itemButtonBorderColor"]) ) { $buttonStyle .= "border-color: #".$parameters["itemButtonBorderColor"]."; "; }
        
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div toaTiID = "'.$tiID.'">';
        
        $return .= '<table width="'.$webItemWidth.'" cellpadding="0" cellspacing="0" style="padding:0; margin: 0;">';
        $return .= '<tr style="padding:0; margin: 0;">';
        $return .= '<td width="100%" style="padding:0; margin: 0;" align="right">';
        
        $return .= '<input type="text" value="" placeholder="'.$name.'" style="'.$textStyle.'" class="mainSearchText" onkeydown="return event.key != \'Enter\';" />';
        
        $return .= '</td>';
        $return .= '<td style="padding:0; margin: 0;" align="left">';
        
        $return .= '<input type="button" value="'.$itemButtonText.'" style="'.$buttonStyle.'" onClick="javascript: searchButtonOnClick( this );" devRerouteServerApi = "'.$devRerouteServerApiEnc.'" actionTranID = "'.$actionTranID.'" nameParameter = "'.$this->textToParameter($name).'" tranFields = "'.$tranFieldsJsonEnc.'" class="mainSearchButton"/>';
        
        $return .= '</td>';
        $return .= '</tr>';
        $return .= '</table>';
        
        $return .= '</div>';
        $return .= '</div>';
                
        return $return;
        
    }
    
    function inputTypeID_65( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $return = '';
        
        $actionTranID = $tabOutput["actionTranID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $prmInput = $tabOutput["prmInput"];
        $ID = "";
        $tableID = $tabOutput["tableID"];
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
                
        $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
        $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
        
                        
        $styles = $this->processParameters( $parameters );
        
        $webItemWidth = $parameters["webItemWidth"];
        //$webItemWidth = str_replace( array( "%", "px" ), "",  $webItemWidth);
        
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'" toaTiID = "'.$tiID.'">';
        
        $return .= '</div>';
        $return .= '</div>';
                
        return $return;
        
    }
    
    function inputTypeID_67( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $return = '';
        
        $actionTranID = $tabOutput["actionTranID"];
        $tiID = $tabOutput["tiID"];
        $name = $tabOutput["name"];
        $prmInput = $tabOutput["prmInput"];
        $ID = "";
        $tableID = $tabOutput["tableID"];
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
                
        $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
        $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
        
                        
        $styles = $this->processParameters( $parameters );
        
        $webItemWidth = $parameters["webItemWidth"];
        $html = $parameters["html"];
        //$webItemWidth = str_replace( array( "%", "px" ), "",  $webItemWidth);
        
        if ( $html != "" ) {
            $return .= '<div class="" style="'.$styles["style_1"].'">';
            $return .= '<div style="'.$styles["style_2"].'" toaTiID = "'.$tiID.'">';
            $return .= $html;
            $return .= '</div>';
            $return .= '</div>';
        }
                
        return $return;
        
    }
    
    function inputTypeID_83( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $return = '';
                        
        //echo json_encode( $tabOutput );
        
        $tiID = $tabOutput["tiID"];
        $actionTranID = $tabOutput["actionTranID"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
        
        $styles = $this->processParameters( $parameters );

        $claimData = array();
        
        if ( !empty($tabOutput["frameworkClaimData"]) ) {
            $frameworkClaimData = $tabOutput["frameworkClaimData"];
            if ( count($frameworkClaimData) > 0 ) {
                $frameworkClaimData_0 = $frameworkClaimData[0];
                if ( !empty($frameworkClaimData_0["claimData"]) ) {
                    $claimData = $frameworkClaimData_0["claimData"];
                }
            }
        }
        
        $maxWidth = "1200";

        $imageHeight = ( $parameters["imageHeight"] == "" || $parameters["imageHeight"] == 0 ) ? "" : 'height="'.$parameters["imageHeight"].'"';
        $itemSpaceLeft = ( $parameters["itemSpaceLeft"] == "" || $parameters["itemSpaceLeft"] == 0 ) ? "" : $parameters["itemSpaceLeft"];
        $itemSpaceRight = ( $parameters["itemSpaceRight"] == "" || $parameters["itemSpaceRight"] == 0 ) ? "" : $parameters["itemSpaceRight"];
        $imageWidth = ( $parameters["imageWidth"] == "" || $parameters["imageWidth"] == 0 ) ? "" : 'width="'.$parameters["imageWidth"].'"';
        $webItemMaxWidth = ( $parameters["webItemMaxWidth"] == "" || $parameters["webItemMaxWidth"] == 0 ) ? "" : $parameters["webItemMaxWidth"];
        $imageBorderColor = ( $parameters["imageBorderColor"] == "" ) ? "" : "border: 1px solid #".$parameters["imageBorderColor"]."";
        $style_li = ( $parameters["middleSpace"] == "" || $parameters["middleSpace"] == 0 ) ? "" : "padding : 0 ".$parameters["middleSpace"]."px 0 0;";        

        $itemSpaceTotal = 0; 
        if ( $webItemMaxWidth != "" ) {
            if ( !preg_match("/%/i", $webItemMaxWidth) ) {
                $maxWidth = str_replace( "px", "", $webItemMaxWidth);
                $itemSpaceTotal =  $itemSpaceLeft + $itemSpaceRight;
            }
        }
        
        
        
        //print_r( $claimData );
        
        $return .= '<script>';
        $return .= '
                 $(document).ready( function(){
                 $("#tiid-'.$tiID.'").slick({
                        dots: false,
                        infinite: true,
                        speed: 300,
                        slidesToScroll: 6,
                        variableWidth: true,
                        centerMode: false,
                        draggable: true,
                        lazyLoad: "progressive",
                        responsive: [
                          { breakpoint: 1200, settings: { slidesToScroll: 5 } },
                          { breakpoint: 1000, settings: { slidesToScroll: 4 } },
                          { breakpoint: 800, settings: { slidesToScroll: 3 } },
                          { breakpoint: 600, settings: { slidesToScroll: 2 } },
                          { breakpoint: 400, settings: { slidesToScroll: 1 } }
                        ]
                      });';
        
        $return .= 'function screenResize_'.$tiID.'() {

                    var parentElementsSize = 0;
                    var parentElementsSizes = [];

                    
                    var parentElements = $("[toaTiID='.$tiID.']").closest("table").find("> tbody > tr ").children();
                    $(parentElements).each( function( index, item){
                        parentElementsSizes.push( $(item).width() );
                    });

                    var tolerance = 24 + '.$itemSpaceTotal.';
                    var maxWidth = '.$maxWidth.';

                    var bodyWidth = document.body.clientWidth
                    if ( parentElementsSizes.length > 1 ) {
                        var parentElementsSize_0 = parentElementsSizes[0];
                        var parentElementsSize_1 = parentElementsSizes[1];
                        if ( parentElementsSize_0 < parentElementsSize_1 ) {
                            maxWidth = parentElementsSize_1;
                            bodyWidth = bodyWidth - parentElementsSize_0;
                        }

                    }
                    
                    if ( bodyWidth < maxWidth ) {
                        $("[toaTiID='.$tiID.']").css({ width: Math.ceil(bodyWidth-tolerance)+"px" });
                    }
                    else {
                        $("[toaTiID='.$tiID.']").css({ width: Math.ceil(maxWidth)+"px" });
                    }
                    
                ';
        
        
        $return .= '} ';
        
        $return .= 'screenResize_'.$tiID.'(); ';
        $return .= '$(window).bind("load", screenResize_'.$tiID.');';
        $return .= '$(window).bind("resize", screenResize_'.$tiID.');';
        $return .= '$(window).bind("orientationchange", screenResize_'.$tiID.');';
        
        $return .= '}); ';
        $return .= '</script>';
        
        $return .= '<div class="input_type_id_83" id="tiid-main-'.$tiID.'" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'"  toaTiID = "'.$tiID.'" >';
        
        $return .= '<div id="tiid-'.$tiID.'" class="slider responsive" >';
        
        foreach ( $claimData as $claimDataRow ) {
            $ID = $claimDataRow["ID"];
            $name = $claimDataRow["name"];
            $imageURL = $claimDataRow["imageURL"];
            $dynamicView = $claimDataRow["dynamicView"];
            $values = $claimDataRow["values"];
            
            $claimDataRow_style = $this->viewTypeID_style( $claimDataRow );
            $style_li .= $claimDataRow_style;
            
            $onClick_string_83 = "";
            if ( $actionTranID > 0 ) {
                
                $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
                
                $targetURLGen = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
                $onClick_string_83 = "onClick=\"javascript:onClick( '".$targetURLGen."' );\" class=\"onClickView\" title=\"".$name."\" alt=\"".$name."\"";
            }
            //echo "actionTranID" . $actionTranID."<br><br>";
            
            $return .= '<div style="'.$style_li.'" '.$onClick_string_83.' class="multiple">';
            if ( $imageURL != "" ) {
                $return .= '<div><img style="'.$imageBorderColor.'" src="'.$imageURL.'" '.$imageHeight.' '.$imageWidth.' /></div>';
            }
            if ( $name != "" ) {
                $return .= "<div>".$name."</div>";
            }
            foreach( $values as $value ) {
                $value_val = $value["val"];
                $value_viewTypeID_style = $this->viewTypeID_style( $value );
                $return .= "<div style=\"".$value_viewTypeID_style."\">".$value_val."</div>";
            }
            if ( !empty($dynamicView) ) {
                $dynamicView_new = $this->dynamicViewLoop( $dynamicView );
                $return .= "<div>".$this->dynamicView( $dynamicView_new, $tiID, $devRerouteServerApiEnc)."</div>";
            }
            

            
            $return .= '</div>';
        }

        $return .= '</div>';
        
        $return .= '</div>';
        
        
        $return .= '</div>';
                
        return $return;
    }

    function inputTypeID_87( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $return = '';
        
        $styles = $this->processParameters( $parameters );
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">';
        $return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function inputTypeID_95( $tabOutput = array(), $parameters = array(), $tranID = 0 ){

        $return = '';
        
        $claimData = array();
        
        $tiID = $tabOutput["tiID"];
        $actionTranID = $tabOutput["actionTranID"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];
        $columnCount = empty($parameters["columnCount"]) ? 1 : $parameters["columnCount"];
        $middleSpace = empty($parameters["middleSpace"]) ? 0 : $parameters["middleSpace"];
        $format = $tabOutput["format"];
        $formatParse = explode(",", $format);
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
                
        if ( !empty($tabOutput["frameworkClaimData"]) ) {
            $frameworkClaimData = $tabOutput["frameworkClaimData"];
            if ( count($frameworkClaimData) > 0 ) {
                $frameworkClaimData_0 = $frameworkClaimData[0];
                if ( !empty($frameworkClaimData_0["claimData"]) ) {
                    $claimData = $frameworkClaimData_0["claimData"];//array_merge( $frameworkClaimData_0["claimData"], $frameworkClaimData_0["claimData"], $frameworkClaimData_0["claimData"]);
                }
            }
        }
        
        $styles = $this->processParameters( $parameters );
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">';
        
        $tdWidth = "100";
        if ( $columnCount > 0 ) { $tdWidth = 100 / $columnCount; }
        
        $return .= "<table cellpadding=\"0\" cellspacing=\"".$middleSpace."\" width=\"100%\">";
        $return .= "<tr>";
                
                
        foreach ( $claimData as $id => $claimDataRow ) {
            
            $ID = $claimDataRow["ID"];
            $imageURL = $claimDataRow["imageURL"];
            $name = $claimDataRow["name"];
            if ( $name == "" ) { $name = "Gallery " . $id; }
            
            $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
            $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
                
            $onClick_string = "";
            if ( in_array("2",$formatParse) ) { 
                $targetURLGen = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
                $onClick_string = "onClick=\"javascript:onClick( '".$targetURLGen."' );\" class=\"onClickView\" title=\"".$name."\" alt=\"".$name."\"";
            }
         
            $return .= "<td width = \"".$tdWidth."%\" align=\"center\" valign=\"middle\" style=\"max-width:".$tdWidth."%; \" \"".$onClick_string."\" >";
            $return .= "<div><img src=\"".$imageURL."\" /></div>";
            $return .= "<div>".$name."</div>";
            $return .= "</td>";
            if ( ( ($id+1) % $columnCount ) == 0 ) {
                $return .= "</tr><tr>";
            }

        }
       
        $return .= "</tr>";
        $return .= "</table>";
        
        $return .= '</div>';
        $return .= '</div>';
                
        return $return;
    }
    
    function inputTypeID_98( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $return = '';
        
        $itemShowStyle = $parameters["itemShowStyle"];
        if ( $itemShowStyle == 0 || $itemShowStyle == "" ) {
            $itemShowStyle = 1;
        }
                
        $claimData = array();
        $claimGroupData = array();
        $claimGroupDataStatus = false;
        
        $tiID = $tabOutput["tiID"];
        $actionTranID = $tabOutput["actionTranID"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];
        
        $directoryPath = $tabOutput["__directoryPath"];
                
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
                
        if ( !empty($tabOutput["frameworkClaimData"]) ) {
            $frameworkClaimData = $tabOutput["frameworkClaimData"];
            if ( count($frameworkClaimData) > 0 ) {
                $frameworkClaimData_0 = $frameworkClaimData[0];
                if ( !empty($frameworkClaimData_0["claimData"]) ) {
                    $claimData = $frameworkClaimData_0["claimData"];
                }
                if ( !empty($frameworkClaimData_0["claimGroupData"]) ) {
                    $claimGroupData = $frameworkClaimData_0["claimGroupData"];
                    $claimGroupDataStatus = true;
                }
            }
        }
                
        //echo json_encode( $claimData );
        //echo "<br>-----<br>";
        //echo json_encode( $claimGroupData );
        //echo "<br>-----<br>";
        
        $itemTextSize = !empty($parameters["itemTextSize"])?$parameters["itemTextSize"]:"12";
                
        $styles = $this->processParameters( $parameters );
        
        $imageHeight = $itemTextSize;
        $imageWidth = $itemTextSize;
        
        if ( !empty($parameters["imageHeight"]) && $parameters["imageHeight"] > 0  ) {
            $imageHeight = $parameters["imageHeight"];
        }
        if ( !empty($parameters["imageWidth"]) && $parameters["imageWidth"] > 0  ) {
            $imageWidth = $parameters["imageWidth"];
        }
                        
        $return .= '<script>';
        $return .= 'if ( mobileDeviceStatus() ) { ';
        $return .= '$(document).ready( function(){ ';
        $return .= '$("#segment-menu").css({ display: "none" }); ';
        $return .= '$("#segment-menu-mobile-main").css({ display: "block" }); ';
        $return .= '$("#segment-menu-mobile-main").parent().css({ "width" : "100%" }); ';
        $return .= '}); ';
        $return .= '} ';
        $return .= 'function segmentMenuMobileShow() { ';
        $return .= 'var displayStatus = $("#segment-menu-mobile").css("display"); ';
        $return .= 'if ( displayStatus === "none" || displayStatus === undefined ) {'
                . '$("#segment-menu-mobile").fadeIn("fast");'
                . 'var menuOffset = $("#segment-menu-mobile-main").parent().parent().offset();'
                . 'var menuOffsetLeft = (menuOffset.left===undefined)?0:menuOffset.left;'
                . 'var menuOffsetRight = (menuOffset.right===undefined)?0:menuOffset.right;'
                . 'if ( menuOffsetLeft > menuOffsetRight && menuOffsetRight === 0 ) {'
                . '$("#segment-menu-mobile-main").parent().parent().css({ "left": "auto", "right": "0" });'
                . '}'
                . 'console.log( menuOffsetLeft+" > "+menuOffsetRight );'
                . 'console.log( menuOffset );'
                . '} else { $("#segment-menu-mobile").fadeOut("fast");'
                . '} ';
        $return .= '} ';
        $return .= '</script>';
        
        $return .= '<div class="" style="'.$styles["style_1"].'" >';
        $return .= '<div style="'.$styles["style_2"].'">';
        
        
        if ( $itemShowStyle == 1 ) {
            
            $return .= '<ul class="segment-menu" id="segment-menu" >';
            
            foreach ( $claimData as $id => $value ) {

                $ID = $value["ID"];
                $name = $value["name"];
                $imageURL = $value["imageURL"];

                $rowStyle = $this->claimDataRowStyle( $value );
                
                $urlGen = "";
                if ( $actionTranID > 0 ) {

                    $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                    $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
                    $urlTarget = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
                    $urlGen = "onClick = \"javascript:onClick( '".$urlTarget."' );\" class=\"onClickView\" ";
                }

                $return .= '<li '.$urlGen.'>';
                $return .= '<div class="menu-button" style="'.$rowStyle.'">';
                if ( $imageURL != "" ) {
                    $return .= '<img src="'.$imageURL.'" height="'.$imageHeight.'" width="'.$imageWidth.'" />&nbsp;';
                }
                $return .= $name;
                $return .= '</div>';
                $return .= '</li>';
            }
            
            $return .= '</ul>';

        }
        else if ( $itemShowStyle == 2 ) {
            
            $return .= "<script>";
            $return .= "$(document).ready( function(){ ";
            $return .= "$(\"ul.dd-menu-main > li\").mouseenter( function(){";
            $return .= "var itemCount = $(this).find(\".dd-menu-sub-div\").attr(\"itemCount\");";
            $return .= "if ( itemCount > 0 ) { ";
            $return .= "$(this).find(\".dd-menu-sub-div\").fadeIn(\"fast\");";
            $return .= "}";
            $return .= "}).mouseleave( function(){";
            $return .= "$(this).find(\".dd-menu-sub-div\").fadeOut(\"fast\");";
            $return .= "});";
            $return .= "});";
            $return .= "</script>";
            
            $return .= "<style>";
            $return .= "ul.dd-menu-main { display: flex; list-style: none; margin: 0; padding: 0; flex-direction: row; ms-flex-direction: row; }";
            $return .= "ul.dd-menu-main > li { display: inline; list-style: none; margin: 0; padding: 2px 4px; list-style-type: none; white-space: nowrap; position: relative; cursor: pointer; }";
            $return .= "div.dd-menu-sub-div { position: absolute; top: 20px; left: 0; display: none; padding: 10px; background-color: #FFFFFF; z-index: 1000; border-radius: 4px; border: 1px solid #EDEDED; }";
            $return .= "ul.dd-menu-sub { list-style: none; margin: 0; padding: 0; flex-direction: column; ms-flex-direction: column; }";
            $return .= "ul.dd-menu-sub > li { list-style: none; margin: 0; padding: 2px 4px; white-space: nowrap; }";
            $return .= "</style>";
        
            $return .= '<ul class="dd-menu-main" >';
            
            $claimGroupDataNew = $this->claimGroupDataMerge( $claimGroupData, $claimData);
            
            /*
            echo json_encode( $claimGroupData );
            echo "<br><br>";
            echo json_encode( $claimGroupDataNew );
            echo "<br><br>";
            */
            
            foreach ( $claimGroupDataNew as $id => $value ) {

                $ID = $value["ID"];
                $name = $value["name"];
                $imageURL = $value["imageURL"];
                $claimData_ = $value["claimData"];



                $return .= '<li>';
                $return .= '<div>'.$name.'</div>';
                $return .= '<div class="dd-menu-sub-div" itemCount="'.count($claimData_).'">';
                $return .= '<ul class="dd-menu-sub" itemCount="'.count($claimData_).'">';
                if ( $imageURL != "" ) {
                    $return .= '<img src="'.$imageURL.'" height="'.$imageHeight.'" width="'.$imageWidth.'" />&nbsp;';
                }
                foreach( $claimData_ as $id_1 => $value_1 ) {
                    $ID_1 = $value_1["ID"];
                    $name_1 = $value_1["name"];
                    $imageURL_1 = $value_1["imageURL"];
                    
                    $urlGen = "";
                    if ( $actionTranID > 0 ) {

                        $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID_1, "tableID" => $tableID );
                        $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
                        $urlTarget = $this->textToParameter($name_1)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
                        $urlGen = "onClick = \"javascript:onClick( '".$urlTarget."' );\" class=\"onClickView\" ";
                    }
                    
                    $return .= '<li '.$urlGen.'>';
                    if ( $imageURL_1 != "" ) {
                        $return .= '<img src="'.$imageURL_1.'" height="'.$imageHeight.'" width="'.$imageWidth.'" />&nbsp;';
                    }
                    $return .= $name_1;
                    $return .= '</li>';
                }
                $return .= '</ul>';
                $return .= '</div>';
                $return .= '</li>';
            }
            
            $return .= '</ul>';
        }
        
        $mobileMenuIcon = $directoryPath.'/images/icon_menu.png';
        if ( !empty($parameters["mobileMenuIcon"]) && $parameters["mobileMenuIcon"] != "" )
        {
            $mobileMenuIcon = $parameters["mobileMenuIcon"];
        }
        
        $return .= '<div class="segment-menu-mobile-main" id="segment-menu-mobile-main" style="padding: 0 0 0 4px;"> ';
        $return .= '<div><a href="javascript: segmentMenuMobileShow();" ><img src="'.$mobileMenuIcon.'" height="30" width="30" /></a></div>';
            

        $return .= '<ul class="segment-menu-mobile" id="segment-menu-mobile" >';
        
        foreach ( $claimData as $id => $value ) {
            
            $ID = $value["ID"];
            $name = $value["name"];
            $imageURL = $value["imageURL"];
            
            $urlGen = "";
            if ( $actionTranID > 0 ) {
                
                $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID, "tableID" => $tableID );
                $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
                $urlTarget = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
                $urlGen = "onClick = \"javascript:onClick( '".$urlTarget."' );\" class=\"onClickView\" ";
            }
            
            $return .= '<li '.$urlGen.'>';
            $return .= '<div class="menu-button">';
            if ( $imageURL != "" ) {
                $return .= '<img src="'.$imageURL.'" height="'.$imageHeight.'" width="'.$imageWidth.'" />&nbsp;';
            }
            $return .= $name;
            $return .= '</div>';
            $return .= '</li>';
        }
        
        $return .= '</ul>';
        
        $return .= '<div> ';
        
        $return .= '</div>';
        $return .= '</div>';
        
                
        return $return;
    }
    
    function claimDataRowStyle( $claimDataRow = array() ) {
        
        $return = '';
        
        if ( !empty($claimDataRow["backgroundImageURL"]) && $claimDataRow["backgroundImageURL"] != "" ) {
            $return .= 'background: url('.$parameters["itemBackgroundImageURL"].'); background-repeat: no-repeat; background-size: cover; ';
        }
        if ( !empty($claimDataRow["backgroundRGBColor"]) && $claimDataRow["backgroundRGBColor"] != "" ) {
            $return .= 'background-color: #'.$claimDataRow["backgroundRGBColor"].'; ';
        }
        if ( !empty($claimDataRow["backgroundRGBColorOpacity"]) && $claimDataRow["backgroundRGBColorOpacity"] != "" ) {
            //$return .= 'background-color: '.$claimDataRow["backgroundRGBColorOpacity"].'; ';
        }
        if ( !empty($claimDataRow["textRGBColor"]) && $claimDataRow["textRGBColor"] != "" ) {
            $return .= 'color: #'.$claimDataRow["textRGBColor"].'; ';
        }
        if ( !empty($claimDataRow["textSize"]) && $claimDataRow["textSize"] != "" ) {
            $return .= 'font-size: '.$claimDataRow["textSize"].'px; ';
        }
        if ( !empty($claimDataRow["textStyle"]) && $claimDataRow["textStyle"] != "" ) {
            //$return .= 'font-size: '.$claimDataRow["textStyle"].'px; ';
        }
        if ( !empty($claimDataRow["fontStyle"]) && $claimDataRow["fontStyle"] != "" ) {
            $return .= 'font-decoration: '.$claimDataRow["fontStyle"].'; ';
        }
        if ( !empty($claimDataRow["fontName"]) && $claimDataRow["fontName"] != "" ) {
            $return .= 'font-family: '.$claimDataRow["fontName"].'; ';
        }
        
        return $return;
        
    }
    

    function inputTypeID_101( $tabOutput = array(), $parameters = array(), $tranID = 0, $tabOutputActions = array() ){
        
        $return = "";

        $styles = $this->processParameters( $parameters );

        $clickClass = "";
        $HTMLAddress = $parameters["HTMLAddress"];
        if ( !empty($HTMLAddress) && $HTMLAddress != "" ) {
            $HTMLAddress_parse = explode("|", $HTMLAddress);
            
            $HTMLAddress_target = "_self";
            $HTMLAddress_url = $HTMLAddress;
            
            if ( count($HTMLAddress_parse) > 1 ) {                
                $HTMLAddress_target = $HTMLAddress_parse[0];
                $HTMLAddress_url = $HTMLAddress_parse[1];
            }
            
            $clickClass = "onClickView";
            $clickJavascript = 'onClick="javascript: onClickHTML( \''.urlencode($HTMLAddress_url).'\', \''.$HTMLAddress_target.'\' );"';
        }
        
        $subItems = "";
        if ( !empty($tabOutput["subItems"]) ) {
            $subItems = $this->tabOutputs_process_subItems( $tabOutput["subItems"], $parameters, $tranID, $tabOutputActions );            
        }
        
        $return .= '<div class="'.$clickClass.'" style="'.$styles["style_1"].'" '.$clickJavascript.'>';
        //$return .= '<div style="'.$styles["style_2"].'" class="table_l1">[[SUB_ITEMS]]</div>';
        $return .= '<div style="'.$styles["style_2"].'"><table width="100%" cellpadding="0" cellspacing="0" class="table_standart">[[SUB_ITEMS]]</table></div>';
        $return .= '</div>';
        
        $return = str_replace( "[[SUB_ITEMS]]", $subItems, $return);
        
        return $return;
    }
    
    function inputTypeID_102( $tabOutput = array(), $parameters = array(), $tranID = 0, $tabOutputActions = array() ){
        
        $return = "";
        
        $styles = $this->processParameters( $parameters );
        
        $clickClass = "";
        $HTMLAddress = $parameters["HTMLAddress"];
        if ( !empty($HTMLAddress) && $HTMLAddress != "" ) {
            $HTMLAddress_parse = explode("|", $HTMLAddress);
            
            $HTMLAddress_target = "_self";
            $HTMLAddress_url = $HTMLAddress;
            
            if ( count($HTMLAddress_parse) > 1 ) {                
                $HTMLAddress_target = $HTMLAddress_parse[0];
                $HTMLAddress_url = $HTMLAddress_parse[1];
            }
            
            $clickClass = "onClickView";
            $clickJavascript = 'onClick="javascript: onClickHTML( \''.urlencode($HTMLAddress_url).'\', \''.$HTMLAddress_target.'\' );"';
        }
        
        $subItems = "";
        if ( !empty($tabOutput["subItems"]) ) {
            $subItems = $this->tabOutputs_process_subItems( $tabOutput["subItems"], $parameters, $tranID, $tabOutputActions );            
        }
        
        $tableClass = "table_standart";
        $webMobileForceIntegrity = $parameters["webMobileForceIntegrity"];
        if ( $webMobileForceIntegrity == 1 ) {
            $tableClass = "table_integrity";
        }
                
        $return .= '<div class="'.$clickClass.'" style="'.$styles["style_1"].'" '.$clickJavascript.'>';
        //$return .= '<div style="'.$styles["style_2"].'" class="table_l1">[[SUB_ITEMS]]</div>';
        $return .= '<div style="'.$styles["style_2"].'"><table width="100%" cellpadding="0" cellspacing="0" class="'.$tableClass.'">[[SUB_ITEMS]]</table></div>';
        $return .= '</div>';
        
        $return = str_replace( "[[SUB_ITEMS]]", $subItems, $return);

        return $return;
    }
    
    function inputTypeID_unknown( $tabOutput = array(), $parameters = array() ){
        
        $inputTypeID = $tabOutput["inputTypeID"];
        
        $styles = $this->processParameters( $parameters );
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'">Unknown Input Type : '.$inputTypeID.'</div>';
        $return .= '</div>';

        return $return;
    }
    
    function inputTypeID_104( $tabOutput = array(), $parameters = array(), $tranID = 0 ){
        
        $tiID = $tabOutput["tiID"];
        $actionTranID = $tabOutput["actionTranID"];
        $prmInput = $tabOutput["prmInput"];
        $tableID = $tabOutput["tableID"];
        $name = $tabOutput["name"];
        
        $devRerouteServerApiJson = json_encode( $tabOutput["devRerouteServerApi"] );
        $devRerouteServerApiEnc = urlencode( $this->AES256_encrypt( $devRerouteServerApiJson ) );
                
        $styles = $this->processParameters( $parameters );

        $claimData = array();
        if ( !empty($tabOutput["frameworkClaimData"]) ) {
            $frameworkClaimData = $tabOutput["frameworkClaimData"];
            if ( count($frameworkClaimData) > 0 ) {
                $frameworkClaimData_0 = $frameworkClaimData[0];
                if ( !empty($frameworkClaimData_0["claimData"]) ) {
                    $claimData = json_decode( json_encode( $frameworkClaimData_0["claimData"] ), true);
                }
            }
        }
        
        $userData = json_decode( json_encode( $this->getUserData() ), true);
        $userName = $userData["name"] . " " . $userData["lastName"];
        if ( $userData["name"] == null && $userData["lastName"] == null ) {
            $userName = $userData["email"];
        }
        
        $profileImageURL = "https://image-europe-ger-s4y-2.aigap.com/AIGAP_FSR_GS_TEST/100000100000000032/property_repository/00100d49006e46152421698cc4955d4918637.png";
        if ( !empty($parameters["leftImageURL"]) ) {
            if ( $parameters["leftImageURL"] != "" ) {
                $profileImageURL = $parameters["leftImageURL"];
            }
        }
        
        $tableStyle = "";
        if ( !empty($parameters["itemTextColor"]) ) {
            if ( $parameters["itemTextColor"] != "" ) {
                $tableStyle .= "color: #".$parameters["itemTextColor"]."; ";
            }
        }
        if ( !empty($parameters["fontName"]) ) {
            if ( $parameters["fontName"] != "" ) {
                $tableStyle .= "font-family: ".$parameters["fontName"]."; font-weight: 100; ";
            }
        }
        
        $return .= '<div class="" style="'.$styles["style_1"].'">';
        $return .= '<div style="'.$styles["style_2"].'" class="memberMenuMain">';
        $return .= '<table width="100%" style="'.$tableStyle.'">';
        $return .= '<tr>';
        $return .= '<td rowspan="2"><img src="'.$profileImageURL.'" width="20" ></td>';
        $return .= '<td>'.$name.'</td>';
        $return .= '</tr>';
        $return .= '<tr>';
        $return .= '<td>'.$userName.'</td>';
        $return .= '</tr>';
        $return .= '</table>';
        $return .= '<div class="memberMenu">';
        foreach( $claimData as $claimDataRow ) {
            $name_ = $claimDataRow["name"];
            $ID_ = $claimDataRow["ID"];
            
            $tranFiledsArray[] = array( "fieldName" => $prmInput, "fieldValue" => $ID_, "tableID" => $tableID );
            $tranFieldsJsonEnc = urlencode( $this->AES256_encrypt( json_encode($tranFiledsArray) ) );
            
            $targetURLGen_ = $this->textToParameter($name_)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApiEnc."&trf=".$tranFieldsJsonEnc;
            $onClick_string = "onClick=\"javascript:onClick( '".$targetURLGen_."' );\" class=\"onClickView\" title=\"".$name_."\" alt=\"".$name_."\"";
            
            if ( $ID_ == "aigap_navigation_exit" ) {
                $onClick_string = "onClick=\"javascript:logout();\" class=\"onClickView\" title=\"".$name_."\" alt=\"".$name_."\"";
            }
            
            $return .= '<div class="memberMenuItem"><a href="javascript: void(0);" '.$onClick_string.'>'.$name_.'</a></div>';
        }
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        
        
        return $return;
    }
    
    function claimGroupDataMerge( $claimGroupData = array(), $claimData = array() ) {
        
        $return = array();
        
        for( $i = 0; $i < count($claimGroupData); $i++ ) {
            
            $ID_ = $claimGroupData[$i]["ID"];
            
            $claimGroupData_claimData = array();
            
            for( $j = 0; $j < count($claimData); $j++ ) {
                
                $groupID_ = $claimData[$j]["groupID"];
                if ( $ID_ == $groupID_ ) {
                    $claimGroupData_claimData[] = $claimData[$j];
                }
            }
            
            $claimGroupData[$i]["claimData"] = $claimGroupData_claimData;
        }
        
        $return = $claimGroupData;
        
        return $return;
    }


    function dynamicViewLoop( $data = array() ) {
        
        $return = array();
        
        foreach ( $data as $id_0 => $data_0 ) {
            $viewModelID_0 = $data_0["viewModelID"];
            $parentViewModelID_0 = $data_0["parentViewModelID"];
            
            if ( $parentViewModelID_0 == 0 && $viewModelID_0 > 0 ) {
                $return[$viewModelID_0] = $data_0;
                
                $subviews = $this->dynamicViewLoop_1( $data, $viewModelID_0 );
                if ( count($subviews) > 0 ) {
                    $return[$viewModelID_0]["subviews"] = $subviews;
                }
            }
            

        }
                
        return $return;
        
    }
    
    function dynamicViewLoop_1( $data = array(), $parentViewModelID = 0 ) {
    
        $return = array();
        
        foreach ( $data as $id_0 => $data_0 ) {
            $viewModelID_0 = $data_0["viewModelID"];
            $parentViewModelID_0 = $data_0["parentViewModelID"];

            if ( $parentViewModelID == $parentViewModelID_0 && $viewModelID_0 > 0 ) {
                
                $return[$viewModelID_0] = $data_0;
                
                $subviews_0 = $this->dynamicViewLoop_1( $data, $viewModelID_0 );
                if ( count($subviews_0) > 0 ) {
                    $return[$viewModelID_0]["subviews"] = $subviews_0;
                }
            }
        }
        
        return $return;
        
    }
    
    function dynamicView( $data = array(), $tiID=0, $devRerouteServerApi="", $uTabID="", $fwID="" ) {
        
        $return = "";
                
        foreach ( $data as $id_0 => $data_0 ) {

            $orientation_0 = $data_0["orientation"]; // 1 : Horizontal, 2 : Vertical
            $customClaimData_0 = $data_0["customClaimData"];
            $height_0 = $data_0["height"];
            $width_0 = $data_0["width"];
            $backgroundRGBColor_0 = $data_0["backgroundRGBColor"];
            $borderRGBColor_0 = $data_0["borderRGBColor"];
            $margin_0 = $data_0["margin"];
            $padding_0 = $data_0["padding"];
            $itemBorderRadius_0 = $data_0["itemBorderRadius"];
            $opacity_0 = $data_0["opacity"];
            $positionStyle_0 = $data_0["positionStyle"];
                                                    
            $style_0 = "box-sizing: border-box; vertical-align: middle; ";
            if ( $height_0 != "" ) { $style_0 .= "height: ".$height_0."; "; }
            if ( $width_0 != "" ) { $style_0 .= "width: ".$width_0."; max-width: ".$width_0."; "; }
            if ( $backgroundRGBColor_0 != "" ) { $style_0 .= "background-color: #".$backgroundRGBColor_0."; "; }
            if ( $borderRGBColor_0 != "" ) { $style_0 .= "border: 1px solid #".$borderRGBColor_0."; "; }
            if ( $margin_0 != "" ) { $style_0 .= "margin: ".$margin_0."; "; }
            if ( $padding_0 != "" ) { $style_0 .= "padding: ".$padding_0."; "; }
            if ( $itemBorderRadius_0 != "" ) { $style_0 .= "border-radius: ".$itemBorderRadius_0."px; "; }
            if ( $opacity_0 != "" && $opacity_0 > 0 ) { $style_0 .= "opacity: ".$opacity_0."; "; }
            
            if ( $positionStyle_0 > 0 ) {
                $style_0 .= "position: absolute; ";
                
                if ( $positionStyle_0 == 3 || $positionStyle_0 == 6 || $positionStyle_0 == 9 ) {
                    $style_0 .= "left: 0; ";
                    if ( $positionStyle_0 == 3 ) { $style_0 .= "top: 50%; transform: translate( 0, -50% ); "; }
                    else if ( $positionStyle_0 == 6 ) { $style_0 .= "top: 0; "; }
                    else if ( $positionStyle_0 == 9 ) { $style_0 .= "bottom: 0; "; }
                }
                else if ( $positionStyle_0 == 4 || $positionStyle_0 == 7 || $positionStyle_0 == 10 ) {
                    $style_0 .= "left: 50%; ";
                    if ( $positionStyle_0 == 4 ) { $style_0 .= "top: 50%; transform: translate( -50%, -50% ); "; }
                    else if ( $positionStyle_0 == 7 ) { $style_0 .= "top: 0; transform: translate( -50%, 0 ); "; }
                    else if ( $positionStyle_0 == 10 ) { $style_0 .= "bottom: 0; transform: translate( -50%, 0 ); "; }
                }
                else if ( $positionStyle_0 == 5 || $positionStyle_0 == 8 || $positionStyle_0 == 11 ) {
                    $style_0 .= "right: 0; ";
                    if ( $positionStyle_0 == 5 ) { $style_0 .= "top: 50%; transform: translate( 0, -50% ); "; }
                    else if ( $positionStyle_0 == 8 ) { $style_0 .= "top: 0; "; }
                    else if ( $positionStyle_0 == 11 ) { $style_0 .= "bottom: 0; "; }
                }

            }
            
            //white-space: nowrap;
            $return .= "<div style=\"".$style_0." display: inline-block; vertical-align: middle; \">";
            
            $return .= "<table width=\"100%\" style=\"width: 100%; padding: 0; spacing: 0;\" cellpadding=\"0\" cellspacing=\"0\">";
                        
            if ( $orientation_0 == 2 ) {

                $return .= "<tr>";
                
                foreach( $customClaimData_0 as $id_1 => $data_1 ) {
                    
                    $viewModelID_1 = !empty($data_1["viewModelID"])?$data_1["viewModelID"]:"0";
                    $parentViewModelID_1 = !empty($data_1["parentViewModelID"])?$data_1["parentViewModelID"]:"0";
                    
                    $viewTypeID_1 = $data_1["viewTypeID"];
                    $functionName_1 = "viewTypeID_".$viewTypeID_1;

                    $return .= "<td nowrap >";
                    
                    if ( method_exists( $this, $functionName_1 ) ) {
                        $return .= $this->$functionName_1( $data_1, $tiID, $devRerouteServerApi );
                    }
                    else {
                        $return .= "Unknown : View Type ID " . $viewTypeID_1;
                    }
                    $return .= "</td>";

                }
                             
                if ( !empty($data_0["subviews"]) ) {
                    $subviews = $data_0["subviews"];
                    $return .= "<td>".$this->dynamicView( $subviews, $tiID, $devRerouteServerApi )."</td>";
                }
                
                $return .= "</tr>";

            }
            else if ( $orientation_0 == 1 ) {
                
                foreach( $customClaimData_0 as $id_1 => $data_1 ) {
                    
                    $viewModelID_1 = empty($data_1["viewModelID"]) ? "0" : $data_1["viewModelID"];
                    $parentViewModelID_1 = empty($data_1["parentViewModelID"]) ? "0" : $data_1["parentViewModelID"];
                    
                    $viewTypeID_1 = empty($data_1["viewTypeID"]) ? "0" : $data_1["viewTypeID"];
                    $functionName_1 = "viewTypeID_".$viewTypeID_1;

                    $return .= "<tr>";
                    $return .= "<td>";
                    if ( method_exists( $this, $functionName_1 ) ) {
                        $return .= $this->$functionName_1( $data_1, $tiID, $devRerouteServerApi );
                    }
                    else {
                        $return .= "Unknown : View Type ID " . $viewTypeID_1;
                    }
                    $return .= "</td>";
                    $return .= "</tr>";

                }
                
                if ( !empty($data_0["subviews"]) ) {
                    $subviews = $data_0["subviews"];
                    $return .= "<tr><td>".$this->dynamicView( $subviews, $tiID, $devRerouteServerApi )."</td></tr>";
                }
            }
            
            $return .= "</table>";
            $return .= "</div>";

        }
            

                
        return $return;
    }
    
    function viewTypeID_style( $data ) {
        
        $return = '';
                
        $height = empty($data["height"]) ? "" : $data["height"];
        $width = empty($data["width"]) ? "" : $data["width"];
        //if ( $height == "0" ) { $height = "100%"; }
        //if ( $width == "0" ) { $width = "100%"; }
                
        $backgroundRGBColor = $data["backgroundRGBColor"];
        $textRGBColor = $data["textRGBColor"];
        //$iconRGBColor = $data["iconRGBColor"];
        $borderRGBColor = empty($data["borderRGBColor"]) ? "" : $data["borderRGBColor"];
        $textSize = $data["textSize"];
        $textStyle = $data["textStyle"];
        //$fontStyle = $data["fontStyle"];
        $fontName = $data["fontName"];
        $margin = empty($data["margin"]) ? "" : $data["margin"];
        $padding = empty($data["padding"]) ? "" : $data["padding"];
        $itemBorderRadius = empty($data["itemBorderRadius"]) ? "0" : $data["itemBorderRadius"];
        
        
        if ( $height != "" && $height != "0" ) { $return .= 'min-height: '.$height.'; height: '.$height.';  '; }
        if ( $width != "" && $width != "0" ) { $return .= 'width: '.$width.'; max-width: '.$width.'; '; }
        if ( $backgroundRGBColor != "" ) { $return .= 'background-color: #'.$backgroundRGBColor.'; '; }
        if ( $textRGBColor != "" ) { $return .= 'color: #'.$textRGBColor.'; '; }
        if ( $borderRGBColor != "" ) { $return .= 'border: 1px solid #'.$borderRGBColor.'; '; }
        if ( $margin != "" ) { $return .= 'margin: '.$margin.'; '; }
        if ( $padding != "" ) { $return .= 'padding: '.$padding.'; '; }
        if ( $textSize != "" ) { $return .= 'font-size: '.$textSize.'px; '; }
        if ( $itemBorderRadius != "" ) { $return .= 'border-radius: '.$itemBorderRadius.'px; overflow: hidden; '; }
        if ( $fontName != "" ) { $return .= 'font-family: '.$fontName.'; '; }
        if ( $textSize == -1 ) { $return .= 'display: none; '; }
        
        if ( $textStyle == 3 || $textStyle == 6 || $textStyle == 9 ) { $return .= 'text-align: left; align: left; '; }
        else if ( $textStyle == 4 || $textStyle == 7 || $textStyle == 10 ) { $return .= 'text-align: center; align: center; '; }
        else if ( $textStyle == 5 || $textStyle == 8 || $textStyle == 11 ) {  $return .= 'text-align: right; align: right; '; }
        
        if ( $textStyle == 3 || $textStyle == 4 || $textStyle == 5 ) { $return .= 'vertical-align: middle; display: table-cell; '; }
        else if ( $textStyle == 6 || $textStyle == 7 || $textStyle == 8 ) { $return .= 'vertical-align: top; display: table-cell; '; }
        else if ( $textStyle == 9 || $textStyle == 10 || $textStyle == 11 ) { $return .= 'vertical-align: bottom; display: table-cell; '; }
        
        return $return;
        
    }
    
    function viewTypeID_1( $data, $tiID=0, $devRerouteServerApi="" ) {
        
        //$tiID = $data["tiID"];
        $name = $data["name"];

        $style = $this->viewTypeID_style($data);
        
        $return = '';
        
        $return .= '<div style="display: table; width: 100%;"> ';
        $return .= '<div style="'.$style.'">'.$name.'</div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function viewTypeID_2( $data, $tiID=0, $devRerouteServerApi="" ) {
                
        //$tiID = $data["tiID"];
        $name = $data["name"];
        $actionTranID = $data["actionTranID"];
        $ID = $data["ID"];
        $genURL = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApi;
        
        $style = $this->viewTypeID_style($data);
        
        $style_a = "";
        if ( $data["textRGBColor"] != "" ) {
            $style_a .= 'color: #'.$data["textRGBColor"].'; ';
        }
        
        $return = '';
        
        $return .= '<div style="display: table; width: 100%;"> ';
        $return .= '<div style="'.$style.'"><a href="'.$genURL.'" style="'.$style_a.'">'.$name.'</a></div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function viewTypeID_3( $data, $tiID=0, $devRerouteServerApi="" ) {
        
        //$tiID = $data["tiID"];
        $name = $data["name"];
        $actionTranID = $data["actionTranID"];
        $ID = $data["ID"];
        $imageURL = $data["imageURL"];
        $genURL = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApi;
        
        $height = $data["height"]==""||$data["height"]=="0"?"":$data["height"];
        $width = $data["width"]==""||$data["width"]=="0"?"":$data["width"];
        
        $style = $this->viewTypeID_style($data);
        
        $return = '';
        
        $return .= '<div style="display: table; width: 100%;"> ';
        $return .= '<div style="'.$style.'"><a href="'.$genURL.'"><img src="'.$imageURL.'" width="'.$height.'" height="'.$height.'" >&nbsp;'.$name.'</a></div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function viewTypeID_4( $data, $tiID=0, $devRerouteServerApi="" ) {
        
        //$tiID = $data["tiID"];
        $name = $data["name"];
        $actionTranID = $data["actionTranID"];
        $ID = $data["ID"];
        $imageURL = $data["imageURL"];
        $genURL = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApi;
        
        $height = $data["height"]==""||$data["height"]=="0"?"":$data["height"];
        $width = $data["width"]==""||$data["width"]=="0"?"":$data["width"];
        
        $style = $this->viewTypeID_style($data);
        
        $return = '';
        
        $return .= '<div style="display: table; width: 100%;"> ';
        $return .= '<div style="'.$style.'"><a href="'.$genURL.'"><img src="'.$imageURL.'" width="'.$height.'" height="'.$height.'" >&nbsp;'.$name.'</a></div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function viewTypeID_5( $data, $tiID=0, $devRerouteServerApi="" ) {
        
        //$tiID = $data["tiID"];
        $name = $data["name"];
        $actionTranID = $data["actionTranID"];
        $ID = $data["ID"];
        $imageURL = $data["imageURL"];
        $genURL = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApi;
        
        $height = $data["height"]==""||$data["height"]=="0"?"":$data["height"];
        $width = $data["width"]==""||$data["width"]=="0"?"":$data["width"];
        
        $style = $this->viewTypeID_style($data);
        
        $return = '';
        
        $return .= '<div style="display: table; width: 100%;"> ';
        $return .= '<div style="'.$style.'"><img src="'.$imageURL.'" width="'.$width.'" height="'.$height.'" ></div>';
        $return .= '</div>';
        
        return $return;
    }
    
    function viewTypeID_12( $data, $tiID=0, $devRerouteServerApi="" ) {
        
        //$tiID = $data["tiID"];
        $name = $data["name"];
        $actionTranID = $data["actionTranID"];
        $ID = $data["ID"];
        $imageURL = $data["imageURL"];
        $genURL = $this->textToParameter($name)."?t=".$actionTranID."&i=".$ID."&ati=".$tiID."&drsi=".$devRerouteServerApi;
                
        $height = $data["height"]==""||$data["height"]=="0"?"15":$data["height"];
        $width = $data["width"]==""||$data["width"]=="0"?"15":$data["width"];
        
        $style = $this->viewTypeID_style($data);
        
        $return = '';
        
        $return .= '<div style="display: table; width: 100%;"> ';
        $return .= '<div  class="quantity_box">';
        $return .= '<div class="quantity_box_minus"><a class="quantity_button" href="javascript: void(0);" data-multi="-1"><img src="/images/minus.png" width="20" height="20"></a></div>';
        $return .= '<div class="quantity_box_input">';
        $return .= '<input type="text" class="quantity_input" name="quantity" value="'.$name.'" width="'.$width.'" height="'.$height.'" style="'.$style.'" />';
        $return .= '</div>';
        $return .= '<div class="quantity_box_plus"><a class="quantity_button" href="javascript: void(0);" data-multi="1"><img src="/images/plus.png" width="20" height="20"></a></div>';
        $return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
    
    
    function textToParameter( $text ) {
        
        $return = strtolower($text);
        
        $search = array( "_", " ", ":", "|", "{", "}", "[", "]",  "!", "?", ",", "#" );
        $replace = "-";
        
        $search_1 = array( "Ç", "İ", "Ü", "Ö", "Ş", "ç", "ı", "ü", "ö", "ş" );
        $replace_1 = array( "C", "I", "U", "O", "S", "c", "i", "u", "o", "s" );
        
        $return = str_replace( $search, $replace, $return);
        $return = str_replace( $search_1, $replace_1, $return);
        
        if ( $return == "" ) { $return = "target-url"; }
        
        return $return;
    }
    
    function processParameters( $parameters = array() ) {
        
        //print_r( $parameters );
        
        $return = array();
        $return["style_1"] = " ";
        $return["style_2"] = " ";
        $return["style_3"] = " ";
        
        $itemSpaceTop = 0;
        $itemSpaceRight = 0;
        $itemSpaceBottom = 0;
        $itemSpaceLeft = 0;
        
        if ( !empty($parameters["itemSpaceTop"]) ) { $itemSpaceTop = $parameters["itemSpaceTop"]; }
        if ( !empty($parameters["itemSpaceRight"]) ) { $itemSpaceRight = $parameters["itemSpaceRight"]; }
        if ( !empty($parameters["itemSpaceBottom"]) ) { $itemSpaceBottom = $parameters["itemSpaceBottom"]; }
        if ( !empty($parameters["itemSpaceLeft"]) ) { $itemSpaceLeft = $parameters["itemSpaceLeft"]; }
        
        $itemSpace = "box-sizing: border-box; display: block; padding: ".$itemSpaceTop."px " . $itemSpaceRight . "px " . $itemSpaceBottom . "px " . $itemSpaceLeft . "px; ";
        
        $return["style_1"] .= $itemSpace; 
        
        if ( !empty($parameters["itemViewBackgroundColor"]) && $parameters["itemViewBackgroundColor"] != "clear" ) { $return["style_1"] .= "background-color: #".$parameters["itemViewBackgroundColor"]."; "; }        
        if ( !empty($parameters["itemViewBorderRadius"]) ) { $return["style_1"] .= "border-radius: ".$parameters["itemViewBorderRadius"]."px; "; }
        if ( !empty($parameters["itemViewBorderSize"]) && !empty($parameters["itemViewBorderColor"]) ) { $return["style_1"] .= "border: ".$parameters["itemViewBorderSize"]."px solid #".$parameters["itemViewBorderColor"]."; "; }

        if ( !empty($parameters["itemHeight"]) ) { $return["style_2"] .= "height: ".$parameters["itemHeight"]."; max-height: ".$parameters["itemHeight"]."; "; }
        
        if ( !empty($parameters["webItemWidth"]) ) {
            
            $webItemWidth = $parameters["webItemWidth"];
            $itemSpaceX = $itemSpaceLeft + $itemSpaceRight;
            if ( $itemSpaceX > 0 ) { $webItemWidth = "calc(".$webItemWidth." - ".$itemSpaceX."px )"; }

            $return["style_2"] .= "width: ".$webItemWidth."; ";
            
        }
        else if ( !empty($parameters["itemWidth"]) ) { $return["style_2"] .= "width: ".$parameters["itemWidth"]."; "; }
        
        if ( !empty($parameters["webItemMinHeight"]) ) {
            $webItemMinHeight = $parameters["webItemMinHeight"];
            $return["style_2"] .= "min-height: ".$webItemMinHeight."; ";
        }
        
        if ( !empty($parameters["webItemMaxHeight"]) ) {
            $webItemMaxHeight = $parameters["webItemMaxHeight"];
            $return["style_2"] .= "max-height: ".$webItemMaxHeight."; ";
        }
        
        if ( !empty($parameters["webItemMinWidth"]) ) {
            $webItemMinWidth = $parameters["webItemMinWidth"];
            $return["style_2"] .= "min-width: ".$webItemMinWidth."; ";
        }
        
        if ( !empty($parameters["webItemMaxWidth"]) ) {
            $webItemMaxWidth = $parameters["webItemMaxWidth"];
            $return["style_2"] .= "max-width: ".$webItemMaxWidth."; ";
        }
        
        if ( !empty($parameters["itemBackgroundColor"]) && $parameters["itemBackgroundColor"] != "clear" ) { $return["style_2"] .= "background-color: #".$parameters["itemBackgroundColor"]."; "; }        
        if ( !empty($parameters["itemTextColor"]) ) {
            $return["style_2"] .= "color: #".$parameters["itemTextColor"]."; ";
            $return["style_3"] .= "color: #".$parameters["itemTextColor"]."; ";
        }
        if ( !empty($parameters["itemBorderRadius"]) ) { $return["style_2"] .= "border-radius: ".$parameters["itemBorderRadius"]."px; "; }
        if ( !empty($parameters["itemBorderSize"]) && !empty($parameters["itemBorderColor"]) ) { $return["style_2"] .= "border: ".$parameters["itemBorderSize"]."px solid #".$parameters["itemBorderColor"]."; "; }
        if ( !empty($parameters["itemTextSize"]) ) {
            $return["style_2"] .= "font-size: ".$parameters["itemTextSize"]."px; ";
            $return["style_3"] .= "font-size: ".$parameters["itemTextSize"]."px; ";
        }
        if ( !empty($parameters["fontName"]) ) { $return["style_2"] .= 'font-family: '.$parameters["fontName"].'; '; }

        if ( !empty($parameters["webCSS"]) && $parameters["webCSS"] != "" ) { $return["style_2"] .= urldecode( $parameters["webCSS"] ); }
        
        if ( !empty($parameters["itemBackgroundImageURL"]) && $parameters["itemBackgroundImageURL"] != "" && filter_var($parameters["itemBackgroundImageURL"], FILTER_VALIDATE_URL) ) {
            $return["style_1"] .= " background: url(".$parameters["itemBackgroundImageURL"]."); background-repeat: no-repeat; background-size: cover;";
        }
        
        if ( !empty($parameters["itemViewBackgroundImageURL"]) && $parameters["itemViewBackgroundImageURL"] != "" && filter_var($parameters["itemViewBackgroundImageURL"], FILTER_VALIDATE_URL) ) {
            $return["style_2"] .= " background: url(".$parameters["itemViewBackgroundImageURL"]."); background-repeat: no-repeat; background-size: cover;";
        }
        
        if ( !empty($parameters["itemPlaceHolderTextColor"]) ) { $return["style_2"] .= "color: #".$parameters["itemTextColor"]."; "; }
        if ( !empty($parameters["textAlignment"]) ) { $return["style_2"] .= "text-align: ".$parameters["textAlignment"]."; "; }
        if ( !empty($parameters["webMargin"]) ) { $return["style_2"] .= "margin: ".$parameters["webMargin"]."; "; }
        if ( !empty($parameters["font-style"]) ) { $return["style_2"] .= "font-style: ".$parameters["font-style"]."; "; }
        if ( !empty($parameters["font-weight"]) ) { $return["style_2"] .= "font-weight: ".$parameters["font-weight"]."; "; }

        return $return;
    }
    

}


?>