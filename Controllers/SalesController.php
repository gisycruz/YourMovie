<?php
    namespace Controllers;

    use DAO\ShoppingBdDAO as ShoppingBdDAO;
    use DAO\ScreeningBdDAO as ScreeningBdDAO;
    use DAO\MovieBdDAO as  MovieBdDAO;
    use DAO\CinemaBdDAO as CinemaBdDAO;
    use Controllers\MovieController as MovieController;

    class SalesController
    {       
        private $movieController;
        private $shoppingBdDAO;
        private $screeningBdDAO;


        public function __construct() {
           $this->movieController = new MovieController();
           $this->shoppingBdDAO = ShoppingBdDAO::getInstance();
           $this->screeningBdDAO = new ScreeningBdDAO();

        }







       

    public function ShowSalesTicketCinema($id_cinema = null ,$message =""){

        require_once(VIEWS_PATH."validate-session.php");

        $listCinemaScreening = $this->getCinemaWthScreenig();

        if(isset($listCinemaScreening)){

        if($id_cinema != null){
           
            $cinema = CinemaBdDAO::MapearCinema($id_cinema);

          $listShopping =  $this->shoppingBdDAO->GetShoppingToCinema($id_cinema);
    
           
        }
        require_once(VIEWS_PATH."sale-cinema.php");
        

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