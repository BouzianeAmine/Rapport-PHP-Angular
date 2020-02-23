<?php

namespace src\User;

include('./session/SessionsFactroy.php');
include('./models/User.php');
include('./repos/userRepo.php');
include('./models/Rapport.php');
include('./repos/rapportRepo.php');

use src\Models\User;
use src\Repositories\UserRepository;
use src\factory\SessionFactory;
use src\Models\Rapport;
use src\Repositories\RapportRepository;

interface iUserBehavior
{
  public function signUp(User $user);
  public function signIn($email,$password);
  public function signOut(User $user);
}

class Membre implements iUserBehavior
{

  public $rep;
  public $session;
  public $checking;
  public $raprep;

  public function __construct(UserRepository $rep, SessionFactory $session,RapportRepository $raprep)
  {
    $this->rep = $rep;
    $this->session = $session;
    $this->raprep=$raprep;
  }

  public function signUp(User $user)
  {
    if ($this->rep->checkUser($user->getEmail())) {
      return false;
    }
    $this->rep->addUser($user);
    $this->session->setCookie($user);
    return true;
  }

  public function signIn($email,$password)
  {

    $res=$this->rep->checkAuthUser($email,$password);

    if ($res==false) {
      return false;
    }
    if ($this->session->testSession() && $this->session->testCookies()) {
      return $res;
    }
    $this->session->startSession($this->rep->getUserByemail($email));
    $this->session->setCookie($res);
    return $res;
    // i need a checking factory example FactoryUserChecking or FactorySessionChecking
  }

  public function signOut(User $user)
  {
    $this->session->unsetSession();
    return true;
  }

  public function addRapport(Rapport $rap)
  {
    $this->raprep->addRapport($rap);
  }
}
