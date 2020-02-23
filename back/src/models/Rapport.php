<?php

namespace src\Models;

use http\Env\Request;

class Rapport
{

  public $name;
  public $type;
  public $data;
  public $email;
  public $filiere;
  public $annee;
  public $sujet;
  public $encadrant;
  public $societe;
  public function __construct(
    string $name,
    string $type,
    string $data,
    string $email,
    string $filiere,
    string $annee,
    string $sujet,
    string $encadrant,
    string $societe
  ) {
    $this->name = $name;
    $this->data = $data;
    $this->type = $type;
    $this->email = $email;
    $this->filiere = $filiere;
    $this->annee = $annee;
    $this->sujet = $sujet;
    $this->encadrant = $encadrant;
    $this->societe = $societe;
  }

  public static function rapportFromArray($rapport)
  {
    return new Rapport($rapport['name'], $rapport['type'], $rapport['data'], $rapport['email'], $rapport['filiere'], $rapport['annee'], $rapport['sujet'], $rapport['encadrant'], $rapport['societe']);
  }
}
