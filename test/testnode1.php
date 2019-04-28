<?php

include("simulateconfig.php");
include("../function.php");

// A =ADD AN ADDRESS TO THE NETWORK

$password=md5("test");

$F=sendMessage($_DAEMON_HOST,"A ".$password);

print_r($F);
?>
