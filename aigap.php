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


$qs = $_SERVER['QUERY_STRING'];
$qsj = json_encode($qs);
$qsmd5 = md5($qsj);
$cacheDir = "files/cache/";

if ( $qsmd5 != "" && $cacheEnable ) {
    
    $langCode__ = "en";
    $cookiePrefix__ = "";
    $clearCache__ = "";
    
    $subdomain__ = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));
    if ( $subdomain__ === "panel" ) {
        $cookiePrefix__ = "sdk_";
    }

    if ( isset($_COOKIE[ $cookiePrefix__."langCode"]) )
    {
        if ( $_COOKIE[$cookiePrefix__."langCode"] != "" && $_COOKIE[$cookiePrefix__."langCode"] != null ) {
            $langCode__ = $_COOKIE[$cookiePrefix__."langCode"];
        }
    }
    
    if ( isset($_REQUEST["clearCache"]) )
    {
        if ( addslashes($_REQUEST["clearCache"]) != "" && addslashes($_REQUEST["clearCache"]) != null ) {
            $clearCache__ = addslashes($_REQUEST["clearCache"]);
        }
    }
    
    $fileFull = $cacheDir.$qsmd5.".".$langCode__.".html.cache";

    if ( $clearCache__ == "all" ) {

    }
    
    if ( file_exists( $fileFull ) ) {
        if ( $clearCache__ == "page" || $clearCache__ == "all" ) {
            unlink( $fileFull );
        }
        else {
            $cacheFileContents = file_get_contents( $fileFull );
            //$cacheFileContents = str_replace( "<!-- FROM_CACHE -->" , "<div>Load from cache: ".$qsmd5."</div>", $cacheFileContents);
            echo  $cacheFileContents;
            exit;
        }
    }
}

include("aigap.sdk.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
/*
foreach( $_SESSION[] as $key => $value ) {
    session_unset($key);
}
 * 
 */





try {

$directoryPath = "";

$pageURL = $_SERVER["REQUEST_URI"];
$pageDirectory = dirname( $pageURL );
if ( $pageDirectory != "" && $pageDirectory != "/" && $subdomain === "panel" ) {
    $directoryPath = $pageDirectory;
    //$directoryPath = str_replace( "/liveMode", "", $directoryPath);
    $directoryPath = "/sdk";
}


//$directoryPath = str_replace( "/dev", "", $directoryPath);
//$directoryPath = "/sdk";

$parametersTran_style = $parametersTran["webCSS"];
$parametersTran_javascript = $parametersTran["webJS"];

$title = "AIGAP - SDK";
$keywords = "aigap sdk, aigap, sdk";
$description = "Aigap sdk";
$googleSiteVerification = "";
$usePageCache = false;

if ( !empty($parametersTran["webTitle"]) && $parametersTran["webTitle"] != "" ) {
    $title = $parametersTran["webTitle"];
}

if ( !empty($parametersTran["webKeywords"]) && $parametersTran["webKeywords"] != "" ) {
    $keywords = $parametersTran["webKeywords"];
}

if ( !empty($parametersTran["webDescription"]) && $parametersTran["webDescription"] != "" ) {
    $description = $parametersTran["webDescription"];
}

if ( !empty($parametersTran["googleSiteVerification"]) && $parametersTran["googleSiteVerification"] != "" ) {
    $googleSiteVerification = $parametersTran["googleSiteVerification"];
}

if ( !empty($parametersTran["usePageCache"]) && $parametersTran["usePageCache"] != "" ) {
    $usePageCache = $parametersTran["usePageCache"] == "1" ? true : false;
}

if ( $usePageCache == false ) {
    $cacheEnable = false;
}

//echo json_encode( $parametersTran );

$uTabID = "xxxx-xxxx-xxxx";
$uTabIDParent = "xxxx-xxxx-xxxx";
$tranID = "0";
$parentTabData = "";
$sendTabData = "";
$designPropertyTypeID = "0";
$designPropertyID = "0";
$reloadSender = "0";
$senderData = "";
if ( !isset($devRerouteServerApi) ) {
$devRerouteServerApi = "";
}
$devRerouteServerApiEnc = "";
                   
$dev1 = $aigap->g("dev1");
$dev2 = $aigap->g("dev2");
$dev1_dec = json_decode( $aigap->AES256_decrypt( base64_decode( $dev1 ) ), true);

$userData_1 = json_decode( $aigap->AES256_decrypt( $aigap->getCookieSession("userData_1")  ), true);
//echo json_encode($userData_1);

$expireDate = "";
$developerMode = false;

if ( $dev1_dec != "" ) {
    foreach( $dev1_dec as $key => $value ) {
        //echo $key ." : " . $value . "<br>";

        if ( $key == "fwID" ) { $aigap->setFWID( $value ); $developerMode = true; }
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

if ( $dev2 == "1" ) {
    
    $name = 'https://mfa.gov.ct.tr/wp-content/uploads/2020/03/Attention.png';
    $fp = fopen($name, 'rb');

    header("Content-Type: image/png");
    header("Content-Length: " . filesize($name));

    fpassthru($fp);

    exit();
}

$t__ = $aigap->g("t");
$i__ = $aigap->g("i");
$ati__ = $aigap->g("ati");

$collectUrl = $aigap->getCookie("collectUrl");
if ( $collectUrl != "" ) {
    $aigap->sqlite_create_sitemap();
    $aigap->sqlite_addUrl( $t__, $i__, $ati__, $aigap->getCurrentURL(), $title, $keywords, $description );
}

//$userData = json_decode( json_encode( $aigap->getUserData() ), true);
//echo json_encode( $userData )."<br>";

/*
$results = $db->query('SELECT bar FROM foo');
while ($row = $results->fetchArray()) {
    var_dump($row);
}
 * */
 

/*
foreach ( $_COOKIE as $key => $value ) {
    echo $key." > ".$value."<br>";
    $aigap->delCookie($key);
}

foreach ( $_SESSION as $key => $value ) {
    echo $key." > ".$value."<br>";
    $aigap->delSession($key);
}
*/

//echo $devDataSampleB64;

//print_r( $_REQUEST );

//print_r( $tabs );

//print_r( $_COOKIE );
//print_r( $_SESSION );

$clearCache = $aigap->g("clearCache");
if ( $clearCache == "1" ) {
    
    $requestURI = $_SERVER['REQUEST_URI'];
    $requestURI = str_replace( "?clearCache=1", "", $requestURI);
    $requestURI = str_replace( "clearCache=page", "", $requestURI);
    $requestURI = str_replace( "clearCache=all", "", $requestURI);
    
    $aigap->setCookie("homePageURL", $requestURI, false);
    
    foreach( $_SESSION as $key => $value ) {
        if ( $key != $aigap->getCookiePrefix()."browserUID" && $key != $aigap->getCookiePrefix()."langCode" ) {
            $aigap->delSession( $key );
        }
    }
    
    foreach( $_COOKIE as $key => $value ) {
        if ( $key != $aigap->getCookiePrefix()."browserUID" && $key != $aigap->getCookiePrefix()."langCode" && $key != $aigap->getCookiePrefix()."rememberUserData" ) {
            $aigap->delCookieSession( $key );
        }
    }
    
    
    $cacheFiles = scandir( $cacheDir );
    foreach( $cacheFiles as $cacheFile ) {
        if ( $cacheFile != "." && $cacheFile != ".." ) {
            if ( file_exists( $cacheDir.$cacheFile ) ) {
                unlink( $cacheDir.$cacheFile );
            }
        }
    }
    
    
    header("Location: " . $requestURI );
    
    $cacheEnable = false;

}

if ( $aigap->getCookie("homePageURL") == "" ) {
    
    $homePageURL_l0 = urldecode( $_SERVER["REQUEST_URI"] );
    $homePageURL_l1 = explode( "_pe/", $homePageURL_l0)[0];
    $homePageURL_l2 = "/";
    if ( count($homePageURL_l1) > 1 ) { $homePageURL_l2 = $homePageURL_l1."_pe/"; }
    if ( $homePageURL_l2 == "_pe/" || $homePageURL_l2 == "/_pe/" ) { $homePageURL_l2 = "/"; }
    $homePageURL_l2 = str_replace( "?clearCache=1", "", $homePageURL_l2);
    $homePageURL_l2 = str_replace( "clearCache=page", "", $homePageURL_l2);
    $homePageURL_l2 = str_replace( "clearCache=all", "", $homePageURL_l2);
    
    $aigap->setCookie("homePageURL" , $homePageURL_l2, false);
}

$activeData = array( "activeTranID" => "0", "activeTabID" => "0", "activeFwID" => "0" );

if ( !empty($jsonData) ) {
    if ( $jsonData["activeTranID"] ) { $activeData["activeTranID"] = $jsonData["activeTranID"]; }
    if ( $jsonData["activeTabID"] ) { $activeData["activeTabID"] = $jsonData["activeTabID"]; }
    if ( $jsonData["activeFwID"] ) { $activeData["activeFwID"] = $jsonData["activeFwID"]; }
}
$activeDataJson = urlencode( json_encode($activeData) );

?>

<?php
$langCode_ = "en";
if ( $aigap->getCookie("langCode") != "" && $aigap->getCookie("langCode") != null && $aigap->getCookie("langCode") != "null" ) { $langCode_ = $aigap->getCookie("langCode"); }
$languageValuesArray = $aigap->getLanguageFileArray( array( 0 ), $langCode_ );

$aigap->setLangCode( $langCode_ );

$getLanguageValue = function( $field, $langCode  = "en" ) use ($languageValuesArray) {

    if ( $langCode == "" ) { $langCode = $this->getCookie("langCode"); }
    
    $return = "{{" . $field . " - " . $langCode . "}}";

    if ( isset( $languageValuesArray[$field] ) ) {
        $return = $languageValuesArray[$field];
    }

    return $return;
}


//echo "<div>" . $uTabID . " >> " . $uTabIDParent . "</div>";
//echo "<div>" . print_r( $_REQUEST ) . "</div>";


?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php echo $title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>">
<meta name="description" content="<?php echo $description; ?>">
<?php if ( $googleSiteVerification != "" ) { ?>
<meta name="google-site-verification" content="<?php echo $googleSiteVerification; ?>" />
<?php } ?>

<link rel="stylesheet" href="<?php echo $directoryPath; ?>/style/slick.css"/>


<style>
    
    @font-face{ font-family: "SairaSemi-Black"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-Black.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-Bold"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-Bold.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-ExtraBold"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-ExtraBold.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-ExtraLight"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-ExtraLight.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-Light"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-Light.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-Medium"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-Medium.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-Regular"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-Regular.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-SemiBold"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-SemiBold.ttf") format("truetype"); }
    @font-face{ font-family: "SairaSemi-Thin"; src: URL("<?php echo $directoryPath; ?>/fonts/SairaSemiCondensed-Thin.ttf") format("truetype"); }
    @font-face{ font-family: "HelveticaNeue"; src: URL("<?php echo $directoryPath; ?>/fonts/HelveticaNeue.otf") format("opentype"); }
    @font-face{ font-family: "SegoeUI"; src: URL("<?php echo $directoryPath; ?>/fonts/Segoe_UI.woff") format("woff"); }
    
    html, body, table { font-family: arial, verdana; font-size: 14px; padding: 0; margin: 0; color: #000000; }
    a { text-decoration: none; color: #000000; }
    table, table tbody, table tr, table td { padding:0; margin:0; }
    img {  }
    
    .main_table { padding: 0; margin: 0; list-style: none; width: 100%;  }
    .main_table > li.horizontal { padding: 0; margin: 0; display: inline-block; }

    .menu { clear: both; }
    .menu > ul { margin: 10px 0; padding: 0; list-style: none; } 
    .menu > ul > li { float: left; margin: 0; padding: 10px; }
    .menu > ul > li > a { text-decoration: none; color: #000000; }
    
    .header > .logo { margin: 20px 10px; }
    
    .middle > div { padding: 10px 0; }
    .middle > .menu-tab {  }
    .middle > div { position: relative; }
    .middle > .active { display: block; }
    
    .header, .middle, .footer { clear: both; }
    
    input, select { width: 100%; height: 100%; min-height: 20px; min-width: 20px; margin:0; border-radius: 6px; border: 1px solid #CCCCCC; }
    input[type=checkbox] { width: auto; height: auto; min-height: 0; min-width: 0; }
    .label_checkbox { margin-left: 4px; }
    button { width: 100%; min-height: 20px; padding: 0 10px; margin: 0; border-radius: 10px; border: 1px solid #CCCCCC; cursor: pointer; }
    
    /*.carousel, .carousel-inner, .carousel-item { position: relative; height: auto; display: inline-block; }*/
    .carousel-item { position: relative; height: 100px; }
    /*img { max-width: 100%; max-height: 100%; width: auto; height: auto; position: relative;}*/
    
    .button {}
    .button-green { background-color:#00dd1c; color: #0a0a0a; border: 0; }
    .button-red { background-color:#c82333; color: #0a0a0a; border: 0; }
    
    .segment-menu { display: table; width: auto; margin: 0; padding: 0; }
    .segment-menu > li { display: table-cell; margin: 0; padding: 5px 10px; list-style-type: none; transition: all 0.3s; }
    .segment-menu > li:hover { opacity: 0.5; }
    .segment-menu > li > .menu-button { display: flex; align-items:center; }
    .segment-menu > li > .menu-button > a { white-space: nowrap; }
    
    .segment-menu-mobile-main { display: none; z-index: 1; position: relative; }
    .segment-menu-mobile { display: none; width: auto; min-width: 150px; margin: 0; padding: 0; background-color: #FFFFFF; -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.5); -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.5); box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.5);  }
    .segment-menu-mobile > li { margin: 0; padding: 5px 10px; list-style-type: none; transition: all 0.3s; }
    .segment-menu-mobile > li:hover { opacity: 0.5; }
    .segment-menu-mobile > li > .menu-button { display: flex; align-items:center; }
    .segment-menu-mobile > li > .menu-button > a { white-space: nowrap; }

    .input_type_id_83 { position: relative; }

    .s_tb { display: block; }
    
    .mainSearchText { margin-right: 0; border-radius: 0; padding: 0 10px; }
    .mainSearchButton { margin-left: 0; border-radius: 0; }
    
    .memberMenuMain { position: relative; cursor: pointer; white-space: nowrap; }
    .memberMenu { position: absolute; bottom: 1px; left: 0; transform: translateY(100%); white-space: nowrap; padding: 5px; display: none; -webkit-box-shadow: 0px 2px 20px 0px rgba(0,0,0,0.75); -moz-box-shadow: 0px 2px 20px 0px rgba(0,0,0,0.75); box-shadow: 0px 2px 20px 0px rgba(0,0,0,0.75); border-radius: 10px; background-color: #FFFFFF; z-index: 2000; }
    .memberMenuItem { padding: 5px 10px; border-bottom: 1px solid #DDDDDD; }
    .memberMenuItem:last-child { border: 0; }
    .memberMenuItem:hover { background-color: #EDEDED; border-radius: 5px; }
    
    .loadIcon { width: 32px; height: 32px; background: url('/images/ajax-loader-new.gif'); position: absolute; top: 50%; left: 50%; transform: translate( -50%, -50% ); background-repeat: no-repeat; }
    
    .quantity_box { display: table; }
    .quantity_box > div { display: table-cell; vertical-align: middle; }
    
    .onClickView { cursor: pointer; }
    .button { position: relative; }
    
    .progressIcon { top: 50%; transform: translateY(-50%); width: 16px; height: 16px; border-radius: 8px; left: 10px; position: absolute; background-color: rgba( 0, 0, 0, 0.5 ); }
    
.options_div {
    position: absolute;
    top: 40px;
    right:0;
    width: 100%;
    background-color: #FDFDFD;
    border: 1px solid #C2CAD2;
    border-radius: 6px;
    display: none;
    padding: 10px;
    z-index: 1061;
    min-width: 300px;
    -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.5);
    -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.5);
    box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.5);
}

.options_div > .search {
    padding: 5px;
}

.form-control {
    min-height: 20px;
}

.btn {
    min-height: 34px;
    border: 0;
    background-color: #EDEDED;
    color: #000000;
    cursor: pointer;
}

.btn:hover {
    background-color: #DDDDDD;
    color: #000000;
}

.options_div .close_button > img, .options_div .menu_add > img {
    border: 1px solid #000000;
    border-radius: 17px;
    cursor: pointer;
}

.options_div .close_button > img:hover, .options_div .menu_add > img:hover {
    transition: 0.70s;
    -webkit-transition: 0.70s;
    -moz-transition: 0.70s;
    -ms-transition: 0.70s;
    -o-transition: 0.70s;
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
    background-color: #DDDDDD;
}


.options_div_table, options_div_table tr, options_div_table td {
    padding: 0; margin: 0; border: 0;
}

.options_div > .content {
    min-height: 50px;
    max-height: 32vh;
    overflow-y: auto;
}

.options_div > .content > div {
    padding: 5px 10px;
    margin: 0 5px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}
 
.options_div > .content > div:nth-child(even) {
    background-color: #EDEDED;
}

.options_div > .content > div:hover {
    background-color: #DDDDDD;
}

.options_div > .content > div.selectedItem {
    background-color: #5B5B5B;
    color: #EEEEEE;
}

.options_div > .content > div.group {
    background-color: #AAAAAA;
}

.options_div > .content > div.groupItem {
    padding: 5px 10px 5px 20px;
}

.textOverDot { text-overflow: ellipsis; overflow: hidden; white-space: nowrap; }
.imageTextArea { padding: 0; margin: 0; }
.imageTextArea > li {
    padding: 0;
    margin: 0;
    display: inline-block;
    list-style-type: none;
    overflow: hidden;
    vertical-align: middle;
}
.imageTextArea .textAreaDetail { padding: 0; margin: 0; }
.imageTextArea .textAreaDetail > li {
    padding: 0;
    margin: 0;
    list-style-type: none;
}

.inputTypeID_38 { overflow-y: auto; }

.messages { position: absolute; left:0; top:0; right:0; height:auto; z-index: 999; padding: 10px 0; display: none; }
.messages > .message { margin: 6px; display: none; padding: 16px; border-radius: 6px; box-shadow: 0px 0px 4px 0px rgba(0,0,0,0.5); }
.messages > .red { background-color: #e74c3c; color: #FFFFFF; }
.messages > .orange { background-color: #e67e22; color: #FFFFFF; }
.messages > .green { background-color: #2ecc71; color: #FFFFFF; }

.table_l1 { display: table; border: 1px dashed #FF0000; }
.cell_l1 { display: inline-block; width: 100%; }
.cell_l2 { display: inline-table; vertical-align: top; width: 100%; }

.google_map {
    position: relative;
    height: 0;
    overflow: hidden;
    width: 100% !important;
    height: 100% !important;
}
video { width: 100%; height: auto; }

.tableClickRow { cursor: pointer; }

@media only screen and (max-width: 760px), (min-device-width: 768px) and (max-device-width: 1024px) {
    /* Force table to not be like tables anymore */
    .table_standart, .table_standart > thead, .table_standart > tbody, .table_standart > th, .table_standart > tbody > tr > td, .table_standart > tr > td, .table_standart > tr {
        display: block;
        padding: 2px 0;
        width: 100%;
    }
    body { padding: 0 4px; }
    .segment-menu  { display: block; }
    .segment-menu > li { display: block; }
}

tr.collapse.in {
  display:table-row;
}

td > div { vertical-align: middle; }

.treegrid-indent {
    width: 0px;
    height: 10px;
    display: inline-block;
    position: relative;
}
    
.treegrid-expander {
    width: 0px;
    height: 10px;
    display: inline-block;
    position: relative;
    left:-17px;
    cursor: pointer;
}
.icon_g, .icon_gu { width: 10px; height: 10px; margin-right: 2px; }
.messageArea { padding: 10px 10px; margin: 10px 0; display: none; background-color: #F8D9D5; border-radius: 5px;  }

.messageArea_failure_1 { display: none; margin: 10px 0; }
.messageArea_failure_2 { background-color: #F8D9D5; color: #E74C3C; }
.messageArea_success_1 { display: none; margin: 10px 0; }
.messageArea_success_2 { background-color: #CCEBC0; color: #025159; }

table.dynamicView{
    width:100%;
    padding: 0;
    spacing: 0;
    clear: both;
    text-align: left;
    white-space: initial;
}
table.dynamicView td{
    white-space: nowrap;  /** added **/
    vertical-align: top;
    white-space: initial;
}
table.dynamicView td:last-child{
    width:100%;
    white-space: initial;
}

.errorArea { margin: 30px auto; max-width: calc( 100% - 80px ); text-align: center; }
.errorMessage { background-color: #F8E8B5; color: #F0340F; border: 1px solid #F0340F; padding: 10px; border-radius: 20px; font-size: 12pt; text-align: center; display: inline-block; }

.processBackground { position: fixed; top:0; right: 0; bottom: 0; left: 0; background-color: #000000; opacity: 0.2; z-index: 1000; display: none; }

.table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td { padding: 5px; }
.table > thead > tr, table > thead > tr > td { background-color: #DDDDDD; text-shadow: 1px 1px #FFFFFF; }
.table > tbody > tr:nth-child(even) { background-color: #EEEEEE; }


.table-border { border: 1px solid #EEEEEE; border-collapse: collapse; }
.table-border > thead > tr > td { border-right: 1px solid #CCCCCC; }
.table-border > thead > tr > td:last-child { border: 0; }

.table-border > tbody > tr { border-bottom: 1px solid #EEEEEE; }
.table-border > tbody > tr > td { border-right: 1px solid #EEEEEE; }
.table-border > tbody > tr:last-child { border-bottom: 0; }
.table-border > tbody > tr > td:last-child { border-right: 0; }

.table-border > tbody > tr:hover { background-color: #DEDEDE; }

<?php
if ( $parametersTran_style != "" ) {
    echo urldecode( $parametersTran_style );
}
?>
</style>

<link rel="stylesheet" href="<?php echo $directoryPath; ?>/style/jquery-ui.min.css" />
<link rel="stylesheet" href="<?php echo $directoryPath; ?>/style/glyphicons.css" />
<link rel="stylesheet" href="<?php echo $directoryPath; ?>/style/jquery.datetimepicker.css" />

<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $directoryPath; ?>/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $directoryPath; ?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $directoryPath; ?>/favicon-16x16.png">
<link rel="manifest" href="<?php echo $directoryPath; ?>/site.webmanifest">

<script src="<?php echo $directoryPath; ?>/javascript/jquery-3.4.1.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/jquery-ui.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/jquery.datetimepicker.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/jquery.cookie.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/jssor.slider.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/aigap.main.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/slick.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/Utils.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/jquery.base64.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/inputmask.min.js"></script>
<script src="<?php echo $directoryPath; ?>/javascript/bindings/inputmask.binding.js"></script>

<script src="https://kit.fontawesome.com/2c3974ae8f.js" crossorigin="anonymous"></script>


<script>


<?php
if ( $parametersTran_javascript != "" ) {
    echo urldecode( $parametersTran_javascript );
}
?>
  
  var Utils = new Utils();
  

    $(document).ready( function(){
        $(document).on( "click", ".menu > ul > li > a", function(){

            var tabID = $(this).attr("tabID");

            console.log("A");
            $(".middle").find("div.active").removeClass("active");
            $("#menu-tab-id-"+tabID+"").addClass("active");
        });

        $(document).on( "click", ".memberMenuMain", function(){
            var display = $(this).find(".memberMenu").css("display");
            if ( display === "none"  ) {
                $(this).find(".memberMenu").fadeIn("fast");
            }
            else {
                $(this).find(".memberMenu").fadeOut("fast");
            }
        });

        if ( $(".memberMenuMain").length > 0 ) {
            $(".memberMenuMain").mouseleave( function() {
                var display = $(this).find(".memberMenu").css("display");
            if ( display !== "none"  ) {
                $(this).find(".memberMenu").fadeOut("fast");
            }
            });
        }

        $(".quantity_button").on("click", function() {

            var $button = $(this);
            var $input = $button.closest('.quantity_box').find("[name=\"quantity\"]");

            $input.val(function(i, value) {
                return +value + (1 * +$button.data('multi')) < 0 ? 0 : +value + (1 * +$button.data('multi'));
            });
        });
    
    if ( Utils.mobileDeviceStatus() ) {
        $(".table_standart, .table_standart > thead, .table_standart > tbody, .table_standart > th, .table_standart > tbody > tr > td, .table_standart > tr > td, .table_standart > tr").css({ "display": "block", "padding": "2px 0", "width": "100%" });
        $("body > *").css({ "padding" : "0 4px" });
    }
    
    var pressTimeLength = 2000;
    var pressStartTime = 0;
    var pressEndTime = 0;
    
    $(".longPressActive").on("mousedown", function(event) {
        
        var devRerouteServerApi = $(this).attr("devRerouteServerApi");
        pressStartTime = new Date().getTime();
        pressEndTime = 0;
        setTimeout( function(){
            if ( pressEndTime >= ( pressStartTime + (pressTimeLength*0.8) ) || pressEndTime === 0  ) {
                location.href = "target-url?t=11572&i=0&ati=0&drsi="+devRerouteServerApi+"&trf=";
            }
        }, pressTimeLength);
    }).on("mouseup", function(event) {
        var currentDate = new Date().getTime();
        pressEndTime = currentDate;
    });
    
});

var scrollEventList = [];
var eventNumber = 1;

function addToaEvent( event, eventData ) {
    var eventDataJson = JSON.parse( $.base64.decode( eventData ) );
    eventDataJson["event"] = event;
    
    //console.log( event );
    //console.log("Event: " + eventNumber );
    //console.log( eventDataJson );
    eventNumber++;
    
    if ( event === "onScroll" || event === "onScrollRefresh" ) {
        scrollEventList.push( eventDataJson );
        
        var bodyHeight = $("body").height();
        var windowHeight = $(window).height();
        
        if ( bodyHeight < windowHeight ) {
                                
            var tiID__ = eventDataJson.tiID
            var targetObject = $("[toaTiID=\""+tiID__+"\"]");
            var status__ = targetObject.attr("toaStatus");
            
            if ( status__ !== "wait" ) {
                var tranID__ = targetObject.attr("tranID");
                var tabID__ = targetObject.attr("tabID");
                var referTranID__ = targetObject.attr("referTranID");
                var referTabID__ = targetObject.attr("referTabID");
                var referFwID__ = targetObject.attr("referFwID");
                var selectedID__ = targetObject.attr("selectedID");
                var devRerouteServerApi__ = targetObject.attr("devRerouteServerApi");
                var tranFields__ = targetObject.attr("tranFields");
                var inputTypeID__ = targetObject.attr("inputTypeID");

                console.log( targetObject );
                //console.log( tiID__ + " > " + JSON.stringify(eventDataJson) );


                tabOutputActions( targetObject, tranID__, tabID__, referTranID__, referTabID__, referFwID__, encodeURIComponent(JSON.stringify(eventDataJson)), tranFields__, devRerouteServerApi__, selectedID__, inputTypeID__, tiID__ );

                targetObject.css({"opacity": "0.5"});
                targetObject.attr("toaStatus", "wait");
            }

        }
        
        
    }
    else if ( event === "onTimer" ) {
        
        var refreshTimer4Second = eventDataJson.refreshTimer4Second;
        var refreshTimer4MS = parseInt(refreshTimer4Second) * 1000;
        
        setInterval( function(){
        
            
            var tiID__ = eventDataJson.tiID
            var targetObject = $("[toaTiID=\""+tiID__+"\"]");
            var status__ = targetObject.attr("toaStatus");
            
            if ( status__ !== "wait" ) {
                            var tranID__ = targetObject.attr("tranID");
                var tabID__ = targetObject.attr("tabID");
                var referTranID__ = targetObject.attr("referTranID");
                var referTabID__ = targetObject.attr("referTabID");
                var referFwID__ = targetObject.attr("referFwID");
                var selectedID__ = targetObject.attr("selectedID");
                var devRerouteServerApi__ = targetObject.attr("devRerouteServerApi");
                var tranFields__ = targetObject.attr("tranFields");
                var inputTypeID__ = targetObject.attr("inputTypeID");

console.log( targetObject );

                tabOutputActions( targetObject, tranID__, tabID__, referTranID__, referTabID__, referFwID__, encodeURIComponent(JSON.stringify(eventDataJson)), tranFields__, devRerouteServerApi__, selectedID__, inputTypeID__, tiID__ );

                targetObject.css({"opacity": "0.5"});
                targetObject.attr("toaStatus", "wait");
            }

        }, refreshTimer4MS);
    }
}

$(document).scroll( function(){
    
    for( var i = 0; i < scrollEventList.length; i++ ) {
        
        var scrollEventObject = scrollEventList[i];
        var scrollPos = $(this).scrollTop();
        var tiID__ = scrollEventObject["tiID"];
        var targetObject = $("[toaTiID=\""+tiID__+"\"]");
        var status__ = targetObject.attr("toaStatus");
        if ( status__ !== "wait" ) {
            var objectHeight = targetObject.height();
            var targetScrollPos = parseInt(targetObject.offset().top) - parseInt(objectHeight);
            var targetScrollPosEnd = parseInt(targetScrollPos) + parseInt(objectHeight);

            if ( scrollPos >= targetScrollPos && targetScrollPosEnd <= targetScrollPosEnd ) {

                var tranID__ = targetObject.attr("tranID");
                var tabID__ = targetObject.attr("tabID");
                var referTranID__ = targetObject.attr("referTranID");
                var referTabID__ = targetObject.attr("referTabID");
                var referFwID__ = targetObject.attr("referFwID");
                var selectedID__ = targetObject.attr("selectedID");
                var devRerouteServerApi__ = targetObject.attr("devRerouteServerApi");
                var tranFields__ = targetObject.attr("tranFields");
                var inputTypeID__ = targetObject.attr("inputTypeID");

                 //console.log( scrollEventObject );
                 console.log( targetObject );
                 console.log( "Pos: " + scrollPos + " > " + targetScrollPos + " :: " + targetScrollPosEnd + " > " + tiID__ + " > " + tranID__ + " > " + tabID__ );
                 //console.log( targetObject.position() );

                 tabOutputActions( targetObject, tranID__, tabID__, referTranID__, referTabID__, referFwID__, encodeURIComponent(JSON.stringify(scrollEventObject)), tranFields__, devRerouteServerApi__, selectedID__, inputTypeID__, tiID__ );

                 targetObject.css({"opacity": "0.5"});
                 targetObject.attr("toaStatus", "wait");
             
            }
        }
    }
    
});

function onClickHTML( url, target ) {
    window.open( decodeURIComponent(url), target )
}

function inputTypeID_4_onChange( sender ) {
    
    var input = $(sender);
    var prmInput = input.attr("prmInput");
    var cookiePrefix = "<?php echo $aigap->getCookiePrefix(); ?>";
    
    if ( prmInput === "aigap_framework_dev_panel_language_picker" ) {
        var selected_langCode = input.val();
        console.log( selected_langCode );
        if ( selected_langCode !== "" ) {

            $.cookie( cookiePrefix+"langCode", selected_langCode, { "path" : "/", "expires" : 3650, "secure" : true } );
            setTimeout( function() {
                location.reload();  
            }, 200);
        }
    }
}

function onClick( targetURL ) {
    location.href = targetURL;
}


var lastWidth = "300px;";

function tabOutputActions( sender, tranID, tabID, referTranID, referTabID, referFwID, tabOutputActions, tranFields, devRerouteServerApi, selectedID, inputTypeID, tiID ) {
    
    console.log( "Action Geldii" );
    
    if ( selectedID === undefined ) { selectedID = "<?php echo $ID_res; ?>"; }
    if ( inputTypeID === undefined ) { inputTypeID = "0"; }
    if ( tiID === undefined ) { tiID = "0"; }
    var cookiePrefix = "<?php echo $aigap->getCookiePrefix(); ?>";


    var messageAreaFailure = $("#messageAreaFailure");
    var messageAreaSuccess = $("#messageAreaSuccess");

    if ( messageAreaFailure.length <= 0 ) {
        var senderObj = $(sender);
        
        var messageAreaFailureNew = "<div id=\"messageAreaFailure\" class=\"messageArea_failure_1\"><div class=\"messageArea_failure_2\"></div></div>";
        var messageAreaSuccessNew = "<div id=\"messageAreaSuccess\" class=\"messageArea_success_1\"><div class=\"messageArea_success_2\"></div></div>";
        
        senderObj.before( messageAreaFailureNew );
        senderObj.before( messageAreaSuccessNew );
        messageAreaFailure = $("#messageAreaFailure");
        messageAreaSuccess = $("#messageAreaSuccess");
    }

    var motionAndTimerEventStatus = false;
    if ( parseInt(eventActionTypeID) === 19 || parseInt(eventActionTypeID) === 20 || parseInt(eventActionTypeID) ===  21 ) {
        motionAndTimerEventStatus = true;
            console.log("motionAndTimerEventStatus: aa: " + motionAndTimerEventStatus + "  > " + parseInt(eventActionTypeID));

    }

    var __form = $("form");
    var __formonSubmitOriginal = __form.attr("onSubmitOriginal");
    
    if ( __formonSubmitOriginal === "" && !motionAndTimerEventStatus ) {
    __form.attr("onSubmitOriginal", __form.clone().attr("onSubmit") );
    __form.attr("onSubmit", "javascript: return false;");
    }
    
    var selected_actionTiID = $(sender).attr("actionTiID");
    if ( selected_actionTiID !== undefined ) {
        $("[name=actionTiID]").val( selected_actionTiID );
    }
    var formSubmitStatus = true;
    if ( document.querySelector('form:invalid') ) { formSubmitStatus = false; }
            
    var tabOutputActionsDec = decodeURIComponent(tabOutputActions);
    var tabOutputActionsJson = JSON.parse( tabOutputActionsDec );
    
    var eventActionTypeID = tabOutputActionsJson.eventActionTypeID;
    var formActionTypeID = tabOutputActionsJson.formActionTypeID;
        
    var actionTiIDA = "0";
    if ( tabOutputActionsJson !== undefined ){
        if ( tabOutputActionsJson.actionTiIDs !== undefined ) {
            $(tabOutputActionsJson.actionTiIDs).each( function( idx, item ){
                
                var actionTiID = item.actionTiID;
                actionTiIDA = actionTiID;
                var lastWidth = "100%";
                $("[toaTiID='"+actionTiID+"']").append( "<div style=\"min-width: "+lastWidth+";\"><div class=\"loadIcon\"></div></div>" );
                $("[toaTiID='"+actionTiID+"']").css({ opacity: 0.5 });                
            });
        }
    }
    
    if ( devRerouteServerApi !== undefined ) {
        if ( devRerouteServerApi !== "" ) {
            $("[name=devRerouteServerApi]").val(devRerouteServerApi);
        }
    }
    
    var senderObj = $(sender);
    
    var progressDiv = $('<div class="progressIcon"><i class="fas fa-spinner fa-pulse"></i></div>');
    senderObj.prepend( progressDiv );
    
    console.log("motionAndTimerEventStatus: " + motionAndTimerEventStatus + "  > " + parseInt(eventActionTypeID));
    
    if ( !motionAndTimerEventStatus ) {
        $(function() {
            $(".processBackground").css({ "display": "block" });
            senderObj.css({ "z-index": "1001" });
        });
    }

    var tableAll = senderObj.parent().parent().parent().find(".selected");
    $(tableAll).each(function( index, item ){
        $(item).removeClass("selected");
    });
    
    senderObj.addClass("selected");
    
    
    if ( formSubmitStatus ) {
    if ( parseInt(eventActionTypeID) === 3 ) {
    
        $.ajax({
            url: "<?php echo $directoryPath; ?>/get.json.php",
            type: "POST",
            crossDomain: true,
            data: {
                "get" : "tranTabInputs_toa",
                "tranID" : "<?php echo $tranID_res=="0"?$tranID:$tranID_res; ?>",
                "tabID" : tabID,
                "ID" : selectedID,
                "tiID" : actionTiIDA,
                "actionTiID" : tiID,
                "referTranID" : referTranID,
                "referTabID" : referTabID,
                "referFwID" : referFwID,
                "devRerouteServerApi" : devRerouteServerApi,
                "dev1" : "<?php echo $dev1; ?>",
                "dev2" : "<?php echo $dev2; ?>",
                "tranFields" : tranFields,
                "tabOutputActions" : tabOutputActions,
                "activeDataJson" : "<?php echo $activeDataJson; ?>"

            },
            dataType: "json",
            success: function (result) {

                try {
                    var resultJson = JSON.parse( JSON.stringify(result) );

                    if ( resultJson.returnCode.messageID === 0 ) {

                        var responseData = result.responseData;

                        $( responseData ).each( function( idx, item ){

                            if ( formActionTypeID === 2 ) {

                                var actionTiID_ = item.actionTiID;
                                var html_ = item.html;
                                var width_ = item.width;

                                $("[toaTiID='"+actionTiID_+"']").html("");
                                $("[toaTiID='"+actionTiID_+"']").css({ opacity: 1 });
                                $("[toaTiID='"+actionTiID_+"']").closest("td").html( html_ );
                            }
                            else if ( formActionTypeID === 5 || formActionTypeID === 6 ) {
                            }
                            else if ( formActionTypeID === 7 ) {
                                removeSelectedProject( sender )
                            }
                            

                        });

                    }
                    else {
                        Utils.showMessage( resultJson.returnCode.message, "e" );
                        console.log( "A: " + resultJson.returnCode.message );
                    }

                    senderObj.find(".progressIcon").remove();
                    $(function(){
                        $(".processBackground").css({ "display": "none" });
                    });
                }
                catch(Exception){
                    console.log( Exception.message );
                }

                senderObj.find(".progressIcon").remove();
                $(function(){
                    $(".processBackground").css({ "display": "none" });
                });
                
                __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
                __form.attr("onSubmitOriginal", "" );
            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            //showMessageBottom( error, "e" );
                senderObj.find(".progressIcon").remove();
                $(function(){
                    $(".processBackground").css({ "display": "none" });
                });
                __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
                __form.attr("onSubmitOriginal", "" );
            }
        });
    }
    else if ( parseInt(eventActionTypeID) === 7 || parseInt(eventActionTypeID) === 8 ) {
        
        var uTabID = "xxxx-xxxx-xxxx";
        var formMain = $('#form-tran-'+tranID+'-utabid-' + uTabID);
        var serializeFiles = Utils.serializeFiles();
        var formFileValues = formMain.serializeFiles();
        //console.log( formFileValues );
        //    alert("Register or Login");
        
        //formFileValues.append("devRerouteServerApi", devRerouteServerApi);
        formFileValues.append("dev1", "<?php echo $dev1; ?>");
        formFileValues.append("dev2", "<?php echo $dev2; ?>");
        formFileValues.append("tranFields", tranFields);

        var timeoutSecond = 60000;
        
         $.ajax({
            url: "<?php echo $directoryPath; ?>/tran.save.async.php",
            data: formFileValues,
            processData: false,
            contentType: false,
            type: 'POST',
            timeout: timeoutSecond,
            success: function (result) {

                try {
                    var resultJson = JSON.parse( JSON.stringify(result) );

                    if ( resultJson.returnCode.messageID === 0 ) {
                        
                        Utils.showMessage( resultJson.returnCode.message, "c" );
                        
                        var autoRunTranID_ = parseInt(resultJson.autoRunTranID);
                        var autoRunStateID_ = parseInt(resultJson.autoRunStateID);
                        var devRerouteServerApi_ = resultJson.devRerouteServerApi===null?"":resultJson.devRerouteServerApi;

                        if ( autoRunTranID_ > 0 ) {


                            var targetURL = 'actiontran?t='+autoRunTranID_+'&i=0&ati=0&drsi='+devRerouteServerApi_+'&trf=';
                            location.href = targetURL; 

                        }
                        else {

                            var goHomePage = resultJson.goHomePage;

                            if ( goHomePage ) {
                                var cookie_homePageURL = cookiePrefix + "homePageURL";
                                console.log( "L0: " + cookie_homePageURL );
                                var homePageURL = $.cookie( cookie_homePageURL );
                                console.log( "L1: " + homePageURL );
                                if ( homePageURL === undefined ) { homePageURL = "?rc=" + createUUID(); }
                                
                                console.log( "L2: " + homePageURL );
                                
                                homePageURL = homePageURL + "?clearCache=page";
                                
                                location.href = homePageURL;
                            }
                            else {
                                if ( formActionTypeID === 5 ) {
                                    setTimeout( function(){
                                        location.reload();
                                    }, 1000);
                                }
                            }
                        }
                    }
                    else {
                        Utils.showMessage( resultJson.returnCode.message, "e" );
                        messageAreaFailure.find(".messageArea_failure_2").html( resultJson.returnCode.message );
                        messageAreaFailure.show();
                    }
                    


                    ///console.log( resultJson );

                    senderObj.find(".progressIcon").remove();
                    $(function(){
                        $(".processBackground").css({ "display": "none" });
                    });
                }
                catch(Exception){
                    console.log( Exception.message );
                    Utils.showMessage( Exception.message, "e" );
                    messageAreaFailure.find(".messageArea_failure_2").html( Exception.message );
                    messageAreaFailure.show();
                }

                senderObj.find(".progressIcon").remove();
                $(function(){
                    $(".processBackground").css({ "display": "none" });
                });
                
                __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
                __form.attr("onSubmitOriginal", "" );
            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            
            Utils.showMessage( error, "e" );
            messageAreaFailure.find(".messageArea_failure_2").html( error );
            messageAreaFailure.show();
            
            //showMessageBottom( error, "e" );
                senderObj.find(".progressIcon").remove();
                __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
                __form.attr("onSubmitOriginal", "" );
            }
        });

        //setTimeout( function(){ __form.attr("onSubmit", __form.attr("onSubmitOriginal") ); senderObj.find(".progressIcon").remove(); }, 2000 );
        

    }
    else if ( parseInt(eventActionTypeID) === 19 || parseInt(eventActionTypeID) === 20 || parseInt(eventActionTypeID) === 21 ) {
    
        //console.log("TOA: " + eventActionTypeID + " > " + formActionTypeID);
        
        $.ajax({
            url: "<?php echo $directoryPath; ?>/get.json.php",
            type: "POST",
            crossDomain: true,
            data: {
                "get" : "tranTabInputs_toa",
                "tranID" : tranID,
                "tabID" : tabID,
                "ID" : selectedID,
                "inputTypeID" : inputTypeID,
                "tiID" : tiID,
                "actionTiID" : actionTiIDA,
                "referTranID" : referTranID,
                "referTabID" : referTabID,
                "referFwID" : referFwID,
                "devRerouteServerApi" : devRerouteServerApi,
                "dev1" : "<?php echo $dev1; ?>",
                "dev2" : "<?php echo $dev2; ?>",
                "tranFields" : tranFields,
                "tabOutputActions" : tabOutputActions,
                "activeDataJson" : "" //"<?php echo $activeDataJson; ?>"

            },
            dataType: "json",
            success: function (result) {

                
                
                if ( parseInt(eventActionTypeID) === 20 || parseInt(eventActionTypeID) === 21 ) {
                    senderObj.attr("toaStatus", "idle");
                }
                senderObj.css({ "opacity" : "1" });

            
                try {
                    var resultJson = JSON.parse( JSON.stringify(result) );

                    if ( resultJson.returnCode.messageID === 0 ) {

                        var responseData = result.responseData;

                        $( responseData ).each( function( idx, item ){

                            

                            if ( formActionTypeID === 2 ) {

                                /*
                                 
                                var actionTiID_ = item.actionTiID;
                                var html_ = item.html;
                                var width_ = item.width;

                                $("[toaTiID='"+actionTiID_+"']").html("");
                                $("[toaTiID='"+actionTiID_+"']").css({ opacity: 1 });
                                $("[toaTiID='"+actionTiID_+"']").closest("td").html( html_ );
             *
                                 */
                            }
                            else if ( formActionTypeID === 5 || formActionTypeID === 6 ) {
                            }
                            else if ( formActionTypeID === 7 ) {
                                removeSelectedProject( sender )
                            }
                            else if ( formActionTypeID === 13 ) {
                                var html_ = item.html;
                                senderObj.css({ display: "none" });
                                senderObj.html( html_ );
                                senderObj.fadeIn("fast");
                            }
                            
                           //console.log( senderObj );
                           //console.log( result );

                        });

                    }
                    else {
                        Utils.showMessage( resultJson.returnCode.message, "e" );
                        console.log( "A: " + resultJson.returnCode.message );
                    }

                    senderObj.find(".progressIcon").remove();
                    $(function(){
                        $(".processBackground").css({ "display": "none" });
                    });
                }
                catch(Exception){
                    console.log( Exception.message );
                }

                senderObj.find(".progressIcon").remove();
                $(function(){
                    $(".processBackground").css({ "display": "none" });
                });
                
                __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            //showMessageBottom( error, "e" );
                senderObj.find(".progressIcon").remove();
                $(function(){
                    $(".processBackground").css({ "display": "none" });
                });
                __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
                __form.attr("onSubmitOriginal", "" );
            }
        });

    }
    }
    else {
    
        senderObj.find(".progressIcon").remove();
        $(function(){
            $(".processBackground").css({ "display": "none" });
        });
        __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
        __form.attr("onSubmitOriginal", "" );
    }
    
    return false;
}

function searchButtonOnClick( sender ) {
    
    $(document).ready( function(){
        
        var senderObj = $(sender);
        var senderObjParent = senderObj.parent().parent();
        var senderObjText = senderObjParent.find("[type=\"text\"]");
        var searchText = senderObjText.val();
        if ( searchText.length > 0 ) {
            
            var actionTranID = senderObj.attr("actionTranID");
            var devRerouteServerApi = senderObj.attr("devRerouteServerApi");
            var nameParameter = senderObj.attr("nameParameter");
            var tranFields = senderObj.attr("tranFields");
            var ID = "0";
            var tiID = "0";
            
            var targetURLGen = nameParameter+"-t"+actionTranID+"-i"+ID+"-ati"+tiID+"?drsi="+devRerouteServerApi+"&trf="+tranFields+"&searchText="+searchText;
           
            location.href = targetURLGen;
            
        }
    });
    
}

function createUUID() {
    var s = [];
    var hexDigits = "0123456789abcdef";
    for (var i = 0; i < 36; i++) {
        s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1);
    }
    s[14] = "4";  // bits 12-15 of the time_hi_and_version field to 0010
    s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);  // bits 6-7 of the clock_seq_hi_and_reserved to 01
    s[8] = s[13] = s[18] = s[23] = "-";

    var uuid = s.join("");
    return uuid;
}

function inputTypeID_19_click( sender ) {
    var senderObject = $(sender);
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.parent().find(".options_div");

    if ( optionsDiv.is(":hidden") ) {
        inputTypeID_19_show( sender );
    }
    else {
        inputTypeID_19_close( sender );
    }
}

function inputTypeID_19_show( sender ) {
        
    var senderObject = $(sender);
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.parent().find(".options_div");
    var optionsDivContent = senderObjectMain.find(".content");
    
    var firstLoad = senderObject.attr("firstLoad");
    var disableScroll = senderObject.attr("disableScroll");
    var uTabID = senderObject.attr("uTabID");
    var search_text_div = senderObjectMain.find("[name=\"search_text_div\"]");
    var searchText = search_text_div.val();
    var tranID = senderObject.attr("tranID");
    var tabID = senderObject.attr("tabID");
    var tiID = senderObject.attr("tiID");
    var referFwID = senderObject.attr("referFwID");
    var claimID = senderObject.attr("claimID");
    var editID = "0";//senderObject.attr("editID");
    var firstID = senderObject.attr("firstID");
    var lastID = senderObject.attr("lastID");
    var lastGroupID = senderObject.attr("lastGroupID");
    var tranIDForce = senderObject.attr("tranIDForce");
    var range = senderObject.attr("range");
    var devRerouteServerApi = senderObject.attr("devRerouteServerApi");
    var devRerouteServerApi_change = senderObject.attr("devRerouteServerApi_change");

    firstLoad = "0";
    firstID = "0";
    lastID = "0";
    lastGroupID = "0";
    optionsDivContent.html("");
    disableScroll = "0";
    
    setTimeout(function() { search_text_div.focus(); }, 100);
    
    senderObjectMain.find(".loadSpinner").css({ "display" : "block" });

    $(optionsDivContent).on('scroll', function() {
        
        var scrollTop_ = Math.ceil( $(this).scrollTop() );
        var innerHeight_ = Math.ceil( $(this).innerHeight() );
        var scrollHeight_ = $(this)[0].scrollHeight;
        
        var disableScrollOnTime = senderObject.attr("disableScroll");
        
        if( scrollTop_ + innerHeight_ >= scrollHeight_ && parseInt(disableScrollOnTime) === 0 ) {
            console.log( "19::NEW::Scroll::End" );

            inputTypeID_19_loadNext( senderObject );
            
            disableScroll = senderObject.attr("disableScroll");
        }
    });
       
    var search_text_div = senderObjectMain.find("[name=\"search_text_div\"]");
    search_text_div.keydown(function (e){
        if(e.keyCode === 13){

            var search_search_div = senderObjectMain.find("[name=\"search_search_div\"]");

            inputTypeID_19_search( search_search_div );

            e.preventDefault();

            $('form').submit(function() { return false; });

            console.log( "19::NEW::SearchEnter" );

        return false;
        }
    });
    
    $("body").mouseup(function(e){
        // If the target of the click isn't the container
        if(!senderObjectMain.is(e.target) && senderObjectMain.has(e.target).length === 0){            
            optionsDiv.stop( true, true ).fadeOut("fast");
            $("body").off("mouseup");
        }
    });
   
    if ( firstLoad === "0" ) {
        optionsDivContent.html( '<i class="fas fa-spinner fa-pulse fa-2x"></i>' );
    }
    
    optionsDiv.stop( true, true ).fadeIn("fast");
    //$(".itid_19_modal_back_new").fadeIn("fast");

    if ( disableScroll === "0" ) {
    $.ajax({
        url: "<?php echo $directoryPath; ?>/get.json.php",
        type: "POST",
        crossDomain: true,
        data: {
                "get": "claimData",
                "searchText" : searchText,
                "tranID" : tranID,
                "claimID" : claimID,
                "editID" : editID,
                "firstID" : firstID,
                "lastID" : lastID,
                "tranIDForce" : tranIDForce,
                "lastGroupID" : lastGroupID,
                "range" : range,
                "tabID" : tabID,
                "tiID" : tiID,
                "devRerouteServerApi" : devRerouteServerApi,
                "devRerouteServerApi_change" : devRerouteServerApi_change,
                "parameterTemplate" : "",
                "parameterTemplateDelete" : "",
                "dev1" : "<?php echo $aigap->g("dev1"); ?>"

        },
        dataType: "json",
        success: function (result) {

            if ( firstLoad === "0" ) {
                optionsDivContent.html("");
                senderObject.attr("firstLoad", "1");
            }

            inputTypeID_19_process( senderObject, result, uTabID, tabID, tiID, referFwID );

        },
        error: function (xhr, status, error) {

            //senderObject.attr("disabled", false);


                console.log(  status + " : " + error );
                Utils.showMessage( error, "e" );
        }

    });
    }
    
    console.log( "19::NEW::Show" );
}

function inputTypeID_19_search( sender ) {
    
    var senderObject = $(sender);
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.parent().find(".options_div");
    var optionsDivContent = senderObjectMain.find(".content");
    
    var senderObjectInput = senderObjectMain.find(".sw_select_19");
        
    var firstLoad = senderObjectInput.attr("firstLoad");
    var disableScroll = senderObjectInput.attr("disableScroll");
    var uTabID = senderObjectInput.attr("uTabID");
    var searchText = senderObjectMain.find("[name=\"search_text_div\"]").val();
    var tranID = senderObjectInput.attr("tranID");
    var tabID = senderObjectInput.attr("tabID");
    var tiID = senderObjectInput.attr("tiID");
    var referFwID = senderObjectInput.attr("referFwID");
    var claimID = senderObjectInput.attr("claimID");
    var editID = "0";//senderObject.attr("editID");
    var firstID = senderObjectInput.attr("firstID");
    var lastID = senderObjectInput.attr("lastID");
    var lastGroupID = senderObject.attr("lastGroupID");
    var tranIDForce = senderObjectInput.attr("tranIDForce");
    var range = senderObjectInput.attr("range");
    var devRerouteServerApi = senderObjectInput.attr("devRerouteServerApi");
    var devRerouteServerApi_change = senderObjectInput.attr("devRerouteServerApi_change");

    senderObjectInput.attr("firstID","0");
    senderObjectInput.attr("lastID","0");
    senderObjectInput.attr("lastGroupID","0");
    senderObjectInput.attr("firstLoad","1");
    optionsDivContent.html( '<i class="fas fa-spinner fa-pulse fa-2x"></i>' );
    
    firstID = "0";
    lastID = "0";
    lastGroupID = "0";
    firstLoad = "1";
    
    senderObjectMain.find(".loadSpinner").css({ "display" : "block" });
    
    $.ajax({
        url: "<?php echo $directoryPath; ?>/get.json.php",
        type: "POST",
        crossDomain: true,
        data: {
                "get": "claimData",
                "searchText" : searchText,
                "tranID" : tranID,
                "claimID" : claimID,
                "editID" : editID,
                "firstID" : firstID,
                "lastID" : lastID,
                "tranIDForce" : tranIDForce,
                "lastGroupID" : lastGroupID,
                "range" : range,
                "tabID" : tabID,
                "tiID" : tiID,
                "devRerouteServerApi" : devRerouteServerApi,
                "devRerouteServerApi_change" : devRerouteServerApi_change,
                "parameterTemplate" : "",
                "parameterTemplateDelete" : ""

        },
        dataType: "json",
        success: function (result) {

            optionsDivContent.html("");

            inputTypeID_19_process( senderObjectInput, result, uTabID, tabID, tiID, referFwID );


        },
        error: function (xhr, status, error) {


                console.log(  status + " : " + error );
                Utils.showMessage( error, "e" );
        }

    });
    
    console.log( "19::NEW::Search" );
}

function inputTypeID_19_clear( sender ) {
 
    var senderObject = $(sender);
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.parent().find(".options_div");
    var optionsDivContent = senderObjectMain.find(".content");
        
    var senderObjectInput = senderObjectMain.find(".sw_select_19");
        
    var firstLoad = senderObjectInput.attr("firstLoad");
    var disableScroll = senderObjectInput.attr("disableScroll");
    var uTabID = senderObjectInput.attr("uTabID");
    var searchText = senderObjectMain.find("[name=\"search_text_div\"]").val();
    var tranID = senderObjectInput.attr("tranID");
    var tabID = senderObjectInput.attr("tabID");
    var tiID = senderObjectInput.attr("tiID");
    var referFwID = senderObjectInput.attr("referFwID");
    var claimID = senderObjectInput.attr("claimID");
    var editID = "0";//senderObject.attr("editID");
    var firstID = senderObjectInput.attr("firstID");
    var lastID = senderObjectInput.attr("lastID");
    var lastGroupID = senderObject.attr("lastGroupID");
    var tranIDForce = senderObjectInput.attr("tranIDForce");
    var range = senderObjectInput.attr("range");
    var devRerouteServerApi = senderObjectInput.attr("devRerouteServerApi");
    var devRerouteServerApi_change = senderObjectInput.attr("devRerouteServerApi_change");

    senderObjectMain.find("[name=\"search_text_div\"]").val("");
    senderObjectInput.attr("firstID","0");
    senderObjectInput.attr("lastID","0");
    senderObjectInput.attr("lastGroupID","0");
    senderObjectInput.attr("firstLoad","1");
    
    searchText = "";
    firstID = "0";
    lastID = "0";
    lastGroupID = "0";
    firstLoad = "1";
    optionsDivContent.html( '<i class="fas fa-spinner fa-pulse fa-2x"></i>' );
    
    senderObjectMain.find(".loadSpinner").css({ "display" : "block" });
    
    $.ajax({
        url: "<?php echo $directoryPath; ?>/get.json.php",
        type: "POST",
        crossDomain: true,
        data: {
                "get": "claimData",
                "searchText" : searchText,
                "tranID" : tranID,
                "claimID" : claimID,
                "editID" : editID,
                "firstID" : firstID,
                "lastID" : lastID,
                "tranIDForce" : tranIDForce,
                "lastGroupID" : lastGroupID,
                "range" : range,
                "tabID" : tabID,
                "tiID" : tiID,
                "devRerouteServerApi" : devRerouteServerApi,
                "devRerouteServerApi_change" : devRerouteServerApi_change,
                "parameterTemplate" : "",
                "parameterTemplateDelete" : ""

        },
        dataType: "json",
        success: function (result) {

            optionsDivContent.html("");

            inputTypeID_19_process( senderObjectInput, result, uTabID, tabID, tiID, referFwID );

        },
        error: function (xhr, status, error) {

                console.log(  status + " : " + error );
                Utils.showMessage( error, "e" );
        }

    });
    
    console.log( "19::NEW::Clear" );
}

function inputTypeID_19_loadNext( senderObject ) {
    
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.parent().find(".options_div");
    var optionsDivContent = senderObjectMain.find(".content");
    
    var firstLoad = senderObject.attr("firstLoad");
    var disableScroll = senderObject.attr("disableScroll");
    var uTabID = senderObject.attr("uTabID");
    var searchText = senderObjectMain.find("[name=\"search_text_div\"]").val();
    var tranID = senderObject.attr("tranID");
    var tabID = senderObject.attr("tabID");
    var tiID = senderObject.attr("tiID");
    var referFwID = senderObject.attr("referFwID");
    var claimID = senderObject.attr("claimID");
    var editID = "0";//senderObject.attr("editID");
    var firstID = senderObject.attr("firstID");
    var lastID = senderObject.attr("lastID");
    var lastGroupID = senderObject.attr("lastGroupID");
    var tranIDForce = senderObject.attr("tranIDForce");
    var range = senderObject.attr("range");
    var devRerouteServerApi = senderObject.attr("devRerouteServerApi");
    var devRerouteServerApi_change = senderObject.attr("devRerouteServerApi_change");

    senderObjectMain.find(".loadSpinner").css({ "display" : "block" });
    
    $.ajax({
        url: "<?php echo $directoryPath; ?>/get.json.php",
        type: "POST",
        crossDomain: true,
        data: {
                "get": "claimData",
                "searchText" : searchText,
                "tranID" : tranID,
                "claimID" : claimID,
                "editID" : editID,
                "firstID" : firstID,
                "lastID" : lastID,
                "tranIDForce" : tranIDForce,
                "lastGroupID" : lastGroupID,
                "range" : range,
                "tabID" : tabID,
                "tiID" : tiID,
                "devRerouteServerApi" : devRerouteServerApi,
                "devRerouteServerApi_change" : devRerouteServerApi_change,
                "parameterTemplate" : "",
                "parameterTemplateDelete" : ""

        },
        dataType: "json",
        success: function (result) {

            optionsDiv.fadeIn("fast");

            inputTypeID_19_process( senderObject, result, uTabID, tabID, tiID, referFwID );


            console.log( result );

        },
        error: function (xhr, status, error) {


                console.log(  status + " : " + error );
                Utils.showMessage( error, "e" );
        }

    });
    
    console.log( "19::NEW::LoadNext" );
}

function inputTypeID_19_process( senderObject, result, uTabID, tabID, tiID, referFwID ) {
    
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.parent().find(".options_div");
    var optionsDivContent = senderObjectMain.parent().find(".content");
    
    var senderObjectInput = senderObjectMain.find(".sw_select_19");
    var range = senderObjectInput.attr("range");
    var firstID = senderObjectInput.attr("firstID");
    var lastID = senderObjectInput.attr("lastID");
    var lastGroupID = senderObjectInput.attr("lastGroupID");
    
    var resultJsonMain = JSON.parse( JSON.stringify(result) );
    var resultJson = resultJsonMain.responseData;
    
    var devRerouteServerApi_change_find = [ 
                                    "aigap_framework_action_type_change_aimlFwID",
                                    "aigap_framework_action_type_change_fwID",
                                    "aigap_framework_action_type_change_fwActionTypeID",
                                    "aigap_framework_action_type_change_firewallURL",
                                    "aigap_framework_action_type_change_firewallPublicKey",
                                    "aigap_framework_action_type_change_encTypeID",
                                    "aigap_framework_action_type_change_algorithmTypeID",
                                    "aigap_framework_action_type_change_projectID",
                                    "aigap_framework_action_type_change_oProjectID",
                                    "aigap_framework_action_type_change_developerID",
                                    "aigap_framework_action_type_change_dreamerID",
                                    "aigap_framework_action_type_change_tranID",
                                    "aigap_framework_action_type_change_companyID",
                                    "aigap_framework_action_type_change_iCompanyID"];
    
    if ( resultJson.returnCode.messageID === 0 ) {
        
        senderObjectMain.find(".loadSpinner").css({ "display" : "none" });

         var r_lastID = resultJson.lastID;
         var r_lastGroupID = resultJson.lastGroupID;

        senderObject.attr("lastID", r_lastID);
        senderObject.attr("lastGroupID", r_lastGroupID);
        
        if ( resultJson.claimData.length <= 0 || resultJson.claimData.length < parseInt(range) ) {
            senderObjectInput.attr("disableScroll", "1");
        }
        else {
            senderObjectInput.attr("disableScroll", "0");
        }

        if ( resultJson.claimData.length  === 0 && parseInt(lastID) === 0 ) {
            optionsDivContent.html("<div>No Result</div>");
        }

        if ( resultJson.claimGroupData !== null && resultJson.claimGroupData.length > 0 ) {

            var lastGroupID = "0";

            $.each( resultJson.claimGroupData, function(i_0, item_0) {

                var ID_ = item_0.ID;
                var name_ = item_0.name;

                var tableRow_item = "<tr data-toggle=\"collapse\" data-target=\".group_"+ID_+"\">" +
                "<td colspan=\"2\">" +
                "<div style=\"padding:5px; font-weight:bold;\">&nbsp;<span class=\"icon_plus icon_plus_group_"+ID_+"\">+</span>&nbsp;&nbsp;"+name_+"</div>" +
                "</td>" +
                "</tr>";

                var showClassText = "";
                if ( i_0 === 0 ) { showClassText = "show"; }

                var appendDivGroup = '<div value="'+ID_+'" class="group textOverDot " name="'+name_+'"  data-toggle="collapse" data-target=".group_'+ID_+'"><span class="icon_plus icon_plus_group_'+ID_+'">+</span>&nbsp;'+name_+'</div>';
                optionsDivContent.append( appendDivGroup );

            
                $.each( resultJson.claimData, function(i_1, item_1) {

                    var ID__ = item_1.ID;
                    var name__ = item_1.name;
                    var values__ = item_1.values;
                    var groupID__ = item_1.groupID;

                    if ( groupID__ === ID_ ) {

                        
                        var tranFieldsArray = [];
                        var tranFieldsString = "";
                        var values_html__ = "";
                        $.each( values__, function(i_0, item_0) {

                            var val_ = item_0.val;
                            var moveVal_ = item_0.moveVal;
                            var field_ = item_0.field;

                            if ( moveVal_ === true ) {
                                var tranFieldRow = { "field" : ""+field_+"", "value" : ""+val_+"", "tableID" : "0" };
                                tranFieldsArray.push( tranFieldRow );
                            }
                            else {
                                values_html__ += "<div>"+val_+"</div>";
                            }
                        });
                        
                        
                        if ( tranFieldsArray.length > 0 ) { tranFieldsString = encodeURIComponent( JSON.stringify( tranFieldsArray ) ); }

                        var selectedClass__ = "";
                        var selectedID__ = $("[uTabID='"+uTabID+"'][name='sw_\\["+tabID+"\\]\\["+tiID+"\\]']").val();
                        if ( selectedID__ !== undefined ) {
                            if ( ID__.toString() ===  selectedID__.toString() ) {
                                selectedClass__ = "selectedItem";
                            }
                        }

                        var appendDiv = '<div value="'+ID__+'" class="'+selectedClass__+' groupItem textOverDot collapse '+showClassText+' group_'+groupID__+' groupID="'+groupID__+'" name="'+name__+'" onClick="javascript:inputTypeID_19_select(this, \''+ID__+'\', \''+name__+'\', \''+uTabID+'\', \''+tabID+'\', \''+tiID+'\', \''+referFwID+'\', \''+tranFieldsString+'\' );">';

                        appendDiv += name__;
                        if ( values_html__ !== "" ) {
                            appendDiv += '<div class="textOverDot">'+values_html__+'</div>';    
                        }
                        appendDiv += '</div>';

                        optionsDivContent.append( appendDiv );
                    }

                });


                 lastGroupID = ID_;

            });

            senderObject.attr("lastGroupID", lastGroupID);
                
        }
        else {
            
            $.each( resultJson.claimData, function(i, item) {

                var ID_ = item.ID;
                var name_ = item.name;
                var values_ = item.values;
                var valuesClean_ = [];
                var imageURL_ = item.imageURL;

                var tranFieldsArray = [];
                var tranFieldsString = "";
                var values_html = "";
                $.each( values_, function(i_0, item_0) {

                    var val_ = item_0.val;
                    var moveVal_ = item_0.moveVal;
                    var field_ = item_0.field;

                    if ( moveVal_ === true ) {
                        var tranFieldRow = { "field" : ""+field_+"", "value" : ""+val_+"", "tableID" : "0" };
                        tranFieldsArray.push( tranFieldRow );
                    }
                    else {
                        if ( $.inArray(field_, devRerouteServerApi_change_find) <= 0 ) {
                            values_html += "<div>"+val_+"</div>";
                        }
                    }
                    
                    valuesClean_.push( { "field" : field_, "val" : val_ } );
                });
                
                valuesClean_.push( { "field" : "aigap_framework_action_type_change_name", "val" : name_ } );
                
                if ( tranFieldsArray.length > 0 ) { tranFieldsString = encodeURIComponent( JSON.stringify( tranFieldsArray ) ); }
                
                var selectedClass = "";
                var selectedID = $("[uTabID='"+uTabID+"'][name='sw_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val();
                if ( selectedID !== undefined ) {
                    if ( ID_.toString() ===  selectedID.toString() ) {
                        selectedClass = "selectedItem";
                    }
                }

                var appendDiv = '<div value="'+ID_+'" class="'+selectedClass+' textOverDot" name="'+name_+'" values="'+encodeURIComponent( JSON.stringify( valuesClean_ ) )+'" onClick="javascript:inputTypeID_19_select(this, \''+ID_+'\', \''+name_+'\', \''+uTabID+'\', \''+tabID+'\', \''+tiID+'\', \''+referFwID+'\', \''+tranFieldsString+'\' );">';
                appendDiv += '<ul class="imageTextArea">';
                if ( imageURL_ !== undefined ) {
                    if ( imageURL_ !== "" && imageURL_ !== null ) {
                        appendDiv += '<li class="imageArea"><img src="'+imageURL_+'" height="40" /></li>';
                    }
                }
                appendDiv += '<li class="textArea">';
                appendDiv += '<ul class="textAreaDetail">';
                appendDiv += '<li class="textOverDot">'+name_+'</li>';
                if ( values_html !== "" ) {
                appendDiv += '<li class="textOverDot">'+values_html+'</li>';    
                }
                appendDiv += '</ul>'
                appendDiv += '</li>';
                appendDiv += '</ul>'
                appendDiv += '</div>';

                optionsDivContent.append( appendDiv );

            });                                    
        }
    }
}

function inputTypeID_19_select( sender, selectedID, selectedName, uTabID, tabID, tiID, referFwID, tranFieldsArrayString ) {
    
    var senderObject = $(sender);
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.closest(".options_div");
    var optionsDivContent = senderObjectMain.parent().find(".content");
    
    var senderObjectInput = senderObjectMain.find(".sw_select_19");
    
    var values = JSON.parse( decodeURIComponent( senderObject.attr("values") ) );
    
    var selectedProjectDataString = "";
    var selectedProjectData = {};
    $.each( values, function( index, item ){
        
        var field_ = item.field;
        var fieldClean_ = field_.replace( "aigap_framework_action_type_change_", "" );
        var val_ = item.val;
        var match_ = field_.match(/aigap_framework_action_type_change_/gi);
        var matchStatus_ = ( match_ !== null && match_.length > 0 ) ? true : false;
        if ( matchStatus_ ) {
            selectedProjectData[ fieldClean_ ] = val_;
        }
    });
    
    if ( selectedProjectData !== null && Object.keys( selectedProjectData ).length > 0 ) {
        selectedProjectDataString = encodeURIComponent( JSON.stringify( selectedProjectData ) );
    }
        
    $( optionsDivContent ).find("div").each( function( index, element) {
        $(element).removeClass( "bg-primary" ).removeClass( "text-white" );
    });
    
    senderObject.addClass( "bg-primary" ).addClass( "text-white" );
    
    
    $("[uTabID='"+uTabID+"'][name='sw_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val( selectedID );
    $("[uTabID='"+uTabID+"'][name='sw_text_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val( selectedName );
    $("[uTabID='"+uTabID+"'][name='sw_text_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").attr({ "title": selectedName });
    $("[uTabID='"+uTabID+"'][name='sw_select_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val( selectedName );
    
    optionsDiv.stop( true, true ).fadeOut("fast");
    senderObject.val( selectedName );
    
    var tranID = senderObjectInput.attr("tranID");
    var tranIDForce = senderObjectInput.attr("tranIDForce");
    var prmInput = senderObjectInput.attr("prmInput");
    var tableID = senderObjectInput.attr("tableID");
    var devRerouteServerApi = senderObject.attr("devRerouteServerApi");
    var devRerouteServerApi_change = senderObject.attr("devRerouteServerApi_change");
    
    	$.ajax({
            url: "<?php echo $directoryPath; ?>/get.json.php",
            type: "POST",
            crossDomain: true,
            data: {
                    "get": "setTranFields",
                    "prmInput" : prmInput,
                    "tableID" : tableID,
                    "ID" : selectedID,
                    "tranID" : tranID,
                    "name" : selectedName,
                    "tranIDForce" : tranIDForce,
                    "uTabID" : uTabID,
                    "tranFieldsArrayString" : tranFieldsArrayString,
                    "devRerouteServerApi" : devRerouteServerApi,
                    "devRerouteServerApi_change" : devRerouteServerApi_change,
                    "selectedProjectDataString" : selectedProjectDataString
            },
            dataType: "json",
            success: function (result) {
                
                var resultJson = JSON.parse( JSON.stringify( result ) );
                
                
                inputTypeID_19_close( sender );

                console.log("19::NEW:: Hide Tran Fields Add Complete");
                
                if ( resultJson.reloadStatus ) {
                    setInterval(function(){
                        $("body").animate({ "opacity" : "0.5" }, 1000);
                        $("body").animate({ "opacity" : "1.0" }, 1000);
                    }, 2000);
                    
                    var newLocation = document.location.href.split("_pe/")[0] + "_pe/";
                    if ( newLocation === "_pe/" || newLocation === "/_pe/" ) { newLocation = "/"; }
                    document.location = newLocation;
                }
            },
            error: function (xhr, status, error) {
                
                inputTypeID_19_close( sender );
                
                //console.log(  status + " : " + error );
                console.log("19::NEW:: Hide Tran Fields Error");
                Utils.showMessage( "İşlem yapılamadı", "e" );
            }
    });
    
   
    
    console.log( "19::NEW::Select" );
    
}

function inputTypeID_19_remove( sender ) {
    
    var cookiePrefix = "<?php echo $aigap->getCookiePrefix(); ?>";
    var senderObject = $(sender);
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.closest(".options_div");
    var optionsDivContent = senderObjectMain.parent().find(".content");
    
    var senderObjectInput = senderObjectMain.find(".sw_select_19");
    
    var uTabID = senderObjectInput.attr("uTabID");
    var tabID = senderObjectInput.attr("tabID");
    var tiID = senderObjectInput.attr("tiID");
    var referFwID = senderObjectInput.attr("referFwID");
    
    var currentValueText = $("[uTabID='"+uTabID+"'][name='sw_text_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val();
    var currentValue = $("[uTabID='"+uTabID+"'][name='sw_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val( "0" );

    if ( currentValueText !== undefined && currentValueText !== "undefined" ) {
        if ( currentValueText !== "" || currentValue > parseInt(currentValue) ) {
            var confirmMessage = confirm( currentValueText + " seçimi kaldırılsınmı?" );
            


            if ( confirmMessage ) {
                $(document).ready(function(){
                    
                    $( optionsDivContent ).find("div").each( function( index, element) {
                        $(element).removeClass( "bg-primary" ).removeClass( "text-white" );
                    });
                    
                    $("[uTabID='"+uTabID+"'][name='sw_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val( "0" );
                    $("[uTabID='"+uTabID+"'][name='sw_text_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val( "" );
                    $("[uTabID='"+uTabID+"'][name='sw_select_\\["+tabID+"\\]\\["+tiID+"-"+referFwID+"\\]']").val( "" );
                });
            }
        }
    }
    
    var cookieName = cookiePrefix+"selectedProjectData";
    if ( $.cookie( cookieName ) !== "" ) {
        $.removeCookie( cookieName );
    }
    
    console.log( "19::NEW::Remove" );
}

function inputTypeID_19_close( sender ) {
    
    var senderObject = $(sender);
    var senderObjectMain = senderObject.closest(".inputTypeID_19_main");
    var optionsDiv = senderObjectMain.parent().find(".options_div");
    var optionsDivContent = senderObjectMain.parent().find(".content");
    var search_text_div = senderObjectMain.find("[name=\"search_text_div\"]");
    
    $( optionsDivContent ).off("DOMSubtreeModified");
    $( optionsDivContent ).off('scroll');
    $( search_text_div ).off('keydown');
    $(".itid_19_modal_back_new").off("click");
    $("body").off("mouseup");
    
    optionsDiv.stop( true, true ).fadeOut("fast");
    //$(".itid_19_modal_back_new").fadeOut("fast");
    
    console.log( "19::NEW::Close" );
    
}

function removeSelectedProject( sender ) {

    $.ajax({
        url: "<?php echo $directoryPath; ?>/get.json.php",
        type: "POST",
        crossDomain: true,
        data: {
            "get" : "removeSelectedProject"
        },
        dataType: "json",
        success: function (result) {
            var resultJson = JSON.parse( JSON.stringify( result ) );
            if ( resultJson.reloadStatus ) {
                setInterval(function(){
                    $("body").animate({ "opacity" : "0.5" }, 1000);
                    $("body").animate({ "opacity" : "1.0" }, 1000);
                }, 2000);
                location.reload();
            }
        },
        error: function (xhr, status, error) {

        console.log(  status + " : " + error );
        //showMessageBottom( error, "e" );
        }
    });
}

function inputTypeID_38_scrollListener( senderID ) {
    
    
    var buttonLoadStatus = $(".buttonLoadStatus");
    var senderObject = $("#"+senderID);

        $(document).on("scroll", function() {

            var disableScrollOnTime = senderObject.attr("disableScroll");

            //console.log( "38::NEW::Scroll::Act" );

            var isElementInView = Utils.isElementInView( buttonLoadStatus, false);

            if( isElementInView && disableScrollOnTime === "0" ) {

                console.log( "38::NEW::Scroll::Cat" );


                senderObject.attr("disableScroll", "1");

                var firstID = senderObject.attr("firstID");
                var lastID = senderObject.attr("lastID");
                var lastGroupID = senderObject.attr("lastGroupID");
                var listRange = senderObject.attr("listRange");
                var columnCount = senderObject.attr("columnCount");
                var claimID = senderObject.attr("claimID");
                var tranID = senderObject.attr("tranID");
                var tabID = senderObject.attr("tabID");
                var tiID = senderObject.attr("tiID");
                var actionTranID = senderObject.attr("actionTranID");
                var devRerouteServerApi = senderObject.attr("devRerouteServerApi");
                var devRerouteServerApi_change = "";
                var listRange = senderObject.attr("listRange");
                var searchText = "";
                var editID = "0";
                var tranIDForce = "0";

                $.ajax({
                    url: "<?php echo $directoryPath; ?>/get.json.php",
                    type: "POST",
                    crossDomain: true,
                    data: {
                            "get": "claimDataHtml",
                            "searchText" : searchText,
                            "tranID" : tranID,
                            "claimID" : claimID,
                            "editID" : editID,
                            "firstID" : firstID,
                            "lastID" : lastID,
                            "tranIDForce" : tranIDForce,
                            "lastGroupID" : lastGroupID,
                            "range" : listRange,
                            "columnCount" : columnCount,
                            "tabID" : tabID,
                            "tiID" : tiID,
                            "devRerouteServerApi" : devRerouteServerApi,
                            "devRerouteServerApi_change" : devRerouteServerApi_change,
                            "parameterTemplate" : "",
                            "parameterTemplateDelete" : "",
                            "dev1" : "<?php echo $aigap->g("dev1"); ?>"

                    },
                    dataType: "json",
                    success: function (result) {

                        var resultJson = JSON.parse( JSON.stringify( result ) );

                        if ( resultJson.returnCode.messageID === 0 ) {    

                            var lastID__ = resultJson.lastID;
                            var lastGroupID__ = resultJson.lastGroupID;
                            var claimDataHtmlArray__ = resultJson.claimDataHtmlArray;

                            if ( claimDataHtmlArray__.length >= parseInt(listRange) ) {

                                senderObject.attr("disableScroll", "0");
                                senderObject.attr("lastID", lastID__);
                                senderObject.attr("lastGroupID", lastGroupID__);

                                $.each( claimDataHtmlArray__, function( index, item ) {
                                    var appendItem = $( decodeURIComponent(item) );
                                    //appendItem.css({ "display": "none" });
                                    senderObject.append( appendItem );
                                    //appendItem.fadeIn("fast");
                                });
                            }
                            else {
                                buttonLoadStatus.fadeOut("fast", function(){ $(this).remove(); });
                            }

                             //console.log( resultJson );

                        }
                        else {
                            console.log( "Error: " + resultJson.returnCode.message );
                        }

                    },
                    error: function (xhr, status, error) {
                        console.log(  status + " : " + error );
                        Utils.showMessage( error, "e" );
                    }

                });

            }
    });
}

function logout(){

$(document).ready( function() {
    
    $.ajax({
        url: "<?php echo $directoryPath; ?>/get.json.php",
        type: "POST",
        crossDomain: true,
        data: {
                "get": "logout"
        },
        dataType: "json",
        success: function (result) {

            var resultJson = JSON.parse( JSON.stringify( result ) );

            if ( resultJson.messageID === 0 ) {    

                var reloadStatus = resultJson.reloadStatus;
                if ( reloadStatus ) {
                    location.reload();
                }
                 //console.log( resultJson );

            }
            else {
                console.log( "Error: " + resultJson.message );
            }

        },
        error: function (xhr, status, error) {
            console.log(  status + " : " + error );
            Utils.showMessage( error, "e" );
        }

        });     
});

}

window.mobileDeviceStatus = function() {
  return Utils.mobileDeviceStatus();
};

</script>

<script>
    
    
$(function () {
    var $table = $('.tree-table');
    var $table_id = $table.attr("id");
    var $table_by_id = $("#" + $table_id );    
    var rows = $table_by_id.find('tr');
    var imagePlus = "/images/icon_gright.png";
    var imageMinus = "/images/icon_gdown.png";

    rows.each(function (index, row) {
    var
    $row = $(row),
    level = $row.data('level'),
    id = $row.data('id'),
    $columnName = $row.find('td[data-column="name"]'),
    children = $table.find('tr[data-parent="' + id + '"]');

    if (children.length) {
    var expander = $columnName.prepend('<img src="'+imagePlus+'" status="0" class="icon_g" />');
    var expander_2 = $columnName.find(".icon_g");
    //$columnName.append("&nbsp;<a href=\""+$columnName.attr("onClickOrg")+"\" class=\"open\" ><img src=\"/images/icon_gurl2.png\" class=\"icon_gu\"></a>");

    children.hide();

    var selectedBackgroundColor = $table.attr("selectedBackgroundColor");
    var selectedTextColor = $table.attr("selectedTextColor");
    var selectedID = $table.attr("selectedID");
    if ( selectedID === undefined ) {
        if ( selectedID === "-1" ) {
            selectedID = getUrlVars()["i"];
        }
    }
    $table.find("td").each( function( id, item ) {
        
        var dataColumnId = $(item).attr("data-column-id");
        var dataColumnGroupId = $(item).attr("data-column-group-id");
        
        if ( dataColumnId !== undefined ) {
            if ( dataColumnId === selectedID ) {
                //$(item).animate({ "background-color" : selectedBackgroundColor, "color" : selectedTextColor });
                //$(item).find("tr, td, div, a").animate({ "color" : selectedTextColor });
                
                $(item).addClass("selected");
                
                var selectedItemGroup = $table.find('tr[data-parent="' + dataColumnGroupId + '"]');
                selectedItemGroup.show();
                
                setTimeout( function(){
                    reverseShow($table, selectedItemGroup); 
                }, 200);
                
                //console.log( item );
            }
        }
    });

    expander.on('click', function (e) {
    var $target = $(e.target).find(".icon_g");
    var $targetSub = $(e.target).hasClass("icon_gu");
    if ( $target.length === 0 ) { $target = $(e.target); }

        if ( !$targetSub ) {
            
            var $imageFind = $target.closest("tr").find(".icon_g");
            
            if ($imageFind.attr("status")==="0") {
                $imageFind.attr("status","1");
                $imageFind.attr("src", imageMinus);
                $columnName.attr("groupOpenStatus", "1");
                children.show();
            } else {
                $imageFind.attr("status","0");
                $imageFind.attr("src", imagePlus);
                $columnName.attr("groupOpenStatus", "0");
                reverseHide($table, $row);                                        
            }
            
            var currentObject = $target.closest("td");
            var currentObjectLevel = currentObject.attr("data-column-level");
            var parentTableList = $target.closest("table").find("tr > td");
            
            $(parentTableList).each( function( id, item ){
                
                var itemObject = $(item);
                var itemObjectLevel = itemObject.attr("data-column-level");
                
                if ( itemObjectLevel === currentObjectLevel && !itemObject.is(currentObject) ) {

                    var itemObjectFind = itemObject.closest("tr").find(".icon_g");

                    if (itemObjectFind.attr("status") !== "0") {
                        itemObjectFind.attr("status","0");
                        itemObjectFind.attr("src", imagePlus);
                        itemObject.attr("groupOpenStatus", "0");
                        reverseHide($table, itemObject.closest("tr"));                                        
                    }
                }
                
            });
            
        }

        getOpenedGroupIDList( $table );
        });
        $columnName.attr("onClick", "");
        $columnName.find("a").attr("href", "javascript:void(0);");
    }
    else {
    $columnName.attr("onClick", $columnName.attr("onClickOrg"));
    }

        //$columnName.prepend('<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>');
        $columnName.css({ "padding-left" : ( 15 * level ) + 'px' });
    });

    // Reverse hide all elements
    reverseHide = function (table, element) {
        var
        $element = $(element),
        id = $element.data('id'),
        children = table.find('tr[data-parent="' + id + '"]');

        if (children.length) {
            children.each(function (i, e) {
                reverseHide(table, e);
            });

            $element.find(".icon_g").attr("src", imagePlus).attr("status", "0");
            $element.find(".icon_g").closest('td[data-column="name"]').attr("groupOpenStatus", "0");

            children.hide();
        }
    };
    
    // Reverse show all elements
    reverseShow = function (table, element) {
        var
        $element = $(element),
        id = $element.data('id'),
        parentId = $element.data('parent'),
        parent = table.find('tr[data-id="' + parentId + '"]');
        
        if ( parent.length && ( parentId !== "" && parentId !== undefined ) ) {
            parent.each(function (i, e) {
                reverseShow(table, e);
            });

            $element.find(".icon_g").attr("src", imageMinus).attr("status", "1");
            $element.find(".icon_g").closest('td[data-column="name"]').attr("groupOpenStatus", "1");

            parent.show();
        }
    };
    
    });

        function getOpenedGroupIDList( senderID ) {

            var senderOBJ = $(senderID);
            var rows = senderOBJ.find('tr');
            var groupIDList = [];

            rows.each(function (index, row) {

            var groupID = $(row).attr("data-id")
            var columnName = $(row).find('td[data-column="name"]');
            var groupOpenStatus = columnName.attr("groupOpenStatus");
            var groupIsHidden = $(row).is(":hidden");
            if ( groupOpenStatus === "1" && !groupIsHidden ) {

            groupIDList.push( groupID );

            $.cookie("treeMenuGroupList", groupIDList);

        }
    });
    

    //setTranTab_openedGroupData_withID( '<?php echo $uTabID; ?>', groupIDList );
    
    
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
                    
    $(document).ready( function(){
        var table = $('.tree-table');
        var imageMinus = "/images/icon_gdown.png";

        var treeMenuGroupList = $.cookie("treeMenuGroupList");

        var all_groupData = treeMenuGroupList;

        if ( all_groupData !== undefined ) {
            if ( all_groupData !== "" ) {
                var all_groupData_array = all_groupData.split(",");
                for ( var i = 0; i < all_groupData_array.length; i++ ) {
                    var groupID = all_groupData_array[i];

                    var column = table.find('tr[data-id="' + groupID + '"]');
                    var column_upd = table.find('tr[data-parent="' + groupID + '"]');
                    var columnName = $(column).find('td[data-column="name"]');
                    var columnNameImage = $(column).find('.icon_g');

                    column_upd.show();

                    //if ( columnName.attr("groupOpenStatus") === "0" ) {
                        columnName.attr("groupOpenStatus", "1");
                        columnNameImage.attr("status","1");
                        columnNameImage.attr("src", imageMinus);
                    //}
                }
            }
        }
        
    });  
                    
</script>

</head>

<body style="margin: 0; padding: 0;">

<div class="processBackground"></div>
    
<!-- FROM_CACHE -->
    
<div class="messages"></div>
    
<?php
/**
$selectedProjectData = $aigap->getCookie("selectedProjectData");
if ( $selectedProjectData != "" ) {
    $selectedProjectDataArray = json_decode( $aigap->AES256_decrypt( base64_decode( $selectedProjectData ) ), true );
?>
<style>
    .projectMessageArea {
        padding: 10px 20px;
        background-color: #e74c3c;
        color: #FFFFFF;
    }
    .projectMessageArea > .projectName {
        font-weight: bold;
    }
    .projectMessageArea > .projectRemoveButton {
        width: auto;
        background-color: #f1c40f;
        border: 1px solid #f1c40f;
        border-radius: 4px;
        min-height: 30px;
        cursor: pointer;
    }
    .projectMessageArea > .projectRemoveButton:hover {
        background-color: #f39c12;
        border: 1px solid #f39c12;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
    }
</style>
<script>
    function removeSelectedProject( sender ) {
         
        $.ajax({
            url: "<?php echo $directoryPath; ?>/get.json.php",
            type: "POST",
            crossDomain: true,
            data: {
                "get" : "removeSelectedProject"
            },
            dataType: "json",
            success: function (result) {
                var resultJson = JSON.parse( JSON.stringify( result ) );
                if ( resultJson.reloadStatus ) {
                    setInterval(function(){
                        $("body").animate({ "opacity" : "0.5" }, 1000);
                        $("body").animate({ "opacity" : "1.0" }, 1000);
                    }, 2000);
                    location.reload();
                }
            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            //showMessageBottom( error, "e" );
            }
        });
    }
</script>

<div class="projectMessageArea">
    <?php echo $getLanguageValue("t.SelectedProject") ?> : <span class="projectName"><?php echo $selectedProjectDataArray["name"]; ?></span>&nbsp;&nbsp;
    <button class="projectRemoveButton" onClick="javascript: removeSelectedProject( this );"><?php echo $getLanguageValue("b.RemoveSelection") ?></button>
</div>
<?php }
 * 
 **/ ?>
 
    
<?php
    $activeText = "";
?>



<div>
    <?php include("aigap.tranCoder.php"); ?>
</div>

    
</body>

</html>

<?php /**
<!--REMOVE-->
<script>
    
    $(document).ready(function(){
       var htmlToken = "<?php echo $qsmd5; ?>";
       var allHtml = $("html").html();
       
       var allHtmlEnc = $.base64.encode( encodeURIComponent( "<!doctype html>\n<html>\n"+allHtml+"\n</html>" ) );
       
       $.ajax({
            url: "<?php echo $directoryPath; ?>/get.json.php",
            type: "POST",
            crossDomain: true,
            data: {
                "get": "pageCache",
                "htmlToken": htmlToken,
                "htmlContent": allHtmlEnc
            },
            dataType: "json",
            success: function (result) {

                try {
                    var resultJson = JSON.parse( JSON.stringify(result) );

                    console.log( resultJson )
                }
                catch(Exception){
                    console.log( Exception.message );
                }

                senderObj.find(".progressIcon").remove();
                
                __form.attr("onSubmit", __form.attr("onSubmitOriginal") );
            },
            error: function (xhr, status, error) {

            console.log(  status + " : " + error );
            //showMessageBottom( error, "e" );
            }
        });
    });
    
</script>
<!--/REMOVE-->
 * 
 */
?>


<?php

}
 catch ( Exception $ex ) {
     echo "Hata: ".$ex->getMessage();
 }

 
 if ( $qsmd5 != "" && $cacheEnable == true ) {
    $fileFull = $cacheDir.$qsmd5.".".$langCode_.".html.cache";
    if ( !file_exists( $fileFull ) ) {
        $contents =  ob_get_contents();
        if ( $contents != "" ) {
            $aigap->fileWrite( $fileFull, $contents );
        }
    }
}

 
exit();

?>