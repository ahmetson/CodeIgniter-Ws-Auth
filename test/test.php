<?php 

include __DIR__.'\..\vendor\autoload.php';


use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// session related
use Ratchet\Session\SessionProvider;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;
use Symfony\Component\HttpFoundation\Session\Session;


require ( __DIR__.'\Message.php' );


$_PORT 	= 8000;


/**
 *	Runs the loop system that will listen to in ports and trigger the events
 *
 *	NOTE: run_ws_server should be the last function that is called, nothing will be executed after it
 */
function run_ws_server ( $port = 8000 )
{
	// echo "\n\n\tWEB_SOCKET SERVER IS RUNNING AT PORT $port.\n";

    $pdo = new PDO ( 'mysql:host=localhost;dbname=ws-auth-tester', 'root', '' );
	$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $db_options = array(
        'db_table'          =>'sessions',
        'db_id_col'         =>'sess_id',
        'db_data_col'       =>'sess_data',
        'db_time_col'       => 'sess_time',
        'db_lifetime_col'   => 'sess_lifetime'
    );

    $ws_server = new WsServer ( new Message () );

    $session = new SessionProvider(
    	$ws_server, 
        new Handler\PdoSessionHandler ( $pdo, $db_options )
    );
	    
	$server = IoServer::factory (
		new HttpServer( $session ),
	    $port
	);

	$ws_server->enableKeepAlive ( $server->loop, 10 );

	$server->run();

}


///////////////////////////////////////////////////////////
// 	body
///////////////////////////////////////////////////////////

run_ws_server ( $_PORT );
