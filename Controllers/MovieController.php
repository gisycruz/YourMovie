<?php

namespace Controllers;

use DAO\CinemaBdDao as CinemaBdDao ;
use DAO\GenreBdDAO as GenreBdDAO;
use DAO\MovieBdDao as MovieBdDao;
use Models\Movie as Movie;
use DAO\ScreeningBdDAO as ScreeningBdDAO ;
use Models\Genre as Genre;
use DAO\ShoppingBdDAO as ShoppingBdDAO;

class MovieController { 

    private $movieBdDao;
    private $screeningBdDAO;

public function __construct() {
       
 $this->movieBdDao = new MovieBdDao(); 
$this->screeningBdDAO = new ScreeningBdDAO();
$this->shoppingBdDAO = new ShoppingBdDAO();
 }

 
 public function ShowListMovie($MovieList,$genresOfScreenings,$datesOfScreenings,$message,$var){
    $count = 0;
    if(is_array($MovieList) && !empty($MovieList)) {
    $cantidadDeMovies = count($MovieList);
    }
    require_once(VIEWS_PATH."movie-list.php");
}

 public function ShowMovieSheet($id_movie,$message,$var) {
   
    $screeningList = [];
   
    $movie = MovieBdDAO::MapearMovie($id_movie);

    if(!isset($_SESSION["loginAdmid"])){
        
    $listScreeningWithSeatFreeAndfromNow = $this->getMoviesList();

    foreach($listScreeningWithSeatFreeAndfromNow as $screening){
        
        if($screening->getMovie()->getId_movie() == $id_movie){
            array_push($screeningList , $screening);
        }
       
    }
   
}else{

    if($message ==1){
    $listScreening = $this->screeningBdDAO->getAllScreening();
    
    foreach($listScreening as $screening){
        if($screening->getMovie()->getId_movie() == $id_movie){
            array_push($screeningList , $screening);

        }

    }
    }else{

        $listScreeningWithSeatFreeAndfromNow = $this->getMoviesList();

        foreach($listScreeningWithSeatFreeAndfromNow as $screening){
            
            if($screening->getMovie()->getId_movie() == $id_movie){
                array_push($screeningList , $screening);
            }
           
        }

    }
}     

    require_once(VIEWS_PATH. "movie-sheet.php");

}


public function ShowSalesTicketMovie($id_movie = null,$message =""){

    require_once(VIEWS_PATH."validate-session.php");

    $var =true;

    $message =1;

    $listScreening = $this->screeningBdDAO->getAllScreening();

    if($listScreening){

   $MovieList = $this->screeningBdDAO->getMovieWithScreening();

    $this->ShowListMovie($MovieList,$genresOfScreenings =[],$datesOfScreenings=[],$message,$var);

}else{

    $this->listMovies("not screening add");
} 

}

public function ShowIncomingInfo($id_movie) {
        
    $url = $this->movieBdDao->GetPageOfIncomingMovieFromAPI($id_movie);

    if(!empty($url)){
        header('location:' . $url);
    }
    else {
        $this->listMovies("We havent info about that movie yet! Sorry!");
    }
}

public function getMoviesList() {

    $listScreening = [];

    $listScreeningWithSeatFreeAndfromNow =[];
   
    $listScreening = $this->screeningBdDAO->getAllScreening();

    if( !empty($listScreening) ){
             
             foreach($listScreening as $screening){
            
                date_default_timezone_set('America/Argentina/Ushuaia');

                $date_now =strtotime(date("Y-m-d H:i:s",time()));

                $date =$screening->getDate_screening();

                $time = $screening->getHour_screening();

                $date_screening = date_create($date.$time);

                $combinedDateAndTime =strtotime(date_format($date_screening,"Y-m-d H:i:s"));
                
                //agrego 15 minutos mas para poder comprar en los minutos de espera de la sala 
                $NewDate = strtotime ( '+15 minute' ,  $combinedDateAndTime) ; 
               
                if($NewDate >= $date_now){
                    
                //si hay lugar devuelve el screening ,sino null
               $screeningSeatFree = $this->screeningBdDAO->screenigWhitSeatFree($screening->getId_screening()); 

                if($screeningSeatFree != null){

                    array_push( $listScreeningWithSeatFreeAndfromNow , $screening);
                }

            }


          }

        }

        return $listScreeningWithSeatFreeAndfromNow ;

    }
    
    public function listMovies($message ="") {

        $genresOfScreenings =[];
        $datesOfScreenings=[];
        $MovieList =[];     
        

         $listScreenigMovie = $this->listScreenigListDateAndListGenre();

         $datesOfScreenings = $listScreenigMovie[1];
         $genresOfScreenings =$listScreenigMovie[2];
        $MovieList = $this->lisMovieUnique($listScreenigMovie[0]);
     

    $this->ShowListMovie($MovieList,$genresOfScreenings,$datesOfScreenings,$message,$var="");

    }

    public function listMoviesScreenig($message =""){


    require_once(VIEWS_PATH."validate-session.php");

    $listScreening = $this->screeningBdDAO->getAllScreening();

   $MovieList = $this->screeningBdDAO->getMovieWithScreening();

   $message = 1;

   $this->ShowListMovie($MovieList,$genresOfScreenings =[],$datesOfScreenings=[],$message,$var="");

    }




    private function listScreenigListDateAndListGenre(){

        $genresOfScreenings =[];
        $datesOfScreenings=[];
        $listScreenigListDateAndListGenre =[];

        $listScreeningWithSeatFreeAndfromNow = $this->getMoviesList();

        if(isset($listScreeningWithSeatFreeAndfromNow )){

            foreach($listScreeningWithSeatFreeAndfromNow as $screening){

                    array_push($datesOfScreenings ,$screening->getDate_screening());
                    array_push($genresOfScreenings , $screening->getMovie()->getGenre()->getGenreName());

            }
        }
        $datesOfScreenings = array_unique($datesOfScreenings);
        $genresOfScreenings = array_unique($genresOfScreenings);
        sort($genresOfScreenings);
        sort($datesOfScreenings);

        $listScreenigListDateAndListGenre[0] = $listScreeningWithSeatFreeAndfromNow;
        $listScreenigListDateAndListGenre[1] = $datesOfScreenings;
        $listScreenigListDateAndListGenre[2] =$genresOfScreenings;
       

        return $listScreenigListDateAndListGenre;

    }

    private function lisMovieUnique($listScreening){

        $MovieList =[];
        $MovieListId =[];

        foreach($listScreening as $screening){
            array_push($MovieListId ,$screening->getMovie()->getId_movie());
          }

         $MovieListId  = array_unique($MovieListId);

        foreach($MovieListId  as $idMovie){
            array_push($MovieList , MovieBdDAO::MapearMovie($idMovie));
        }

        return $MovieList;
    }


    private function getGenreListScreenig($listScreening,$genre){

        $screeningListGenre = [];

        foreach($listScreening as $screening) {
            if($screening->getMovie()->getGenre()->getGenreName() == $genre)
            array_push($screeningListGenre , $screening); 
        }

        return  $screeningListGenre ;
    }

    public function ApplyFilters($date,$genre) 
    {
       
        if(isset($_POST)){

            if(!empty($date) && !empty($genre)){

            $this->listMoviesWithFilterDateAndGenre($date,$genre);
            
            }else if(!empty($date)){

               
                $this->listMoviesWithFilter("date", $date);
            }
            else if (!empty($genre)){

               
                $this->listMoviesWithFilter("genre", $genre);
            }
            else if(empty($date) && empty($genre)){

                $this->movieController->listMovies("Si desea filtrar las peliculas en cartelera<br>Recuerde asignar correctamente los filtros.<br>(Date->Date // Genre->Genre)");
            }
    
    } 
} 

private function listMoviesWithFilterDateAndGenre($date, $genre) {

   $listScreeningGenre =[];
   $screeningList =[];
   $MovieList =[];

   $listScreningDateAndGenre =$this->listScreenigListDateAndListGenre();

   $datesOfScreenings = $listScreningDateAndGenre[1];
   $genresOfScreenings =$listScreningDateAndGenre[2];

    $listScreeningDate = $this->screeningBdDAO->getScreeningToDate($date);

    if(!empty($listScreeningDate)){

       $listScreeningGenre =$this->getGenreListScreenig($listScreeningDate,$genre);

       if(!empty($listScreeningGenre)){

        $MovieList = $this->lisMovieUnique($listScreeningGenre);
        $this->ShowListMovie($MovieList,$genresOfScreenings,$datesOfScreenings,"Screening para el dia : ".$date." Genre :".$genre,$var="");

       }else{
        $this->listMovies("I do not know find a movie in function whith the date and genre");
       }
    }else{
        $this->listMovies("I do not know find a movie in function whith the date "); 
    }

}

private function listMoviesWithFilter($filter, $value) {

    $screeningList=[];
    $MovieList =[];
    $listGenreScreening =[];

    $listScreningDateAndGenre =$this->listScreenigListDateAndListGenre();
    $datesOfScreenings = $listScreningDateAndGenre[1];
    $genresOfScreenings =$listScreningDateAndGenre[2];

        if($filter == "date") {

            $screeningList = $this->screeningBdDAO->getScreeningToDate($value);

                if(!empty($screeningList)){

                    $MovieList =$this->lisMovieUnique($screeningList);
                   
                   $this->ShowListMovie($MovieList,$genresOfScreenings,$datesOfScreenings,"Screening date : ".$value,$var="");

            }else{
        
                $this->listMovies("I do not know find a movie in function whith the date ");
            }
            

    }else if($filter == "genre"){

         $screeningList =$listScreningDateAndGenre[0];

        $listGenreScreening = getGenreListScreenig($screeningList,$value);

        if(isset($listGenreScreening)){

        $MovieList =$this->lisMovieUnique($listGenreScreening);

        $this->ShowListMovie($MovieList,$genresOfScreenings,$datesOfScreenings,"Screening Genre : ".$value,$var="");

        }else{
        
                $this->listMovies("I do not know find a movie in function whith the genre ");
            }
      

      }
   }

    public function GetMoviesWithoutScreening($id_room) {
        return $this->movieBdDao->GetMoviesWithOutScreening($id_room);
    }

    public function GetNowPlayingFromAPI() {
        $this->movieBdDao->GetNowPlayingFromAPI();
    }

    public function GetUpComingMoviesFromAPI() {
        return $this->movieBdDao->GetUpcomingMoviesFromAPI();
    }

    
    

}