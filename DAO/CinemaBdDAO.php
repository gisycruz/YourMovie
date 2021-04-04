<?php
namespace DAO;

use Models\Cinema as Cinema;
use DAO\Icinema as Icinema;
use FFI\Exception;

class CinemaBdDao implements Icinema{

  
    private $tableName = "cinema";
    private $connection;
    

    public function getCinemasFromDB(){
        
        $query = "SELECT * FROM " . $this->tableName;
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

        } catch (Exception $ex) {
            throw $ex;
        }
        
        return $result;
    
    }

    public function getAllCinema() {

        $cinemasList = array();

        $cinemasArray = $this->getCinemasFromDB();
        if(!empty($cinemasArray)) {
            
            $result = $this->mapear($cinemasArray);
            if(is_array($result)) {
                $this->cinemasList = $result;
            }
            else {
                $arrayResult[0] = $result;
                $this->cinemasList = $arrayResult;
            }
            return $this->cinemasList;
        }
        else {
            return $errorArray[0] = "Error al leer la base de datos.";
        }

    }

    

    public static function MapearCinema($idCinemaAMapear) {
        $cinemaDAOBdAux = new CinemaBdDao();
        return $cinemaDAOBdAux->GetCinemaById($idCinemaAMapear);
    }

    public function GetCinemaById($idCinemaABuscar)
    {    
        $cinema = null;

        $query = "SELECT * FROM " . $this->tableName . " WHERE (id_cinema = :id_cinema) ";

        $parameters["id_cinema"] = $idCinemaABuscar;

        try{

            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters);
        
        } catch (Exception $ex) {
            throw $ex;
        }

        
        $return = $this->mapear($results);
        

        return $return;
    }  

    public function SaveCinemaInDB(Cinema $cinema) {

        $sql = "INSERT INTO cinema (name, address) VALUES (:name, :address)";

        $parameters["name"] = $cinema->getName();
        $parameters["address"] = $cinema->getAddress();

        try {
            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function DeleteCinemaInDB($id_cinema) {
  
        $sql = "CALL deleteCinema(?)";
  
        $parameters["id_cinema"] = $id_cinema;
 
        try {

            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters,QueryType::StoredProcedure);

        } catch (Exception $ex){
            throw $ex;
        }
    }

    public function ModifyCinemaInBd($id_cinema, $name, $address) {

        $query = "UPDATE " . $this->tableName . " SET name=:name, address=:address WHERE (id_cinema=:id_cinema)";
      
        $parameters["name"] = $name;
        $parameters["address"] = $address;
        $parameters["id_cinema"] =$id_cinema;
        try {
            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }

    }

    protected function mapear($value) {


        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            $cinema = new Cinema($p['name'], $p['address']);
            $cinema->setId_Cinema($p['id_cinema']);
            return $cinema;

        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

}