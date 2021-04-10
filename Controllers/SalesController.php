<?php
    namespace Controllers;

    use DAO\ShoppingBdDAO as ShoppingBdDAO;
    use DAO\ScreeningBdDAO as ScreeningBdDAO;
    use DAO\MovieBdDAO as  MovieBdDAO;
    use DAO\CinemaBdDAO as CinemaBdDAO;

    class SalesController
    {       
        
        private $shoppingBdDAO;
        private $screeningBdDAO;


        public function __construct() {

           $this->shoppingBdDAO = ShoppingBdDAO::getInstance();
           $this->screeningBdDAO = new ScreeningBdDAO();

        }

    public function ShowSalesTicketCinema($id_cinema = null ,$message =""){

        require_once(VIEWS_PATH."validate-session.php");

        $listCinemaScreening = $this->getCinemaWthScreenig();

        if(isset($listCinemaScreening)){

        if($id_cinema != null){
           
            $cinema = CinemaBdDAO::MapearCinema($id_cinema);

           $totalTicket =  $this->soldCinema($id_cinema);

           $Remnants = $this->notSoldCinema($id_cinema);
    
        $totalMoneySold = $this->getSoldmoneyCinema($id_cinema);

        }
        require_once(VIEWS_PATH."sale-cinema.php");
        

        }else{

            $message = "not screening add";

        }
    }



    public function ShowSalesTicketMovie($id_movie = null,$message =""){

        require_once(VIEWS_PATH."validate-session.php");

        $listMovieScreening = $this->getMovieWithScreenigSales();

        if(isset($listMovieScreening)){

        if($id_movie != null){

            $movie = MovieBdDAO::MapearMovie($id_movie);

            $totalTicket =  $this->soldMovie($id_movie);

            $Remnants = $this->notSoldMovie($id_movie);
    
            $totalMoneySold = $this->getSoldmoneyMovie($id_movie);

        }

        require_once(VIEWS_PATH."sale-movie.php");

    }else{

        $message = "not screening add";

    } 

    }

    private function getCinemaWthScreenig(){

    $listCinemaScreening = $this->screeningBdDAO->getCinemaWithScreening();

    return  $listCinemaScreening;
    
    }

    private function getMovieWithScreenigSales(){

    $listMovieScreening = $this->screeningBdDAO->getMovieWithScreening();

    return  $listMovieScreening ;

    }

    private function soldCinema($id_cinema){

        $totalTicket =  $this->shoppingBdDAO->sumNumberOfPurchasesOfaCinema($id_cinema);

        return $totalTicket;
    }
    
    private function soldMovie($id_movie){

        $totalTicket =  $this->shoppingBdDAO->sumNumberOfPurchasesOfaMovie($id_movie);

        return $totalTicket;
    }

    private function notSoldCinema($id_cinema){

        $totalTicket =  $this->soldCinema($id_cinema);
        $capacityRoomCinema =  $this->screeningBdDAO->sumCapacityByCinema($id_cinema);
        $Remnants = $capacityRoomCinema - $totalTicket;
        
        return $Remnants;
    }

    private function notSoldMovie($id_movie){

        $totalTicket =  $this->soldMovie($id_movie);
        $capacityRoomMovie =  $this->screeningBdDAO->sumCapacityByMovie($id_movie);
        $Remnants = $capacityRoomMovie - $totalTicket;
        
        return $Remnants;
    }

    private function getSoldmoneyCinema($id_cinema){

        $totalMoneySold = $this->shoppingBdDAO->sumMoneyOfPurchasesOfaCinema($id_cinema);
    
        return $totalMoneySold ;
    
        }
    private function getSoldmoneyMovie($id_movie){

        $totalMoneySold = $this->shoppingBdDAO->sumMoneyOfPurchasesOfaMovie($id_movie);
    
        return $totalMoneySold ;
    
        }
    
    }