<?php
namespace src\Repositories;
include('../system/Connector.php');
include('../models/Rapport.php');
include('../models/User.php');

use PDO;
use src\System\Connector;
use src\Models\Rapport;
use src\Models\User;

class RapportRepository{

    private $connector;

    public function __construct(Connector $connector)
    {
        $this->connector=$connector->getConnection();
    }

    public function addRapport(Rapport $rap)
    {
        $stat='INSERT INTO rapport(name,type, data,email ,filiere,annee, sujet,encadrant,societe) VALUES (:name,:type, :data,:email ,:filiere,:annee, :sujet,:encadrant,:societe)';
        $prep=$this->connector->prepare($stat);
        return $prep->execute(array(':name'=>$rap->name,':type'=>$rap->type,':data'=>$rap->data,':email'=>$rap->email,':filiere'=>$rap->filiere,':annee'=>$rap->annee,':sujet'=>$rap->sujet,':encadrant'=>$rap->encadrant,':societe'=>$rap->societe));
    }

    public function getRapportsbyUser(User $user){
        $stat='select * from rapport where email=:email';
        $prep=$this->connector->prepare($stat);
        $prep->execute(array(':email'=>$user->email));
        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRapports(){
      $stat='select * from rapport';
      $prep=$this->connector->prepare($stat);
      $prep->execute();
      return $prep->fetchAll(PDO::FETCH_ASSOC);
    }
}
