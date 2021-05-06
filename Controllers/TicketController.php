<?php
namespace Controllers;


use DAO\ShoppingBdDAO as ShoppingBdDAO; 
use Models\Shopping as Shopping;
use Models\Ticket as Ticket;
use DAO\TicketBdDAO as TicketBdDAO;
use Models\Mail as Mail ;
use Controllers\MovieController as MovieController;

class TicketController
{
    
    private $ticketBdDAO;
    private $MovieController;
    private $shoppingBdDAO;

    public function __construct() {
        
        $this->ticketBdDAO = new TicketBdDAO();
        $this->MovieController = new MovieController();
        $this->shoppingBdDAO = new ShoppingBdDAO();
       
    }

    public function ShowTicketUserViews($id_shopping ,$message =""){

        require_once(VIEWS_PATH."validate-sessionUser.php");
       
        $Listticket = $this->ticketBdDAO->GetTicketFromShopping($id_shopping);

        require_once(VIEWS_PATH."ticketUser.php");

        

    }
    public function ShowTicketObtainedUser($id_user, $message =""){

        require_once(VIEWS_PATH."validate-sessionUser.php");

        $Listticket = $this->ticketBdDAO->getAuserSticketIdMapear($id_user);
        
         require_once(VIEWS_PATH."ticketUser.php");

    }

    public function addTicket($id_shopping)
    {
        require_once(VIEWS_PATH."validate-sessionUser.php");

           $shopping = ShoppingBdDAO::MapearShopping($id_shopping);

            if($shopping !=null)
            {
                $user = $shopping->getUser();
                $screening = $shopping->getScreening();
                $cinema = $shopping->getScreening()->getRoom()->getCinema();
                $room = $shopping->getScreening()->getRoom();
                $movie = $screening->getMovie();
                $img = $user->getUserId(); 
                $path = 'img/Qr/'.$user->getUserName().'/';
                $id_shopping = $shopping->getId_shopping();

                $array = array();
                
                for($i = 1; $i <= $shopping->getCountrtiket();$i++)
                {
                    // Function to write image into file
                      if (!file_exists($path)) 
                        mkdir($path, 0777, true);

                     $url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='."-Name:".$user->getFirstName()."-LastName:".$user->getLastName()."-Cinema:".$cinema->getName()."-Room:".$room->getName()."-Movie:".$movie->getTitle()."-Day:".$screening->getDate_screening()."-Hour:".$screening->getHour_screening().$i; 

                     $url = str_replace(' ', '', $url);

                     $nameimg ='img/Qr/'.$user->getUserName().'/'.$img.'-'.$shopping->getId_shopping().'-'.$i.".png";

                     file_put_contents($nameimg, file_get_contents($url));

                    $ticket = new Ticket();

                    $ticket->setShopping($shopping);

                    $ticket->setQr("http://localhost/YourMovie/".$nameimg);

                    $ticket->setNumberTicket($screening->getId_screening().$cinema->getId_Cinema().$room->getId_room().$user->getUserId().$shopping->getId_shopping().$i);

                    $numberShopping = $this->shoppingBdDAO->sumNumberOfPurchasesOfaScreening($screening->getId_screening());

                    $seat = $numberShopping - $shopping->getCountrtiket() + $i;

                    $ticket->SetSeat($seat);
                     
                    $result = $this->ticketBdDAO->SaveTicketInBd($ticket);

                }

                if($result == 1)
                 $this->ShowTicketUserViews($id_shopping,"The purchase of the ticket was successfully carried out!!. ");
               else
               $message = "ERROR: Failed in screening delete, reintente";
      
            }
               
            
     }
        
public function sendtoemail($email,$id_Shopping){

    $ticketList = $this->ticketBdDAO->GetTicketFromShopping($id_Shopping);

    $mail = new Mail();

    $mail->sendMail($email,$ticketList);

    $this->MovieController->listMovies("The tickets were sent with QR to your mail . CHECK..!!");

}

}
    

       


   

    

