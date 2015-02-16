<?php
/**
 * Created by PhpStorm.
 * User: taohaisong
 * Date: 2015/2/15
 * Time: 14:29
 */

/**
 * 观察者模式
 */

/**
 * Class Login
 * 原始代码
 */
//class Login {
//    const LOGIN_USER_UNKNOWN = 1;
//    const LOGIN_WRONG_PASS = 2;
//    const LOGIN_ACCESS = 3;
//    private $status = array();
//
//    function handleLogin($user, $pass, $ip) {
//        switch (rand(1, 3)) {
//        case 1:
//            $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
//            $ret = true;
//            break;
//        case 2:
//            $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
//            $ret = false;
//            break;
//        case 3:
//            $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
//            $ret = false;
//            break;
//        }
//        Logger::logIP($user,$ip,$this->getStatus());
//        return $ret;
//    }
//
//    private function setStatus($status, $user, $ip) {
//        $this->status = array($status, $user, $ip);
//    }
//
//    function getStatus(){
//        return $this->status;
//    }
//}

interface Observable {
    function attach ( Observer $observer );

    function detach ( Observer $observer );

    function notify ();
}

class Login implements Observable {
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    private $observers;
    private $status = array();

    function __constuct () {
        $this->observers = array();
    }

    function handleLogin ( $user, $pass, $ip ) {
        switch ( rand( 1, 3 ) ) {
        case 1:
            $this->setStatus( self::LOGIN_ACCESS, $user, $ip );
            $ret = true;
            break;
        case 2:
            $this->setStatus( self::LOGIN_WRONG_PASS, $user, $ip );
            $ret = false;
            break;
        case 3:
            $this->setStatus( self::LOGIN_USER_UNKNOWN, $user, $ip );
            $ret = false;
            break;
        }
        Logger::logIP( $user, $ip, $this->getStatus() );
        return $ret;
    }

    function attach ( Observer $observer ) {
        $this->observers[] = $observer;
    }

    function detach ( Observer $observer ) {
        $newObservers = array();
        foreach ($this->observers as $obs) {
            if ( ( $obs !== $observer ) ) {
                $newObservers[] = $obs;
            }
        }
        $this->observers = $newObservers;
    }

    function notify () {
        foreach ($this->observers as $obs) {
            $obs->update( $this );
        }
    }
}

interface Observer {
    function update ( Observable $observable );
}

class SecurityMonitor extends LoginObserver {
    //function update ( Observable $observable ) {
    //    $status = $observable->getStatus();
    //    if ( $status[0] == Login::LOGIN_WRONG_PASS ) {
    //        print __CLASS__ . ":\tsending mail to sysadmin\n";
    //    }
    //}

    function doUpdate(Login $login){
        $status = $login->getStatus();
        if($status[0]==Login::LOGIN_WRONG_PASS){
            //email to manager
            print __CLASS__ .":\t sending mail to sysadmin \n";
        }
    }
}
class GeneralLogger extends LoginObserver{
    function doUpdate(Login $login){
        $status = $login->getStatus();
        //log the data
        print __CLASS__ . "\t add login data to log\n";
    }
}

abstract class LoginObserver implements Observer {
    private $login;

    function __construct ( Login $login ) {
        $this->login = $login;
        $login->attach( $this );
    }

    function update ( Observable $observable ) {
        if ( $observable === $this->login ) {
            $this->doUpdate( $observable );
        }
    }

    abstract function doUpdate ( Login $login );
}

$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
