<?php

include("../version.php");

//
// Parse and show the overall footer.
//
$smarty->assign("wrm_version", $version);		

$smarty->display("footer.tpl.html");
?>