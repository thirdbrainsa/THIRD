<?php
$push=TRUE;
while ($push)
    {

	$fp = stream_socket_client("tcp://127.0.0.1:1234", $errno, $errstr, 30);
	if (!$fp) {
    			echo "$errstr ($errno)<br />\n";exit;
} else {
   
    $RAND=mt_rand(0,1000000);
    fwrite($fp, "consensus reach ask ".$RAND);

}  
  fclose($fp);
}
?>
