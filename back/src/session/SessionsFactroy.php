<?php

namespace src\factory;

include('../models/User.php');

use src\Models\User;


interface iSessionBehavior {
    public function startSession($user); //set the membre to true
    public function testCookies(); // test if the cookie is set des isset sur les cookies
    public function testSession(); // si la variable $_SESSION is set and equals to true
    public function unsetSession(); // pour se deconecter (singout) unset le session variable
    public function setCookie(User $membre); // après l'inscription creation de la session sessionStart et aussi remplir les cookies
}

class SessionFactory implements iSessionBehavior
{
    public $app;
    public function __construct($app){$this->app=$app;}

    public function startSession($user){
        if($this->testSession()){return true;}
        session_start();
        $this->app['session']->set('auth',true);
        $this->app['session']->set('user',$user);
        return $this->app['session']->get('auth');
    }
    public function testCookies(){
        if($this->app['session']->get('auth') && isset($_COOKIE['membre']['mdp'])){
            return true;
        }else return false;
    } // test if the cookie is set des isset sur les cookies, leave it for the checking factory
    public function testSession(){
        if($this->app['session']->get('auth') && $this->app['session']->get('auth') == true){
            return true;
        }else return false;
    } // si la variable $_SESSION is set and equals to true leave it for the sessioncheking factory
    public function unsetSession(){
      $this->app['session']->set('auth',null);
      $this->app['session']->set('user',null);
      session_destroy();
    } // pour se deconecter (singout) unset le session variable
    public function setCookie(User $membre){
        if($this->testCookies()){return true;}
        setcookie("membre[login]",$membre->email, time() + 3600*24*365);
        setcookie("membre[mdp]", md5($membre->password), time() + 3600*24*365);
    } // après l'inscription creation de la session sessionStart et aussi remplir les cookies don't need to unset them after a year they will unset them selfes

    public function getUserConnected(){
      if($this->testSession() && $this->testCookies()){
        return $this->app['session']->get('user');
      }else return null;
    }
}
