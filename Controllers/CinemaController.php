<?php
namespace Controllers;

use Models\Cinema as Cinema;
use DAO\CinemaBdDao as CinemaBdDAO;
use Controllers\Functions;
use PDOException;

   class CinemaController
    {      
        private $cinemaBdDAO;

        public function __construct() {

            $this->cinemaBdDAO = new CinemaBdDAO();
        }

        public function ShowAddCinemaView($message = "") {

            require_once(VIEWS_PATH."validate-session.php");
            
            require_once(VIEWS_PATH."cinema-add.php");
        }

        
        public function ShowListCinemaView($message="")
        {   
            require_once(VIEWS_PATH."validate-session.php");

            $cinemaList = $this->cinemaBdDAO->getAllCinema();
            
            require_once(VIEWS_PATH."cinema-list.php");
            
        }

        public function ShowModififyView($id_cinema){

            require_once(VIEWS_PATH."validate-session.php");

            $cinema = CinemaBdDAO::MapearCinema($id_cinema);

             require_once(VIEWS_PATH."cinema-modify.php");
        }


        public function AddCinema($name, $address)
        {
            require_once(VIEWS_PATH."validate-session.php");

            $newCinema = new Cinema($name, $address);
          
                try{
                    $result = $this->cinemaBdDAO->SaveCinemaInDB($newCinema);

                    if($result) {

                        $message = "Cinema added succesfully!";

                        $this->ShowAddCinemaView($message);

                     }else{

                        $message = "ERROR: System error, reintente";

                        $this->ShowAddCinemaView($message);
                    }

                } catch (PDOException $ex){

                    $message = $ex->getMessage();

                    if(Functions::contains_substr($message, "Duplicate entry")){

                        $message = "some of the data entered (Address/Name) already exists . repeated";

                        $this->ShowAddCinemaView($message);
                    }
                }
            
            
        }  
        
        
        public function RemoveCinemaFromDB($id_cinema)
        {
            require_once(VIEWS_PATH."validate-session.php");

            try{

                if($result == 1){

            $result = $this->cinemaBdDAO->DeleteCinemaInDB($id_cinema);

            $message = "Cinema Deleted Succefully!";

            $this->ShowListcinemaView($message);
              
        }else{

            $message = "ERROR: System error, reintente";

            $this->ShowListcinemaView($message);
            
           }
           
        } catch(PDOException $ex){

            $message = $ex->getMessage();

            if(Functions::contains_substr($message, "Result consisted of more than one row")) {

                $message = "has associated rooms cannot be deleted !! you must delete rooms";

                $this->ShowListcinemaView($message);

            }
        }

    }

    public function modify($name ,$address ,$id_cinema){

        require_once(VIEWS_PATH."validate-session.php");
        
        try{
            $result = $this->cinemaBdDAO->ModifyCinemaInBd($id_cinema, $name, $address);

            if($result == 1){

            $message ="cinema modify"; 

            $this->ShowListCinemaView($message);

            }else{

             $message = "ERROR: System error, reintente";

             $this->ShowAddCinemaView($message);
             
            }

        } catch (PDOException $ex){

            $message = $ex->getMessage();

            if(Functions::contains_substr($message, "Duplicate entry")){

                $message = "some of the data entered (Address/Name) already exists . repeated";

                $this->ShowListCinemaView($message);
            }
        }
       
    }
    
    
}  
    
?>