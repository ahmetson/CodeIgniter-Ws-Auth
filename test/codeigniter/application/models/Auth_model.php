<?php

/**
 * Authorization validations and access to database
 *
 * @author Ahmetson
 */
class Auth_model extends CI_Model 
{
    /**
     *  Checks whether user with the given identity was registered or not
     *
     *  @param  string          $email  - Identity of the user
     *
     *  @return boolean
     */
    public function is_email_exist ( $email ) 
    {
        return $this->ion_auth->email_check ( $email );
    }
     

    /**
     *  @todo fill the function body
     *  
     *  Checks whether given string is a valid email
     *
     *  @param string           $email  - String that has to be checked
     *
     *  @return boolean
     */
    public function is_valid_email ( $email ) 
    {
        return ( ! ( empty ( $email ) ) );
    }


    /**
     *  @todo fill the function body
     *  
     *  Checks whether given string is a valid password
     *
     *  @param string           $password  - String that has to be checked
     *
     *  @return boolean
     */
    public function is_valid_password ( $password ) 
    {
        return ( ! ( empty ( $password ) ) );
    }

}
