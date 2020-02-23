<?php
namespace src\Models;

class User{
    public $firstname;
    public $lastname;
    public $password;
    public $email;
    public $promotion;
    public $telephone;
    public $naissance;
    public $linkedin;
    public $solde;
    public function __construct($firstname,$lastname,$password,$email,$promotion,$tel,$naissance,$linkedin){

        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->email=$email;
        $this->password=$password;
        $this->promotion=$promotion;
        $this->telephone=$tel;
        $this->naissance=$naissance;
        $this->linkedin=$linkedin;

        if($promotion=="1"){$this->solde=1;}
        else if($promotion=="2"){$this->demandeRapportPormotionUne();}
        else {$this->demandeRapportPormotionUneetdeux();}

    }


    public function  demandeRapportPormotionUne(){
      /*il doit déposer le rapport de la première année */
      $this->solde=2;
    }
    public function demandeRapportPormotionUneetdeux(){$this->demandeRapportPormotionUne();$this->solde++;}

  /**
   * @return mixed
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * @return mixed
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * @return mixed
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * @return mixed
   */
  public function getNaissance()
  {
    return $this->naissance;
  }

  /**
   * @return mixed
   */
  public function getLinkedin()
  {
    return $this->linkedin;
  }

  /**
   * @return mixed
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * @return mixed
   */
  public function getPromotion()
  {
    return $this->promotion;
  }

  /**
   * @return int
   */
  public function getSolde()
  {
    return $this->solde;
  }

  /**
   * @return mixed
   */
  public function getTelephone()
  {
    return $this->telephone;
  }

  /**
   * @param mixed $email
   */
  public function setEmail($email)
  {
    $this->email = $email;
  }

  /**
   * @param mixed $firstname
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;
  }

  /**
   * @param mixed $lastname
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;
  }

  /**
   * @param mixed $linkedin
   */
  public function setLinkedin($linkedin)
  {
    $this->linkedin = $linkedin;
  }

  /**
   * @param mixed $naissance
   */
  public function setNaissance($naissance)
  {
    $this->naissance = $naissance;
  }

  /**
   * @param mixed $password
   */
  public function setPassword($password)
  {
    $this->password = $password;
  }

  /**
   * @param mixed $promotion
   */
  public function setPromotion($promotion)
  {
    $this->promotion = $promotion;
  }

  /**
   * @param int $solde
   */
  public function setSolde($solde)
  {
    $this->solde = $solde;
  }

  /**
   * @param mixed $telephone
   */
  public function setTelephone($telephone)
  {
    $this->telephone = $telephone;
  }

  public static function userFromArray($array){
    $user= new User($array['firstname'],$array['lastname'],$array['password'],$array['email'],$array['promotion'],$array['telephone'],$array['naissance'],$array['linkedin']);
    $user->solde=$array['solde'];
    return $user;
  }
}


?>
