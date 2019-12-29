<?php

include_once __DIR__.'\..\vendor\autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

/**
 *  @author Medet Ahmetson admin@blocklords.io
 * 
 *  Message is used by RunRatchet Library.
 *
 *  Checkout the Ratchet documentation
 */
class Message implements MessageComponentInterface 
{
    protected $clients;
    protected $users;
    protected $registered_users;
    protected $CI;
    

    public function __construct() 
    {
        $this->clients = new \SplObjectStorage ();
        $this->users = array ();

        $this->CI =& get_instance ();

        $this->CI->load->model ( array ( 'auth_model', 'auth' ) );
    }

    private function _connect_db ()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=ws-auth-tester', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    private function _get_options ()
    {
        $db_options = array (
            'db_table'          => 'sessions',
            'db_id_col'         => 'sess_id',
            'db_data_col'       => 'sess_data',
            'db_time_col'       => 'sess_time',
            'db_lifetime_col'   => 'sess_lifetime',
        );

        return $db_options;
    }

    /**
     *  Client established a connection with a Server
     *
     *  @param Connection   $conn   - Connection ID and Client information
     */
    public function onOpen ( ConnectionInterface $conn ) 
    {
        // Store the new connection to send messages to later
        $this->clients->attach ( $conn );

        $this->users [ $conn->resourceId ] = $conn;
        // echo "On Connect {$conn->resourceId}\n";
    }


    /**
     *  Client sends data to the server some message
     *
     *  @param Connection   $from           - Connection ID of a Client
     *  @param string       $message_string - Message in JSON format
     */
    public function onMessage ( ConnectionInterface $from, $message_string ) 
    {
        // echo "Recieved a message $message_string\n";
        $message = json_decode ( $message_string, TRUE );

        if ( empty ( $message ) === TRUE || is_array ( $message ) === FALSE )
        {
            $from->send ( json_encode ( array ( 'message' => 'Invalid message data.', 'error' => TRUE ) ) );
        }
        else
        {
            if ( $message [ 0 ] !== 'register' && $message [ 0 ] !== 'login' &&
                $message [ 0 ] !== 'logout' && $message [ 0 ] !== 'is_logged_in' )
            {
                echo "Unsupported command was given\n";
                $from->send ( json_encode ( array ( 'message' => 'Command was not recognized.', 'error' => TRUE ) ) );
            }
            else
            {
                $command = $message [ 0 ];
                $arguments = array_slice ( $message, 1 );

                $result = $this->CI->auth->$command ( $arguments );
                // var_dump ( $result );

                // Return Back Result To Message Invoker
                $from->send ( $result );
            }
        }
    }


    /**
     *  Connection between client and server was lost
     */
    public function onClose(ConnectionInterface $conn) {
        
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        unset($this->users[$conn->resourceId]);

        if ( ! is_null ( $this->registered_users ) )
        {
            $wallet_address = array_search ( $conn->resourceId, $this->registered_users );
            if ( $wallet_address !== FALSE )
            {
                unset ( $this->registered_users [ $wallet_address ] );
            }
        }
    }


    /**
     *  Occur an error during the connection
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
