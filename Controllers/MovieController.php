<?php

namespace Controllers;

use DAO\CinemaBdDao as CinemaBdDao ;
use DAO\GenreBdDAO as GenreBdDAO;
use DAO\MovieBdDao as MovieBdDao;
use Models\Movie as Movie;
use DAO\ScreeningBdDAO as ScreeningBdDAO ;
use Models\Genre as Genre;

class MovieController { 

    private $movieBdDao;
    private $screeningBdDAO;

public function __construct() {
       
 $this->movieBdDao = new MovieBdDao(); 
$this->screeningBdDAO = new ScreeningBdDAO();
 }


 public function ShowMovieSheet($id_movie) {
   
    $movie = MovieBdDao::MapearMovie($id_movie);
    
    $screeningController = new ScreeningController();

    $screeningList = $screeningController->GetAllScreeningsFromMovie($id_movie);
    
    $cinemaName = $screeningList[0]->getRoom()->getCinema()->getName();

    require_once(VIEWS_PATH. "movie-sheet.php");
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

               
                 
                //$newDate = strtotime ('+20 minute' , strtotime ($combinedDateAndTime)) ; 

                if($combinedDateAndTime >= $date_now){
                    
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

    
    public function listMovies($message = "") {

        $listScreeningWithSeatFreeAndfromNow = $this->getMoviesList();
               
        $genresOfScreenings =[];

        $datesOfScreenings=[];

        $MovieList =[];

        $MovieListId =[];

        if(isset($listScreeningWithSeatFreeAndfromNow )){

            foreach($listScreeningWithSeatFreeAndfromNow as $screening){

                    array_push($datesOfScreenings ,$screening->getDate_screening());
                    array_push($genresOfScreenings , $screening->getMovie()->getGenre()->getGenreName());
                    array_push($MovieListId, $screening->getMovie()->getId_movie());

            }
        }
        $datesOfScreenings = array_unique($datesOfScreenings);
        $genresOfScreenings = array_unique($genresOfScreenings);
        $MovieListId = array_unique($MovieListId);

       
        sort($genresOfScreenings);
        sort($datesOfScreenings);

        foreach($MovieListId as $idMovie){
            array_push($MovieList , MovieBdDAO::MapearMovie($idMovie));
        }
        
        $count = 0;
        if(is_array($MovieList) && !empty($MovieList)) {
        $cantidadDeMovies = count($MovieList);
        }
       
        require_once(VIEWS_PATH."movie-list.php");
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
