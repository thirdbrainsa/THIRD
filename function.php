<?php

/*
*
* BroadCast Message to Nodes in the $_LIST
*
*/

function broadCastMessage($_MESSAGE,$_NHOST)
{

	// Take the Route.Server files and transform to 
	
	$file=fopen("../route.server","r");
	
	while (!feof($file))
		{
	
			$_socket=fgets($file,255);
			if ($_socket!=$_NHOST)
		  	  {
			$_LIST[$_socket]=1;
			     }	
		}

	fclose($file);


	// Broadcast Message to alive nodes

	foreach ($_LIST AS $KEY => $VALUE)
	
	{

		$return=sendMessage($KEY,$_MESSAGE);
		$totalreturn[$KEY]=$return;		
	}

$_FEEDBACK['log']=$totalreturn;

return $_FEEDBACK;

}


/*
*
*  Create an address in the network
*
*/


function createAddress($_DATA)
{
	$_P=explode(" ",$_DATA);

	$_PASSWORD=trim($_P[1]);
	
	$whataddrr=md5(time().microtime().$_PASSWORD);

	$file=fopen("../address/".$whataddrr,"w");
	fputs($file,$_PASSWORD);
	fclose($file);	

	$_BACK['addrr']=$whataddrr;
	$_BACK['password']=$_PASSWORD;

	return $_BACK;

}


/*
*
*  Mirror locally address received braodcasted
*
*/

function mirrorAddress($_DATA)
{

     $_P=explode(" ",$_DATA);

     $_A=$_P[1];

     $_B=$_P[2];

     $file=fopen("../address/".$_A,"w");
     fputs($file,$_B);
     fclose($file);
}


/*
*
*   Send a TCP message to a $_SOCKET
*
*/



function sendMessage($_SOCKET,$_MESSAGE)
{

$_FEEDBACK=array("");
$_FEEDBACK['error']="";
$_FEEDBACK['answer']="";

$fp = @stream_socket_client("tcp://".$_SOCKET, $errno, $errstr, 30);

if (!$fp) 
	{

    $_FEEDBACK['error']="$errstr ($errno)";

    logMessage($_SOCKET." - ".$errstr." - ".$errno);

	} 

else
 	{

    fwrite($fp, $_MESSAGE);
    
    logMessage($_SOCKET." - ".$_MESSAGE);    
   
    $_FEEDBACK['answer']=fread($fp, 255);
  
   
	}


return $_FEEDBACK;

}

/*
*
* LOG MESSAGE SENT
* 
*/

function logMessage($_LOG)
{
	
	$file=fopen("../log/general.log","a");
	fputs($file,date("j-m-y H:i:s")."-". $_LOG."\n");
	fclose($file);


}


