<?php
    namespace Controllers;

use DAO\GenreBdDAO;
use Exception;
use Controllers\MovieController as MovieController;


class HomeController
    {
        public function Index($message = "")
        {   
            $this->InicSystem();
            $MovieController = new MovieController();
            $MovieController->listMovies();
           
            
        }
        
        public function ShowWeAreWorkingView() {
            require_once(VIEWS_PATH."we-are-working-error.php");
        }
        
        private function InicSystem() {
            
            try{
            $GenresBdDAO = new GenreBdDAO();
            $GenresBdDAO->GetGenresFromAPI();
            $MovieController = new MovieController();
            $MovieController->GetNowPlayingFromAPI();
            } catch (Exception $ex) {
                return;
            }
        }
    }
