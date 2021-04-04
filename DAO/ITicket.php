<?php 
namespace DAO;

use Models\Ticket as Ticket;

interface ITicket{

    function SaveTicketInBd(Ticket $ticket);
    public function getAllTicket();
    function GetTicketById($searchidticket);
    function DeleteTicketInDB($id_Ticket);
    function GetTicketFromShopping($id_shopping);
}

?>