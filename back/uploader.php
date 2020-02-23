<?php
error_reporting(0);

require 'vendor/autoload.php';


include('./src/models/Rapport.php');
include('./src/repos/rapportRepo.php');
include('./src/system/Connector.php');
include('./src/models/User.php');

use Dotenv\Dotenv;
use src\Models\Rapport;
use src\Models\User;
use src\Repositories\RapportRepository;
use src\System\Connector;


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With");

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$raprep=new RapportRepository(new Connector());

$response = array();
$upload_dir = 'uploads/';
$server_url = 'http://localhost:8000';


if($_FILES['file'])
{
  $file_name = $_FILES["file"]["name"];
  $file_tmp_name = $_FILES["file"]["tmp_name"];
  $error = $_FILES["file"]["error"];
  $type = $_FILES["file"]["type"];
  $email = json_decode($_POST["user"])->email;
  $rapport = json_decode($_POST["rapportDetails"]);
  if($error > 0){
    $response = array(
      "status" => "error",
      "error" => true,
      "message" => "Error uploading the file!"
    );

  }else
  {
    $random_name = rand(1000,1000000)."-".$file_name;
    $upload_name = $upload_dir.strtolower($random_name);
    $upload_name = preg_replace('/\s+/', '-', $upload_name);

    if(move_uploaded_file($file_tmp_name , $upload_name)) {
      $response = array(
        "status" => "success",
        "error" => false,
        "message" => "File uploaded successfully",
        "url" => $server_url."/".$upload_name
      );
      $rapport=new Rapport($file_name, $type, $response['url'], $email,$rapport->filiere,$rapport->annee,$rapport->sujet,$rapport->encadrant,$rapport->societe);
      $raprep->addRapport($rapport);
    }else
    {
      $response = array(
        "status" => "error",
        "error" => true,
        "message" => "Error uploading the file!"
      );
    }
  }

}else{
  $response = array(
    "status" => "error",
    "error" => true,
    "message" => "No file was sent!"
  );
}

return json_encode($response);
?>
