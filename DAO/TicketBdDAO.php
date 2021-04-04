<?php 
namespace DAO;

use Models\Ticket as Ticket;
use DAO\Connection as Connection;
use DAO\ShoppingBdDAO as ShoppingBdDAO;
use FFI\Exception;

class TicketBdDAO implements ITicket{

    private $tableName ="ticket";
    private $connection;
    private $ticketList = [];
   

    public function SaveTicketInBd(Ticket $ticket){
    
        $query = " INSERT INTO ". $this->tableName ."(idshopping,numberTicket,seat,qr) value (:idshopping ,:numberticket,:seat,:qr)";
      
              $parameters["idshopping"] = $ticket->getShopping()->getId_shopping();
              $parameters['numberticket'] = $ticket->getNumberTicket();
              $parameters['seat'] = $ticket->getSeat();
              $parameters['qr'] = $ticket->getQr();


              try {
                  $this->connection = Connection::GetInstance();
                  return $this->connection->ExecuteNonQuery($query, $parameters);

              } catch (Exception $ex) {

                  throw $ex;

              }
          }

          
    private function getTicketFromDB(){
        
        $query = "SELECT * FROM " . $this->tableName;

        try {

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

        } catch (Exception $ex) {
            throw $ex;
        }
        
        return $result;
    
    }

    public function getAllTicket() {

        $ticketArray = $this->getTicketFromDB();

        if(!empty($ticketArray)) {
            
            $result = $this->mapear($ticketArray);

            if(is_array($result)) {

                $this->ticketList = $result;
            }
            else {
                $arrayResult[0] = $result;

                $this->ticketList = $arrayResult;
            }

            return $this->ticketList;
        }

        else {

            return $errorArray[0] = "ERROR while reading the database.";
        }

    }

    protected function mapear($value) {


        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){

            $ticket = new Ticket();
            $ticket->setId_ticket($p['id_ticket']);
            $ticket->setShopping(ShoppingBdDAO::MapearShopping($p['idshopping']));
            $ticket->setSeat($p['seat']);
            $ticket->setNumberTicket($p['numberTicket']);
            $ticket->setQr($p['qr']);
            
            return $ticket;
            
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }
   
    public function GetTicketById($searchidticket){

        
          $query = "SELECT * FROM " . $this->tableName . " WHERE (id_ticket =:idticket)";
    
            $parameters["idticket"] = $searchidticket;
    
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);
            
            } catch (Exception $ex) {
                throw $ex;
            }
               $ticket = $this->mapear($results);
            
            return  $ticket;

        }

        public static function MapearTicket($idTicketToMapear) {

            $ticketDAOBdAux = new TicketBdDAO();

            $ticket = $ticketDAOBdAux->GetTicketById($idTicketToMapear);

            return $ticket;
        }


        public function DeleteTicketInDB($id_Ticket) {

            $query = "call deleteTicket(?)";

            $parameters['id_ticket'] =$id_shopping;
    
            try{
                
                $this->connection = Connection::GetInstance();
    
               $result = $this->connection->Excecute($query,$parameters,QueryType::storedProcedure);
    
            }catch(Exception $ex){
    
                throw $ex;
            }
    
            return $result;
        }

        private function getTickesFromShoppingDB($id_shopping){
        
            $query = "SELECT * FROM " . $this->tableName . " WHERE idshopping = :idshopping ";

            $parameters["idshopping"] = intval($id_shopping);

            try {
            
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters);
    
            } catch (Exception $ex) {

                return null;
            }
            
            return $result;
        
        }

        public function GetTicketFromShopping($id_shopping) {

            $ticketfromShopping = $this->getTickesFromShoppingDB($id_shopping);

            if(!empty($ticketfromShopping)) {
            
                $result = $this->mapear($ticketfromShopping);

                if(is_array($result)) {

                    $this->ticketList = $result;
                }

                else {

                    $arrayResult[0] = $result;

                    $this->ticketList = $arrayResult;
                }

                return $this->ticketList;
            }
            else {

                return $errorArray[0] = "Error al leer la base de datos.";
            }
            
        }



       //ordenados por fecha 
     private  function getAuserSticketIdDB($id_user){

          $query = "SELECT t.id_ticket,sc.date_screening 
          FROM shopping s
          inner join screening sc
         on s.idscreening = sc.id_screening
         inner join ticket t
         on t.idshopping = s.id_shopping
                    WHere iduser =:id_user
                    ORDER BY date_screening asc";

           $parameters['id_user'] = $id_user;

           try {
            
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $parameters);

        } catch (Exception $ex) {

            return null;
        }
        
        return $result;


     }

     public function getAuserSticketIdMapear($id_user){

        $ticket = null;

        $listTicket = [];

            $result =  $this-> getAuserSticketIdDB($id_user);

            if(!empty($result)){

                foreach($result as $res){

                    $ticket = TicketBdDAO::MapearTicket($res['id_ticket']);
                    array_push($listTicket ,$ticket);

                }
            }

            return $listTicket;

     }
        
    }
    ?>