<?php

/*
<div>
    <div>Start: <?php echo $responseJson["performance"]["timeStart"] ?></div>
    <div>End: <?php echo $responseJson["performance"]["timeEnd"] ?></div>
    <div>CURL Info: <br><?php foreach( $responseJson["curlInfo"] as $key => $value ) { echo "&nbsp;&nbsp;&nbsp;<b>[".$key . "]</b>: " . $value."<br>"; } ?></div>
</div>
 * 
 */

//echo "DRSA::".$devRerouteServerApi."::DRSA";

            //$tranTabs_jsonData = json_decode( $tranTabs["jsonDataDecrypted"], true);
            //$tabs = $tranTabs_jsonData["tabs"];
            $tabID_first = $tabs[0]["tabID"]; 
            
    //print_r($tabs);
            
    //echo json_encode( $jsonData );
            
    $stateCheckID = !empty($parametersTran["stateCheckID"]) ? $parametersTran["stateCheckID"] : 0;
    $stateCheckIntervalSecond = !empty($parametersTran["stateCheckIntervalSecond"]) ? $parametersTran["stateCheckIntervalSecond"] : 0;
    $stateCheckTimeout = !empty($parametersTran["stateCheckTimeout"]) ? $parametersTran["stateCheckTimeout"] : 0;
    $firewallURL = !empty($parametersTran["firewallURL"]) ? $parametersTran["firewallURL"] : 0;
    $firewallPublicKey = !empty($parametersTran["firewallPublicKey"]) ? $parametersTran["firewallPublicKey"] : 0;
    $encTypeID= !empty($parametersTran["encTypeID"]) ? $parametersTran["encTypeID"] : 0;
    $algorithmTypeID = !empty($parametersTran["algorithmTypeID"]) ? $parametersTran["algorithmTypeID"] : 0;
    $aimlFwID = !empty($parametersTran["aimlFwID"]) ? $parametersTran["aimlFwID"] : 0;
    $fwID = !empty($parametersTran["fwID"]) ? $parametersTran["fwID"] : 0;
    $fwActionTypeID = !empty($parametersTran["fwActionTypeID"]) ? $parametersTran["fwActionTypeID"] : 0;
    $apiTypeID = !empty($parametersTran["apiTypeID"]) ? $parametersTran["apiTypeID"] : 0;
    $apiMethod = !empty($parametersTran["apiMethod"]) ? $parametersTran["apiMethod"] : 0;

    $stateCheckData = array();
    $stateCheckDataJson = NULL;
    
    if ( $stateCheckTimeout > 0 && $stateCheckIntervalSecond > 0 ) {
        $stateCheckData["stateCheckID"] = $stateCheckID;
        $stateCheckData["stateCheckIntervalSecond"] = $stateCheckIntervalSecond;
        $stateCheckData["stateCheckTimeout"] = $stateCheckTimeout;
        $stateCheckData["firewallURL"] = $firewallURL;
        $stateCheckData["firewallPublicKey"] = $firewallPublicKey;
        $stateCheckData["encTypeID"] = $encTypeID;
        $stateCheckData["algorithmTypeID"] = $algorithmTypeID;
        $stateCheckData["aimlFwID"] = $aimlFwID;
        $stateCheckData["fwID"] = $fwID;
        $stateCheckData["fwActionTypeID"] = $fwActionTypeID;
        $stateCheckData["apiTypeID"] = $apiTypeID;
        $stateCheckData["apiMethod"] = $apiMethod;
        
        $stateCheckData["tranID"] = $tranID_res;
        $stateCheckData["ID"] = $ID_res;
        $stateCheckData["actionTiID"] = $actionTiID_res;
        $stateCheckData["referData"] = $referData;
        $stateCheckData["devRerouteServerApi"] = "";
        
        $stateCheckData["uTabID"] = $uTabID;
        
        $stateCheckDataJson = json_encode( $stateCheckData );
    }
    
    ?>
<?php
    
if ( $developerMode || $aigap->getSession("developerToolsShow") == "1" ) {

    $l_b_GoHomePage = $getLanguageValue( "b.GoHomePage" );
    $l_b_ClearCache = $getLanguageValue( "b.ClearCache" );
    $l_b_ClearCookie = $getLanguageValue( "b.ClearCookie" );
    $l_b_ClearPageCache = $getLanguageValue( "b.ClearPageCache" );
    $urlFull = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $homePage = $urlFull;
    if (sizeof(explode("?", $urlFull) ) > 1 ) {
        $homePage = dirname( $urlFull )."/";
    }
    
    $aigap->setCookie("homePageURL", $homePage, false );
?>
<script>
    
    $(document).ready( function(){
        
        $(".developer-tools ul > li > a").click(function(){
            
            var action = $(this).attr("action");
            
            $(".developer-tools > .message").fadeIn("fast").html( "<?php echo $getLanguageValue( "t.Loading" ); ?>" );
            
            if( action === "homePage" ) {
                var homePageURL = "<?php echo $homePage; ?>";
                window.open( homePageURL, "_self");
                $(".developer-tools > .message").html( "<?php echo $getLanguageValue( "b.Done" ); ?>" );
            }
            else {
                getAction( this );
            }
        });
        
        $(".developer-tools").draggable({
            handle: ".title",
           stop: function() {                
                var position = $(this).position().left+":"+$(this).position().top;
                $.cookie("developerToolsPosition", position);
            }
        });
        
        if ( $.cookie("developerToolsPosition") !== undefined ) {
            if ( $.cookie("developerToolsPosition") !== "" ) {

                var positionArray = $.cookie("developerToolsPosition").split(":");
                var positionLeft = positionArray[0];
                var positionTop = positionArray[1];
                $(".developer-tools").css({ left: positionLeft+"px", top: positionTop+"px" });
            }
        }
    });
    
    function getAction( sender ) {
        
        var senderObj = $( sender );
        var action = senderObj.attr("action");
        
        $.ajax({
            url: "options.get",
            type: "POST",
            crossDomain: true,
            data: {
                "action" : action,
                "pageCode" : "<?php echo $qsmd5; ?>",
                "langCode" : "<?php echo $langCode_; ?>"
            },
            dataType: "json",
            success: function (result) {
                
                var resultJson = JSON.parse( JSON.stringify( result ) );
                
                if ( resultJson.status === "0" ) {

                    $(".developer-tools > .message").fadeIn("fast").html( "<?php echo $getLanguageValue( "b.Done" ); ?>" );
                    //if ( action === "update" ) {
                        location.reload(true);
                    //}
                }
                else {
                    alert( resultJson.message );
                    $(".developer-tools > .message").html( resultJson.message );
                }
            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            //showMessageBottom( error, "e" );
            
                $(".developer-tools > .message").html( error );
            }
        });
    }
    
    <?php if ( $stateCheckDataJson != NULL ) { ?>
    
    var loopStatus = "idle";
    var intervalLoop = <?php echo $stateCheckData["stateCheckTimeout"]; ?>;
    var timerInterval = setInterval( function(){
                
        if ( intervalLoop > 0 ) {
            if ( loopStatus === "idle" ) {
                stateCheckFunction( "<?php echo rawurlencode( addslashes( $stateCheckDataJson ) ); ?>" );
                console.log( "Interval: " + intervalLoop );
            }
        }
        else {
            clearInterval( timerInterval );
            window.history.go(-1);
            console.log( "Interval Stop" );
        }
        
        intervalLoop--;

    }, <?php echo intval( $stateCheckData["stateCheckIntervalSecond"] ) * 1000; ?> );
    
    function stateCheckFunction( data ) {
        
        loopStatus = "wait";
        
        $.ajax({
            url: "<?php echo $directoryPath; ?>/get.json.php",
            type: "POST",
            crossDomain: true,
            data: {
                "get" : "stateCheck",
                "dev1" : "<?php echo $dev1; ?>",
                "dev2" : "<?php echo $dev2; ?>",
                "sess" : "<?php echo $aigap->AES256_encrypt( serialize($_SESSION) ); ?>",
                "data" : data
            },
            dataType: "json",
            success: function (result) {

                loopStatus = "idle";

                try {
                    var resultJson = JSON.parse( JSON.stringify(result) );

                    if ( resultJson.returnCode.messageID === 0 ) {

                        var responseData = result.responseData;
                        var statusTypeID = responseData.statusTypeID;
                        
                        if ( parseInt(statusTypeID) === 10 || parseInt(statusTypeID) === -1 ) {
                            console.log( "State: Wait: " +  statusTypeID );
                        }
                        else {
                            
                            var autoRunTranID_ = parseInt(responseData.autoRunTranID);
                            var autoRunStateID_ = parseInt(responseData.autoRunStateID);
                            var devRerouteServerApi_ = resultJson.devRerouteServerApi===null?"":responseData.devRerouteServerApi;
                            if ( autoRunTranID_ > 0 ) {
                                var targetURL = 'actiontran?t='+autoRunTranID_+'&i=0&ati=0&drsi='+devRerouteServerApi_+'&trf=';
                                location.href = targetURL; 
                            }
                            
                            console.log( "State: Next: " +  statusTypeID );
                        }

                        console.log( "State: " +  statusTypeID );
                    }
                    else {
                        Utils.showMessage( resultJson.returnCode.message, "e" );
                        console.log( "A: " + resultJson.returnCode.message );
                    }

                }
                catch(Exception){
                    console.log( Exception.message );
                }

            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            //showMessageBottom( error, "e" );
            }
        });
    }
    
    <?php } ?>
</script>
<style>
    .developer-tools { position: fixed; z-index: 199999; top: calc( 50% - 20px ); left: 20px; min-height: 20px; min-width: 20px; background-color: rgba( 255,255,255, 0.8 ); border: 1px solid rgba( 0, 0, 0, 0.8); border-radius: 10px; }
    .developer-tools > .title, .developer-tools > .message { text-align: center; padding: 10px 0;  color: #3d3d3d; }
    .developer-tools > .title { cursor: move; }
    .developer-tools > .message { display: none; }
    .developer-tools  ul { margin: 0; padding: 0; list-style: none; }
    .developer-tools  ul > li { margin: 0; padding: 10px; display: inline-block; }
    .developer-tools  ul > li > a { min-height: 30px; min-width: 30px; color: #3d3d3d;  }
    
    .developer-tools .button-move { position: absolute; top: -15px; left: -15px; width: 30px; height: 30px; background-color: transparent; border: 0; }
</style>

<div class="developer-tools">
    <div class="title">Developer Tools<?php if ( $expireDate != "" ) { ?> - (<?php echo $expireDate; ?>)<?php } ?></div>
    <div class="message"></div>
    <div>
        <ul>
            <li><a href="javascript:void(0);" action="homePage" alt="<?php echo $l_b_GoHomePage; ?>;" title="<?php echo $l_b_GoHomePage; ?>"><i class="fas fa-home fa-2x"></i></a></li>
            <li><a href="javascript:void(0);" action="clearCookie" alt="<?php echo $l_b_ClearCookie; ?>;" title="<?php echo $l_b_ClearCookie; ?>"><i class="fas fa-cookie-bite fa-2x"></i></a></li>
            <li><a href="javascript:void(0);" action="clearCache" alt="<?php echo $l_b_ClearCache; ?>" title="<?php echo $l_b_ClearCache; ?>"><i class="fas fa-redo fa-2x"></i></a></li>
            <li><a href="javascript:void(0);" action="clearCachePage" alt="<?php echo $l_b_ClearPageCache; ?>" title="<?php echo $l_b_ClearPageCache; ?>"><i class="fas fa-sync-alt fa-2x"></i></a></li>
        </ul>
    </div>
</div>

<?php } ?> 

<div id="tranTabs-<?php echo $uTabID; ?>">

    <?php if ( count($tabs) > 1 ) { ?>

    <div class="separator"></div>

    <div class="d-flex" style="padding: 10px 0;">
        <ul class="nav nav-tabs" >

            <?php foreach ($tabs as $id => $tab) { ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $id == 0 ? "active" : ""; ?>" tabIndex="<?php echo $id; ?>" tabID="<?php echo $tab["tabID"]; ?>" id="tab-id-<?php echo $tab["tabID"]; ?>-<?php echo $uTabID; ?>" href="#tab-<?php echo $tab["tabID"]; ?>-<?php echo $uTabID; ?>" role="tab" aria-controls="tran-<?php echo $tab["tabID"]; ?>-<?php echo $uTabID; ?>" aria-selected="true"><?php echo $tab["tabName"]; ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    
    <script>
    $(document).ready( function(){
        $("#tranTabs-<?php echo $uTabID; ?>" ).tabs({ active: 0, activate: function(event, ui) {
         console.log( event );
         console.log( ui );
        }
    });

    });
    </script>

    <?php } ?>
    
    
    <form enctype="multipart/form-data" method="post" action="tran.save.async.php" accept-charset="UTF-8" onSubmit="javascript:return tranSave('<?php echo $tranID; ?>', '<?php echo $ID; ?>', '<?php echo $parentTabData; ?>', '<?php echo $sendTabData; ?>', '<?php echo $designPropertyTypeID; ?>', '<?php echo $designPropertyID; ?>', '<?php echo $reloadSender; ?>', '<?php echo $senderData; ?>', '<?php echo $uTabID; ?>', '<?php echo $devRerouteServerApi; ?>' );" uTabID = "<?php echo $uTabID; ?>" id="form-tran-<?php echo $tranID; ?>-utabid-<?php echo $uTabID; ?>">

    <input type="hidden" name="devRerouteServerApi" value="<?php echo $devRerouteServerApi; ?>" />
    <input type="hidden" name="returnUrl" value="tran.tabs.php?parameters=<?php echo $parameters; ?>" />
    <input type="hidden" name="uTabID" value="<?php echo $uTabID; ?>" />
    <input type="hidden" name="uTabIDParent" value="<?php echo $uTabIDParent; ?>" />
    <input type="hidden" name="activeTabID" value="<?php echo $tabID_first; ?>" />
    <input type="hidden" name="actionTiID" value="<?php echo $actionTiID_res; ?>" />
    <input type="hidden" name="referData" value="" />
    <input type="hidden" name="activeData" value="<?php echo $activeDataJson; ?>" />
    <input type="hidden" name="cookiePrefix" value="<?php echo $aigap->getCookiePrefix(); ?>" />

    <div class="tab-content" id="tranTabsContent-<?php echo $uTabID; ?>">
                            
    <?php
        foreach( $tabs as $id => $tab )
        {
            $tabID = $tab["tabID"];
            $tabOutputs__ = $tab["tabOutputs"];
            $tabOutputActions__ = $tab["tabOutputActions"];
            
            $tabOutputActions = array();
            
            foreach ( $tabOutputActions__ as $tabOutputAction ) {
                
                $tiID__ = $tabOutputAction["tiID"];
                $tabOutputActions[$tiID__] = $tabOutputAction;
            }
            
            //echo json_encode( $tabOutputActions__ )."<br><br>";
            //echo json_encode( $tabOutputActions )."<br><br>";
            //echo json_encode( $tabOutputs__ )."<br><br>";
            
            $stateID = 1;

    ?>
				
            <input type="hidden" name="editID" value="<?php echo $ID_res; ?>">
            <input type="hidden" name="tranID" value="<?php echo $tranID_res; ?>">
            <input type="hidden" name="stateID" value="<?php echo $stateID; ?>">
            <input type="hidden" name="tranIDForce" value="<?php echo $tranIDForce; ?>">
            <?php if( !empty($dataJson["tranIDSender"]) ) { ?>
            <input type="hidden" name="tranIDSender" value="<?php echo $dataJson["tranIDSender"]; ?>">
            <?php } ?>
            <input type="hidden" name="tabs[]" value="<?php echo $tabID; ?>">


            <div class="tab-pane show <?php echo $id==0?"active":""; ?>" id="tab-<?php echo $tab["tabID"]; ?>-<?php echo $uTabID; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $tab["tabID"]; ?>-<?php echo $uTabID; ?>">
 
           <?php

                    $tabOutputs_ = array();
                     $tranTabInputs_jsonData = array();

                    if ( $id == 0 && !empty($tabOutputs__) ) {
                        $tabOutputs_ = $tabOutputs__;
                    }
                    else {
                        $tranTabInputs = $aigap->services_AigapGetTranTabInputs( $tranID, $tabID, $stateID, $ID, 0, $designPropertyTypeID, $designPropertyID, $tranIDForce, $devRerouteServerApiDec, $tranCallerTypeID, $uTabID );
                        $tranTabInputs_jsonData = json_decode( $tranTabInputs["jsonDataDecrypted"], true);				   
                        $tabOutputs_ = $tranTabInputs_jsonData["tabOutputs"];
                        
                        if ( $tranTabInputs_jsonData["returnCode"]["messageID"] != 0 ) {
                            echo '<div class="alert alert-danger" role="alert">'.$tranTabInputs_jsonData["returnCode"]["message"].'</div>';
                        }
                    }
                    
                    $tabOutputs_new = $aigap->tabOutputs_findMessageClass( $tabOutputs_ );
                    $tabOutput_failure = $tabOutputs_new["failure"];
                    $parameters_failure = json_decode( $tabOutput_failure["parameters"], true );
                    $styles_failure = $aigap->processParameters( $parameters_failure );
                    $tabOutput_success = $tabOutputs_new["success"];
                    $parameters_success = json_decode( $tabOutput_success["parameters"], true );
                    $styles_success = $aigap->processParameters( $parameters_success );

                    echo "<style>";
                    echo ".messageArea_failure_1 { ".$styles_failure["style_1"]." display: none; margin: 10px 0; }";
                    echo ".messageArea_failure_2 { ".$styles_failure["style_2"]." }";
                    echo ".messageArea_success_1 { ".$styles_success["style_1"]." display: none; margin: 10px 0; }";
                    echo ".messageArea_success_2 { ".$styles_success["style_2"]." }";
                    echo "</style>";
                    
                    //echo json_encode( $tabOutputs__ );
                $tabOutputsRebuild = $aigap->tabOutputs_rebuild_subitems( $tabOutputs_new["tabOutputs"], 0, $tranID, $tabOutputActions, $directoryPath, $dev1, $dev2 );

                //echo json_encode( $tabOutputs_ )."<br><br>";
						
                    foreach( $tabOutputsRebuild as $tabOutput )
                    {

                        //echo "<div>";
                        //print_r( $tabOutput );
                        //echo "</div>";

                        $ID = !empty($tabOutput["ID"]) ? $tabOutput["ID"] : "0";
                        $tiID = !empty($tabOutput["tiID"]) ? $tabOutput["tiID"] : "0";
                        $inputTypeID = !empty($tabOutput["inputTypeID"]) ? $tabOutput["inputTypeID"] : "0";
                        $tabID = !empty($tabOutput["tabID"])?$tabOutput["tabID"] : "0";
                        $tableID = !empty($tabOutput["tableID"])?$tabOutput["tableID"]:"0";
                        $min = !empty($tabOutput["min"])?$tabOutput["min"] : "0";
                        $max = !empty($tabOutput["max"])?$tabOutput["max"] : "0";
                        $name = !empty($tabOutput["name"])?$tabOutput["name"] : "";
                        $format = !empty($tabOutput["format"])?$tabOutput["format"] : "";
                        $claimID = !empty($tabOutput["claimID"]) ? $tabOutput["claimID"] : "";
                        $mandatory = !empty($tabOutput["mandatory"]) ? $tabOutput["mandatory"]: "";
                        $valueTypeID = !empty($tabOutput["valueTypeID"]) ? $tabOutput["valueTypeID"]: "";
                        $claimData = !empty($tabOutput["claimData"]) ? $tabOutput["claimData"] : "";
                        $prmInput = !empty($tabOutput["prmInput"]) ? $tabOutput["prmInput"] : "";
                        $fieldActionID = !empty($tabOutput["fieldActionID"]) ? $tabOutput["fieldActionID"] : "";
                        $actionTranID = !empty($tabOutput["actionTranID"]) ? $tabOutput["actionTranID"] : "";
                        $insertTranID = !empty($tabOutput["insertTranID"]) ? $tabOutput["insertTranID"] : "";
                        $sortID = !empty($tabOutput["sortID"]) ? $tabOutput["sortID"] : "0";
                        $filterTranID = !empty($tabOutput["filterTranID"])?$tabOutput["filterTranID"] : "0";
                        $multipleValues = !empty($tabOutput["multipleValues"])?$tabOutput["multipleValues"] : "";
                        $helpStr = !empty($tabOutput["helpStr"])?$tabOutput["helpStr"] : "";
                        
                        $parameters = array();
                        if ( !empty($tabOutput["parameters"]) ) { $parameters = json_decode( $tabOutput["parameters"], true ); }
                        $parameters["__directoryPatch"] = $directoryPath;
                        $parameters["__dev1"] = $dev1;
                        $parameters["__dev2"] = $dev2;
                        
                        $name_A = $name;
                        $name_AA = $name;
                        $menuTranID = 0;
                        $menuCategoryID = 0;
                        $menuName = "";
                        $menuParentName = "";

                        $button_actionTiID = "0";
                        if ( $inputTypeID == 17 ) { $button_actionTiID = $tiID; }

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

                        $filterParameters_ = array();

                        $tranIDSender = empty($dataJson["tranIDSender"])?0:$dataJson["tranIDSender"];
                        if ( !empty($_SESSION["filter"][$tranIDSender]) )
                        {
                                $filterParameters_ = unserialize($_SESSION["filter"][$tranIDSender]);
                        }


                        if ( count($filterParameters_) > 0 )
                        {
                                if ( !empty($filterParameters_[$tabID]["singleValues"]) )
                                {
                                        foreach( $filterParameters_[$tabID]["singleValues"] as $singleValues )
                                        {
                                                if ( $singleValues["tiID"] == $tiID )
                                                {
                                                        $valueString = $singleValues["value"];
                                                        $valueTextString = $singleValues["value"];

                                                        if( !empty($singleValues["valueText"]) )
                                                        {
                                                                $valueTextString = $singleValues["valueText"];
                                                        }
                                                }
                                        }
                                }
                        }


                        $formatParse = explode(",", $format);

                        if ( !empty($tabOutput["devRerouteServerApi"]) && $tabOutput["devRerouteServerApi"] != null && $tabOutput["devRerouteServerApi"] != "" ) {
                            $devRerouteServerApi = json_encode($tabOutput["devRerouteServerApi"]);
                            $devRerouteServerApiEnc = $aigap->AES256_encrypt( $devRerouteServerApi );
                        }
                        else if ( $aigap->AES256_decrypt($devRerouteServerApi) != "" && $aigap->AES256_decrypt($devRerouteServerApi) != null ) {
                            $devRerouteServerApiEnc = $devRerouteServerApi;
                            $devRerouteServerApi = $aigap->AES256_decrypt($devRerouteServerApi);
                        }

                        $URL_add = "tran.tabs.frame.php?data=".base64_encode("{ \"tranID\" : ".$insertTranID.", \"menuName\" : \"".$name_A."\", \"menuParentName\" : \"".$name_AA."\", \"ID\" : \"0\", \"fieldName\" : \"".$prmInput."\", \"fieldValue\" : \"".$ID."\", \"tableID\" : \"".$tableID."\", \"uTabIDSend\" : \"".$uTabID."\", \"menuTranID\" : \"".$menuTranID."\", \"menuCategoryID\" : \"".$menuCategoryID."\", \"menuName\" : \"".$menuName."\", \"menuParentName\" : \"".$menuParentName."\", \"designPropertyTypeID\" : \"".$designPropertyTypeID."\", \"designPropertyID\" : \"".$designPropertyID."\", \"devRerouteServerApi\" : \"".$devRerouteServerApiEnc."\"  }");

                        $URL_filter = "tran.tabs.frame.php?data=".base64_encode("{ \"tranIDSender\" : ".$tranID.", \"tranID\" : ".$filterTranID.", \"menuName\" : \"".$name_A."\", \"menuParentName\" : \"".$name_AA."\", \"ID\" : \"0\", \"fieldName\" : \"".$prmInput."\", \"fieldValue\" : \"".$ID."\", \"tableID\" : \"".$tableID."\", \"uTabIDSend\" : \"".$uTabID."\", \"menuTranID\" : \"".$menuTranID."\", \"menuCategoryID\" : \"".$menuCategoryID."\", \"menuName\" : \"".$menuName."\", \"menuParentName\" : \"".$menuParentName."\", \"designPropertyTypeID\" : \"".$designPropertyTypeID."\", \"designPropertyID\" : \"".$designPropertyID."\", \"devRerouteServerApi\" : \"".$devRerouteServerApiEnc."\"  }");


                        $buttonSaveEnabled = false;
                        $buttonCancelEnabled = false;
                        $buttonFilterClearEnabled = false;

                        $URL_add = $URL_add . "&parentTabData=". $sendTabData;
                        $URL_filter = $URL_filter . "&parentTabData=". $sendTabData;
                        

                        /*                <input type="hidden" name="tabOutputs[<?php echo $tabID ?>][]" value="<?php echo base64_encode(json_encode($tabOutputClean)); ?>">
                         * 
                         */

                    $tabOutputClean = $tabOutput;
                    $tabOutputClean["subItems"] = "";
                    $tabOutputClean["parameters"] = "";
                    $tabOutputClean["frameworkClaimData"] = "";
                
                ?>
                                    
                <?php if ( $inputTypeID != 101 && $inputTypeID != 102 ) { ?>
                <input type="hidden" name="tabOutputs[<?php echo $tabID ?>][]" value="<?php echo base64_encode(json_encode($tabOutputClean)); ?>">
                <?php } ?>
                
                <?php
                $functionName = "inputTypeID_".$inputTypeID;
                if ( method_exists( $aigap, $functionName ) ) { ?>
                    
                    <?php echo $aigap->$functionName( $tabOutput, $parameters, $tranID, $tabOutputActions ); ?>
                    
                <?php } else { ?>
                    <?php if ( $inputTypeID > 0 ) { ?>
                    <?php echo $aigap->inputTypeID_unknown( $tabOutput, $parameters ); ?>
                    <?php } ?>
                <?php } ?>		
            <?php } ?>
				
				
            <div>
                <table class="table" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="100%"></td>
                        <?php if ( $reloadSender == "1" ) { ?>
                        <?php
                        $senderDataArray = explode("|", $senderData );
                        $__targetID = $senderDataArray[0];
                        $__targetMainID = $senderDataArray[1];
                        $__tranID = $senderDataArray[2];

                        ?>
                        <script>
                            function buttonCancelClick_<?php echo $__tranID; ?>(){
                                var targetObject = $("#<?php echo $__targetID; ?>");
                                targetObject.attr("isOpen", "0");
                                cleanHtml_<?php echo $__tranID; ?>( '<?php echo $__targetID; ?>' );
                            }
                        </script>
                        <td nowrap>
                        <button type="button" class="btn btn-warning" onclick="javascript:buttonCancelClick_<?php echo $__tranID; ?>();">Vazgeç</button></td>
                        <?php } ?> 

                        <?php if ( $buttonSaveEnabled ) { ?>
                        <td nowrap><button type="submit" class="btn btn-success" uTabID="<?php echo $uTabID; ?>" tranID="<?php echo $tranID; ?>" tabID="<?php echo $tab["tabID"]; ?>" actionTiID="<?php echo $button_actionTiID; ?>" onclick="javascript:buttonSubmitOnClick(this);"><?php echo $buttonSaveText ?></button></td>
                        <?php } ?> 

                        <?php if ( $buttonCancelEnabled ) { ?>
                        <td nowrap><button type="button" class="btn btn-danger" onClick="javascript:cancelButtonClick();"><?php echo $buttonCancelText ?></button></td>
                        <?php } ?> 

                        <?php if ( $buttonFilterClearEnabled ) { ?>
                        <td><button type="button" class="btn btn-warning" onClick="javascript:clearFilter('<?php echo $tranIDSender; ?>','<?php echo $tabID ?>');"><?php echo $getLanguageValue("t.ClearFilter"); ?></button></td>
                        <?php } ?>
                    </tr>
                </table>
            </div>


            </div>
            <?php } ?>
            </div>
		      
	</form>
    
</div>
  
    
<script>

function tranSave( tranID, ID, parentTabData, currentTabData, designPropertyTypeID, designPropertyID, reloadSender, senderData, uTabID, devRerouteServerApi, timeoutSecond ) {
    
    if ( timeoutSecond === undefined || timeoutSecond === "undefined" ) {
        timeoutSecond = 60 * 60 * 1000;
    }
    
        var formMain = $('#form-tran-'+tranID+'-utabid-' + uTabID);
        
        var buttonSubmit = formMain.find("[type=submit]");
        if ( buttonSubmit !== undefined && buttonSubmit !== "undefined" ) { buttonSubmit.attr( "disabled", true ); }
        var formSubmitStatus = true;
        if ( document.querySelector('form:invalid') ) { formSubmitStatus = false; }
                
        //console.log("AA : " + formMain.html() );
        
        var formFileValues = formMain.serializeFiles();
        formFileValues.append("dev1", "<?php echo $dev1; ?>");
        formFileValues.append("dev2", "<?php echo $dev2; ?>");
        //formFileValues.append("tranFields", tranFields);
                
        var uTabIDPass = uTabID;
        
        if ( formSubmitStatus ) {
        $.ajax({
            url: "<?php echo $directoryPath; ?>/tran.save.async.php",
            data: formFileValues,
            processData: false,
            contentType: false,
            type: 'POST',
            timeout: timeoutSecond,
            success: function ( result ) {
                
                if ( buttonSubmit !== undefined && buttonSubmit !== "undefined" ) { buttonSubmit.attr( "disabled", false ); }
                
                var resultJson = JSON.parse( JSON.stringify( result ) );
                
                if ( resultJson.returnCode.messageID === 0 ) {
                    
                    var autoRunTranID_ = parseInt(resultJson.autoRunTranID);
                    var autoRunStateID_ = parseInt(resultJson.autoRunStateID);
                    var devRerouteServerApi_ = resultJson.devRerouteServerApi===null?"":resultJson.devRerouteServerApi;
                    
                    if ( autoRunTranID_ > 0 ) {
                    
                        var targetURL = 'actiontran?t='+autoRunTranID_+'&i=0&ati=0&drsi='+devRerouteServerApi_+'&trf=';
                        location.href = targetURL;                        
                    }
                    else {
                        location.reload( true );
                        //alert( resultJson.returnCode.message );
                    }
                    
                }
                else {
                    alert( resultJson.returnCode.message );
                }
                
                $("body").find(".progressIcon").remove();
                $(function(){
                    $(".processBackground").css({ "display": "none" });
                });
            },
            error: function( x, t, e ){
                
                if ( buttonSubmit !== undefined && buttonSubmit !== "undefined" ) { buttonSubmit.attr( "disabled", false ); }
                
                var errorMessage = "Error";
                var language = $.cookie("language");
                
                if ( t === "timeout" ) {
                    if ( language === "tr" ) { errorMessage = "İşlem zaman aşımına uğradı"; }
                    else { errorMessage = "Process timed out"; }
                }
                else {
                    errorMessage = "Error ["+t+" ("+e+")]";
                }
                
                $("body").find(".progressIcon").remove();
                $(function(){
                    $(".processBackground").css({ "display": "none" });
                });

                console.log( "Error : " + t + " > " + e );
            }
        });
    }
    
    return false;
}

function buttonSubmitOnClick( sender ) {
    
    var senderObject = $(sender);
    var actionTiID = senderObject.attr("actionTiID");
    var devRerouteServerApi = senderObject.attr("devRerouteServerApi");
    var referData = senderObject.attr("referData");

    $("[name=\"actionTiID\"]").val( actionTiID );
    
    if ( senderObject.is("button") ) {

        
        $(document).ready( function(){
            $(".processBackground").css({ "display": "block" });
            senderObject.css({ "z-index": "1001" });
            
            $(function() {
                var progressDiv = $('<div class="progressIcon"><i class="fas fa-spinner fa-pulse"></i></div>');
                senderObject.prepend( progressDiv );
            });
        });

    }
    
    if ( senderObject.is("button") && ( devRerouteServerApi !== undefined && devRerouteServerApi !== "" ) ) {
        $("[name=\"devRerouteServerApi\"]").val( devRerouteServerApi );
        $("[name=\"referData\"]").val( referData );
    }
}

function buttonHomeOnClick( sender, clearUserData ) {
    
    var senderOBJ = $(sender);
    var cookiePrefix = senderOBJ.attr("cookiePrefix");
    var cookie_homePageURL = cookiePrefix + "homePageURL";
    var homePageURL = $.cookie( cookie_homePageURL );
    
    if ( clearUserData ) {
        $.ajax({
            url: "<?php echo $directoryPath; ?>/get.json.php",
            data: {
                "get" : "logout",
                "clearUserData" : clearUserData
            },
            type: "POST",
            crossDomain: true,
            dataType: "json",
            success: function ( result ) {

                var resultJson = JSON.parse( JSON.stringify( result ) );
                
                if ( resultJson.messageID === 0 ) {
                    
                    var waitSecond = 0;
                    if ( parseInt( resultJson.waitSecond ) > 0 ) {
                        waitSecond = parseInt( resultJson.waitSecond ) * 1000;
                        
                        setTimeout( function(){ location.href = homePageURL; }, waitSecond );
                    }
                    else {
                        location.href = homePageURL;
                    }
                    
                }
                else {
                    alert( resultJson.message );
                }
            },
            error: function( x, t, e ){

                console.log( "Error : " + t + " > " + e );
            }
        });
    }
    else {
        location.href = homePageURL;
    }
}

(function($) {
  $.fn.serializeFiles = function() {
    var form = $(this),
        formData = new FormData(),
        formParams = form.serializeArray();

    $.each(form.find('input[type="file"]'), function(i, tag) {
      $.each($(tag)[0].files, function(i, file) {
        formData.append(tag.name, file);
      });
    });

    $.each(formParams, function(i, val) {
      formData.append(val.name, (val.value===null?"":val.value) );
    });

    return formData;
  };
})(jQuery);

</script>