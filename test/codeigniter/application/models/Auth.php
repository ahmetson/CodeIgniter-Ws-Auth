<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Everything that logs in or creates a user
 *
 * @author Medet Ahmetson
 */
class Auth extends CI_Model 
{
	/**
	 * Registers a new user
	 * 
	 * @param 	string 		$email 		- User ID
	 * @param 	string 		$password 	- Password
	 *
	 * @return  int (user ID)
	 * @return  string (email)
	 */
	public function register ( $args ) 
	{
		$email = trim ( $args [ 0 ] );
		$password = trim ( $args [ 1 ] );


    	$result = $this->ws_auth->register ( $email, $password, $email );

    	if ( $result === FALSE )
    	{
    		// echo "\n\tUser registration failed. Error message:\n";
			$errors = $this->ws_auth->errors();

			// var_dump ( $errors );

			// echo "\n\n";

			return json_encode ( array ( 'error' => TRUE, 'message' => $errors ) );
    	}

		$data = array ( 'user_id' => $result, 'email' => $email );
		return json_encode ( $data );
	}


	/**
	 * Authorizes in the system by given email/password
	 * 
	 * @param 	string 		$email 		- User ID
	 * @param 	string 		$password 	- Password
	 *
	 * @return  int (user ID)
	 */
	public function login ( $args ) 
	{
		ob_start();
		$email = trim ( $args [ 0 ] );
		$password = trim ( $args [ 1 ] );
		$is_remember = TRUE;

    	$result = $this->ws_auth->login ( $email, $password, $is_remember );

    	if ( $result === FALSE )
    	{
    		// echo "\n\tUser registration failed. Error message:\n";
			$errors = $this->ws_auth->errors();

			// var_dump ( $errors );

			// echo "\n\n";
			// echo ob_get_contents();
    		ob_end_flush();

			return json_encode ( array ( 'error' => TRUE, 'message' => $errors ) );
    	}
    	else
    	{
    		$user = $this->ws_auth->user()->row();
    		// var_dump ( $user );

    		// var_dump ( $this->ws_auth->logged_in() );
    	}

    	ob_end_flush();

		// echo ob_get_contents();

		$data = array ( 'email' => $email );
		return json_encode ( $data );
	}


	/**
	 * Checks whether player is athorized or not.
	 * If authorized, then extends the logging in session.
	 * 
	 * @return  boolean
	 */
	public function is_logged_in ( $args ) 
	{
    	$result = $this->ws_auth->logged_in ( );

		$data = array ( 'is_logged_in' => $result );

		return json_encode ( $data );
	}


	/**
	 * Clears the session
	 * 
	 */
	public function logout ( $args ) 
	{
    	$result = $this->ws_auth->logout ( );

    	$data = array ( );
		return json_encode ( $data );
	}
	
}
