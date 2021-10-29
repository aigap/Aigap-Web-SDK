<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (file_exists("aigap.class.php") ) { unlink("aigap.class.php"); }
copy( "../aigap.class.php", "aigap.class.php" );

include("ZipAll.php");
include("aigap.class.php");

$aigap = new aigap();
$authorizedCode = "asdf1234!asgh#abh987sacds!acs";

$versionControlURL = "https://sdk.aigap.com/update/version.json";
$versionControlJson = json_decode(file_get_contents(  $versionControlURL ) );

$versionControl_code = $versionControlJson->version->code;
$versionControl_build = $versionControlJson->version->build;
$versionControl_required = $versionControlJson->version->required;
$versionControl_url = $versionControlJson->version->url;

$class_code = $aigap->getVersion( "../" )["version"];
$class_build = $aigap->getVersion( "../" )["build"];

$do = $aigap->g("do");

$langCode = $aigap->getCookie("langCode");
if ( $langCode == "" ) { $langCode = "en"; }

$cacheDir = "../files/cache/";

?>

<div class="main">
    
<form enctype="multipart/form-data" method="post" action="update.last.php">
    
<table width="100%">
    

<?php
if ( $versionControl_code > $class_code || ( $versionControl_code == $class_code && $versionControl_build > $class_build ) ) {
?>

<?php


if ( $do == "update" ) {

    $destinationFile = "update.zip";

    $copyFileOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false ) );

    if ( file_exists($destinationFile) ) { unlink($destinationFile); }

    $copyFile = copy( $versionControl_url, $destinationFile, stream_context_create($copyFileOptions) );

    if ( $copyFile ) {
            echo "<div>".$aigap->getLanguageValue("t.CopyComplete", $langCode)."</div>";
            $zip = new ZipArchive;
        $res = $zip->open($destinationFile);
        if ($res === TRUE) {
            $zip->extractTo('../');
            $zip->close();
            echo '<div>'.$aigap->getLanguageValue("t.UnarchiveComplete", $langCode).'</div>';
            unlink( $destinationFile );
            
            $cacheFiles = scandir( $cacheDir );
            foreach( $cacheFiles as $cacheFile ) {
                if ( $cacheFile != "." && $cacheFile != ".." ) {
                    if ( file_exists( $cacheDir.$cacheFile ) ) {
                        unlink( $cacheDir.$cacheFile );
                    }
                }
            }
            
            echo "<script> setTimeout(function(){ location.href = \"update.last.php\"; }, 1000);</script>";

        } else {
          echo '<div>'.$aigap->getLanguageValue("t.UnarchiveNotComplete", $langCode).'</div>';
        }
    }
    else {
            echo "<div>".$aigap->getLanguageValue("t.CopyNotComplete", $langCode)."</div>";
    }
    
}
?>
    
<tr>
    <td>Yüklü versiyon</td>
    <td><?php echo $class_code.".".$class_build; ?></td>
</tr>
<tr>
    <td>Yeni versiyon</td>
    <td><?php echo $versionControl_code.".".$versionControl_build; ?></td>
</tr>
<tr>
    <td>Zorunlu</td>
    <td><?php echo $versionControl_required==1? $aigap->getLanguageValue("t.Yes", $langCode) : $aigap->getLanguageValue("t.No", $langCode); ?></td>
</tr>
<tr>
    <td colspan="2" align="right">
        <input type="hidden" name="do" value="update" />
        <input type="submit" value="Güncelle" />
    </td>
</tr>
<?php
} else {
?>
<tr>
    <td><?php echo $aigap->getLanguageValue("t.SdkIsUpToDate", $langCode); ?></td>
</tr>
<?php
}
?>
</table>
    
</form>

</div>


<style>
.main { min-width: 220px; position: absolute; top: 50%; left: 50%; transform: translate( -50%, -50% ); padding: 10px; border-radius: 10px; background-color: #EDEDED; border: 1px solid #CCCCCC; }
html, body, table, table tr, table td { font-family: Arial; font-size: 1em; }
table, table tr, table td { padding: 2px; }
form { padding: 0; }
input[type=button], input[type=submit] { font-size: 1.05em; padding: 10px; border: 0; background-color: #23272b; color: #EDEDED; border-radius: 10px; width: 100%; }
</style>