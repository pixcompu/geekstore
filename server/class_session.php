<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 23/04/2016
 * Time: 04:44 PM
 */
class Session{

    public function __construct(){
        session_start();
    }

    public function login($user){
        $_SESSION['user'] = json_encode($user);
    }
    
    public function logout(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public function userIsLoggued(){
        return isset($_SESSION['user']);
    }

    public function getActiveUser(){
        return (isset($_SESSION['user']) ? $_SESSION['user'] : null);
    }
}