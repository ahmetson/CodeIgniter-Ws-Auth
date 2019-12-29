<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

// session related
use Ratchet\Session\SessionProvider;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;
use Symfony\Component\HttpFoundation\Session\Session;

require ( __DIR__.'\..\..\..\Message.php' );

define ( 'PORT', 8000 );

define ( 'PROJECT_ROOT', __DIR__. DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR );
define ( 'LIB_PATH', PROJECT_ROOT.'src'.DIRECTORY_SEPARATOR.'ws-auth'.DIRECTORY_SEPARATOR );

// require ( $LIB_PATH . 'libraries' . DIRECTORY_SEPARATOR . 'Ws_auth.php' );

class Ws_tester extends CI_Controller {

	public function run_server()
	{
	
		// Loading the Ws-auth
		$this->load->add_package_path ( LIB_PATH );
		$this->load->library ( 'Ws_auth' );
		$this->load->remove_package_path ( LIB_PATH );



		// echo "\n\n\tWEB_SOCKET SERVER IS RUNNING AT PORT ".PORT.".\n";
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
		    PORT
		);

		$ws_server->enableKeepAlive ( $server->loop, 10 );

		$server->run();
	}
}
