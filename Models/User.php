<?php 

namespace Models;
 
class User{

    private $user_id;
    private $userName ;
    private $password;
    private $role;
    private $firstName ;
    private $lastName;
    private $dni;
    private $birthDate;

    public function __construct($userName, $password, $role,$firstName,$lastName,$dni,$birthDate)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->role = $role;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dni = $dni;
        $this->birthDate =$birthDate;
    }

    public function getUserId(){ return $this->user_id;}
    public function setUserId($user_id){  $this->user_id = $user_id; }
    public function getUserName(){  return $this->userName; }
    public function setUserName($userName){$this->userName = $userName;}
    public function getPassword(){  return $this->password;}
    public function setPassword($password) { $this->password = $password;}
    public function getRole(){  return $this->role;}
    public function setRole($role) { $this->role = $role;}
    public function getFirstName(){ return $this->firstName;}
    public function setFirstName($firstName){ $this->firstName = $firstName;}
    public function getLastName(){return $this->lastName; }
    public function setLastName($lastName){ $this->lastName = $lastName;}
    public function getDni(){return $this->dni;}
    public function setDni($dni){$this->dni = $dni;}
    public function getBirthDate(){ return $this->birthDate;}
    public function setBirthDate($birthDate){ $this->birthDate = $birthDate; }
}
?>