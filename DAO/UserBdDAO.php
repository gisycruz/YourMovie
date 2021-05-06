<?php
namespace DAO;

use DAO\Iuser as Iuser;
use Models\User as User;
use DAO\Connection as Connection;
use Exception as GlobalException;
use FFI\Exception;


class UserBdDAO implements Iuser{

    private $connection;
    private $tableName = "user";
    
    public function GetByUserName($userName)
    {

        $query = "SELECT * FROM " . $this->tableName . " WHERE (username = :username) ";

        $parameters["username"] = $userName;

        try{

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $parameters);
        
        } catch (Exception $ex) {
            throw $ex;
        }

        if (!empty($result)){
            return $this->mapear($result);
        }
        else
            return false;
    }  

    public function SaveUserInDB(User $user) {

        $sql = "INSERT INTO " .$this->tableName."(username,password ,role,firstname,lastName,dni,birthDate) VALUES (:userName,:password,:role,:firstName,:lastName,:dni,:birthDate) ";
 
        $parameters["userName"] = $user->GetUserName();
        $parameters["password"] = $user->GetPassword();
        $parameters["role"] = 2;
        $parameters['firstName'] =$user->getFirstName();
        $parameters['lastName'] =$user->getLastName();
        $parameters['dni'] = $user->getDni();
        $parameters['birthDate'] =$user->getBirthDate();

        try {
            $this->connection = Connection::GetInstance();

            return $this->connection->ExecuteNonQuery($sql, $parameters);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    protected function mapear($value) {
        
        $value =($value) ? $value : [];

        $resp = array_map(function($p){
            $user = new User($p['username'], $p['password'], $p['role'],$p['firstName'],$p['lastName'],$p['dni'],$p['birthDate']);
            $user->setUserId($p["user_id"]);
            return $user;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    public function GetUserById($searchidUser)
    {
        $User = null;

        $query = "SELECT * FROM " . $this->tableName . " WHERE (user_id = :user_id) ";

        $parameters["user_id"] = $searchidUser;

        try{

            $this->connection = Connection::GetInstance();

            $results = $this->connection->Execute($query, $parameters);
           
        } catch (Exception $ex) {
            throw $ex;
        }
        
        return  $this->mapear($results);

    }

    public function ModifyUserInBd($id_user,$email, $password,$firstName,$lastName,$dni,$birthDate) {

           
        $query = "UPDATE " . $this->tableName . " SET username=:userName, password=:password,role =:role,firstname=:firstName,lastName=:lastName,dni=:dni,birthDate=:birthDate WHERE (user_id=:iduser)";
       
        $parameters["userName"] = $email;
        $parameters["password"] = $password;
        $parameters["role"] = 2;
        $parameters['firstName'] =$firstName;
        $parameters['lastName'] =$lastName;
        $parameters['dni'] = $dni;
        $parameters['birthDate'] =$birthDate;
       $parameters['iduser'] =$id_user;

        try {
            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }

    }

    public function DeleteUserInDB($id_user) {

        $sql ="call deleteroom(?)" ;
  
        $parameters["id_room"] = $id_user;

        try {

            $this->connection = Connection::GetInstance();
            $result = $this->connection->ExecuteNonQuery($sql, $parameters,QueryType::StoredProcedure);
            return $result;

        }catch (Exception $ex){
            throw $ex;
        }
    }

    public static function MapearUser($idUserToMapear) {
        $userDAOBdAux = new UserBdDAO();
        return $userDAOBdAux->GetUserById($idUserToMapear);
    }

    

}
