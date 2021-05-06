<?php
    namespace Controllers;

use DAO\GenreBdDAO;
use Controllers\MovieController as MovieController;
use Exception;

class HomeController
    {
        private $MovieController;
        private $GenresBdDAO;
       
        public function __construct() {

        $this->MovieController = new MovieController();
        $this->GenresBdDAO = new GenreBdDAO();
          
        }

        public function Index($message = "")
        {   
            $this->InicSystem();
            $this->MovieController->listMovies();   
        }
        
        public function ShowWeAreWorkingView() {
            require_once(VIEWS_PATH."we-are-working-error.php");
        }
        
        private function InicSystem() {
            
            try{
            $this->GenresBdDAO->GetGenresFromAPI();
            $this->MovieController->GetNowPlayingFromAPI();

            } catch (Exception $ex) {
                return $ex;
            }
        }
    }
