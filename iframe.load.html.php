<?php

$html = $_REQUEST["html"];

echo html_entity_decode( urldecode( $html ) );

?>
