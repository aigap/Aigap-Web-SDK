<?php


date_default_timezone_set('Europe/Istanbul');

include("config.php");
include("aigap.class.php");

$subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));

$aigap = new aigap();

if ( $subdomain === "panel" ) {
    $aigap->setCookiePrefix("sdk_");
    $referer = $_SERVER["HTTP_REFERER"];

    if ( !preg_match( "/panel.aigap.com/i", $referer) ) {}
}

$listUrl = $aigap->sqlite_listUrl();

header("Content-type: text/xml; charset=utf-8");

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
foreach( $listUrl as $url ) {
echo "<url>";
echo "<loc>".htmlspecialchars($url["url"])."</loc>";
echo "<lastmod>".date( "Y-m-d\TH:i:sP", strtotime($url["date"]))."</lastmod>"; //2019-08-21T16:12:20+03:00
echo "<changefreq>weekly</changefreq>";
echo "<priority>0.8</priority>";
echo "</url>";
}
echo "</urlset>";



?>