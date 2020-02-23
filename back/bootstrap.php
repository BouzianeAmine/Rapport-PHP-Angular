<?php

require 'vendor/autoload.php';
error_reporting(0);

include('./src/system/Connector.php');
include('./src/models/User.php');
include('./src/repos/userRepo.php');
include('./src/Membre.php');
include('./src/session/SessionsFactroy.php');
include('./src/repos/rapportRepo.php');
include('./src/models/Rapport.php');

use Symfony\Component\HttpFoundation\Request;
use Dotenv\Dotenv;
use src\factory\SessionFactory;
use src\Models\Rapport;
use src\System\Connector;
use src\Models\User;
use src\Repositories\RapportRepository;
use src\Repositories\UserRepository;
use src\User\Membre;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With");

$config['rewrite_short_tags'] = FALSE;

$app = new Silex\Application();



$app->register(new Silex\Provider\SessionServiceProvider());

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$con=new Connector();
$repo=new UserRepository($con);
$raprepo=new RapportRepository($con);
$sessions=new SessionFactory($app);
$membre=new Membre($repo,$sessions,$raprepo);
//$rapport=new Rapport("rapport","pdf","zfjkzkefkzegfkzhegfe");

$app->post('/connect', function(Request $req) use($membre){
  $email=json_decode($req->getContent(),true)['email'];
  $password=json_decode($req->getContent(),true)['password'];
  return json_encode($membre->signIn($email,$password));
});

$app->post('/rapport', function (Request $req) use($raprepo) {
  $currentUser=User::userFromArray(json_decode($req->getContent(),true));
  if($currentUser) {
    return json_encode($raprepo->getRapportsbyUser($currentUser));
  }else return json_encode(array("error"=>"No user is auth"));
});

$app->post('/deconnect',function(Request $req) use($membre){
    if($membre->signOut(User::userFromArray(json_decode($req->getContent(),true))))
      return json_encode(true);
    else return json_encode(false);
});

$app->get('/rapports',function() use($raprepo){
  return json_encode($raprepo->getRapports());
});

$app->post('/addRapport', function(Request $req) use($raprepo){
  $rapport=json_decode($req->getContent(),true);
  return json_encode($raprepo->addRapport($rapport));
});

$app->post('signup', function(Request $req) use($repo){
  $user=User::userFromArray(json_decode($req->getContent(),true));
  if($repo->addUser($user)) return json_encode($user);
  return json_encode(false);
});

$app->post('updateUser',function(Request $req) use($repo){
  $user=User::userFromArray(json_decode($req->getContent(),true));
  if($repo->updateUser($user)){
    return json_encode($repo->getUserByemail($user->email));
  }
  return json_encode(false);
});


//$app["cors-enabled"]($app);
$app->run();
