<?php
#### TCP COMMUNICATION FRAMEWORK WITH THE NETWORK

#### A COMMUNICATION TO THE NETWORK FOLLOW THE SAME PROTOCOLE <A LETTER or a NUMBER THEN A to Z, 0 to 9 AND AFTER THE <THE DATA>
#### A : CREATE A NEW ADDRESS - INITIAL BROADCAST , SYNTAX : A <YOUR PASSWORD MD5>, RETURN : YOUR NEW ADDRESS 
#### B : BROADCAST NEW ADDRESS TO NETWORK, B <ADDRESS TO BROADCAST> <PASSWORD MD5>, RETURN : NO RETURN
#### C : LOGIN WITH <ADDRESS> <PASSWORD>, RETURN : OK / NOT OK

#### THIRD - SERVER WHICH IS ACCEPTING THE NODES CONNECTION --- ALL IS STARTING HERE --- #####

include("../config.php");
include("../function.php");

#### DAEMON - SERVER - ACCEPTING INCOMING CONNECTION FROM OTHERS NODES

##### OPENING THE SERVER ON IP WITH PORT
##### YOU CAN OPEN MULTIPLE NODES ON THE SAME SERVER CHANGING THE PORT EACH TIME - THEN YOU MAY OPEN A LOT OF NODES

$SOCKET_URL="tcp://".$_DAEMON_IP.":".$_DAEMON_PORT;

$server = stream_socket_server($SOCKET_URL);

if (!($server))
{


}
else
{
$loop=TRUE;


while ($socket = @stream_socket_accept($server,$_nbSecondsIdle))
 
{

	$data="";

	// Accept socket connection

	// Get the first 1024 CAR sent by the client

	$data=fread($socket,1024); 


	if ($data!="")
		{
			printf ($data.'|');
			if (trim($data)=="exit") {$loop=FALSE;}
		}

	$dataF=$data[0];

	switch ($dataF) 
			{
			
			// receive first broadcast to create a new address

			case"A":

				printf(" ---> A < ---\n");

				$return=createAddress($data);
				
				$bMessage="B ".$return['addrr']." ".$return['password'];			
				
				// broadacast to nodes of the network

				$returnB=broadCastMessage($bMessage,$_DAEMON_HOST);			

			break;
			
			// receive broadcasting alert about a new address to be locally mirrored.

			case "B":

			       printf(" ---> B <---- \n");
				
			       $return=mirrorAddress($data);
				
			
			// 

			case "C":

			      printf(* ----> C <---- \n");

			      $return=loginWithAddress($data);
			   
			      if ($return=="OK")

						{

							

						}

			break;


			}
	// close connection after accepted the node's connection	

}

if (isset($socket)) {fclose($socket);}

fclose($server);
}
?>
