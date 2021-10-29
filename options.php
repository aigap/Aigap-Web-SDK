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
include("config.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");

//$aigap = new aigap();

$config_pageToken = $config["pageToken"];
$pageToken = isset($_REQUEST["pageToken"])?addslashes( $_REQUEST["pageToken"] ):"";

$homePageURL = "/";

$requestUriParse = parse_url( $referURL );
$homePageURL_l0 = urldecode( $_SERVER["REQUEST_URI"] );
$homePageURL_l1 = explode( "_pe/", $homePageURL_l0)[0];
$homePageURL = $homePageURL_l1."_pe/";
if ( $homePageURL == "_pe/" || $homePageURL == "/_pe/" ) { $homePageURL = "/"; }

function getVersion( $directory = __DIR__."/" ) {

    $versionJson = json_decode( file_get_contents( $directory."class/version.info.json" ) );
    if ( $versionJson == "" ) {
        $versionJson = json_decode( file_get_contents( "class/version.info.json" ) );
    }

    $versionArray = array();
    $versionArray["version"] = $versionJson->version;
    $versionArray["build"] = $versionJson->build;

    return $versionArray;

}

function getLanguageFileArray( $directory = __DIR__."/", $screenIDs = array( 0 ), $langCode = "en" ) {
            
    $languageArray = array();

    $filePath = "";
    if ( file_exists( $directory."files/languages/".$langCode.".json") ) {
        $filePath = $directory."files/languages/".$langCode.".json";
    }
    else if ( file_exists("files/languages/".$langCode.".json") ) {
        $filePath = "files/languages/".$langCode.".json";
    }
        
    if ( $filePath != "" ) {
        $languageFile = file_get_contents( $filePath );
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

$langCode = getCookie("langCode");
$languageArray = getLanguageFileArray( "", array(0), $langCode );

function getCookie( $field )
{

    $return = "";

    if ( isset($_COOKIE[$field]) )
    {
            $return = $_COOKIE[$field];
    }

    return $return;
}

function getLanguageValue( $a, $b  = "tr", $languageArray = array() ) {


    $return = "{{" . $a . " - " . $b . "}}";

    if ( isset($languageArray[$a]) ) {
        $return = $languageArray[$a];
    }

    return $return;
}

$versionControlURL = "https://sdk.aigap.com/update/version.json";
$versionControlJson = json_decode(file_get_contents(  $versionControlURL ) );

$versionControl_code = $versionControlJson->version->code;
$versionControl_build = $versionControlJson->version->build;
$versionControl_required = $versionControlJson->version->required;
$versionControl_url = $versionControlJson->version->url;

$class_code = getVersion( "../" )["version"];
$class_build = getVersion( "../" )["build"];

$referURL = $_SERVER["HTTP_REFERER"];
$referUrlParse = parse_url( $referURL );
$referUrlParse_host = $referUrlParse["host"];

$secureCheck = false;

if ( $pageToken == $config_pageToken && $pageToken != "" ) {
    $secureCheck = true;
}
else if ( preg_match( "/aigap.com/i", $referUrlParse_host) ) {
    $secureCheck = true;
}

if ( !$secureCheck ) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";
    exit;
}

$_SESSION["developerToolsShow"] = "1";

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Options</title>
<meta name="keywords" content="Options">
<meta name="description" content="Options">


<link rel="stylesheet" href="<?php echo $directoryPath; ?>/style/glyphicons.css" />

<script src="<?php echo $directoryPath; ?>/javascript/jquery-3.4.1.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/jquery.cookie.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/aigap.main.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/slick.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/Utils.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/jquery.base64.min.js"></script>

<script src="https://kit.fontawesome.com/2c3974ae8f.js" crossorigin="anonymous"></script>

<style>
    body { font-family :verdana; }
    .managementMain { margin: 20px auto; width: 500px; border: 1px solid #3d3d3d; border-radius: 10px; overflow: hidden; }
    .managementMain thead, .managementMain tfoot { background-color: #3d3d3d; color: #ffffff; height: 40px; }
    .managementMain thead > tr > td {  text-align: center; }
    .managementMain tbody > tr { height: 40px; }
    .managementMain tbody > tr > td { padding: 0 10px; }
    .managementMain tbody > tr:nth-child(even) { background-color: #ededed; }
    .managementMain input[type="button"] { background-color: #4b4b4b; color: #FFFFFF; padding: 5px 10px; border: 0; min-height: 30px; border-radius: 10px; }
</style>

<script>
    
    var htmlCheck = "<i class=\"fas fa-spinner fa-pulse\"></i>";
    var htmlCorrect = "<i class=\"fas fa-check\"></i>";
    var htmlError = "<i class=\"fas fa-times\"></i>";
    
    $(document).ready( function(){
        $("input[type=\"button\"]").click(function(){
            
            var action = $(this).attr("action");
            
            $(this).closest("tr").find(".state").html( htmlCheck )
            
            if( action === "homePage" ) {
                var homePageURL = "<?php echo $homePageURL; ?>";
                window.open( homePageURL, "_blank");
                $(this).closest("tr").find(".state").html( htmlCorrect );
            }
            else {
                getAction( this );
            }
        });
    });
    

    
    function getAction( sender ) {
        
        var senderObj = $( sender );
        var action = senderObj.attr("action");
        
        $.ajax({
            url: "options.get",
            type: "POST",
            crossDomain: true,
            data: {
                "action" : action
            },
            dataType: "json",
            success: function (result) {
                console.log("aaa");
                
                var resultJson = JSON.parse( JSON.stringify( result ) );
                
                if ( resultJson.status === "0" ) {

                    senderObj.closest("tr").find(".state").html( htmlCorrect );
                    if ( action === "update" ) {
                        location.reload(true);
                    }
                }
                else {
                    alert( resultJson.message );
                    senderObj.closest("tr").find(".state").html( htmlError );
                }
            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            //showMessageBottom( error, "e" );
            
                senderObj.closest("tr").find(".state").html( htmlError );
            }
        });
    }
</script>

</head>

<body style="margin: 0; padding: 0;">

<div class="managementMain">
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td colspan="4"><?php echo getLanguageValue( "t.AdminMenu", $langCode, $languageArray ); ?></td>
            </tr>
        </thead>
        
        <tbody>
            
            <tr>
                <td><?php echo getLanguageValue( "t.HomePage" ); ?></td>
                <td>&nbsp;:&nbsp;</td>
                <td><input type="button" action="homePage" value="<?php echo getLanguageValue( "b.GoHomePage", $langCode, $languageArray ); ?>" /></td>
                <td class="state" width="30"></td>
            </tr>
            
            <tr>
                <td><?php echo getLanguageValue( "t.Cache", $langCode, $languageArray ); ?></td>
                <td>&nbsp;:&nbsp;</td>
                <td><input type="button" action="clearCache" value="<?php echo getLanguageValue( "b.ClearCache", $langCode, $languageArray ); ?>" /></td>
                <td class="state" width="30"></td>
            </tr>
            
            <tr>
                <td><?php echo getLanguageValue( "t.Cookie", $langCode, $languageArray ); ?></td>
                <td>&nbsp;:&nbsp;</td>
                <td><input type="button" action="clearCookie" value="<?php echo getLanguageValue( "b.ClearCookie", $langCode, $languageArray ); ?>" /></td>
                <td class="state" width="30"></td>
            </tr>
            
            <tr>
                <td><?php echo getLanguageValue( "t.Update", $langCode, $languageArray ); ?></td>
                <td>&nbsp;:&nbsp;</td>
                <td>
                    <div>
                        <?php if ( $versionControl_code > $class_code || ( $versionControl_code == $class_code && $versionControl_build > $class_build ) ) { ?>
                        <div>
                            <table>
                                <tr>
                                    <td><?php echo getLanguageValue( "t.InstalledVersion", $langCode, $languageArray ); ?></td>
                                    <td><?php echo $class_code.".".$class_build; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo getLanguageValue( "t.NewVersion", $langCode, $languageArray ); ?></td>
                                    <td><?php echo $versionControl_code.".".$versionControl_build; ?></td>
                                </tr>
                                <tr>
                                    <td>Zorunlu</td>
                                    <td><?php echo $versionControl_required==1? getLanguageValue( "b.Yes", $langCode, $languageArray ) : getLanguageValue( "b.No", $langCode, $languageArray ); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <input type="button" action="update" value="Güncelle" />
                        </div>
                        <?php } else { ?>
                        <?php echo getLanguageValue( "t.Updated", $langCode, $languageArray ); ?>
                        <?php } ?>
                    </div>
                </td>
                <td class="state" width="40"></td>
            </tr>
            
        </tbody>        
        
        <tfoot>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
        </tfoot>
        
    </table>
</div>

</body>
</html>