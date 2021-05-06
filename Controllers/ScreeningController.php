<?php
namespace Controllers;

use DAO\CinemaBdDAO as CinemaBdDAO;
use DAO\GenreBdDAO as  GenreBdDAO;
use DAO\MovieBdDao as MovieBdDao;
use DAO\RoomBdDAO as RoomBdDAO;
use Models\Screening as Screening;
use DAO\ScreeningBdDao as ScreeningBdDao;
use Controllers\RoomController as RoomController;


    class ScreeningController {

        
        private $screeningBdDAO;
        private $cinemabdDAO;
        private $roomBdDAO;
        private $movieBdDAO;
        private $movieController;
       
        

        public function __construct()
        {
            $this->screeningBdDAO = new ScreeningBdDao();
            $this->cinemabdDAO = new CinemaBdDAO();
            $this->roomBdDAO = new RoomBdDAO();
            $this->movieBdDAO = new MovieBdDAO();
            $this->movieController = new MovieController();
        }
    
        
        public function ShowAddScreeningView($id_cinema = null,$message = "") {
           
            require_once(VIEWS_PATH."validate-session.php");

            $listCinema =null;

            $roomList =null;

            $listCinema = $this->cinemabdDAO->getAllCinema();

           if($id_cinema != null ){

            $cinema = CinemaBdDao::MapearCinema($id_cinema);

           $roomList = $this->roomBdDAO->GetRoomsFromCinema($id_cinema);
           
            
            if($roomList == null){

                $roomController = new RoomController();

                $roomController->ShowAddRoomView($id_cinema,"the cinema that i select does not have rooms !!");
            }

            $movieList =$this->movieBdDAO->getAllMovies(); 

           }
           
        require_once(VIEWS_PATH."screening-add.php");
            
        }

        public function ShowScreeningsOfRoom($message="",$id_cinema,$id_room) {
            
            require_once(VIEWS_PATH."validate-session.php");
            
            $cinema = CinemaBdDao::MapearCinema($id_cinema);
        
            $screeningList = $this->screeningBdDAO->GetScreeningsFromARoom($id_room);

            require_once(VIEWS_PATH."screening-list-from-room.php");   
        }

        public function ShowScreeningsOfCinema($id_cinema,$message="") {
            
            require_once(VIEWS_PATH."validate-session.php");

            $cinema = CinemaBdDao::MapearCinema($id_cinema);

            $screeningList = $this->screeningBdDAO->getCinemaScreening($id_cinema);

            require_once(VIEWS_PATH."screening-list-from-room.php");   
        }
                
        
        public function ShowModififyView($id_screening,$message =""){

            require_once(VIEWS_PATH."validate-session.php");
            
            $screening = $this->screeningBdDAO->GetScreeningById($id_screening);
        
            $movieList =$this->movieBdDAO->getAllMovies(); 
            
            require_once(VIEWS_PATH."screening-modify.php");
            
        }
        
       

        private function addAscreening($id_room,$id_movie, $date_screening, $hour_screening,$id_cinema){

            require_once(VIEWS_PATH."validate-session.php");

            $movie = MovieBdDao::MapearMovie($id_movie);  
    
            $room = RoomBdDAO::MapearRoom($id_room);
    
            $newScreening = new Screening($room,$movie,$date_screening, $hour_screening);
    
            $result = $this->screeningBdDAO->SaveScreeningInBd($newScreening);
    
            if($result == 1) 
           $this->ShowAddScreeningView($id_cinema ,"Screening added succesfully!");
             else
           $this->ShowScreeningsOfRoom( "Screening added FAIL!",$id_cinema,$id_room);
    
           }

        private function evaluateTheTimeBetweenMvies($id_room,$date_screening,$hour_screening){

        $screeningOfRoomDate = $this->screeningBdDAO->getScreeningsOfaRoomInDate($id_room ,$date_screening); 


            if($screeningOfRoomDate != null){
                
                $minLeft = true;

             $waiting = '00:15:00';
            $waitings[1]=explode(':',$waiting);
            $hour_screenings = $hour_screening.":00";
            $arrayHMS[1]=explode(':',$hour_screenings);
        
                foreach($screeningOfRoomDate as $screening){

                       if($minLeft == true){

                    $hourScreening =$screening->getHour_screening();
                    $arrayHMS[2]= explode(':',$hourScreening);
                   
                    if($screening->getHour_screening() > $hour_screenings){
                       
                        //MINUTOS DE LA siguiente al ingresar ,lo pongo en segundos las horas + los minutos ($screening->getHour_screening()) + los minutos de la pelicula + 15 minutos espera
                        $totalMinScreening[1] = ($arrayHMS[1][0]*60)+$arrayHMS[1][1]+$screening->getMovie()->getDuration()+$waitings[1][1];
                        //minutos del escreening que quiere ingresar
                        $totalMinScreening[2] = ($arrayHMS[2][0]*60)+$arrayHMS[2][1]; 
                        //total minutos entre medio 
                        $minBetween = $totalMinScreening[2]-$totalMinScreening[1];
                        
                        if($minBetween>=0)
                            $minLeft = true;
                        else
                            $minLeft = false;
                    }else{
                        //MINUTOS DE LA anterior al ingresar ,lo pongo en segundos las horas + los minutos ($screening->getHour_screening()) + los minutos de la pelicula + 15 minutos espera
                        $totalMinScreening[2] = ($arrayHMS[2][0]*60)+$arrayHMS[2][1]+$screening->getMovie()->getDuration()+$waitings[1][1];
                        //minutos del escreening que quiere ingresar
                        $totalMinScreening[1] = ($arrayHMS[1][0]*60)+$arrayHMS[1][1]; 
                        //total minutos entre medio 
                        $minBetween = $totalMinScreening[1]-$totalMinScreening[2];
                       
                        if($minBetween>=0)
                            $minLeft = true;
                        else
                            $minLeft = false;
                        
                     }

                }
                }
            }

        return $minLeft;
    }

    public function AddScreening($id_room,$id_movie, $date_screening, $hour_screening,$id_cinema) {

        require_once(VIEWS_PATH."validate-session.php");

      //pregunto si alguna funcion para ese dia tiene esa pelicula

      $screening = $this->screeningBdDAO->getScreeningsDateAndMovie($id_movie , $date_screening);

      if($screening !=null){

        if($screening->getRoom()->getId_room() == $id_room){

           $minLeft = $this->evaluateTheTimeBetweenMvies($id_room,$date_screening,$hour_screening);

            
                if(!$minLeft){

                     $this->ShowAddScreeningView($id_cinema," Room occupied day ".$date_screening ." and Time ".$hour_screening ."!");    
                
                }else{

                $this->addAscreening($id_room,$id_movie, $date_screening, $hour_screening,$id_cinema);
                
                }
            
            //si la sala no es igual existe una sala con esa pelicula
            }else{
            
                $this->ShowAddScreeningView($id_cinema ," The movie ".$screening->getMovie()->getTitle() ." is already projected for the day ".$date_screening." at cinema ".$screening->getRoom()->getCinema()->getName() ." And Room ". $screening->getRoom()->getName() .""); 

              }

        }else{//cargar no hay funcion para esa pelicula

            $this->addAscreening($id_room,$id_movie, $date_screening, $hour_screening,$id_cinema);
        }
      

    }



    private function modyfyScreening($id_movie,$date_screening,$hour_screening, $id_room,$id_screening){

        $result = $this->screeningBdDAO->ModifyScreeningInBd($id_movie, $date_screening, $hour_screening, $id_screening);

        $room = RoomBdDao::MapearRoom($id_room);

        if($result == 1) 
            $this->ShowScreeningsOfRoom("Screening Modify Succefully!", $room->getCinema()->getId_Cinema(), $id_room); 
        else
            $this->ShowScreeningsOfRoom("ERROR: Failed in screening delete, reintente", $room->getCinema()->getId_Cinema(), $id_room); 

    }
           
    
        public function modify($id_movie,$date_screening,$hour_screening, $id_room,$id_screening){

         $screening = $this->screeningBdDAO->getScreeningsDateAndMovie($id_movie , $date_screening);

        if($screening !=null){

        if($screening->getRoom()->getId_room() == $id_room){

           $minLeft =  $this->evaluateTheTimeBetweenMvies($id_room,$date_screening,$hour_screening);
            
                if(!$minLeft)
                    $this->ShowModififyView($id_screening,"Room occupied day ".$date_screening ."and Time ".$hour_screening ."!" );  
                else
                $this->modyfyScreening($id_movie,$date_screening,$hour_screening, $id_room,$id_screening);
            
            //si la sala no es igual existe una sala con esa pelicula
            }else{
                $this->ShowModififyView($id_screening," The movie ".$screening->getMovie()->getTitle() ." is already projected for the day ".$date_screening." at cinema ".$screening->getRoom()->getCinema()->getName() ." And Room ". $screening->getRoom()->getName() .""); 

              }

        }else//cargar no hay funcion para esa pelicula
            $this->modyfyScreening($id_movie,$date_screening,$hour_screening, $id_room,$id_screening);
    } 

            
    

        public function RemoveScreeningFromDB($id_screening,$id_room)
        {   

            require_once(VIEWS_PATH."validate-session.php");

            $result = $this->screeningBdDAO->DeleteScreeningInDB($id_screening);

            $room = RoomBdDao::MapearRoom($id_room);

            if($result == 1) 
                $this->ShowScreeningsOfRoom("Screening Deleted Succefully!", $room->getCinema()->getId_Cinema(), $id_room); 
            else
              $this->ShowScreeningsOfRoom("ERROR: Failed in screening delete, reintente", $room->getCinema()->getId_Cinema(), $id_room); 
            
        }
        

       

public function GetAllScreeningsFromMovie($id_movie) {
    return $this->screeningBdDAO->GetScreeningsFromAMovie($id_movie);

}


}

?>