<?php
    namespace Controllers;

//c) Consultar cantidades vendidas y remanentes de las proyecciones (Película, Cine, Turno)
//d) Consultar totales vendidos en pesos (por película ó por cine, entre fechas)

    use DAO\ScreeningBdDAO as ScreeningBdDAO;
    use DAO\UserBdDAO as UserBdDAO;
    use Models\User as User;
    use DAO\ShoppingBdDAO as ShoppingBdDAO;
    use DAO\MovieBdDAO as  MovieBdDAO;
    use Models\Shopping as Shopping;
    use Controllers\TicketController as TicketController;
    use Controllers\Functions;
    use PDOException;
    use Controllers\MovieController as MovieController;
    class ShoppingController
    {       
        
        private $shoppingBdDAO;
        private $userBdDAO ;
        private $ticketController;
        private $screeningBdDAO;
        private $MovieController;

        public function __construct() {

           $this->shoppingBdDAO = ShoppingBdDAO::getInstance();
           $this->userBdDAO = new UserBdDAO();
           $this->ticketController = new TicketController();
           $this->screeningBdDAO = new ScreeningBdDAO();
           $this->MovieController = new MovieController();

        }

        public function ShowLoginIfNotLoging($message ="",$id_screening){
            
            if(!isset($_SESSION['loginUser'])){
              
                require_once(VIEWS_PATH."login.php");

            }
        }

        public function ShowAddShoppingViews($id_screening,$message =""){
             
            require_once(VIEWS_PATH."validate-sessionUser.php");

            $screening = ScreeningBdDAO::MapearScreening($id_screening);

            require_once(VIEWS_PATH."add-Shopping.php");
               
        }

         //calcular el total  
        public function ShowATotalShoppingViews($ticketQuantity,$id_screening,$total,$message =""){

            require_once(VIEWS_PATH."validate-sessionUser.php");

            $screening = ScreeningBdDAO::MapearScreening($id_screening);

            require_once(VIEWS_PATH."add-Shopping.php");
    
           }

           public function ShowAddCardViews($id_screening ,$ticketQuantity ,$message = ""){

            require_once(VIEWS_PATH."validate-sessionUser.php");

            $screening = ScreeningBdDAO::MapearScreening($id_screening);

            $total = $screening->getRoom()->getTicketValue() * $ticketQuantity; 
            
            require_once(VIEWS_PATH."add-card.php");

        }

        public function ShowAddTicketUserViews($id_shopping){

            require_once(VIEWS_PATH."validate-sessionUser.php");

            $this->ticketController->addTicket($id_shopping);

        }

    
        public function addQuantityTicket($ticketQuantity , $id_screening){

            require_once(VIEWS_PATH."validate-sessionUser.php");

             //SI NO HAY LUGAR NO LE APARECE EN CARTELERA
            $unoccupiedSeats = $this->screeningBdDAO->unoccupiedSeatsFromScreening($id_screening);
        
            //evaluar si hay lugar para esa cantidad de entradas

            $seatFree = $unoccupiedSeats - $ticketQuantity;

              //entoces asiento del cliente es desocupados - $ticketQuantity;

            if($seatFree >= 0){
              
                $screening = ScreeningBdDAO::MapearScreening($id_screening);
                  
                $total = 0;
    
                $total = $screening->getRoom()->getTicketValue() * $ticketQuantity;
    
                $this->ShowATotalShoppingViews($ticketQuantity,$id_screening,$total,"If you wisd before loading  the car you can modify the quantities");

            }else{

                $this->ShowAddShoppingViews($id_screening, "excuse !! the room is full they have not left a seat for that amount of tickets there is only ". $unoccupiedSeats." places");
            }

           }

        public function GetShopping($id_screening) {
           
            if(!isset($_SESSION['loginUser']))
                $this->ShowLoginIfNotLoging("To get a ticket yuo must be logged in ..!",$id_screening);
                else
                 $this->ShowAddShoppingViews($id_screening,"welcome a Shopping to ticket");
            
        }


        
       public function validateCard($inputNumero,$month,$year,$ccv,$ticketQuantity,$id_screening,$var = false)
       {
        
        require_once(VIEWS_PATH."validate-sessionUser.php");

         if(isset($_GET)){

        $companyCard = "";
        $fecha = $year."-".$month;
       
        $fecha_actual = strtotime(date("Y-m"));
        $fecha_entrada = strtotime("$fecha");
        $longNumberCard = strlen($inputNumero);
        $longCcvCard = strlen($ccv);

            
        if($longNumberCard == 19 )
        {

            if($inputNumero[0] == 4){
           
                $companyCard ="Visa";
   
           }else if($inputNumero[0] == 5){
   
               $companyCard ="Mastecar";

             }else{

                $this->ShowAddCardViews($id_screening ,$ticketQuantity ," Card not supported .");

             }
              if($fecha_actual > $fecha_entrada){

                $this->ShowAddCardViews($id_screening ,$ticketQuantity ," Expired Card .");
    
                }
                 if($longCcvCard != 3){
        
                    $this->ShowAddCardViews($id_screening ,$ticketQuantity ,"Some ccv number is missing..!");

                }else{

                $var = true;

               $this->addShopping($id_screening,$ticketQuantity);

                }
    
        }else{
            $this->ShowAddCardViews($id_screening ,$ticketQuantity ,"The card number needs to be completed..!");
        }


    }
   
       
    }

       public function addShopping($id_screening,$ticketQuantity) {


        require_once(VIEWS_PATH."validate-sessionUser.php");

        $screening = ScreeningBdDAO::MapearScreening($id_screening);
         
        $Shopping = new Shopping();

        $Shopping->setScreening($screening);

        $Shopping->setCountrtiket($ticketQuantity);

        $Shopping->setPriceRoom($screening->getRoom()->getTicketValue());

        $total = $Shopping->getPriceRoom() * $Shopping->getCountrtiket();

        $Shopping->setTotal($total);

        $user = $_SESSION['loginUser'];

        $Shopping->setUser($user);

       date_default_timezone_set('America/Argentina/Ushuaia');

        $Shopping->setDateShopping(date("Y-m-d(H:i:s)",time()));

    try{

       $result =  $this->shoppingBdDAO->addShopping($Shopping);

       if($result == 1){

      $id_shopping = $this->shoppingBdDAO->GetIdShoppingById($Shopping->getUser()->getUserId(),$Shopping->getDateShopping());

      $this->ShowAddTicketUserViews($id_shopping);

          }else
              $this->ShowAddShoppingViews($id_screening,"ERROR: reintente");

     }catch(PDOException $ex){

          if(Functions::contains_substr($ex->getMessage(),"Duplicate entry")) 
              $this->MovieController->listMovies("The purchase already exists!!!");
              

    }
       }
  
       
   }
   ?>