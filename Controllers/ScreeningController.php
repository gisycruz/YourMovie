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

                $message ="the cinema that i select does not have rooms !!";
               
                $roomController = new RoomController();

                $roomController->ShowAddRoomView($id_cinema,$message);
            }

            $movieList =$this->movieBdDAO->getAllMovies(); 

           }
           
        require_once(VIEWS_PATH."screening-add.php");
            
        }

        public function ShowScreeningsOfRoom($message="",$id_cinema,$id_room) {
            
            require_once(VIEWS_PATH."validate-session.php");
            
            $cinema = CinemaBdDao::MapearCinema($id_cinema);

            $room = RoomBdDAO::MapearRoom($id_room);

        
            $screeningList = $this->screeningBdDAO->GetScreeningsFromARoom($id_room);

            require_once(VIEWS_PATH."screening-list-from-room.php");   
        }

                
        
        public function ShowModififyView($id_screening){

            require_once(VIEWS_PATH."validate-session.php");
            
            $screening = $this->screeningBdDAO->GetScreeningById($id_screening);
        
            $movieList =$this->movieBdDAO->getAllMovies(); 
            
            require_once(VIEWS_PATH."screening-modify.php");
            
        }

        public function AddScreening($id_room,$id_movie, $date_screening, $hour_screening,$id_cinema) {

            require_once(VIEWS_PATH."validate-session.php");
            //devuelve la sala ocupada en esa hora y dia

            $valueScreening = $this->screeningBdDAO->GetScreeningsFromDateAndTime($id_room , $date_screening, $hour_screening);
           
            if($valueScreening != null){

                $message = " Occupied room !!!";

                $this->ShowAddScreeningView($id_cinema = null,$message);

            }else{


                //evaluar los 15 minutos de la sala en espera 


                //funcion que me devuelbe los screening con igual fecha ingresado 

                //lista de escreenig de igual fecha si es distinto de null busco la pelicula 

            $room = RoomBdDAO::MapearRoom($id_room);
            
            $movie = MovieBdDao::MapearMovie($id_movie);  

            $newScreening = new Screening($room,$movie,$date_screening, $hour_screening);
           
            $result = $this->screeningBdDAO->SaveScreeningInBd($newScreening);

            if($result == 1) {

                $message = "Screening added succesfully!";

                $this->ShowScreeningsOfRoom($message,$id_cinema,$id_room);
            }
            else {

                $message = "Screening added FAIL!";

                require_once(VIEWS_PATH."screening-list-from-room.php");           
            }

           }

        }


        public function modify($movie, $date , $time, $id_room,$id_screening){

            require_once(VIEWS_PATH."validate-session.php");

            $result = $this->screeningBdDAO->ModifyScreeningInBd($movie, $date, $time, $id_screening);

            $room = RoomBdDao::MapearRoom($id_room);

            if($result == 1) {
                
                $message = "Screening Modify Succefully!";

                $this->ShowScreeningsOfRoom($message, $room->getCinema()->getId_Cinema(), $id_room); 
            }
            else
            {
                
                $message = "ERROR: Failed in screening delete, reintente";
                $this->ShowScreeningsOfRoom($message, $room->getCinema()->getId_Cinema(), $id_room); 
            }
            
        }


        public function RemoveScreeningFromDB($id_screening,$id_room)
        {   

            require_once(VIEWS_PATH."validate-session.php");

            $result = $this->screeningBdDAO->DeleteScreeningInDB($id_screening);

            $room = RoomBdDao::MapearRoom($id_room);

            if($result == 1) {
                
                $message = "Screening Deleted Succefully!";

                $this->ShowScreeningsOfRoom($message, $room->getCinema()->getId_Cinema(), $id_room); 
            }
            else
            {
                $message = "ERROR: Failed in screening delete, reintente";

                $this->ShowScreeningsOfRoom($message, $room->getCinema()->getId_Cinema(), $id_room); 
            }
        }
        

        public function ApplyFilters($date,$genre) 
        {
            if(isset($_GET)){

                if(!empty($date) && !empty($genre)){

                $this->listMoviesWithFilterDateAndGenre($date,$genre);
                
                }else if(!empty($date)){

                    $this->listMoviesWithFilter("date", $date);
                }
                else if (!empty($genre)){

                   
                    $this->listMoviesWithFilter("genre", $genre);
                }
                else if(empty($date) && empty($genre)){

        
                    $message = "Si desea filtrar las peliculas en cartelera<br>Recuerde asignar correctamente los filtros.<br>(Date->Date // Genre->Genre)";

                    $this->movieController->listMovies($message);
                }
        
        } 
    } 

    public function listMoviesWithFilterDateAndGenre($date, $genre) {

        $ListFiltre =[];
        $genresOfScreenings =[];
        $datesOfScreenings=[];
        $MovieList =[];
       
        $listScreeningWithSeatFreeAndfromNow = $this->movieController->getMoviesList();
    
        if(isset($listScreeningWithSeatFreeAndfromNow)){
    
            foreach($listScreeningWithSeatFreeAndfromNow as $screening) {
    
                if( $screening->getDate_screening() == $date && $screening->getMovie()->getGenre()->getGenreName() == $genre){
                array_push($ListFiltre, $screening->getMovie());
                }
            }
    
            if(!empty($ListFiltre)){
    
                $MovieList = $ListFiltre;

                $filterMessage = " || Date: " .  $date . " || Genre: " .  $genre ;
    
                foreach($listScreeningWithSeatFreeAndfromNow as $screening){
    
                    array_push($datesOfScreenings ,$screening->getDate_screening());
                    array_push($genresOfScreenings , $screening->getMovie()->getGenre()->getGenreName());
    
                }

                $datesOfScreenings = array_unique($datesOfScreenings);
                $genresOfScreenings = array_unique($genresOfScreenings);
                sort($genresOfScreenings);
                sort($datesOfScreenings);

                $count = 0;
                if(is_array($MovieList) && !empty($MovieList)) {
                $cantidadDeMovies = count($MovieList);
                }
    
                require_once(VIEWS_PATH. "movie-list.php");
    
            }else{
               
           $message = "I do not know find a movie in function whith the date and genre"; 
    
           $this->movieController->listMovies($message);
    
           }
        }
    }


    public function listMoviesWithFilter($filter, $value) {

        $ListFiltre =[];
        $genresOfScreenings =[];
        $datesOfScreenings=[];
        $MovieList =[];
       
        $listScreeningWithSeatFreeAndfromNow = $this->movieController->getMoviesList();

        foreach($listScreeningWithSeatFreeAndfromNow as $screening){
    
            array_push($datesOfScreenings ,$screening->getDate_screening());
            array_push($genresOfScreenings , $screening->getMovie()->getGenre()->getGenreName());

        }
           
        $datesOfScreenings = array_unique($datesOfScreenings);
        $genresOfScreenings = array_unique($genresOfScreenings);
        sort($genresOfScreenings);
        sort($datesOfScreenings);

        $count = 0;
        if(is_array($MovieList) && !empty($MovieList)) {
        $cantidadDeMovies = count($MovieList);
        }

        if(isset($listScreeningWithSeatFreeAndfromNow)){

            if($filter == "date") {
    
            foreach($listScreeningWithSeatFreeAndfromNow as $screening) {
    
                if( $screening->getDate_screening()  == $value){
                array_push($ListFiltre, $screening->getMovie());
                }
            }
    
            if(!empty($ListFiltre)){
    
                $MovieList = $ListFiltre;

                $filterMessage = " || Date: " .  $value;

                require_once(VIEWS_PATH. "movie-list.php");

            }else{

                $message = "I do not know find a movie in function whith the date "; 
        
                $this->movieController->listMovies($message);
            }

        }else if($filter == "genre"){
        
            foreach($listScreeningWithSeatFreeAndfromNow as $screening) {
    
                if($screening->getMovie()->getGenre()->getGenreName() == $value){
                array_push($ListFiltre, $screening->getMovie());
                }
            }
    
            if(!empty($ListFiltre)){

                $MovieList = $ListFiltre;
               
              $filterMessage = " || Genre: " .  $value;

              require_once(VIEWS_PATH. "movie-list.php");

            }else{

                $message = "I do not know find a movie in function whith the genre "; 
        
                $this->movieController->listMovies($message);
              }
          

          }
       }
 
    }
    

public function GetAllScreeningsFromMovie($id_movie) {
    return $this->screeningBdDAO->GetScreeningsFromAMovie($id_movie);

}

/*public function GetGenresOfScreenings() {
   return $this->screeningBdDAO->GetGenresOfScreenings();
}

public function GetDatesOfScreenings() {
    return $this->screeningBdDAO->GetDatesOfScreenings();
}*/

    

}

?>