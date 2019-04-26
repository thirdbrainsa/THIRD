<?php
#### THIRD - SERVER WHICH IS ACCEPTING THE NODES CONNECTION --- ALL IS STARTING HERE --- #####

include("../config.php");

#### DAEMON - SERVER - ACCEPTING INCOMING CONNECTION FROM OTHERS NODES

##### OPENING THE SERVER ON IP WITH PORT
##### YOU CAN OPEN MULTIPLE NODES ON THE SAME SERVER CHANGING THE PORT EACH TIME - THEN YOU MAY OPEN A LOT OF NODES

$SOCKET_URL="tcp://".$_DAEMON_IP.":".$_DAEMON_PORT;

$server = stream_socket_server($SOCKET_URL);


$loop=TRUE;

while ($loop)
{
	// Accept socket connection
	$socket=stream_socket_accept($server);

	// Get the first 1500 CAR sent by the client
	$data=stream_socket_recvfrom($socket, 1500);

	if ($data!="")
		{
			print ($data.'\n');
			if (trim($data)=="exit") {$loop=FALSE;}
		}
	// close connection after accepted the node's connection	
	fclose($socket);
}

fclose($server);
?>
