<?php

function createAddress($_DATA)
{
	$_P=explode(" ",$_DATA);

	$_PASSWORD=trim($_P[1]);
	
	$whataddrr=md5(time().microtime().$_PASSWORD);

	$file=fopen("../address/".$whataddrr,"w");
	fputs($file,$_PASSWORD);
	fclose($file);	


}
function sendMessage($_SOCKET,$_MESSAGE)
{

$_FEEDBACK=array("");
$_FEEDBACK['error']="";
$_FEEDBACK['string']="";

$fp = @stream_socket_client("tcp://".$_SOCKET, $errno, $errstr, 30);

if (!$fp) 
	{

    $_FEEDBACK['error']="$errstr ($errno)";

	} 

else
 	{

    fwrite($fp, $_MESSAGE);

    while (!feof($fp))	 {
     				   $_FEEDBACK['string'].=fgets($fp, 1024);
   			 }
    	fclose($fp);
	}

return $_FEEDBACK;

}

