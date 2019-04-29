<?php

include("simulateconfig.php");
include("../function.php");

// A =ADD AN ADDRESS TO THE NETWORK

$password=md5("test");
$address="";

$F=sendMessage($_DAEMON_HOST,"C ".$password);

print_r($F);
?>
