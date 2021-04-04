<?php
namespace DAO;

use Models\Room as Room;
use DAO\Iroom as Iroom;
use DAO\Connection as Connection;
use FFI\Exception;

class RoomBdDAO implements Iroom{

    private $tableName = "Room";
    private $connection;
    private $roomList = [];
   
    public function __construct(){
        
    }

    public function SaveRoomInBd(Room $Room) {
    
        $sql = " INSERT INTO ". $this->tableName ."(name, capacity,ticketvalue,idcinema) VALUES (:name, :capacity ,:ticketvalue , :idcinema)";
      
              $parameters["name"] = $Room->getName();
              $parameters["capacity"] = $Room->getCapacity();
              $parameters["ticketvalue"] = $Room->getTicketvalue();
              $parameters["idcinema"] = $Room->getCinema()->getId_Cinema();
              try {
                  $this->connection = Connection::GetInstance();
                  return $this->connection->ExecuteNonQuery($sql, $parameters);
              } catch (Exception $ex) {
                  throw $ex;
              }
          }

          
    public function getRoomFromDB(){
        
        $query = "SELECT * FROM " . $this->tableName;
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

        } catch (Exception $ex) {
            throw $ex;
        }

        return $result;
    
    }
    
    public function getAllRoom() {

        $roomArray = $this->getRoomFromDB();
        
        if(!empty($roomArray)) {
            
            $result = $this->mapear($roomArray);

            if(is_array($result)) {

                $this->roomList = $result;
            }
            else {
                $arrayResult[0] = $result;
                $this->roomList = $arrayResult;
            }
            
        return $this->roomList;

        }
        else {
            return $errorArray[0] = "ERROR while reading the database.";
        }
   
    }

    protected function mapear($value) {
        
        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            $room = new Room($p['name'], $p['capacity'], $p['ticketvalue'],CinemaBdDao::MapearCinema($p["idcinema"]));
            $room->setId_room($p['id_room']);
        
            return $room;

        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

  
        public function GetRoomById($searchidRoom)
        {
            $room = null;
    
            $query = "SELECT * FROM " . $this->tableName . " WHERE (id_room =:idroom )";
           
            $parameters["idroom"] = $searchidRoom;
    
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);


            } catch (Exception $ex) {
                throw $ex;
            }
            
            $room  = $this->mapear($results);
            return $room ;
    
        }
        
        public static function MapearRoom($idRoomToMapear) {

            $roomDAOBdAux = new RoomBdDAO();

            return $roomDAOBdAux->GetRoomById($idRoomToMapear);
        }

        public function DeleteRoomInDB($id_room) {

            $sql ="call deleteroom(?)" ;
      
            $parameters["id_room"] = $id_room;
    
            try {
    
                $this->connection = Connection::GetInstance();
                $result = $this->connection->ExecuteNonQuery($sql, $parameters,QueryType::StoredProcedure);
                return $result;

            }catch (Exception $ex){
                throw $ex;
            }
        }
        
        

        public function GetRoomsXCinemaFromBd($id_cinema) {

            $query = "SELECT * FROM " . $this->tableName . " WHERE idcinema = :idcinema ";
    
            $parameters["idcinema"] = $id_cinema;
    
            try{
    
                $this->connection = Connection::GetInstance();
                return $this->connection->Execute($query, $parameters);
            
            } catch (Exception $ex) {
                throw $ex;
            }

        }
        
        public function GetRoomsFromCinema($id_cinema) {

            $roomsXCinema = $this->GetRoomsXCinemaFromBd($id_cinema);

            if(!empty($roomsXCinema)) {
            
                $result = $this->mapear($roomsXCinema);

                if(is_array($result)) {
                    $this->roomList = $result;
                }
                else {
                    $arrayResult[0] = $result;
                    $this->roomList = $arrayResult;
                }
                return $this->roomList;
            }
            else {
                return $errorArray[0] = null;
            }
            
        }
        public function ModifyRoomInBd($name, $capacity, $ticketValue, $id_room) {

           
            $query = "UPDATE " . $this->tableName . " SET name=:name, capacity=:capacity, ticketValue=:ticketValue WHERE (id_room=:id_room)";
           
      
            $parameters["name"] = $name;
            $parameters["capacity"] = $capacity;
            $parameters["ticketValue"] = $ticketValue;
            $parameters["id_room"] = $id_room;
    
            try {
                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
    
        }
        
        
        
    

}