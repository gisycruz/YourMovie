<?php
 namespace Controllers;

use Models\Room as Room;
use DAO\RoomBdDAO as RoomBdDAO;
use DAO\CinemaBdDAO as CinemaBdDAO;
use Controllers\Functions;
use PDOException;

class RoomController
    {       
        
        private $roomBdDAO;
        private $cinemabdDAO;

        public function __construct() {
            
            $this->roomBdDAO = new RoomBdDAO();
            $this->cinemabdDAO = new CinemaBdDAO();
           
        }

        public function ShowAddRoomView($id_cinema = NULL ,$message ="") {

            require_once(VIEWS_PATH."validate-session.php");

            $listCinema = NULL;

            $listCinema = $this->cinemabdDAO->getAllCinema();

            if($id_cinema != null ){

                $cinema = CinemaBdDao::MapearCinema($id_cinema);
            }

            require_once(VIEWS_PATH."room-add.php");
        }


        public function ShowRoomListCinemas($id_cinema) {

            require_once(VIEWS_PATH."validate-session.php");

            $this->ShowListRoomView($message ="", $id_cinema);
        }

        
        public function ShowListRoomView($message="", $id_cinema)
        {   
            
            require_once(VIEWS_PATH."validate-session.php");
        
            $cinema = CinemaBdDAO::MapearCinema($id_cinema);

            $roomList = array();

            $roomList = $this->roomBdDAO->GetRoomsFromCinema($id_cinema);
            
            require_once(VIEWS_PATH."room-list.php");
            
        }
       
        public function ShowModififyView($id_room,$message =""){

            require_once(VIEWS_PATH."validate-session.php");
            
            $room =null;

            $cinema =null;

            $room = RoomBdDAO::MapearRoom($id_room);

            $cinema = CinemaBdDAO::MapearCinema($room->getCinema()->getId_Cinema());
            
            require_once(VIEWS_PATH."room-modify.php");
        
        }


        public function Addroom($name, $capacity , $ticketValue, $id_cinema)
        {   
            
            require_once(VIEWS_PATH."validate-session.php");

            $newRoom = new Room($name, $capacity, $ticketValue,CinemaBdDao::MapearCinema($id_cinema));

                try{

                    $result = $this->roomBdDAO->SaveRoomInBd($newRoom);

                    if($result == 1) 
                        $this->ShowAddRoomView($id_cinema,"Room added succesfully!"); 
                     else 
                         $this->ShowAddRoomView($id_cinema, "ERROR: Failed in room Add, reintente");
                         
                     
                    
                } catch (PDOException $ex){

                    if(Functions::contains_substr($ex->getMessage(), "Duplicate entry"))
                     $this->ShowAddRoomView($id_cinema,"some of the data entered");
                    
                }
            
        }  
        
        public function RemoveRoomFromDB($id_cinema, $id_room){
            
            require_once(VIEWS_PATH."validate-session.php");

            try{

            $result = $this->roomBdDAO->DeleteRoomInDB($id_room);

            if($result == 1)
                $this->ShowListRoomView("Room Deleted Succefully!", $id_cinema); 
            else
                $this->ShowListRoomView("ERROR: Failed in room delete, reintente", $id_cinema);

        } catch (PDOException $ex){

            if(Functions::contains_substr($ex->getMessage(),"Result consisted of more than one row"))   
                $this->ShowListRoomView("has associated screening cannot be deleted !! you must delete screening", $id_cinema); 
        }
      }

        public function modify($name, $capacity, $ticketValue, $id_room){

            require_once(VIEWS_PATH."validate-session.php");

            try{
                   
            $result = $this->roomBdDAO->ModifyRoomInBd($name, $capacity, $ticketValue, $id_room);

            $room = RoomBdDAO::MapearRoom($id_room);

            if($result == 1)
            $this->ShowListRoomView("Room modify succesfully!", $room->getCinema()->getId_Cinema());
             else
                $this->ShowListRoomView("ERROR: Failed in room modify, reintente", $room->getCinema()->getId_Cinema());
            

              }catch(PDOException $ex){

                   if(Functions::contains_substr($ex->getMessage(), "Duplicate entry")) 
                       $this->ShowModififyView($id_room,"There is already a room with the same name to change!!!");

                     
                }

        } 
    }
    
?>